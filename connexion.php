<?php

//1- COnnexion a la  base de données Ecommerce et Instance de la classe PDO
ob_start();
$user = "root";
$pass = "";

try {
    $db = new PDO("mysql:host=localhost;dbname=ecommerce;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion " . $e->getMessage();
}

//On demarre la session
session_start();
//si session connecter retourne la page d'accueil
if(isset($_SESSION['connecter']) && $_SESSION['connecter'] === true){
    header("Location:http://localhost/Ampoules/listeAmpoule.php?page=1");
}

//1 verifiée les champ du formulaire de connexion
if(isset($_POST['email_employe']) && !empty($_POST['email_employe'])){
    $email = htmlspecialchars(strip_tags($_POST['email_employe']));
}else{
    echo "<p class='alert-danger p-3'>Merci de remplir le champ email</p>";
}

//1 verifiée les champ du formulaire de connexion
if(isset($_POST['password_employe']) && !empty($_POST['password_employe'])){
    $password = htmlspecialchars(strip_tags($_POST['password_employe']));
}else{
    echo "<p class='alert-danger p-3'>Merci de remplir le champ mot de passe</p>";
}
//Verfifié que les champs champs ne sont pas vides
if(!empty($_POST['email_employe']) && !empty($_POST['password_employe'])){
    //Requète de selection filtré a mail et mot passe
    $sql = "SELECT * FROM employes WHERE email_employe = :email_employe AND password_employe = :password_employe";
    //Requete préparée
    $stmt = $db->prepare($sql);
    //Passage des parapmètre bind lié
    $stmt->bindParam(":email_employe", $_POST['email_employe']);
    $stmt->bindParam(":password_employe", $_POST['password_employe']);
    //execution de la requète
    $stmt->execute();

    //Compte les elements = si il y a une entrée (un employé dans la table)
    if($stmt->rowCount() == 1){
        //variable $row stock les recultat de recheche (fetch)
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            //recup de id
            $id = $row['id_employe'];
            //recup de email
            $email = $row['email_employe'];
            //recup de mot de passe hashé
            $hashed_password = $row['password_employe'];
            //Vérifie que le hachage fourni correspond bien au mot de passe fourni.
            if(password_verify($_POST['password_employe'], $hashed_password)){
                echo"Le mot de passe est bon";
            }else{
                echo "Erreur de connexion";
                //Si email entré = email dans la table et mot de passe ebtré = mot de passe de la table
                if($_POST['email_employe'] == $row['email_employe'] && $_POST['password_employe'] == $row['password_employe']){
                    session_start();
                    $_SESSION['connecter'] = true;
                    $_SESSION['id_employe'] = $id;
                    $_SESSION['email_employe'] = $email;
                    //On stock tous dans la variable super globale $_SESSION et on fait une redirection vers la page d'aacueil
                    header("Location:http://localhost/Ampoules/listeAmpoule.php?page=1");
                }else{
                    //Sinon on affiche diverses erreurs
                    echo "erreur de connexion merci de vérifié votre email et mot de passe";
                }
            }
        }else{
            echo "aucun element trouver";
        }
    }else{
        echo "Aucun element dans le table";
    }

}


$content = ob_get_clean();
require "template.php";

