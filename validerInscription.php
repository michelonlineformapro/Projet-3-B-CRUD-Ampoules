<?php
//1- COnnexion a la  base de données Ecommerce et Instance de la classe PDO
ob_start();
$user = "root";
$pass = "";

try {
    $db = new PDO("mysql:host=localhost;dbname=ecommerce;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    echo "Erreur de connexion " .$e->getMessage();
}

//2 verifier les champs du formulaire
if(isset($_POST['email_employe']) && !empty($_POST['email_employe'])){
    $email = htmlspecialchars(strip_tags($_POST['email_employe']));
}else{
    echo "<p class='alert-danger p-3'>Merci de remplir le champ email</p>";
}

//2 verifier les champs du formulaire
if(isset($_POST['password_employe']) && !empty($_POST['password_employe'])){
    $password = htmlspecialchars(strip_tags($_POST['password_employe']));
}else{
    echo "<p class='alert-danger p-3'>Merci de remplir le champ mot de passe</p>";
}

//3 verifiée que l'email n'est pas deja dans la base
if(empty(trim($_POST['email_employe']))){
    echo "<p class='alert-danger p-3'>Merci de remplir le champ email</p>";
}else{
    //4 La requète SQL
    $sql = "SELECT COUNT(*) FROM employes WHERE email_employe = ?";
    //5 Prepartion de la requète
    $stmt = $db->prepare($sql);
    //6 passage des paramètres
    $stmt->bindParam(1, $_POST['email_employe']);
    //Execution de la requète
    $result = $stmt->execute(array($_POST['email_employe']));
    $result = $stmt->fetch();

    //Il recupere element 0 du tableau et on verifie qu'il n'est identique
    //c'est aquivalent a = if($_POST['email_employe'] === $result['email_employe']){
        if($result[0] == 0){
            $email = htmlspecialchars(strip_tags($_POST['email_employe']));
        //7 creation et hash du mot de passe
        if(empty(trim($_POST['password_employe']))){
            echo "<p class='alert-danger p-3'>Merci de remplir le champ mot de passe</p>";
            //On veut que le mout de passe contienne 8 lettres minimum
        }elseif (strlen(trim($_POST['password_employe'])) < 8){
            echo "<p class='alert-danger p-3'>Erreur : votre mot de passe doit contenir au moin 8 lettres</p>";
            echo "<a href='inscription.php' class='btn btn-dark'>Recommencer</a>";
            //Le mot de passe doit etre le meme que le mot de passe répété
        }elseif ($_POST['password_employe'] != $_POST['confirm_password_employe']){
            echo "<p class='alert-danger p-3'>Les 2 mot de passe sont différents</p>";
            echo "<a href='inscription.php' class='btn btn-dark'>Recommencer</a>";
            //Le champ confirmé ne doit pas etre vide
        }elseif (empty(trim($_POST['confirm_password_employe']))){
            echo "<p class='alert-danger p-3'>Merci de remplir le champ confirmer votre mot de passe</p>";
        }else{
            //8 Requète d'insertion des champs du formulaires
            $sqlInsert = "INSERT INTO employes (email_employe, password_employe) VALUES (?,?)";
            //9 requète preparée
            $insertUser = $db->prepare($sqlInsert);
            //10 lier les paramètres
            $insertUser->bindParam(1, $_POST['email_employe']);
            $insertUser->bindParam(2, $_POST['password_employe']);

            //Paramètres de securité
            $param_email = $email;
            //Hash en BCRYPT du mot de passe
            $param_password = password_hash($password, PASSWORD_BCRYPT);

            $enregistrer = $insertUser->execute(array($_POST['email_employe'], $param_password));

            //Condition pour afficher les resultats
            if($enregistrer){
                //Redirection vers la page de login
                header("location:http://localhost/Ampoules/");
            }else{
                echo "<p class='alert-danger p-3'>Une erreur est survenue durant l'inscription</p>";
            }

            /**Ici test envois email pour validation de compte
             * <?php
            $to      = 'personne@example.com';
            $subject = 'le sujet';
            $message = 'Bonjour !';
            $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            ?>
             */

        }
            return false;
        }else{
            echo "<p class='alert-danger p-3'>Cette email n'est pas disponible</p>";
            return true;
        }

}


$content = ob_get_clean();
require "template.php";