
<?= raw($error) ?>

<a href="<?= raw($searchUrl) ?>" title="<?= xlat('bridge_error:find_similar_bugs_title') ?>">
    <button><?= xlat('bridge_error:find_similar_bugs') ?></button>
</a>

<a href="<?= raw($issueUrl) ?>" title="<?= xlat('bridge_error:create_github_issue_title') ?>">
    <button><?= xlat('bridge_error:create_github_issue') ?></button>
</a>

<p class="maintainer">
    <?= e($maintainer) ?>
</p>