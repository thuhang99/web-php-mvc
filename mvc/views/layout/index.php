<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ustora Demo</title>

    <base href="<?php echo URL; ?>">

    <?php require_once 'home/css.php'; ?>
  </head>
  <body>
   
    <?php require_once 'home/header_area.php'; ?>

    <?php require_once 'home/site_branding_area.php'; ?>
    
    <?php require_once 'home/mainmenu_area.php'; ?>

    <?php require_once $data['main'] . '.php'; ?>
    
    <?php require_once 'home/footer_top_area.php'; ?>
    
    <?php require_once 'home/footer_bottom_area.php'; ?>
   
    <?php require_once 'home/js.php'; ?>
  </body>
</html>