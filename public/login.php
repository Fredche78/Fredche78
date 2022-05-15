<?php
// session_start();
require_once '../system/config.php';
/////////////////////////////////////////////////////////////////////////////////////////
//Grâce à cette ligne nous avons une gestion stricte des types 
// declare(strict_types=1);

// //La classe Role ne va pas avoir vocation à être instanciée, nous pouvons donc utiliser une classe abstraite. On utilise le mot clé abstract. 
// abstract class Role
// {
//     //Constantes de classe
//     //Ces constantes sont naturellement statiques autrement dit on fait appel à ces propriétés via la classe et non via une instance de la classe.
//     const ADMIN = "admin";
//     const USER = "user";

//     // Lorsque vous voyez la mention static dans la déclaration d'une méthode cala signifie que la méthode est statique et ne pourra être appelé que via la classe.
//     public static function getRoles(): array
//     {
//         // Le mot clé self permet de faire référence à la classe courante. Ne pas confondre avec $this qui fait référence à une instance de la classe.
//         return array(self::USER, self::ADMIN);
//     }
// }
// //L'utilisation d'une interface permet de lister la déclaration des méthodes à implémenter dans une classe par la suite.
// interface IUser
// {
//     public function getFullname(): string;
//     public function isAdmin(): bool;
// }

// //Pour utiliser (implémenter) une interface, il faut utiliser le mot clé impléments
// class User implements IUser
// {

//     // La propriété role ne sera pas accessible via l'instance de la classe User car nous utilisons le mot clé protected.
//     // Role::USER permet de faire appel à la propriété statique USER de la classe Role
//     protected $role = Role::USER;

//     public function __construct(string $firstname, string $lastname, string $email)
//     {
//         //Sans même le précidez firstname et lastname ont une visibilité public
//         $this->firstname = $firstname;
//         $this->lastname = $lastname;
//         $this->email = $email;
//     }

//     // LE mot clé finale en préfixe de la déclaration de la méthode indique que la méthode ne pourra pas être surchargée dans la ou les classes enfants.

//     public function getFullname(): string
//     {
//         return "{$this->firstname} {$this->lastname} {$this->email}"; // ou "$this->firstname ." ". this->lastname"
//     }

//     final public function isAdmin(): bool
//     {
//         return $this->role === Role::ADMIN;

//         //Redéfinir la méthode n'est pas possible car la méthode de la classe mère dispose du mot clé final qui empêche la srucharge de cette méthode dans une classe enfant
//         // public function isAdmin() {}
//     }
// }

// //Pour hériter d'une classe on utilise le mot clé extends
// class Admin extends User
// {
//     protected $role = Role::ADMIN;

//     // Redéfinir un constructeur pour ajouter des propriétés supplémentaires
//     public function __construct(string $firstname, string $lastname, string $email, string $controlArea)

//     {
//         parent::__construct($firstname, $lastname, $email);
//         $this->controlArea = $controlArea;
//     }
// }

// $db = new PDO("mysql:host=localhost;dbname=sbpolish", "root", "");

// $query = $db->query("SELECT * FROM users");
// $users = $query->fetchAll();

// foreach ($users as $user) {
//     # code...
// }



// //On créé une isntance de la classe User / autrement dit on génère un objet de type User.
// // $user = new User("Jean-Francis", "Simpson", "Simpson");
// // pour faire appel à une propriété ou une méthode de cet objet on utilise ->
// echo $user->getFullname();
// var_dump($user->isAdmin());

// // $admin = new Admin("Quentin", "Danna", "pizzeria");
// echo $admin->getFullname();

// var_dump($admin->isAdmin());

// //On fait appele à la méthode statique getRoles de la classe Role.
// $roles = Role::getRoles();
// var_dump($roles);

///////////////////////////////////////////////////////////////////////////////////////////

$error = "";

if (!empty($_POST)) {
    $email = trim(strip_tags($_POST["email"]));
    $password = trim(strip_tags($_POST["password"]));

    // $db : Vient de config.php
    $query = $db->prepare("SELECT * FROM users WHERE email LIKE :email");
    $query->bindParam(":email", $email);
    $query->execute();
    //Si vous ne voulez pas avoir les résultats en doublon il faut ajouter PDO::FETCH_ASSOC
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // if ($password == $result["password"]) pas possible de le tester comme ça car nous avons d'un côté une donnée non cryptée et une donnée cryptée
    // if ($password_hash($password) == $result["password"]) pas possible non plus car le hash généré par password_hash change à chaque appel

    // password_verify va nous permettre de vérifier la correspondance entre le mot de passe saisi et le hash saisi et le hash stocké en BDD.
    if (!empty($result) && password_verify($password, $result["password"])) {

        ///////////////////////////////////////////////////////
        session_start();
        //////////////////////////////////////////////////////

    
        //On stocke le prénom, le nom et l'email dans des variables de session
        $_SESSION["user"] = $result["firstname"];
        $_SESSION["userName"] = $result["lastname"];
        $_SESSION["email"] = $result["email"];
        
        // On stocke l'adresse IP de l'utilisateur pour palier à une possible attaque "session hijacking"
        $_SESSION["user_ip"] = $_SERVER["REMOTE_ADDR"];
        // REMOTE_ADDR donne l'adresse ip de l'appelant
        // Redirection vers la page d'accueil
        
        $token = bin2hex(random_bytes(50));
        $validity = time() + 7200;

        $query = $db->prepare("INSERT INTO user_reset (email, token, validity) VALUES (:email, :token, :validity)");
        $query->bindParam(":email", $email);
        $query->bindParam(":token", $token);
        //On lie la durée de validity
        $query->bindParam(":validity", $validity, PDO::PARAM_INT);

        if ($query->execute()) {
            $_SESSION["token"] = $token;
        }

        header("Location: index.php");

    } else {
        $error = "Identifiant et/ou mot de passe incorrect(s)";
    }
}

$page="Connexion";
include("../templates/header.php")
?>

<div class="contact">

    <h1>Connexion</h1>

    <p id="errorLogin">
        <?= $error ?>
    </p> 

    <div class="form">

        <form action="" method="post">
            <div class="container">
                <div class="form-group-account">
                    <div class="form-item-group">
                        <label for="inputEmail">Email :</label>
                        <input type="email" name="email" id="inputEmail">

                        <label for="inputPassword">Mot de passe :</label>
                        <input type="password" name="password" id="inputPassword">
                        <p id="resetPwd">
                            <a href="reset_password.php">J'ai oublié mon mot de passe
                            </a>
                        </p>           
                    </div>
                </div>
                <input type="submit" value="Se connecter">
            </div>
        </form>

    </div>

</div>

<?php
include("../templates/footer.php")
?>