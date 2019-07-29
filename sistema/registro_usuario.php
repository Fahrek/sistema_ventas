<?php require_once '../conexion.php';
    if ($_POST)
    {
        $alert = '';
        if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol']))
        {
            $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
        } else {
            $nombre = $_POST['nombre'];
            $email  = $_POST['correo'];
            $user   = mysqli_real_escape_string($conn, $_POST['usuario']);
            $pass   = md5(mysqli_real_escape_string($conn, $_POST['clave']));
            $rol    = $_POST['rol'];

            $sql = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email'");
            $res = mysqli_num_rows($sql);

            if ($res > 0)
            {
                $row = mysqli_fetch_array($sql);
                $alert = '<p class="msg_error">El usuario o el correo ya existen.</p>';
            } else {
                $query_insert = mysqli_query($conn, "INSERT INTO usuario (nombre, correo, usuario, clave, rol)
                                                     VALUES ('$nombre', '$email', '$user', '$pass', '$rol')");
                if ($query_insert)
                {
                    $alert = '<p class="msg_success">Usuario creado correctamente.</p>';
                } else {
                    $alert = '<p class="msg_error">Error al crear el usuario.</p>';
                }
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Registro Usuario</title>
        <?php include 'includes/scripts.php'; ?>
    </head>

    <body>
        <?php include 'includes/header.php'; ?>
        <section id="container">
            <div class="form_register">
                <h1>Registro usuario</h1><hr>
                <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

                <form action="" method="POST">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre completo">
                    <label for="corre">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" placeholder="Correo electrónico">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario">
                    <label for="clave">Clave</label>
                    <input type="password" name="clave" id="clave" placeholder="Clave de acceso">
                    <label for="rol">Tipo Usuario</label>
                    <?php
                        $query_rol = mysqli_query($conn, "SELECT * FROM rol");
                        $res_rol   = mysqli_num_rows($query_rol);
                    ?>
                    <select name="rol" id="rol">
                        <?php
                            if ($res_rol > 0)
                            {
                                while ($rol = mysqli_fetch_array($query_rol))
                                {
                        ?>
                        <option value="<?php echo $rol['idrol']; ?>"><?php echo $rol['rol']; ?></option>
                        <?php
                                }
                            }
                        ?>
                    </select>
                    <input type="submit" value="Crear Usuario" class="btn_save">
                </form>

            </div>
        </section>
        <?php include 'includes/footer.php'; ?>
    </body>

</html>
