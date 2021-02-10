<?php
if(!empty($_COOKIE['utilisateur'])){
    $nom = $_COOKIE['utilisateur'];
}

if(!empty($_POST['nom'])){
    setcookie('utilisateur', $_POST['nom'], time()+60*60*24*30);
    $nom = $_POST['nom'];
    var_dump($nom);
}

if(isset($nom)){
    ?>
        <h1 class="text-center text-danger">BONJOUR <?= htmlentities($nom) ?></h1>
    <?php
        if($nom){
            ?>
            <div class="text-center">
                <a href="" class="btn btn-info">Détruire le cookie</a>
            </div>
            <?php
            unset($_COOKIE['utilisateur']);
            setcookie('utilisateur', '', time() - 10);
        }
    ?>

    <?php
}

ob_start();

?>
<div class="text-center">
    <form action="cookie.php" method="post">
        <div class="form-group">
            <label for="nom">Votre nom</label>
            <input type="text" class="form-control" placeholder="Votre nom" name="nom">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-info">Test le cookie</button>
        </div>
    </form>
</div>

<?php

//Stock et deplacement de photo
?>
<div class="text-center">
    <!--Attribut enctype pour upload de fichier-->
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="img_name">Votre photo</label>
            <input type="file" accept="image/png, image/jpeg, image/jpg, image/svg" name="img_name">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Valider la photo</button>
        </div>
    </form>
</div>

<?php

//Deplace un fichier d'un poiunt a au point b
//Stock du dossier de destination
$uploadDir = 'img/';
//Recup du nom de l'image
$img_name = $uploadDir . basename($_FILES['img_name']['name']);

//Apple de la valeur de l'attribut name de input type = file
$_POST['img_name'] = $img_name;

//Deplacement du fichier
if(move_uploaded_file($_FILES['img_name']['tmp_name'], $img_name)){
    echo "<p class='text-success'>Le fichier est valide a été télécharger dans le dossier img/</p>";
}else{
    echo "<p class='text-danger'>Erreur de telechargement du fichier</p>";
}


$content = ob_get_clean();
require "template.php";
