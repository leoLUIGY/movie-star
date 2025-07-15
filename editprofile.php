<?php 
    require_once("templates/header.php");

    require_once("dao/UserDAO.php");

    $userDAO = new UserDAO($conn, $BASE_URL);
    $user = $userDAO->verifyToken(true);
?>

    <div id="main-container" class="container-fluid">
        <h1>Ediçao de Perfil</h1>
    </div>

<?php
    require_once("templates/footer.php");
?>
