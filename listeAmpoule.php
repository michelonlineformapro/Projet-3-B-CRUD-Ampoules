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

//LA requète SQL de selection de toutes les opérations
//Ici selection sur la table ampoules puis selction de la table concièrges ou la cle primaire (id_concierge) est = a la clé etrangère de la table ampoules (concierge_id)
$sql = "SELECT * FROM ampoules INNER JOIN concierges ON concierges.id_concierge = ampoules.concierge_id INNER JOIN categories ON categories.id_categories = ampoules.categories_id  ORDER BY date_changement DESC";
//Stock de la requète dans une variable = connexion + fonction fléchée query + requète SQL
$resultat = $db->query($sql);

?>
<div class="bg-content">
<h1 class="text-info text-center">GESTION DES AMPOULES</h1>

    <div class="text-center">
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
                       <form action="ajouterAmpoule.php" method="post">
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
                               <label for="position">Selection étage</label>
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
            <td><?= $date_formater->format('d/m/Y'); ?></td>
            <td><?= $row['etage'] ?></td>
            <td><?= $row['position_ampoule'] ?></td>
            <td><?= $row['prix_ampoule'] ?> €</td>
            <td><?= $row['email_concierge'] ?></td>
            <td><?= $row['type_ampoule'] ?></td>

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
                                </ul>


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
                                <form action="majAmpoule.php?majID=<?= $row['id_ampoule'] ?>" method="post">
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
                                        <label for="position">Selection étage</label>
                                        <select class="form-control" id="etage" name="position_ampoule">
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
                                        <label for="concierge_id"></label>
                                        <input type="text"  class="form-control" name="concierge_id" id="concierge_id">
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

