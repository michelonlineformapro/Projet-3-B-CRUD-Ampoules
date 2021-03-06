<?php

use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;


ob_start();


require "vendor/autoload.php";
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

//On demerar
session_start();
if(isset($_SESSION['connecter']) && $_SESSION['connecter'] === true){
    echo "<div class='text-center mt-3'>
    <a href='deconnexion.php' class='btn btn-info'>DECONNEXION</a></div>";

}else{
    header("location:http://localhost/Ampoules/");
}
?>
<h1 class='text-center text-danger'>Bonjour : <?= $_SESSION['email_employe'] ?> </h1>

<?php

//Pagination creation d'un routing page?= 1 2 3 4 5 6 etc...
if(isset($_GET['page'])){
    $page = $_GET['page']; //listeProduit.php?page=1
}else{
    $page = "page=1";
}
//Nombre d'element affiché par page
$limite = 2;
//Valeur de départ  = $page courante - 1 * limite (ici 2)
$debut = $page - 1;

//LA requète SQL de selection de toutes les opérations
//Ici selection sur la table ampoules puis selction de la table concièrges ou la cle primaire (id_concierge) est = a la clé etrangère de la table ampoules (concierge_id)  AJOUT de limite dynamique et offset pour le depart
$sql = "SELECT * FROM ampoules INNER JOIN concierges ON concierges.id_concierge = ampoules.concierge_id INNER JOIN categories ON categories.id_categories = ampoules.categories_id  ORDER BY date_changement DESC LIMIT {$limite} OFFSET {$debut}";
//Stock de la requète dans une variable = connexion + fonction fléchée query + requète SQL
$resultat = $db->query($sql);


?>
<div class="container">
<h1 class="text-info text-center">GESTION DES AMPOULES</h1>

    <div class="text-center">
        <!--ICI data target prend un hashtag # qui fait reference a la fenètre modal qui cachée  et appel id de la fenètre modal -->
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ajouterAmpoule">
            Ajouter une opération
        </button>
    </div>
        <!-- Modal DETAIL DE OPÉRATION CHANGEMENT DE AMPOULE -->
        <div class="modal fade" id="ajouterAmpoule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter une opération</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                       <form action="ajouterAmpoule.php" method="post" enctype="multipart/form-data">
                           <div class="form-group">
                               <label for="date_changement"></label>
                               <!--Ici le type date pour creer un champ avec un date picker-->
                               <input type="date" class="form-control" name="date_changement" id="date_changement">
                           </div>
                           <div class="form-group">
                               <label for="etage">Selection étage</label>
                               <select class="form-control" id="etage" name="etage">
                                   <option value="RDC">RDC</option>
                                   <option value="Etage 1">Etage 1</option>
                                   <option value="Etage 2">Etage 3</option>
                                   <option value="Etage 3">Etage 3</option>
                                   <option value="Etage 4">Etage 4</option>
                                   <option value="Etage 5">Etage 5</option>
                                   <option value="Etage 6">Etage 6</option>
                                   <option value="Etage 7">Etage 7</option>
                                   <option value="Etage 8">Etage 8</option>
                                   <option value="Etage 9">Etage 9</option>
                                   <option value="Etage 10">Etage 10</option>
                                   <option value="Etage 11">Etage 11</option>
                               </select>
                           </div>

                           <div class="form-group">
                               <label for="position">Selection position de l'ampoule</label>
                               <select class="form-control" id="etage" name="position_ampoule">
                                   <option value="droite">DROITE</option>
                                   <option value="gauche">GAUCHE</option>
                                   <option value="fond">FOND</option>
                               </select>
                           </div>

                           <div class="form-group">
                               <label for="prix_ampoule">Prix</label>
                               <input type="number" step="any" class="form-control" name="prix_ampoule" id="prix_ampoule">
                           </div>

                           <div class="form-group">
                               <label for="concierge_id">Email du conciérge</label>

                               <select class="form-control" id="concierge_id" name="concierge_id">
                               <?php
                               foreach ($db->query("SELECT * FROM concierges") as $row){
                               ?>
                                       <!--ici la value enrigistré est bien un entier dans la table ampoules (concièrge_id) et on affiche toutes les valeurs de la table concièrge-->
                                       <option value="<?= $row['id_concierge'] ?>"><?= $row['email_concierge'] ?></option>
                                   <?php
                               }
                                   ?>
                               </select>
                           </div>

                           <div class="form-group">
                               <label for="categories_id">Type d'ampoule</label>

                               <select class="form-control" id="categories_id" name="categories_id">
                                   <?php
                                   foreach ($db->query("SELECT * FROM categories") as $row){
                                       ?>
                                       <option value="<?= $row['id_categories'] ?>"><?= $row['type_ampoule'] ?></option>
                                       <?php
                                   }
                                   ?>
                               </select>
                           </div>

                           <!--Ajout de la photo type ampoule-->
                           <div class="form-group">
                               <label for="img_ampoule">Choix de la photo</label>
                               <input type="file" class="form-control-file" id="img_ampoule" name="img_ampoule" accept="image/gif, image/jpg, image/jpeg, image/svg, image/png">
                           </div>

                           <div class="form-group">
                               <button type="submit" class="btn btn-info">Ajouter l'opération</button>
                           </div>
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>


