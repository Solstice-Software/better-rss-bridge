
<script>
    document.addEventListener('DOMContentLoaded', rssbridge_toggle_bridge);
    document.addEventListener('DOMContentLoaded', rssbridge_list_search);
    document.addEventListener('DOMContentLoaded', rssbridge_feed_finder);
</script>

<section class="searchbar">
    <h3><?= ucfirst(xlat('misc:search')) ?></h3>
    <input
        type="text"
        name="searchfield"
        id="searchfield"
        placeholder="<?= xlat('frontpage:searchfield_placeholder') ?>"
        onchange="rssbridge_list_search()"
        onkeyup="rssbridge_list_search()"
        value=""
    >
    <button
        type="button"
	    id="findfeed"
        name="findfeed"
    /><?= xlat('frontpage:findfeed_button') ?></button>
    <section id="findfeedresults">
    </section>

</section>

<?= raw($bridges) ?>

<section class="footer">
    <a href="https://github.com/RSS-Bridge/rss-bridge">
        https://github.com/RSS-Bridge/rss-bridge
    </a>

    <br>
    <br>

    <p class="version">
        <?= e(Configuration::getVersion()) ?>
    </p>

    <?= $active_bridges ?>/<?= $total_bridges ?> <?= xlat('frontpage:active_bridges') ?>.<br>

    <br>

    <?php if ($admin_email): ?>
        <div>
            <?= ucfirst(xlat('misc:email')) ?>: <a href="mailto:<?= e($admin_email) ?>"><?= e($admin_email) ?></a>
        </div>
    <?php endif; ?>

    <?php if ($admin_telegram): ?>
        <div>
            <?= ucfirst(xlat('misc:telegram')) ?>: <a href="<?= e($admin_telegram) ?>"><?= e($admin_telegram) ?></a>
        </div>
    <?php endif; ?>

</section>
