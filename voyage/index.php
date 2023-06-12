<?php
include('config/connect.php');

$sql = "SELECT ville.*, pays.nompays, continent.nomcon, necessaire.nomnec, sites.cheminphoto, sites.nomsite
        FROM ville
        INNER JOIN pays ON ville.idpays = pays.idpays
        INNER JOIN continent ON pays.idcon = continent.idcon
        INNER JOIN sites ON sites.idville = sites.idville
        INNER JOIN necessaire ON ville.idville = necessaire.idville";
        
$result = mysqli_query($conn, $sql);

$voyages = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('template/header.php'); ?>
<h4 class="center grey-text">travel</h4>
<div class="container">
    <div class="row">
        <?php foreach($voyages as $voyage): ?>
        <div class="col s6 md3">
            <div class="card z-depth-0">
                <div class="card-content center">
                    <h6><?php echo htmlspecialchars($voyage['nomcon']); ?></h6>
                    <h6><?php echo htmlspecialchars($voyage['nompays']); ?></h6>
                    <h6><?php echo htmlspecialchars($voyage['nomnec']); ?></h6>
                    <h6><?php echo htmlspecialchars($voyage['nomville']); ?></h6>
                    <h6><?php echo htmlspecialchars($voyage['descville']); ?></h6>
                    <h6><?php echo htmlspecialchars($voyage['nomsite']); ?></h6>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</html>


