<?php

$page = "Les prix de nos services";
$sessioncheck = "true";

include("../templates/header.php");
require_once("../system/config.php");

$queryOptions = $db->query("SELECT * FROM services_options");
$options = $queryOptions->fetchAll();

?>

<div class="pricesPage">

    <div class="categoriesPrices">

        <table class="standardPrices">

            <thead>
                <tr>
                    <th>Nos tarifs</th>
                    <th rowspan="2">
                        <p>Citadine / Compact</p>
                    </th>
                    <th rowspan="2">
                        <p>Berline / Break</p>
                    </th>
                    <th rowspan="2">
                        <p>4X4 / Monospace</p>  
                    </th>
                    <!-- <th rowspan="2">
                        <p>Utilitaire / Camion</p>
                    </th> -->
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td colspan="4">Intérieur
                    </td>
                    <!-- <td rowspan="3">
                        <p>Sur devis</p>
                        <p>
                            <a href="contact.php">Votre demande ici</a>
                        </p>
                    </td> -->
                </tr>
                <tr>
                    <td>
                        <p>Formule standard<hr></p>

                        <div class="formules">
                            <p>Aspiration rapide : tapis, moquettes et sièges</p>
                            <p>Dépoussiérage </p>
                            <p>Nettoyage plastiques</p>
                            <p>Nettoyage des surfaces vitrées intérieures</p>
                        </div>
                        
                    </td>
                    <td>30€</td>
                    <td>35€</td>
                    <td>40€</td>
                    
                </tr>
                <tr>
                    <td>
                        <p>Formule premium<hr></p>

                        <div class="formules">
                            <p>Aspiration : tapis, moquettes et sièges</p>
                            <p>Shampouinage : tapis, moquettes et sièges</p>
                            <p>Dépoussiérage</p>
                            <p>Nettoyage et brillant plastiques</p>
                            <p>Nettoyage des surfaces vitrées intérieures</p>
                            <p>traitement des odeurs</p>
                        </div>
                    </td>
                    <td>60€</td>
                    <td>70€</td>
                    <td>80€</td>
                </tr>
                <tr>
                    <td colspan="4">Extérieur
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Formule standard<hr></p>

                        <div class="formules">
                            <p>Prélavage</p>
                            <p>Lavage</p>
                            <p>Nettoyage des jantes</p>
                            <p>Traitement des pneumatiques</p>
                            <p>Séchage</p>
                        </div>                  
                    </td>
                    <td>30€</td>
                    <td>35€</td>
                    <td>40€</td>
                    
                </tr>
                <tr>
                    <td>
                        <p>Formule premium<hr></p>

                        <div class="formules">
                            <p>Prélavage</p>
                            <p>Lavage</p>
                            <p>Décontamination</p>
                            <p>Nettoyage des jantes</p>
                            <p>Traitement des pneumatiques</p>
                            <p>Traitement des plastiques</p>
                            <p>Lavage intérieurs des portes</p>
                            <p>Lavage trappe à essence</p>
                            <p>Séchage</p>
                            <p>Cire de protection (3 mois)</p>
                        </div>
                    </td>
                    <td>50€</td>
                    <td>60€</td>
                    <td>70€</td>
                </tr>
                <tr>
                    <td colspan="4">Lustrage
                    </td>
                </tr>
                <tr>
                    <td>à la machine (minimum 1 heure)</td>
                    <td>100€</td>
                    <td>125€</td>
                    <td>150€</td>
                </tr>
                <tr>
                    <td colspan="4">Intérieur et extérieur
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Formule standard<hr></p>

                        <div class="formules">
                            <p>Prestation standard intérieure et extérieure</p>
                            <p>(Détails ci-dessus)</p>
                        </div>                  
                    </td>
                    <td>50€</td>
                    <td>55€</td>
                    <td>60€</td>
                    
                </tr>
                <tr>
                    <td>
                        <p>Formule premium<hr></p>

                        <div class="formules">
                            <p>Prestation premium intérieure et extérieure</p>
                            <p>(Détails ci-dessus)</p>
                        </div>
                    </td>
                    <td>80€</td>
                    <td>90€</td>
                    <td>100€</td>
                </tr>
            </tbody>

        </table>

    </div>

    <div class="categoriesPrices">

        <table class="optionsPrices">

        <?php
        foreach ($options as $option) {
        ?>
            <tr>
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

    </div>

</div>

<?php
include("../templates/footer.php")
?>