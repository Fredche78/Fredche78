<?php
$page="Les prix de nos services";
session_start();
include("../templates/header.php")
?>

<div class="pricesPage">

    <div class="categoriesPrices">

        <table class="standardPrices">

            <thead>
                <tr>
                    <th></th>
                    <th rowspan="2">
                        <p>Catégorie A</p>
                        <p>Citadide / Compact</p>
                    </th>
                    <th rowspan="2">
                        <p>Catégorie B</p>
                        <p>Berline / Break</p>
                    </th>
                    <th rowspan="2">
                        <p>Catégorie C</p>
                        <p>4X4 / Monospace</p>
                    </th>
                    <th rowspan="2">
                        <p>Catégorie D</p>
                        <p>Utilitaire / Camion</p>
                    </th>
                </tr>
                <tr>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Intérieur</td>
                    <td>60€</td>
                    <td>70€</td>
                    <td>80€</td>
                    <td rowspan="3">
                        <p>Sur devis</p>
                        <p>
                            <a href="contact.php">Votre demande ici</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>Extérieur</td>
                    <td>+30€*</td>
                    <td>+30€*</td>
                    <td>+30€*</td>
                </tr>
                <tr>
                    <td>Polissage</td>
                    <td>400€</td>
                    <td>450€</td>
                    <td>500€</td>
                    <!-- <td>X</td> -->
                </tr>
                <tr>
                    <td colspan="5">
                        <p>* Plus 30€ sur le tarif appliqué sur l'intérieur</p>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

    <div class="categoriesPrices">

        <table class="optionsPrices">
            <tr>
                <td colspan="7">
                    <p>
                        Cire de protection hydrophobe - pose à la main
                    </p>
                    <p>
                        Protège votre véhicule pendant 3 mois et plus
                    </p>
                </td>
                <td>
                    <p>
                        10€
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <p>
                        Cire de protection hydrophobe - pose en spray
                    </p>
                    <p>
                        Protège votre véhicule pendant 3 mois et plus
                    </p>
                </td>
                <td>
                    <p>
                        20€
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <p>
                        Traitement en profondeur de tous les cuirs
                    </p>
                </td>
                <td>
                    <p>
                        30€
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <p>
                        Nettoyage en profondeur du plafonnier
                    </p>
                </td>
                <td>
                    <p>
                        20€
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <p>
                        Intérieur de couleur clair
                    </p>
                </td>
                <td>
                    <p>
                        30€
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <p>
                        Traitement hydrophobe des vitres
                    </p>
                </td>
                <td>
                    <p>
                        20€
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <p>
                        Nettoyage du sable
                    </p>
                    <p>
                        Vous revenez de vacances ? Nous traitons en profondeur votre véhicule
                    </p>
                </td>
                <td>
                    <p>
                        20€
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <p>
                        Nettoyage du compartiment moteur

                    </p>
                </td>
                <td>
                    <p>
                        30€
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <p>
                        Traitement céramique de la carosserie
                    </p>
                </td>
                <td>
                    <p>
                        sur devis
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <p>
                        Déplacement jusqu'à 20km de Valenciennes offert. Au delà 0.5€ du kilomètre
                    </p>
                </td>
            </tr>
        </table>

    </div>
    
</div>

<!-- <div class="options">

        <div class="option">
            <div class="nameOption">
                <p>
                    Cire de protection hydrophobe
                </p>
            </div>
            <div class="txtoption">
                <p>
                    protège votre véhicule pendant 3 mois et plus
                </p>
            </div>
        </div>
        <div class="priceOption">
            <p>
                10€
            </p>
        </div>

    </div> -->

</div>




<?php
include("../templates/footer.php")
?>