<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Programmer Challange</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/assets/css/index.css">
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="error">
                    <?php if (isset($errors)) : ?>
                        <?php foreach ($errors as $error) : ?>
                            <?php echo $error; ?><br/>
                        <?php endforeach ?>
                    <?php endif ?> 
                </div>
                <br/>
                
                <?php require($content) ?>
            </div>
        </div>
    </body>
</html>