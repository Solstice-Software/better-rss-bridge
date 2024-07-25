<?php


class I18n
{
    /*
     * In some parts of this application (namely BridgeAbstract), const values
     *   are used which disallow dynamic translations. Instead, the I18N_MAGIC
     *   const is prepended to strings to indicate the string should be treated
     *   as an i18n selector.
     */
    public const SELECTOR_MAGIC = '__i18n!SEL;';

    /*
     * Whether the current i18n settings have been loaded (and validated as needed).
     */
    private static $LOADED = false;

    /*
     * The loaded i18n dictionary to use for mapping selectors to phrases/words.
     */
    private static $LEXICON = [];


    /*
    * load : Initialize the i18n settings for the app and validate translation
    *   conformity to the 'en-US.php' base translation object.
    */
    public static function load(): void
    {
        if (self::$LOADED) {
            return;
        }

        // The current directory in this context is the 'lib' folder because this is called
        //   from the 'lib/bootstrap.php' file.
        $languageCode = Configuration::getConfig('system', 'app_language', 'en-US');
        
        if (is_file(__DIR__ . '/../i18n/' . $languageCode . '.php')) {
            unset($I18N);
            require __DIR__ . '/../i18n/' . $languageCode . '.php';
            
            self::$LEXICON = $I18N;
            unset($I18N);
        } else {
            http_response_code(500);
            print 'Unable to source i18n language information. Check the application\'s configuration.';
            exit;
        }

        self::$LOADED = true;
    }

    /*
     * is_ltr : Get whether the current local is a left-to-right language.
     */
    public static function is_ltr(): bool
    {
        return self::$LEXICON['ltr'] === true;
    }

    /*
     * dynamic_select : Get the appropriate string from a key-value array based
     *                   on the currently-set locale. If no exact match for the
     *                   current language is found, the locale (xx prefix) will
     *                   be loosely searched instead and matched to a fit entry.
     * 
     * NOTE: See the 'SELECTOR_MAGIC' const for more information about why it is used.
     */
    public static function dynamic_select(mixed $input): string
    {
        if ($input && is_string($input)) {
            if (str_starts_with($input, self::SELECTOR_MAGIC)) {
                $selector = [...explode(';', $input), ''][1];
                return xlat($selector);
            }

            return $input;
        }

        if (!$input || !is_array($input)) {
            return '';
        }

        // Get the current language code and its locale portion.
        $languageCode = Configuration::getConfig('system', 'app_language', 'en-US');
        $languageLocale = explode('-', $languageCode)[0];

        // Match by the exact language code.
        if ($input[$languageCode] && is_string($input[$languageCode])) {
            return $input[$languageCode];
        }

        // Allows a string to be specified per each entire locale;
        //   e.g., 'en' instead of 'en-US' or 'en-GB'.
        if ($input[$languageLocale] && is_string($input[$languageLocale])) {
            return $input[$languageLocale];
        }

        // Get the first matching locale. For example, if the current language setting
        //   is 'en-GB', but only 'en-US' is defined, this should match.
        foreach (array_keys($input) as $i => $k) {
            if (str_starts_with($k, $languageLocale) && is_string($input[$k])) {
                return $input[$k];
            }
        }

        return '';
    }

    /*
     * translate : Primary translation function for i18n.
     * 
     * Input selector values are paths into the table separated by ':' characters.
     */
    public static function translate(string $selector, mixed ...$vars): ?string
    {
        $path = explode(':', $selector, 5);
        $result = null;
    
        foreach ($path as $idx => $leaf) {
            $result = ($idx === 0 ? self::$LEXICON : $result)[$leaf];
        }
    
        if (
            self::$LEXICON['complete'] === true
            && !$result
            && Configuration::getConfig('system', 'enforce_complete_translations')
        ) {
            // Missing translations when the language is marked as complete will throw (in English).
            throw new \Exception(
                sprintf(
                    'Missing translation item within a supposedly "completed" language (%s): "%s"',
                    Configuration::getConfig('system', 'app_language', 'en-US'),
                    $selector
                )
            );
        }
    
        if (count($vars)) {
            $resultFormatted = sprintf($result, ...$vars);
        } else {
            $resultFormatted = $result;
        }
    
        return $resultFormatted;
    }
}


/*
 * xlat : Global function to abbreviate calls to the I18n::translate method.
 */
function xlat(string $selector, mixed ...$vars): ?string
{
    return I18n::translate($selector, ...$vars);
}
