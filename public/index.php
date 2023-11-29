<?php
require_once '../views/layout/header.php';
require_once '../fonctions/pdo.php';
$pdo = getPdo();

?>

<div class="carousel-container">
    <div class="carousel">
        <!-- Gestion des media on utilise srcset et lazy loading-->
        <img src="/images/img1.jpg" srcset="/images/img1_1200.jpg 1200w, /images/img1_750.jpg 750w, /images/img1_500.jpg 500w" loading="lazy" alt="Image">
    </div>
</div>

<div class="text_center" id="counter">0</div>
<div class="flex center">
    <button class="btn" id="incrementBtn">Incrémenter</button>
</div>

<div>
    <h2 class="text_center">Liste des clients</h2>

    <form action="traitement.php" method="post" class="flex center update-client">
        <input class="btn" type="submit" name="update_clients" value="Mettre à jour les clients">
    </form>

    <?php
    // Définir le nombre d'éléments par page
    $elementsParPage = 24; // Vous pouvez ajuster cela en fonction de vos besoins

    // Récupérer le numéro de la page actuelle à partir de la requête GET
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Calculer le point de départ pour la requête SQL en fonction de la page actuelle
    $pointDeDepart = ($page - 1) * $elementsParPage;

    // Requête SQL modifiée avec la limitation et le décalage pour la pagination
    $sqlGetClients = "SELECT * FROM clients LIMIT $pointDeDepart, $elementsParPage";

    $rstGetClients = $pdo->query($sqlGetClients);
    $clients = $rstGetClients->fetchAll(PDO::FETCH_OBJ);

    ?>

    <!-- On affiche les infos des clients -->
    <div class="flex space_around wrap">
        <?php
        foreach ($clients as $key => $client) {
        ?>
            <div class="clients">
                <p>Nom : <?php echo $client->name ?></p>
                <p>Email : <?php echo $client->email ?></p>
                <p>Tel : <?php echo $client->phone ?></p>
                <p>Pays : <?php echo $client->country ?></p>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- Ajouter la pagination -->
    <div class="flex center m15">
        <div class="pagination">
            <?php
            // Requête pour compter le nombre total de clients
            $sqlCountClients = "SELECT COUNT(*) as total FROM clients";
            $rstCountClients = $pdo->query($sqlCountClients);
            $resultCountClients = $rstCountClients->fetch(PDO::FETCH_ASSOC);

            // Calculer le nombre total de pages
            $nombreDePages = ceil($resultCountClients['total'] / $elementsParPage);

            // Afficher la flèche "Précédent" s'il y a une page précédente
            if ($page > 3) {
                echo '<a class="pagination-number" href="?page=' . ($page - 1) . '"> < Précédent</a> ';
                echo '<a class="pagination-number" href="?page=1">1</a> ';
            }

            // Afficher les liens de pagination
            for ($i = max(1, $page - 2); $i <= min($page + 2, $nombreDePages); $i++) {

                $active = "";

                if ($page == $i) {
                    $active = "active";
                }
                echo '<a class="pagination-number ' . $active . '" href="?page=' . $i . '">' . $i . '</a> ';
            }

            // Afficher la flèche "Suivant" s'il y a une page suivante
            if ($page < $nombreDePages) {
                echo '<a class="pagination-number" href="?page=' . $nombreDePages . '">' . $nombreDePages . '</a> ';
                echo '<a class="pagination-number" href="?page=' . ($page + 1) . '">Suivante ></a> ';
            }
            ?>
        </div>
    </div>
</div>

<div class="flex center p15 img_container">
    <!-- Gestion des media on utilise srcset et lazy loading-->
    <img src="/images/img2.jpg" srcset="/images/img2_750.jpg 750w, /images/img2_500.jpg 500w" loading="lazy" alt="Image" class="img">
</div>

</div>
<?php
require_once '../views/layout/footer.php';
