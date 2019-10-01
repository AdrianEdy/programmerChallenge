<?php require(ROOT . 'views/show_board_data.php') ?>
<div style="text-align: left">
    <form method="POST">
        Pass 
        <input type="password" name="password"/> 
        <input type="hidden" name="redirect" value="<?= $redirect ?>"/>
        <input type="submit" name="edit" value="Edit" formaction="/Board/edit/<?= $formBoard['id'] ?>"/> 
        <a style="margin-left: 100px">
            <?php echo get_default_date($formBoard['created_at'])?>
        </a>
        <hr/>
    </form>
</div>