<?php


/*
 * is_ltr_local : Get whether the current locale is a left-to-right language.
 */
function is_ltr_locale(): bool
{
    global $I18N;
    return $I18N['ltr'] === true;
}


/*
 * select_i18n_str : Get the appropriate string from a key-value array based
 *                    on the currently-set locale. If no exact match for the
 *                    current language is found, the locale (xx prefix) will
 *                    be loosely searched instead and matched to a fit entry.
 */
function select_i18n_str(mixed $input): string
{
    if ($input && is_string($input)) {
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
 * xlat : Get a raw string from the current i18n mapping table.
 * 
 * Input selector values are paths into the table separated by ':' characters.
 */
function xlat(string $selector, mixed ...$vars): ?string
{
    global $I18N;

    $path = explode(':', $selector, 5);
    $result = null;

    foreach ($path as $idx => $leaf) {
        $result = ($idx === 0 ? $I18N : $result)[$leaf];
    }

    if ($I18N['complete'] === true && !$result) {
        // Missing translations when the language is marked as complete will throw (in English).
        throw new \Exception('Missing translation on a completed language.');
    }

    if (count($vars)) {
        $resultFormatted = sprintf($result, ...$vars);
    } else {
        $resultFormatted = $result;
    }

    return $resultFormatted;
}
