<?php
include('config/connect.php');

$nompays = $nomcon = '';

$errorss = array(
   
    'nompays' => '',
    'nomcon' => '',

);
if (isset($_POST['submit'])){
    if (empty($_POST['nompays'])) {
        $errorss['nompays'] = "Entrez un nom de pays <br/>";
    } else {
        $nompays = $_POST['nompays'];
    }
   
    if (empty($_POST['nomcon'])) {
        $errorss['nomcon'] = "Entrez un nom de continent <br/>";
    } else {
        $nomcon = $_POST['nomcon'];
    }
    if (!array_filter($errorss)){
        $nompays = mysqli_real_escape_string($conn, $_POST['nompays']);
        $nomcon = mysqli_real_escape_string($conn, $_POST['nomcon']);
    }
    
    //insertion dans la table pays 
     

    $idconn = "SELECT idcon FROM continent where nomcon ='$nomcon';";
                
    $result = mysqli_query($conn, $idconn);
    $voyage = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $a=$voyage[0]['idcon'];


    header('Location: add.php');
}

?>
<html lang="en">
<section>
<h4 class="center">Ajouter un pays</h4>
    <form action="addpayscon.php" method="post">
    <div>
            <label for="continent">Continent :</label>
             <select id="continent" name="nomcon" required>
                <option value="<?php echo htmlspecialchars($nomcon) ?>">Sélectionnez un continent</option>   
                    <?php
                   $continents = array("africa", "europe", "america", "asia", "ocean");
                   foreach ($continents as $nomcon) {
                  echo "<option value=\"$nomcon\">$nomcon</option>";
                   }
                    ?>
                </select>
        </div>
        <label>Nom de pays :</label>
        <input type="text" name="nompays" value="<?php echo htmlspecialchars($nompays) ?>">
        <div class="red-text"><?php echo $errors['nompays'] ?></div>
        <div class="center">
            <input type="submit" value="Submit" name="submit" class="btn brand z-depth-0">
        </div>
        <button> <a href="add.php">back</a> </button>
    </form>
    
</section>
</html>


