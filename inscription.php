<?php
ob_start();
$title = "Inscription Ampoules";
?>
<div class="bg-content">
    <h1 class="text-center text-info">Inscription à Ampoules.com</h1>
    <!-- Appel de la page de traitement (on va recuperer les valeurs des champs avec $_POST['valeur de attribut name']-->
    <form action="validerInscription.php" method="post">

        <div class="form-group">
            <label for="email">Email</label>
            <!--ICI on recup la valeur de l'atribut name="" avec $_POST[''] -->
            <input type="email" class="form-control" name="email_employe" id="email" required placeholder="Votre email"/>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" name="password_employe" id="password" required placeholder="Votre mot de passe"/>
        </div>

        <div class="form-group">
            <label for="password">Confirmer le mot de passe</label>
            <input type="password" class="form-control" name="confirm_password_employe" id="password" placeholder="Confirmer le mot de passe" required/>
        </div>

        <div class="form-group">
            <!-- le bouton de type submit fait appel a form action="url et / ou fichier.php"-->
            <button type="submit" class="btn btn-outline-warning">Inscription</button>
        </div>


    </form>
</div>

<?php
$content = ob_get_clean();
require "template.php";
