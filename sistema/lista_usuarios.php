<?php
include '../conexion.php'
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Lista de Usuarios</title>
        <?php include 'includes/scripts.php'; ?>
    </head>

    <body>
        <?php include 'includes/header.php'; ?>
        <section id="container">

            <h1>Lista de Usuarios</h1>
            <a href="registro_usuario.php" class="btn-new">Crear usuario</a>

            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $query = mysqli_query($conn, "SELECT u.`idusuario`, u.`nombre`, u.`correo`, u.`usuario`, r.`rol` 
                    FROM `usuario` u 
                    INNER JOIN `rol` r 
                    ON u.`rol` = r.idrol
                    ");
                    $result = mysqli_num_rows($query);

                    if ($result > 0) {
                        while ($data = mysqli_fetch_array($query)) {
                            ?>

                            <tr>
                                <td><?php echo $data['idusuario']; ?></td>
                                <td><?php echo $data['nombre']; ?></td>
                                <td><?php echo $data['correo']; ?></td>
                                <td><?php echo $data['usuario']; ?></td>
                                <td><?php echo $data['rol']; ?></td>
                                <td>
                                    <a href="#" class="link_edit">Editar</a>
                                    |
                                    <a href="#" class="link_delete">Eliminar</a>
                                </td>
                            </tr>

                        <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
<?php include 'includes/footer.php'; ?>
    </body>

</html>


