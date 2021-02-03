<?php

/**
 * 1 - connexiona la base de donnée PDO
 *
 * A - Recupérer les champs du formulaire
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

//Champ du formulaire

if(isset($_POST['date_changement']) && !empty($_POST['date_changement'])){
    $date_changement = htmlspecialchars(strip_tags($_POST['date_changement']));
}else{
    echo "Erreur: merci de remplir le champ date";
}

if(isset($_POST['etage']) && !empty($_POST['etage'])){
    $etage = htmlspecialchars(strip_tags($_POST['etage']));
}else{
    echo "Erreur: merci de remplir le champ etage";
}

if(isset($_POST['position_ampoule']) && !empty($_POST['position_ampoule'])){
    $position_ampoule = htmlspecialchars(strip_tags($_POST['position_ampoule']));
}else{
    echo "Erreur: merci de remplir le champ position";
}

if(isset($_POST['prix_ampoule']) && !empty($_POST['prix_ampoule'])){
    $prix_ampoule = htmlspecialchars(strip_tags($_POST['prix_ampoule']));
}else{
    echo "Erreur: merci de remplir le champ date";
}

//requte sql
$sql = "UPDATE ampoules SET date_changement = ?, etage = ?, position_ampoule = ?, prix_ampoule = ? WHERE id_ampoule = ?";

$update = $db->prepare($sql);

//Lier les element
$update->bindParam(1, $date_changement);
$update->bindParam(2, $etage);
$update->bindParam(3, $position_ampoule);
$update->bindParam(4, $prix_ampoule);
$id_maj = $_GET['majID'];

$resultat = $update->execute(array($date_changement, $etage, $position_ampoule, $prix_ampoule, $id_maj));

if($resultat){
    echo "c bien";
    header("Location:http://localhost/Ampoules/listeAmpoule.php");
}else{
    echo "Une erreur est survenue durant la mise a jour";
}



