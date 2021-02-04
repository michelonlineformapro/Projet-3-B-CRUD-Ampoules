<?php

/**
 * 1 - connexion la base de donnée PDO
 * 2 - requète en langage SQL
 * 3 - requète php préparée
 * 4 - bind des elements (lier)
 * 5 - executer la requète
 */

//Connexion a PDO mySQL
$user = "root";
$pass = "";
//Connexion à la base de données via l'instance de la classe native PDO de php
try {
    //host + nom de la base de données + encodage + nom utilisateur phpmyadmin et mot de passe
    $db = new PDO("mysql:host=localhost;dbname=ecommerce;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "COnnexion a pdo mysql";
}catch (PDOException $exception){
    echo "Erreur de connexion a PDO MySQL ". $exception->getMessage();
}

$sql = "DELETE FROM ampoules WHERE id_ampoule = ?";

$supprimer = $db->prepare($sql);
$id_supprimer = $_GET['supprimerID'];
$supprimer->bindParam(1, $id_supprimer);

$resultat = $supprimer->execute();

if($resultat){
    echo "Ca marche";
    header("Location:http://localhost/Ampoules/listeAmpoule.php?page=1");
}else{
    echo "Erreur l'id n'existe pas";
}

