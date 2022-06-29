<?php
$page = "Page administration des prix";
$sessioncheck = "true";

include("../templates/header.php");
require_once("../system/config.php");

if ($_SESSION["role"] != "administrateur") {
    session_destroy();
    header("Location: login.php");
}

/////////////////////////////////////SELECT////////////////////////////////////

$queryPrices = $db->query("SELECT * FROM prices");
$prices = $queryPrices->fetchAll();

$queryOptions = $db->query("SELECT * FROM services_options");
$options = $queryOptions->fetchAll();

$errors = [];

$queryServices = $db->query("SELECT prices.id, prices.type, prices.formule AS 'colonnes', 
GROUP_CONCAT(services_names.name SEPARATOR '<br>') AS 'services' 
FROM services_names
INNER JOIN prices_services_names
ON services_names.id = prices_services_names.services_names_id
INNER JOIN prices
ON prices.id = prices_services_names.prices_id
group by prices.id");
$services = $queryServices->fetchAll();

///////////////////////////////////INSERT INTO/////////////////////////////////////

if (!empty($_POST["addOption"])) {

    $nameOption = trim(strip_tags($_POST["nameOption"]));
    $descriptionOption = trim(strip_tags($_POST["descriptionOption"]));
    $priceOption = trim(strip_tags($_POST["priceOption"]));

    if (empty($nameOption)) {
        $errors["nameOption"] = " Le nom du service doit être complété ";
    }

    if (empty($priceOption)) {
        $errors["priceOption"] = "Le type de service est obligatoire";
    }

    if (empty($errors)) {

        $addOption = $db->prepare("INSERT INTO services_options (name, description, price) VALUES (:nameOption, :descriptionOption, :priceOption)");
        $addOption->bindParam(":nameOption", $nameOption);
        $addOption->bindParam(":descriptionOption", $descriptionOption);
        $addOption->bindParam(":priceOption", $priceOption);

        if ($addOption->execute()) {
            header("Location: prices_admin.php#optionsAdmin");
        }
    }
}

if (!empty($_POST["addPrestation"])) {

    $nameOption = trim(strip_tags($_POST["nameOption"]));
    $descriptionOption = trim(strip_tags($_POST["descriptionOption"]));
    $priceOption = trim(strip_tags($_POST["priceOption"]));

    if (empty($nameOption)) {
        $errors["nameOption"] = " Le nom du service doit être complété ";
    }

    if (empty($priceOption)) {
        $errors["priceOption"] = "Le type de service est obligatoire";
    }

    if (empty($errors)) {

        $addOption = $db->prepare("INSERT INTO services_options (name, description, price) VALUES (:nameOption, :descriptionOption, :priceOption)");
        $addOption->bindParam(":nameOption", $nameOption);
        $addOption->bindParam(":descriptionOption", $descriptionOption);
        $addOption->bindParam(":priceOption", $priceOption);

        if ($addOption->execute()) {
            header("Location: prices_admin.php#optionsAdmin");
        }
    }
}

////////////////////////////////////// DELETES ////////////////////////////////////////

if (!empty($_POST["deleteOption"])) {

    $deleteOption = trim(strip_tags($_POST["deleteOption"]));

    $supOption = $db->prepare("DELETE FROM services_options WHERE services_options.id = :idOption");
    $supOption->bindParam(":idOption", $deleteOption, PDO::PARAM_INT);

    if ($supOption->execute()) {
        header("Location: prices_admin.php#optionsAdmin");
    } else {
        $message = "Erreur de bdd";
    }
}

///////////////////////////////////////UPDATE//////////////////////////////////////////

if (isset($_POST["updateOptions"])) {

    $idOptionUp = trim(strip_tags($_POST["idOptionUp"]));
    $nameOptionUp = trim(strip_tags($_POST["nameOptionUp"]));
    $descriptionOptionUp = trim(strip_tags($_POST["descriptionOptionUp"]));
    $priceOptionUp = trim(strip_tags($_POST["priceOptionUp"]));

    $queryUpdateOption = $db->prepare("UPDATE services_options
                                SET name = :nameOptionUp,
                                description = :descriptionOptionUp,
                                price = :priceOptionUp
                                WHERE id LIKE :idOptionUp");

    $queryUpdateOption->bindParam(":idOptionUp", $idOptionUp, PDO::PARAM_INT);
    $queryUpdateOption->bindParam(":nameOptionUp", $nameOptionUp);
    $queryUpdateOption->bindParam(":descriptionOptionUp", $descriptionOptionUp);
    $queryUpdateOption->bindParam(":priceOptionUp", $priceOptionUp);

    if ($queryUpdateOption->execute()) {

        header("Location: prices_admin.php#optionsAdmin");
        
    } else {

        $message = "Erreur de bdd";
    }
}

?>

<div class="pricesAdmin">

    <?php
    foreach ($prices as $price) {
    ?>
        <div class="pricesFormules">
            <h2>Formule <?= $price["type"] ?> <?= $price["formule"] ?></h2>
            <?php
            foreach ($services as $service) if ($price["id"] === $service["id"]) {
            ?>
            <p><?= $service["services"] ?></p>
            <?php
            }
            ?>
            <p>Prix: <?= $price["price_A"] ?>€ <?= $price["price_B"] ?>€ <?= $price["price_C"] ?>€ </p>
        </div>
        <hr>
    <?php
    }
    ?>
    <table class="optionsAdmin" id="optionsAdmin">

        <?php
        foreach ($options as $option) {
        ?>
            <tr>
                <td>
                    <p>
                        <?= $option["id"] ?>
                    </p>
                </td>
                <td colspan="7">
                    <p>
                        <?= $option["name"] ?>
                    </p>
                    <p>
                        <?= $option["description"] ?>
                    </p>
                </td>
                <td>
                    <p>
                        <?= $option["price"] ?>
                    </p>
                </td>
                <td>
                    <form action="" method="post">
                        <button class="btn-delete" name="deleteOption" type="submit" value="<?= $option['id'] ?>">X</button>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="8">
                <p>
                    Déplacement gratuit sur Valenciennes. Au delà, 1€ du kilomètre.
                </p>
            </td>
        </tr>
    </table>

    <form action="" method="post">
        <div class="addOption">
            <label for="nameOption">
                Nom*
            </label>
            <input type="text" id="nameOption" name="nameOption" value="<?= isset($nameOption) ? $nameOption : "" ?>">

            <label for="descriptionOption">
                Description
            </label>
            <input type="text" id="descriptionOption" name="descriptionOption" value="<?= isset($descriptionOption) ? $descriptionOption : "" ?>">

            <label for="priceOption">
                Prix*
            </label>
            <input type="text" id="priceOption" name="priceOption" value="<?= isset($priceeOption) ? $priceOption : "" ?>">

            <input type="submit" name="addOption" value="Ajouter">
        </div>
    </form>

    <form action="" method="post">
        <div class="form-admin-group">
            <div class="updateOptions">
                <label for="idOptionUp">ID</label>
                <input type="text" id="idOption" name="idOptionUp">

                <label for="nameOptionUp">Nom</label>
                <input type="text" id="nameOptionUp" name="nameOptionUp">

                <label for="descriptionOptionUp">Description</label>
                <input type="text" id="descriptionOptionUp" name="descriptionOptionUp">

                <label for="priceOptionUp">Prix</label>
                <input type="text" id="priceOptionUp" name="priceOptionUp">

                <input type="submit" name="updateOptions" class="btn-submit" value="Mise à jour">
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div class="form-admin-group">
            <div class="updateServices">
                <label for="selectPrestation">Type de prestation</label>
                <select name="prestation" id="selectPrestation">
                    <option value="1">Intérieur standard</option>
                    <option value="2">Intérieur premium</option>
                    <option value="3">Extérieur standard</option>
                    <option value="4">Extérieur premium</option>
                    <option value="7">Lustrage</option>
                </select>
                <label for="serviceAdd"></label>
                <input type="text" id="serviceAdd" name="serviceAdd">
                <input type="submit" name="addPrestation" value="Ajouter">
            </div>
        </div>
    </form>

</div>