<?php
/**
 * This template is used for rendering exceptions
 */
?>
<div class="error">

    <?php if ($e instanceof CloudFlareException): ?>
        <h2><?= xlat('errors:cloudflare:protected') ?></h2>
        <p><?= xlat('errors:cloudflare:reason') ?></p>
    <?php endif; ?>

    <?php
        switch ($e->getCode()) {
            // Generally speaking, we can safely assume any HttpException with
            //   the codes 10 or 11 are not valid (since it is always 3 digits).
            case 10:
            case 11:
                if ($e instanceof HttpException) {
                    print '<p>???</p>';
                    break;
                }
                $e_banner = xlat('errors:curl:e' . $e->getCode() . ':banner');
                $e_reason = xlat('errors:curl:e' . $e->getCode() . ':reason');
                print "<h2>{$e_banner}</h2><p>{$e_reason}</p>";
                break;
            case 400:
            case 403:
            case 404:
            case 429:
            case 503:
                $e_banner = xlat('errors:http_exceptions:e' . $e->getCode() . ':banner');
                $e_reason = xlat('errors:http_exceptions:e' . $e->getCode() . ':reason');
                print "<h2>{$e_banner}</h2><p>{$e_reason}</p>";
                break;
            case 0:
                $e_msg = xlat('errors:curl:see_libcurl_errors_doc');
                echo <<<CONTENT
                    {$e_msg}
                    <a href="https://curl.haxx.se/libcurl/c/libcurl-errors.html">
                        https://curl.haxx.se/libcurl/c/libcurl-errors.html
                    </a>
CONTENT;
                break;
            default:
                $e_rawCode = raw($e->getCode());
                echo <<<CONTENT
                    <p><a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/{$e_rawCode}">
                        https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/{$e_rawCode}
                    </a></p>
CONTENT;
                break;
        }
    ?>

    <h2><?= ucwords(xlat('misc:details')) ?></h2>

    <div style="margin-bottom: 15px">
        <div class="error-type">
            <strong><?= ucwords(xlat('misc:type')) ?>:</strong> <?= e(get_class($e)) ?>
        </div>

        <div>
            <strong><?= ucwords(xlat('misc:code')) ?>:</strong> <?= e($e->getCode()) ?>
        </div>

        <div class="error-message">
            <strong><?= ucwords(xlat('misc:message')) ?>:</strong> <?= e(sanitize_root($e->getMessage())) ?>
        </div>

        <div>   
            <strong><?= ucwords(xlat('misc:file')) ?>:</strong> <?= e(sanitize_root($e->getFile())) ?>
        </div>

        <div>
            <strong><?= ucwords(xlat('misc:line')) ?>:</strong> <?= e($e->getLine()) ?>
        </div>
    </div>

    <h2><?= ucwords(xlat('misc:trace')) ?></h2>

    <?php foreach (trace_from_exception($e) as $i => $frame) : ?>
        <code>
            #<?= $i ?> <?= e(frame_to_call_point($frame)) ?>
        </code>
        <br>
    <?php endforeach; ?>

    <br>

    <h2><?= ucwords(xlat('misc:context')) ?></h2>

    <div>
        <strong><?= ucwords(xlat('misc:query')) ?>:</strong> <?= e(urldecode($_SERVER['QUERY_STRING'] ?? '')) ?>
    </div>

    <div>
        <strong><?= ucwords(xlat('misc:version')) ?>:</strong> <?= raw(Configuration::getVersion()) ?>
    </div>

    <div>
        <strong><?= ucwords(xlat('misc:os')) ?>:</strong> <?= raw(PHP_OS_FAMILY) ?>
    </div>

    <div>
        <strong>PHP:</strong> <?= raw(PHP_VERSION ?: ucwords(xlat('misc:unknown'))) ?>
    </div>

    <br>

    <a href="/"><?= ucwords(xlat('misc:go_back')) ?></a>
</div>

