<?php
ob_start();
$title = "ACCUEIL CRUD AMPOULES";

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

//LA requète SQL

$sql = "SELECT * FROM ampoules ORDER  BY date_changement DESC";
//Stock de la requète dans une variable = connexion + fonction fléchée query + requète SQL
$resultat = $db->query($sql);
?>
<div class="bg-content">
<h1 class="text-info text-center">GESTION DES AMPOULES</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date de changement</th>
            <th>Étage</th>
            <th>Position dans le couloir</th>
            <th>Prix</th>
            <th>Détails</th>
            <th>Mise à jour</th>
            <th>Supprimer</th>
        </tr>
    </thead>

    <tbody>
    <?php


        foreach ($resultat as $row){
            $date_formater = new DateTime($row['date_changement']);

      ?>
        <tr>
            <td><?= $row['id_ampoule'] ?></td>
            <td><?= $date_formater->format('d/m/Y à H:i:s'); ?></td>
            <td><?= $row['etage'] ?></td>
            <td><?= $row['position_ampoule'] ?></td>
            <td><?= $row['prix_ampoule'] ?> €</td>

            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detailsAmpoule<?= $row['id_ampoule'] ?>">
                    Détails de l'opération
                </button>

                <!-- Modal -->
                <div class="modal fade" id="detailsAmpoule<?= $row['id_ampoule'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Détail de l'opération N° <?= $row['id_ampoule'] ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <li><?= "ID de opération : " .$row['id_ampoule'] ?></li>
                                    <li><?= "Date de changement : " .$date_formater->format('d/m/Y à H:i:s'); ?></li>
                                    <li><?= "Étage : " .$row['etage'] ?></li>
                                    <li><?= "Position ampoule : " .$row['position_ampoule'] ?></li>
                                    <li><?= "Prix : " .$row['prix_ampoule'] ?> €</li>
                                </ul>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>


            <td>MODAL mise ajour</td>
            <td>Modal supprimer</td>
        </tr>
            <?php
            }
            ?>
    </tbody>
</table>

</div>

<?php
$content = ob_get_clean();
require "template.php";

