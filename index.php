<?php
ob_start();
$title = "CONNEXION CRUD AMPOULES";
?>

<div class="bg-content">
    <h1 class="text-center text-info">Connexion</h1>
    <!-- Appel de la page de traitement (on va recuperer les valeurs des champs avec $_POST['valeur de attribut name']-->
    <form action="connexion.php" method="post">

        <div class="form-group">
            <label for="email">Email</label>
            <!--ICI on recup la valeur de l'atribut name="" avec $_POST[''] -->
            <input type="email" class="form-control" name="email_employe" id="email"/>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" name="password_employe" id="password"/>
        </div>

        <div class="form-group">
            <!-- le bouton de type submit fait appel a form action="url et / ou fichier.php"-->
            <button type="submit" class="btn btn-outline-warning">Connexion</button>
        </div>
        <!--Page pour inscrire un nouvel employe-->
        <a class="btn btn-outline-danger" href="inscription.php">Inscription</a>
        <br />
        <a href="" class="mt-5">Identifiant oublié ?</a>

    </form>
</div>

<?php
$content = ob_get_clean();
require "template.php";