<?php
$page="Toutes les demandes";
session_start();
require_once '../system/config.php';

// $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");
$queryRequests = $db->query("SELECT * FROM contacts
                            ORDER BY id DESC");
$requests = $queryRequests->fetchAll();
// var_dump($requests);
include("../templates/header.php")
?>

<div class="requests">

    <div class="requestsTable">

        <h1>Demandes</h1>

        <div class="listRequests">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Demande</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Ville</th>
                        <th>Véhicule(s)</th>
                        <th>Message</th>
                        <th>Photo 1</th>
                        <th>Photo 2</th>
                        <th>Photo 3</th>
                        <th>Voir</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($requests as $request) {
                    ?>
                        <tr>
                            <td><?= $request["id"] ?></td>
                            <td><?= $request["question"] ?></td>
                            <td><?= $request["firstname"] ?></td>
                            <td><?= $request["lastname"] ?></td>
                            <td><?= $request["phone"] ?></td>
                            <td><?= $request["email"] ?></td>
                            <td>
                                <?php
                                if (!empty($request['city'])) {
                                    echo $request['city'];
                                } else {
                                    echo " - ";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($request['vehicule'])) {
                                    echo $request['vehicule'];
                                } else {
                                    echo " - ";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($request['message'])) {
                                    echo "Oui";
                                } else {
                                    echo " - ";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($request['photo'])) {
                                    echo "Oui";
                                } else {
                                    echo " - ";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($request['photo2'])) {
                                    echo "Oui";
                                } else {
                                    echo " - ";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (!empty($request['photo3'])) {
                                    echo "Oui";
                                } else {
                                    echo " - ";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="request_view.php?id=<?= $request['id']  ?> ">Voir
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    

</div>
<div class="adminLink">
        <a href="home_admin.php">Page d'administration</a>
</div>


<?php
include("../templates/footer.php")
?>