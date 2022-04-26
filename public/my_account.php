<?php
include("../templates/header.php")
?>

<?php
// On teste que l'utilisateur est bien connecté
if (!isset($_SESSION["user"]) || $_SESSION["user_ip"] !=$_SERVER ["REMOTE_ADDR"]) {
    // Vas-y dégage ! -> rediriger vers la page de login
    header("Location: login.php");
}
?>

<h1>Mon compte utilisateur</h1>


    <h2>Le compte utilisateur de <?= $_SESSION["user"] ." ". $_SESSION["userName"] ?></h2>


<?php
// var_dump($_SESSION);
include("../templates/footer.php")
?>