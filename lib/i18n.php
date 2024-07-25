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
