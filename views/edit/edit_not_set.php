<?php require(ROOT . 'views/show_board_data.php') ?>
<div style="text-align: right">
    <?php echo get_default_date($formBoard['created_at'])?>
</div>
<br/>
<a href="<?= $redirect ?>"><button>Back previous page</button></a>