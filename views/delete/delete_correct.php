<hr/>
<?php require(ROOT . 'views/show_board_data.php') ?>
<div style="text-align: left">
    Date:<?php echo get_default_date($formBoard['created_at'])?>
</div>
<hr/>
<br/>
Are you sure?
<form method="POST">
    <input type="hidden" name="password" value="<?= $submitPass ?>"/>
    <input type="hidden" name="redirect" value="<?= $redirect ?>"/>
    <input type="submit" name="destroy" value="Yes" formaction="/Board/delete/<?= $formBoard['id'] ?>"/>
    <input type="submit" name="cancel" value="Cancel" formaction="<?= $redirect ?>">
</form>