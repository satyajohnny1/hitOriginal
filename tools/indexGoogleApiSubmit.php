<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Google Drive Example App</title>
    </head>
    <body>
        <H3>Following files found in given directory </H3>
        <h4> Submit with Post URL is :  <?php echo $url; ?> </h4>
        <ul>
        <?php foreach ($files as $file) { ?>
            <li><?php echo $file; ?></li>
        <?php } ?>
        </ul>
        <form method="post" action="<?php echo $url; ?>">
            <input type="submit" value="Send to GDrive" name="submit">
        </form>
    </body>
</html>
