<?php
ob_start();
$title = "CONNEXION CRUD AMPOULES";
?>

<div class="bg-content">
    <form action="listeAmpoule.php?page=1" method="post">

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email"/>
        </div>

        <div class="form-group">
            <label for="password">Email</label>
            <input type="password" class="form-control" name="password" id="password"/>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-outline-warning">Connexion</button>
        </div>

    </form>
</div>

<?php
$content = ob_get_clean();
require "template.php";