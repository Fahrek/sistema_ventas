<?php session_start();
    if (empty($_SESSION['active']))
        header('Location: ../');
?>

<header>
    <sector class="header">
        <h1>Sistema Facturación</h1>
        <div class="optionsBar">
            <p>Barcelona, <?php echo fecha(); ?></p>
            <span>|</span>
            <span class="user"><?php echo $_SESSION['user']; ?></span>
            <img src="img/user.png" alt="usuario" class="photouser">
            <a href="../salir.php"><img class="close" title="salir" src="img/salir.png" alt="logout"></a>
        </div>
    </sector>
    <?php include 'nav.php'; ?>
</header>
