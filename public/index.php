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

    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .carousel-container {
        width: 40%;
        margin: auto;
        overflow: hidden;
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
    document.addEventListener("DOMContentLoaded", function() {

        let carousel = document.querySelector(".carousel");
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
            carousel.style.transform = "translateX(" + newTransformValue + ")";
        }

        // Auto-play the carousel
        setInterval(function() {
            currentIndex++;
            showImage(currentIndex);
        }, 3000);
    });
</script>
<?php
require_once '../views/layout/footer.php';
