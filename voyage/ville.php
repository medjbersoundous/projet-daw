<?php
include("config/connect.php");


if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn,$_GET['id']);
}
$sql = "SELECT ville.*, pays.nompays AS nom_pays, sites.*, necessaire.typenec, necessaire.nomnec
        FROM ville
        JOIN pays ON ville.idpays = pays.idpays
        JOIN sites ON ville.idville = sites.idville
        JOIN necessaire ON ville.idville = necessaire.idville
        WHERE ville.idville = $id";



$rslt=mysqli_query($conn,$sql);
$villes=mysqli_fetch_assoc($rslt);
mysqli_free_result($rslt);
mysqli_close($conn);
print_r($villes)



?>
<!DOCTYPE html>
<html>

<h4 class='center'>Details</h4>
<div class="container center">
    <?php if ($villes): ?>
        <h2><?php echo htmlspecialchars($villes['descville']); ?></h2>
        <h4><?php echo htmlspecialchars($villes['nomville']); ?></h4>
        <p>pays: <?php echo htmlspecialchars($villes['nom_pays']); ?></p>

        <h5>site</h5>
        <p><?php echo htmlspecialchars($villes['nomsite']); ?></p>
        <?php if (!empty($villes['cheminphoto'])): ?>
            <img src="<?php echo htmlspecialchars($villes['cheminphoto']); ?>" alt="Image de la ville">
        <?php endif; ?>
    <?php else: ?>
        <h5>no villes</h5>
        <?php echo print_r($villes); ?>
    <?php endif; ?>
</div>

</html>