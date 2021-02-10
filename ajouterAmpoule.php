<?php
//1 - connexion pdo base de données
// 2 - ecrire la requète SQL
// 3 - faire un requète préparée (ou query pour de lecture)
// 3-   binder lier les paramètre (bind)
//4     executer la requète (array)
ob_start();
$title = "AJOUTER CRUD AMPOULES";

//Connexion a PDO mySQL
$user = "root";
$pass = "";
//Connexion à la base de données via l'instance de la classe native PDO de php
try {
    //host + nom de la base de données + encodage + nom utilisateur phpmyadmin et mot de passe
    $db = new PDO("mysql:host=localhost;dbname=ecommerce;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "COnnexion a pdo mysql";
} catch (PDOException $exception) {
    echo "Erreur de connexion a PDO MySQL " . $exception->getMessage();
}
//Recupération des element du dormulaire

if(isset($_POST['date_changement']) && !empty($_POST['date_changement'])){
    $date_changement = $_POST['date_changement'];
}else{
    echo "Erreur: merci de remplir le champ date";
}

if(isset($_POST['etage']) && !empty($_POST['etage'])){
    $etage = $_POST['etage'];
}else{
    echo "Erreur: merci de remplir le champ etage";
}

if(isset($_POST['position_ampoule']) && !empty($_POST['position_ampoule'])){
    $position_ampoule = $_POST['position_ampoule'];
}else{
    echo "Erreur: merci de remplir le champ position";
}

if(isset($_POST['prix_ampoule']) && !empty($_POST['prix_ampoule'])){
    $prix_ampoule = htmlspecialchars(strip_tags($_POST['prix_ampoule']));
}else{
    echo "Erreur: merci de remplir le champ date";
}

if(isset($_POST['concierge_id']) && !empty($_POST['concierge_id'])){
    $concierge_id = $_POST['concierge_id'];
}else{
    echo "Erreur: merci de remplir le champ concièrge";
}

if(isset($_POST['categories_id']) && !empty($_POST['categories_id'])){
    $categories_id = $_POST['categories_id'];
}else{
    echo "Erreur: merci de remplir le champ type d'ampoule";
}

//Telechargement de la photo

//Dossier de desctination
$dossier = "img/";
//Stock du dossier et du nom du fichier
$image = $dossier . basename($_FILES['img_ampoule']['name']);
//Transformer la variable super globale $_FILES en POST
$_POST['img_ampoule'] = $image;
//Les type de fichier a telecharger
$type_fichier = $_FILES['img_ampoule']['type'];
//Le poid su fichier
$poid_image = $_FILES['img_ampoule']['size'];

//Nom temporaire du fichier
$nom_temporaire_image = $_FILES['img_ampoule']['tmp_name'];

//Les conditions d'echec
//Si le champ fichier est vide
if(empty($image)){
    echo "<p class='alert-danger p-3'>Merci de choisir une photo pour le type d'ampoule !</p>";
    //Verifié le type de fichier
}elseif ($type_fichier == "image/jpg" || $type_fichier == "image/jpeg" || $type_fichier == "image/png" || $type_fichier == "image/gif" || $type_fichier == "image/svg" || $type_fichier == "image/jfif"){
    //Si le nom du fichier n'existe pas
    if(!file_exists($image)){
        if($poid_image < 5000000){ //5Mb
            move_uploaded_file($nom_temporaire_image, $image);
            //2 Requète SQL
            $sql = "INSERT INTO ampoules (date_changement, etage, position_ampoule, prix_ampoule, concierge_id, categories_id, img_ampoule) VALUES (?,?,?,?,?,?,?)";
//3-a Requète préparée
            $request = $db->prepare($sql);
//3-b liaison des champ du formulare au variable postée
            $request->bindParam(1,$date_changement);
            $request->bindParam(2,$etage);
            $request->bindParam(3,$position_ampoule);
            $request->bindParam(4,$prix_ampoule);
            $request->bindParam(5, $concierge_id);
            $request->bindParam(6, $categories_id);
            $request->bindParam(7, $image);
            //Executer la requète
            $resultat = $request->execute(array($date_changement, $etage,$position_ampoule, $prix_ampoule, $concierge_id, $categories_id, $image));


            if($resultat){
                header("Location:http://localhost/Ampoules/listeAmpoule.php?page=1");
            }
            echo "<p>Erreur le formulaire est mal rempli</p>";
        }else{
            echo "<p class='alert-danger p-3'>Le poid e la photo ne doit depassé 5Mo</p>";
        }
    }else{
        echo "<p class='alert-danger p-3'>Ce fichier existe déja, merci de renomer votre fichier</p>";
    }
}else{
    echo "<p class='alert-danger p-3'>Le format de la photo est incorrect (seul .jpg, .jpeg, .png, .gif, .svg sont accepté)</p>";
}






$content = ob_get_clean();
require "template.php";

