<?php
require_once '../views/layout/header.php';
require_once '../fonctions/pdo.php';
$pdo = getPdo();

?>
<style>
    .clients {
        border: solid 1px;
        padding: 5px;
        border-radius: 4px;
        margin: 20px;
        width: 350px;
    }

    .carousel-container {
        width: 100%;
        margin: auto;
        overflow: hidden;
        height: 45vw;
    }

    .carousel {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .carousel img {
        width: 100%;
        height: auto;
    }

    h2 {
        margin: 15px;
    }

    .btn {
        border: 1px solid;
        background: none;
        padding: 8px;
        border-radius: 3px;
    }
</style>

<?php
$photos = array("/images/img1.jpg", "/images/img2.jpg", "/images/img3.jpg");
?>

<div class="carousel-container">
    <div class="carousel">
        <?php
        foreach ($photos as $photo) {
            echo '<img src="' . $photo . '" alt="Image">';
        }
        ?>
    </div>
</div>

<div class="text_center" id="counter">0</div>
<div class="flex center">
    <button class="btn" id="incrementBtn">Incrémenter</button>
</div>

<div>
    <h2 class="text_center">Liste des clients</h2>

    <form action="traitement.php" method="post" class="flex center">
        <input class="btn" type="submit" name="update_clients" value="Mettre à jour les clients">
    </form>

    <?php
    $sqlGetClients = "SELECT * FROM clients";

    $rstGetClients = $pdo->query($sqlGetClients);
    $clients = $rstGetClients->fetchAll(PDO::FETCH_OBJ);

    ?>
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

</div>
<script>
    $(document).ready(function() {

        let carousel = $(".carousel");
        let currentIndex = 0;
        let totalItems = <?php echo count($photos); ?>;

        function showImage(index) {
            if (index < 0) {
                currentIndex = totalItems - 1;
            } else if (index >= totalItems) {
                currentIndex = 0;
            } else {
                currentIndex = index;
            }

            let newTransformValue = -currentIndex * 100 + "%";
            carousel.css("transform", "translateX(" + newTransformValue + ")");
        }

        // Auto-play the carousel
        setInterval(function() {
            currentIndex++;
            showImage(currentIndex);
        }, 3000);


        // Initialiser le compteur à 0
        let counterValue = 0;

        // Mettre à jour le contenu du compteur dans l'élément avec l'ID "counter"
        function updateCounter() {
            $("#counter").text(counterValue);
        }

        // Gérer le clic sur le bouton d'incrémentation
        $("#incrementBtn").on("click", function() {
            // Incrémenter la valeur du compteur
            counterValue++;
            // Mettre à jour l'affichage
            updateCounter();
        });

        // Appel initial pour afficher la valeur initiale
        updateCounter();


    });
</script>
<?php
require_once '../views/layout/footer.php';
