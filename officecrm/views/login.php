<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Вход</title>

    <!-- Bootstrap core CSS -->
    <link href="views/css/bootstrap.min.css" rel="stylesheet">
    <link href="views/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="views/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="views/css/style.css" rel="stylesheet">
    <link href="views/css/style-responsive.css" rel="stylesheet" />
    

   
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">

      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Вход</h2>
        <div class="login-wrap">
            <strong style="color:#F67A6E"><?= empty($error['login_error'])? '' : $error['login_error'] ?></strong>
            <strong style="color:#F67A6E"><?= empty($error['login_email'])? '' : $error['login_email'] ?></strong>
            <br>
            <input type="text"     name="login_email" class="form-control"  placeholder="Введите email">
            <strong style="color:#F67A6E"><?= empty($error['login_password'])? '' : $error['login_password'] ?></strong>
            <br>
            <input type="password" name="login_password" class="form-control" placeholder="Введите пароль">
           
            <button class="btn btn-lg btn-login btn-block" type="submit">Войти</button>
            
            
        </div>
      </form>

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>


  </body>
</html>
