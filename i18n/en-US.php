<?php

/*
 * This file is used as a base template for all rss-bridge language translations.
 *
 *   To add support for a new language, copy this file to its respective country code.
 *   For example, to add support for Saudi Arabic, copy this file
 *    to 'ar-SA.php' in the i18n folder.
 * 
 * Any deviations from the structure in this template will unfortunately
 *  cause missing strings, blank lines, and other unexpected application behaviors.
 * 
 */

/*
 * ~*~*~ THIS FILE (en-US) IS THE SOURCE OF TRUTH FOR INTERNATIONALIZATION (I18N)! ~*~*~
 * 
 * If this data structure is ever updated, then the rest of the existing language files
 *  MUST also be amended to reflect the new structure.
 * 
 */


$I18N = [
    /*
     * If the translation is marked complete, then missing items returning
     *   an empty string or null object will cause the application to crash.
     * 
     * BE CAREFUL.
     */
    'complete' => true,   /* is this translation complete? */
    'ltr' => true,   /* left-to-right */
    'frontpage' => [   /* content on the main page */
        'findfeed_button' => 'Find Feed from URL',
        'searchfield_placeholder' => 'Insert URL or bridge name',
        'active_bridges' => 'active bridges',
    ],
    'bridge_default' => [   /* defaults for the BridgeAbstract */
        'name' => 'Unnamed bridge',
        'description' => 'No description provided.',
        'no_maintainer' => 'No maintainer',
    ],
    'bridge_card' => [   /* for the class by the same name */
        'proxy_disable' => 'Disable proxy',
        'cache_timeout' => 'Cache timeout in seconds',
        'example_right_click' => 'Example (right click to use)',
        'generate_feed' => 'generate feed',
    ],
    'bridge_error' => [   /* the bridge-error template */
        'find_similar_bugs' => 'Find similar bugs',
        'find_similar_bugs_title' => 'Opens GitHub to search for similar issues',
        'create_github_issue' => 'Create a GitHub issue',
        'create_github_issue_title' => 'After clicking this button you can review the issue before submitting it',
    ],
    'connectivity' => [ /* the connectivity template */
        'search_for_bridge' => 'Search for bridge...',
    ],
    'errors' => [   /* error messages */
        'general' => [
            'missing_config_option' => 'Missing configuration option: %s',
            'invalid_context' => 'Invalid parameters value(s).',
            'invalid_context_args' => 'Invalid parameters value(s): %s',
            'missing_context' => 'Required parameter(s) missing.',
            'mixed_context' => 'Mixed context parameters.',
            'no_bridges_enabled' => 'No bridges are enabled...',
            'whitelist' => 'This bridge is not whitelisted.',
            'format' => 'You must specify a format.',
            'not_found' => 'Bridge not found.',
            'not_found_named' => 'Bridge "%s" not found.',
            'not_found_for_url' => 'No bridge was found for the given URL',
            'missing_parameter' => 'Missing bridge parameter.',
            'specify_url' => 'You must specify a URL.',
            'specify_format' => 'You must specify a format.',
        ],
        'url' => [
            'illegal' => 'Illegal URL: "%s"',
            'parse' => 'Failed to parse URL: "%s"',
            'scheme' => 'Invalid scheme: "%s"',
            'path_slash' => 'Path must start with forward slash: "%s"',
        ],
        'cache' => [
            'no_type' => 'No cache type is configured.',
            'bad_name' => 'Invalid cache name: "%s"',
            'bad_classname' => 'Invalid cache classname: "%s"',
            'filecache_path_not_found' => 'The FileCache path at "%s" does not exist.',
            'filecache_not_writable' => 'The FileCache path at "%s" is not writable.',
            'not_loaded' => 'The "%s" extension is not loaded. Please check "php.ini".',
            'path_not_writeable' => 'The cache folder is not writable.',
            'config_missing' => 'The configuration for %s is missing.',
            'config_invalid' => 'The configuration for %s is invalid.',
            'param_not_set' => '"%s" parameter is not set for %s.',
            'param_invalid' => '"%s" parameter is invalid for %s.',
            'missing_file' => 'Unable to find the cache file.',
        ],
        'expander' => [
            'no_url' => 'There is no URL for this RSS expander.',
            'bad_xml_url' => 'Unable to parse XML from URL "%s" because the response was empty.',
            'bad_xml_url_msg' => 'Failed to parse XML from URL "%s": %s',
        ],
        'parser' => [
            'bad_xml_msg' => 'Unable to parse XML: %s',
            'feed_format' => 'Unable to detect feed format.',
        ],
        'format' => [
            'invalid_name' => 'Invalid format name: "%s"',
        ],
        'actions' => [
            'connectivity' => [
                'debug_required' => 'This action is only available in debug mode.',
            ],
            'display' => [
                'cached' => 'This is a cached response.',
                'error' => 'Bridge returned error',
            ],
            'findfeed' => [
                'no_name_var' => 'Variable "%s" (No name provided)',
            ],
        ],
        'http_exceptions' => [
            'e400' => [
                'banner' => '400 Bad Request',
                'reason' => 'This is usually caused by an incorrectly constructed HTTP request.',
            ],
            'e403' => [
                'banner' => '403 Forbidden',
                'reason' => 'RSS-Bridge tried to fetch a page with a valid request but was refused by the server.',
            ],
            'e404' => [
                'banner' => '404 Page Not Found',
                'reason' => 'RSS-Bridge tried to fetch a page on a website but it was not found or returned by the server.',
            ],
            'e429' => [
                'banner' => '429 Too Many Requests',
                'reason' => 'RSS-Bridge tried to fetch a website and was directed to try again later.',
            ],
            'e503' => [
                'banner' => '503 Service Unavailable',
                'reason' => 'This is commonly caused when a server is down for maintenance or is overloaded.',
            ],
        ],
        'cloudflare' => [
            'protected' => 'The website is protected by CloudFlare.',
            'reason' => 'RSS-Bridge tried to fetch a website, but it was blocked by CloudFlare. CloudFlare is anti-bot software whose purpose is to block non-human entities.',
        ],
        'curl' => [
            'see_libcurl_errors_doc' => 'See the cURL documentation for information about the error code:',
            'e10' => [
                'banner' => 'The RSS feed is completely empty',
                'reason' => 'RSS-Bridge tried to parse the empty string as XML. Unfortunately, the fetched URL is not pointing to any real XML.',
            ],
            'e11' => [
                'banner' => 'Something is wrong with the RSS feed',
                'reason' => 'RSS-Bridge tried to parse XML and failed. The XML received is probably invalid.',
            ],
        ],
        'dom_empty' => 'Unable to parse the DOM because the HTTP response was empty.',
    ],
    'misc' => [   /* miscellaneous words/text */
        'show_more' => 'show more',
        'show_less' => 'show less',
        'active' => 'active',
        'inactive' => 'inactive',
        'search' => 'search',
        'details' => 'details',
        'attachments' => 'attachments',
        'categories' => 'categories',
        'trace' => 'trace',
        'context' => 'context',
        'version' => 'version',
        'query' => 'query',
        'os' => 'operating system',
        'email' => 'email',
        'token' => 'token',
        'telegram' => 'Telegram',
        'unknown' => 'unknown',
        'go_back' => 'go back',
        'back_to_frontpage' => 'go back to front page',
        'type' => 'type',
        'code' => 'code',
        'message' => 'message',
        'file' => 'file',
        'line' => 'line',
        'donate' => 'donate',
        'donate_maintainer' => 'Donate to Maintainer',
        'author_by' => 'by',
        'token_required' => 'Authentication with token required.',
        'all_is_good' => 'all is good',
    ],
];
