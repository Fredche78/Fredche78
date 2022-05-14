<?php
//Chargement des dépendances Composer
require("../vendor/autoload.php");

require_once '../system/config.php';

use PHPMailer\PHPMailer\PHPMailer;

// Création d'une constante pour générer le lien de réinitialisation du mot de passe
define("HOST", "http://localhost/sbpolish/public/");

if (isset($_POST["email"])) {
    $email = trim(strip_tags($_POST["email"]));

    // $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");
    
    // Vérification de l'existence d'un utilisateur avec cette adresse mail
    $query = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
    $query->bindParam(":email", $email);
    $query->execute();
    $result = $query->fetch();

    if ($result) {
        // La fonction random_bytes renvoie un binaire que nous transformons en une chaine hexadécimale avec la fonction bin2hex
        // Si nous indiquons 50 en paramètre de la fonction random_bytes nous obtiendrions un chaine de 100 caractères.
        $token = bin2hex(random_bytes(50));
        $validity = time() + 3600;

        $query = $db->prepare("INSERT INTO password_reset (email, token, validity) VALUES (:email, :token, :validity)");
        $query->bindParam(":email", $email);
        $query->bindParam(":token", $token);
        //On lie la durée de validity
        $query->bindParam(":validity", $validity, PDO::PARAM_INT);

        if ($query->execute()) {

            /* ?><p>Email envoyé</p><?php */


            //L'insertion en base est ok, on peut passer à l'envoie du mail
            // On fait appel au constructeur de la classe PHPMailler
            $phpmailer = new PHPMailer;
            // On indique que l'on utilise le protocole SMTP
            $phpmailer->isSMTP();
            // Informations du compte Mailtrap
            $phpmailer->Host = 'smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '14df232268ecb9';
            $phpmailer->Password = '03cafa05c63ac5';

            // Expéditeur
            $phpmailer->From = "contact@sbpolish.fr";
            // Nom à afficher à la place de l'adresse mail
            $phpmailer->FromName = "S.B Polish";

            //Destinataire
            $phpmailer->addAddress($email);

            //On indique que le contenu du mail sera du code HTML
            $phpmailer->isHTML();

            // Sujet (titre) du mail
            $phpmailer->Subject = "Réinitialisation du mot de passe";

            //Corps du mail
            $phpmailer->Body = "

            <div class=\"resetMail\">
            
                <h1>Réinitilisation de votre mot de passe</h1>

                <p>Madame, Monsieur,</p>
                <p>Faisant suite à votre demande, veuillez trouver ci-dessous, le lien afin de réinitialiser votre mot de passe</p>

                <a href=\"" . HOST . "new_password.php?token={$token} \">
                Suivez ce lien pour réinitialiser votre mot de passe
                </a>

            </div>
            
            ";

            // Encodage UTF-8
            $phpmailer->CharSet  = "UTF-8";
            //Envoi du mail
            $phpmailer->send();

            header("Location: login.php");
        }
    }
}
?>

<?php
include("../templates/header.php")
?>

<div class="contact">

    <h1>Mot de passe oublié</h1>
    <h2>Un lien va vous être envoyé par Email</h2>

    <div class="form">
        <form action="" method="post">
            <div class="container">
                <div class="form-group-account">
                    <div class="form-item-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" name="email" id="inputEmail">
                    </div>
                </div>

                <input type="submit" value="Envoyer">
            </div>
        </form>
    </div>
</div>

</html>