<?php
ob_start();
$title = "CONNEXION CRUD AMPOULES";
?>

<div class="bg-content">
    <h1 class="text-center text-info">Connexion</h1>
    <form action="listeAmpoule.php?page=1" method="post">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email"/>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" name="password" id="password"/>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-outline-warning">Connexion</button>
        </div>

        <a class="btn btn-outline-danger" href="inscription.php">Inscription</a>
        <br />
        <a href="" class="mt-5">Identifiant oublié ?</a>

    </form>
</div>

<?php
$content = ob_get_clean();
require "template.php";