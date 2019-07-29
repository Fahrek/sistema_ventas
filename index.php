<?php
$msg = '';
session_start();
if (isset($_SESSION['active']))
{
    header('Location: sistema/');
} else {
    if ($_POST)
    {
        if (empty($_POST['usuario']) || empty($_POST['clave']))
        {
            $msg = 'Introduce un usuario y un password';
        } else {
            require_once 'conexion.php';

            $user = mysqli_real_escape_string($conn, $_POST['usuario']);
            $pass = md5(mysqli_real_escape_string($conn, $_POST['clave']));

            $sql = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$pass'");
            $res = mysqli_num_rows($sql);

            if ($res > 0)
            {
                $row = mysqli_fetch_array($sql);
                //print_r($query);
                $_SESSION['active'] = true;
                $_SESSION['isUser'] = $row['idusuario'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['email']  = $row['correo'];
                $_SESSION['user']   = $row['usuario'];
                $_SESSION['rol']    = $row['rol'];

                header('Location: sistema/');
            } else {
                $msg = 'El usuario y/o contraseña son incorrectos';
                session_destroy();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Login | Sistema de facturación</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <section id="container">
            <form action="" method="POST">
                <h3>Iniciar Sesión</h3>
                <img src="" alt="Login">

                <input type="text" name="usuario" placeholder="Usuario">
                <input type="password" name="clave" placeholder="Constraseña">
                <div class="msg"><?php echo isset($msg) ? $msg : ''; ?></div>
                <input type="submit" id="enviar" value="INICIAR">
            </form>
        </section>
    </body>

</html>
