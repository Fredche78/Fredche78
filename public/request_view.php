<?php
$page="Détail des demandes";
session_start();
require_once '../system/config.php';
////////////////////////GET//////////////////////////

if (isset($_GET["id"])) {
    // $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");
    $queryRequests = $db->query("SELECT * FROM contacts
                                    WHERE id = {$_GET['id']}");
    $request = $queryRequests->fetch(PDO::FETCH_ASSOC);
    // var_dump($request);
}

////////////////////DELETE/////////////////////////

if (isset($_POST["deleteRequest"])) {

    $delete = $_POST["deleteRequest"];
    $supRequest = $db->prepare("DELETE FROM contacts WHERE id= :id");
    $supRequest->bindParam(":id", $delete);

    if ($supRequest->execute()) {

        unlink("assets/img/photos/devis/" . $request['photo']);
        unlink("assets/img/photos/devis/" . $request['photo2']);
        unlink("assets/img/photos/devis/" . $request['photo3']);

        header("Location: request.php");
    } else {
        $message = "Erreur de bdd";
    }
}

include("../templates/header.php")
?>

<div class="quote">

    <h1><?= $request["question"] ?></h1>

    <div class="viewQuote">

        <div class="contact">

            <div class="rows">

                <div class="row">
                    <span>Demande n°</span> <?= $request["id"] ?>
                </div>
                <div class="row">
                    <span>Client:</span> <?= $request["firstname"] . " " . $request["lastname"] ?>
                </div>
                <div class="row">
                    <span>Téléphone:</span> <?= $request["phone"] ?>
                </div>
                <div class="row">
                    <span>Email:</span> <?= $request["email"] ?>
                </div>
                <div class="row">
                    <span>Ville:</span> <?= $request["city"] ?>
                </div>
                <div class="row">
                    <span>Véhicule(s):</span> <?= $request["vehicule"] ?>
                </div>

            </div>

            <div class="delete">

                <form action="" method="post">
                    <button class="btn-delete" name="deleteRequest" type="submit" value="<?= $request['id'] ?>">Effacer la demande</button>
                </form>

            </div>

        </div>

        <div class="message">

            <h2>Message</h2>

            <div class="viewMessage">
                <?= $request["message"] ?>
            </div>

        </div>
    </div>

    <div class="photos">

        <div class="photo">
            <?php
            if (empty($request['photo'])) {
            ?>
                <img src="./assets/img/image.svg" class="placeholderView" alt="Pas de photo">
            <?php
            } else {
            ?>
                <a href="assets/img/photos/devis/<?= $request['photo'] ?>" target="_blank">
                    <img src="assets/img/photos/devis/<?= $request['photo'] ?>" alt="<?= $request["photo"] ?>">
                </a>

                <div class="download">
                    <a href="assets/img/photos/devis/<?= $request['photo'] ?>" download="<?= $request['photo'] ?>">
                        <p>Télécharger l'image</p>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>

        <div class="photo">
            <?php
            if (empty($request['photo2'])) {
            ?>
                <img src="./assets/img/image.svg" class="placeholderView" alt="Pas de photo">
            <?php
            } else {
            ?>
                <a href="assets/img/photos/devis/<?= $request['photo2'] ?>" target="_blank">
                    <img src="assets/img/photos/devis/<?= $request['photo2'] ?>" alt="<?= $request["photo2"] ?>">
                </a>

                <div class="download">
                    <a href="assets/img/photos/devis/<?= $request['photo2'] ?>" download="<?= $request['photo2'] ?>">
                        <p>Télécharger l'image</p>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="photo">
            <?php
            if (empty($request['photo3'])) {
            ?>
                <img src="./assets/img/image.svg" class="placeholderView" alt="Pas de photo">
            <?php
            } else {
            ?>
                <a href="assets/img/photos/devis/<?= $request['photo3'] ?>" target="_blank">
                    <img src="assets/img/photos/devis/<?= $request['photo3'] ?>" alt="<?= $request["photo3"] ?>">
                </a>

                <div class="download">
                    <a href="assets/img/photos/devis/<?= $request['photo3'] ?>" download="<?= $request['photo3'] ?>">
                        <p>Télécharger l'image</p>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

</div>



<div class="back">
    <a href="request.php">Retour
    </a>
</div>

<?php
include("../templates/footer.php")
?>