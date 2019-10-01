<div class="content">
    <?php require(ROOT . 'views/form_board.php') ?>

    <div class="posts">
        <?php if (!empty($boardList)) : ?>
            <?php foreach ($boardList as $board) : ?>
                <div class="post">
                    <hr/>
                    <div style="text-align: left">
                        <?php echo show_with_tags($board['title'])?>
                    </div>
                    <div style="text-align: left">
                        <?php echo ln_to_br(show_with_tags($board['message']))?>
                    </div>
                    <div style="text-align: left">
                    <?php 
                        if (!is_null($board['image']) &&
                            file_exists("images/upload/" . $board['image'])) : 
                    ?>
                            <img src="/images/upload/<?= $board['image'] ?>" style="width: 150px; height: auto;">
                    <?php else : ?>
                        <img src="/images/image-not-available.jpg" style="width: 150px; height: auto;">
                    <?php endif ?>
                    </div>
                    <div style="text-align: left">
                        <form method="POST" action="/">
                            <input type="password" name="password"/>
                            <input type="hidden" name="redirect" value="<?= $requestUrl ?>"/>      
                            <input type="submit" name="delete" value="Del" formaction="/Board/delete/<?= $board['id'] ?>"/>
                            <input type="submit" name="edit" value="Edit" formaction="/Board/edit/<?= $board['id'] ?>"/>
                            
                            <a style="margin-left: 100px">
                                <?php echo get_default_date($board['created_at'])?>
                            </a>
                        </form>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <br/>
    
    <div class="pagination">
        <?php echo $pagination ?>
    </div>
</div>