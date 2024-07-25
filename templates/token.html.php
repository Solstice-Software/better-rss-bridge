<?php
/**
 * This template renders a form for user to enter a auth token if it's enabled
 */

?>

<h1><?= ucwords(xlat('misc:token_required')) ?></h1>
<p><?= e($message) ?></p>

<form action="" method="get">
    <label for="token"><?= ucwords(xlat('misc:token')) ?>:</label>
    <input type="password" name="token" id="token" placeholder="<?= ucwords(xlat('misc:token')) ?>">
    <input type="submit" value="OK">
</form>
