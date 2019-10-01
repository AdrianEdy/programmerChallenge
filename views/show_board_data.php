<div style="text-align: left">
    <?php echo show_with_tags($formBoard['title'])?>
</div>
<div style="text-align: left">
    <?php echo ln_to_br(show_with_tags($formBoard['message']))?>
</div>
<div style="text-align: left">
<?php 
    if (!is_null($formBoard['image']) &&
        file_exists("images/upload/" . $formBoard['image'])) : 
?>
    <img src="/images/upload/<?= $formBoard['image'] ?>" style="width: 150px; height: auto;">
<?php else : ?>
    <img src="/images/image-not-available.jpg" style="width: 150px; height: auto;">
<?php endif ?>
</div>