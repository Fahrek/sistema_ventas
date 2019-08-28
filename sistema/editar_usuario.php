<?php require_once '../conexion.php';

    if ($_POST)
    {
        $alert = '';
        if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol']))
        {
            $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
            
        } else {
            
            $idUsuario = $_POST['idUsuario'];
            $nombre    = $_POST['nombre'];
            $email     = $_POST['correo'];
            $user      = mysqli_real_escape_string($conn, $_POST['usuario']);
            $pass      = md5(mysqli_real_escape_string($conn, $_POST['clave']));
            $rol       = $_POST['rol'];

            $query = mysqli_query($conn, "SELECT * FROM usuario "
                                                . "WHERE (usuario = '$user'  AND idusuario != $idUsuario) "
                                                . "OR    (correo  = '$email' AND idusuario != $idUsuario) ");
            $result = mysqli_fetch_array($query);
            
            

            if ($result > 0)
            {
                $alert = '<p class="msg_error">El usuario o el correo ya existen.</p>';
                
            } else {
                
                if (empty($_GET['clave'])) {
                    
                    $sql_update = mysqli_query($conn, "UPDATE usuario "
                                                    . "SET nombre = '$nombre', correo = '$email', usuario = '$user', rol = '$rol' "
                                                    . "WHERE idusuario = $idUsuario");
                } else {
                    
                    $sql_update = mysqli_query($conn, "UPDATE usuario "
                                                    . "SET nombre = '$nombre', correo = '$email', usuario = '$user', clave = '$clave', rol = '$rol' "
                                                    . "WHERE idusuario = $idUsuario");
                }
                
                if ($sql_update) {
                    
                    $alert = '<p class="msg_success">Usuario actualizado correctamente.</p>';
                    
                } else {
                    
                    $alert = '<p class="msg_error">Error al actualizar el usuario.</p>';
                }
            }
        }
    }
    
    // Mostrar datos
    if (empty($_GET['id'])) {
        header('Location: lista_usuarios.php');
    }
    
    $iduser = $_GET['id'];
    
    $sql = mysqli_query($conn, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol, (r.rol) as rol
                                FROM usuario u
                                INNER JOIN rol r
                                ON u.rol = r.idrol
                                WHERE idusuario = $iduser");
    
    $res = mysqli_num_rows($sql);
    
    if ($res == 0) {
        
        header('Location: lista_usuarios.php');
        
    } else {
        
        $option = '';
        
        while ($data = mysqli_fetch_array($sql)) {
            $idusuario = $data['idusuario'];
            $nombre    = $data['nombre'];
            $correo    = $data['correo'];
            $usuario   = $data['usuario'];
            $idrol     = $data['idrol'];
            $rol       = $data['rol'];
            
            if ($idrol == 1) {
                $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
            } elseif ($idrol == 2) {
                $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
            } else {
                $option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Actualizar Usuario</title>
        <?php include 'includes/scripts.php'; ?>
    </head>

    <body>
        <?php include 'includes/header.php'; ?>
        <section id="container">
            <div class="form_register">
                <h1>Actualizar usuario</h1><hr>
                <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

                <form method="POST">
                    <input type="hidden" name="idUsuario" value="<?php echo $iduser; ?>">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
                    <label for="corre">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" value="<?php echo $correo; ?>">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
                    <label for="clave">Clave</label>
                    <input type="password" name="clave" id="clave" placeholder="password">
                    <label for="rol">Tipo Usuario</label>
                    <?php
                        $query_rol = mysqli_query($conn, "SELECT * FROM rol");
                        $res_rol   = mysqli_num_rows($query_rol);
                    ?>
                    <select name="rol" id="rol" class="notItemOne">
                        <?php
                            echo $option;
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
                    <input type="submit" value="Actualizar Usuario" class="btn_save">
                </form>

            </div>
        </section>
        <?php include 'includes/footer.php'; ?>
    </body>

</html>


