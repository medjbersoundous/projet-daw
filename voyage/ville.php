<?php
include("config/connect.php");

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
}
$sql = "SELECT ville.*, pays.nompays AS nom_pays,  necessaire.typenec, necessaire.nomnec
        FROM ville
        JOIN pays ON ville.idpays = pays.idpays
        JOIN necessaire ON ville.idville = necessaire.idville
        WHERE ville.idville = $id";
$sql2 = "SELECT necessaire.typenec, necessaire.nomnec
FROM necessaire
WHERE necessaire.idville = $id AND necessaire.typenec = 'restaurant'";
$sql4 = "SELECT necessaire.typenec, necessaire.nomnec
FROM necessaire
WHERE necessaire.idville = $id AND necessaire.typenec = 'hotel'";
$sql5 = "SELECT necessaire.typenec, necessaire.nomnec
FROM necessaire
WHERE necessaire.idville = $id AND (necessaire.typenec = 'gare' or necessaire.typenec = 'aeroport') ";
$sql3 = "SELECT sites.*
FROM sites
WHERE sites.idville = $id ";

$rslt2 = mysqli_query($conn, $sql2);
$resto = array();

while ($row = mysqli_fetch_assoc($rslt2)) {
    $resto[] = $row;
}

$rslt4 = mysqli_query($conn, $sql4);
$hotels = array();

while ($row = mysqli_fetch_assoc($rslt4)) {
    $hotels[] = $row;
}
$rslt5 = mysqli_query($conn, $sql5);
$Transport = array();

while ($row = mysqli_fetch_assoc($rslt5)) {
    $Transport[] = $row;
}

$rslt3 = mysqli_query($conn, $sql3);
$sites = array();

while ($row = mysqli_fetch_assoc($rslt3)) {
    $sites[] = $row;
}

$rslt = mysqli_query($conn, $sql);
$villes = mysqli_fetch_assoc($rslt);

mysqli_free_result($rslt);
mysqli_free_result($rslt2);
mysqli_free_result($rslt3);
mysqli_close($conn);
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>projet daw</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="viLle.css">
</head>
<html>
<?php if ($villes): ?>
    <div class="ville">
        <h2><?php echo htmlspecialchars($villes['nomville']); ?></h2>
        <div class="bottom"></div>
        <p>
            <?php echo htmlspecialchars($villes['descville']); ?>
        </p>
        <h3>Top site</h3>
        <div class="bottom2"></div>
        <div class="grid">
            <?php
            foreach ($sites as $site) {
                echo '<div class="sights">';
                echo '<img src="' . htmlspecialchars($site['cheminphoto']) . '" alt="Image de la ville">';
                echo '<p>' . htmlspecialchars($site['nomsite']) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="grid">
            <div class="flex">
                <h3>Top resto</h3>
                <div class="bottom2"></div>
                <div class="sights2">
                    <ul>
                        <?php
                        foreach ($resto as $rest) {
                            echo '<li>' . htmlspecialchars($rest['nomnec']) . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
            if (!empty($hotels)) {
                echo ' <div class="flex">';
                echo '<h3>top hotel </h3>';
                echo '<div class="bottom2"></div>';
                echo '<div class="sights2">';
                echo '<ul class="ul">';
                foreach ($hotels as $hotel) {
                    echo '<li>' . htmlspecialchars($hotel['nomnec']) . '</li>';
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
            }
            ?>
            <?php
            if (!empty($Transport)) {
                echo ' <div class="flex">';
                echo '<h3>Transport </h3>';
                echo '<div class="bottom2"></div>';
                echo '<div class="sights2">';
                echo '<ul class="ul">';
                foreach ($Transport as $Transport) {
                    echo '<li>' . htmlspecialchars($Transport['nomnec']) . '</li>';
                }
                echo '</ul>';
                echo '</div>';
                echo '</div>';
            }
            ?>
      
    </div>
<?php else: ?>
    <h5>no villes</h5>
    <?php echo "No data available for villes."; ?>
<?php endif; ?>
</html>