<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date de changement</th>
            <th>Étage</th>
            <th>Position dans le couloir</th>
            <th>Prix</th>
            <th>Email du concièrge</th>
            <th>Type d'ampoule</th>
            <th>Image</th>
            <th>Détails</th>
            <th>Supprimer</th>
            <th>Mise à jour</th>
        </tr>
    </thead>

    <tbody>
    <?php
        foreach ($resultat as $row){
            $date_formater = new DateTime($row['date_changement']);
      ?>
        <tr>
            <td><?= $row['id_ampoule'] ?></td>
            <td><?= $date_formater->format('d/m/Y'); ?></td>
            <td><?= $row['etage'] ?></td>
            <td><?= $row['position_ampoule'] ?></td>
            <td><?= $row['prix_ampoule'] ?> €</td>
            <td><?= $row['email_concierge'] ?></td>
            <td><?= $row['type_ampoule'] ?></td>
            <td><img src="<?= $row['img_ampoule'] ?>" alt="<?= $row['type_ampoule'] ?>" title="<?= $row['type_ampoule'] ?>" width="100%" </td>
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
                                    <li><?= "Date de changement : " .$date_formater->format('d/m/Y'); ?></li>
                                    <li><?= "Étage : " .$row['etage'] ?></li>
                                    <li><?= "Position ampoule : " .$row['position_ampoule'] ?></li>
                                    <li><?= "Prix : " .$row['prix_ampoule'] ?> €</li>
                                    <li><?= "Email : " .$row['email_concierge'] ?></li>
                                    <li><?= "Type ampoule " .$row['type_ampoule']  ?></li>
                                    <li><img src="<?= $row['img_ampoule']  ?>" alt="" title="" width="100%" /></li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <!--SUPPRIMER UNE OPERATION-->
            <td>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAmpoule<?= $row['id_ampoule'] ?>">
                    Supprimer l'opération
                </button>

                <div class="modal fade" id="deleteAmpoule<?= $row['id_ampoule'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Détail de l'opération N° <?= $row['id_ampoule'] ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <a href="supprimerAmpoule.php?supprimerID=<?= $row['id_ampoule'] ?>" class="btn btn-info">SUPPRIMER CETTE OPÉRATION</a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>


            <!--MISE A JOUR FORMULAIRE MODAL-->

            <td>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#updateAmpoule<?= $row['id_ampoule'] ?>">
                    Mise a jour de l'opération
                </button>

                <div class="modal fade" id="updateAmpoule<?= $row['id_ampoule'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Mise a jour de l'opération</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="majAmpoule.php?majID=<?= $row['id_ampoule'] ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="date_changement"></label>
                                        <input type="date" class="form-control" name="date_changement" id="date_changement">
                                    </div>
                                    <div class="form-group">
                                        <label for="etage">Selection étage</label>
                                        <select class="form-control" id="etage" name="etage">
                                            <option value="RDC">RDC</option>
                                            <option value="Etage 1">Etage 1</option>
                                            <option value="Etage 2">Etage 3</option>
                                            <option value="Etage 3">Etage 3</option>
                                            <option value="Etage 4">Etage 4</option>
                                            <option value="Etage 5">Etage 5</option>
                                            <option value="Etage 6">Etage 6</option>
                                            <option value="Etage 7">Etage 7</option>
                                            <option value="Etage 8">Etage 8</option>
                                            <option value="Etage 9">Etage 9</option>
                                            <option value="Etage 10">Etage 10</option>
                                            <option value="Etage 11">Etage 11</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="position">Selection de la position</label>

                                        <select class="form-control" id="etage" name="position_ampoule">
                                            <option value="<?= $row['position_ampoule'] ?>"><?= $row['position_ampoule'] ?></option>
                                            <option value="droite">DROITE</option>
                                            <option value="gauche">GAUCHE</option>
                                            <option value="fond">FOND</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="prix_ampoule"></label>
                                        <input type="number" value="<?= $row['prix_ampoule'] ?>" step="any" class="form-control" name="prix_ampoule" id="prix_ampoule">
                                    </div>

                                    <div class="form-group">
                                        <label for="concierge_id">Email du conciérge</label>

                                        <select class="form-control" id="concierge_id" name="concierge_id">
                                            <?php

                                            ?>

                                            <?php
                                            foreach ($db->query("SELECT * FROM concierges") as $row){
                                                ?>
                                                <option value="<?= $row['id_concierge'] ?>"><?= $row['email_concierge'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="categories_id">Email du conciérge</label>

                                        <select class="form-control" id="categories_id" name="categories_id">
                                            <?php
                                            foreach ($db->query("SELECT * FROM categories") as $row){
                                                ?>
                                                <option value="<?= $row['id_categories'] ?>"><?= $row['type_ampoule'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!--Ajout de la photo type ampoule-->
                                    <div class="form-group">
                                        <label for="img_ampoule">Choix de la photo</label>
                                        <input type="file" class="form-control-file" id="img_ampoule" name="img_ampoule">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">Mettre a jour l'opération</button>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

            <?php
            }
            ?>
    </tbody>
</table>

    <?php
    //Requète qui compte le nombre d'entrée
    $resultFoundRows = $db->query('SELECT COUNT(id_ampoule) FROM ampoules');
    /* On doit extraire le nombre du jeu de résultat */
    $nombredElementsTotal = $resultFoundRows->fetchColumn();
    /* Si on est sur la première page, on n'a pas besoin d'afficher de lien
 * vers la précédente. On va donc ne l'afficher que si on est sur une autre
 * page que la première */
    $nombreDePages = ceil($nombredElementsTotal / $limite);
    ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
    <?php


if ($page > 1):
    ?><li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Page précédente</a></li><?php
endif;

/* On va effectuer une boucle autant de fois que l'on a de pages */
for ($i = 1; $i <= $nombreDePages; $i++):
    ?><li class="page-item"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li><?php
endfor;

/* Avec le nombre total de pages, on peut aussi masquer le lien
 * vers la page suivante quand on est sur la dernière */
if ($page < $nombreDePages):
    ?><li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Page suivante</a></li><?php
endif;
?>

        </ul>
    </nav>


</div>

<?php
$content = ob_get_clean();
require "template.php";

