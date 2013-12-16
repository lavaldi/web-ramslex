<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="CLM Developers">
    <title>Login - Promoción Smartphone Cubot</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-timepicker.css">
    <link rel="stylesheet" type="text/css" href="css/datepicker.css">
    <link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
</head>
<body>

    <div class="container">
        <?php if(isset($_GET['band'])){
            echo '<div class="alert alert-dismissable alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>¡Ooops!</strong> Password incorrecto, vuelve a intentarlo.</div>';}
        ?>
        <form class="form-signin" role="form" action="loginform.php" method="post">
            <h2 class="form-signin-heading">Log in</h2>
            <input type="text" class="form-control" placeholder="Email" required autofocus>
            <input type="password" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
        </form>

    </div>
</body>
</html>
