<form method="POST" enctype="multipart/form-data">
    Title
    <input type="text" name="title" class="text" 
    value="<?php echo isset($formBoard['title']) ? $formBoard['title'] : ''?>"/><br/>
    Body
    <textarea name="message"><?php echo isset($formBoard['message']) ? $formBoard['message'] : '' ?></textarea>
    <br/>
    <div style="display: inline-block; text-align: left; width: 500px">
        <div style="float: left">
            <?php if ($formAction === 'edit') : ?>
                <input type="hidden" name="redirect" value="<?= $redirect ?>"/>
                <?php 
                    if (!is_null($formBoard['image']) &&
                        file_exists("images/upload/" . $formBoard['image'])) : 
                ?>      
                        <div style="float:left; margin-right: 10px;">
                            <img src="/images/upload/<?= $formBoard['image'] ?>" 
                            style="width: 150px; height: auto;">
                        </div>
                <?php else : ?>
                    <div style="float:left; margin-right: 10px;">
                        <img src="/images/image-not-available.jpg" style="width: 150px; height: auto;">
                    </div>
                <?php endif ?>
                <div style="float:left">
                    <input type="checkbox" name="deleteImage"/> Delete image <br/><br/>  
            <?php endif ?>
            Insert Image<br/>
            <input type="file" name="image"/>
            <?php if ($formAction === 'edit') : ?>
                </div>
            <?php endif ?>
        </div>
        <div style="float:right;">
            <?php if ($formAction === 'edit') : ?>
                <input type="hidden" name="password" value="<?= $submitPass ?>"/>
            <?php else : ?>
                Password<br/>
                <input type="password" name="password" class="text" style="width: 100px;">   
            <?php endif ?>
        </div>
    </div>
    <br/>
    <?php if ($formAction === 'edit') : ?>
        <input type="submit" value="Submit" name="update" formaction="/Board/edit/<?= $formBoard['id'] ?>">
        <a href="<?= $redirect ?>">
            <button type="button">Cancel</button>
        </a>
    <?php else : ?>
        <input type="submit" value="Submit" name="submit" class="button" 
        style="display: inline; width: 220px" formaction="/">
    <?php endif ?>
</form>

