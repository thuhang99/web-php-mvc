<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Dashboard</title>

  <base href="<?php echo URL . 'assets/admin/'; ?>">
  <?php  require_once 'home/css.php' ;?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php  require_once 'home/navbar.php' ;?>

  <?php  require_once 'home/aside.php' ;?>

  <?php  require_once $data['main'].'.php' ;?>

  <?php  require_once 'home/footer.php' ;?>


  <aside class="control-sidebar control-sidebar-dark">

  </aside>

</div>

<?php  require_once 'home/js.php' ;?>


</body>
</html>
