<?php
include('config/connect.php');

$nomville = $descville = $nompays = $nomcon = $typenec = $nomnec = $cheminphoto = '';

$errors = array(
    'nomville' => '',
    'descville' => '',
    'nompays' => '',
    'nomcon' => '',
    'nomnech' => '',
    'nomneca' => '',
    'nomnecg' => '',
    'nomnecr' => '',
    'nomsite' =>'',
    'cheminphoto'=>'',

);

if (isset($_POST['submit'])) {
    if (empty($_POST['nomville'])) {
        $errors['nomville'] = "Entrez un nom de ville <br/>";
    } else {
        $nomville = $_POST['nomville'];
    }

    if (empty($_POST['descville'])) {
        $errors['descville'] = "Entrez une description de ville <br/>";
    } else {
        $descville = $_POST['descville'];
    }

    if (empty($_POST['nompays'])) {
        $errors['nompays'] = "Entrez un nom de pays <br/>";
    } else {
        $nompays = $_POST['nompays'];
    }
   
    if (empty($_POST['nomcon'])) {
        $errors['nomcon'] = "Entrez un nom de continent <br/>";
    } else {
        $nomcon = $_POST['nomcon'];
    }

    if (empty($_POST['nomnech'])) {
        $errors['nomnech'] = "Entrez le nom de hotel <br/>";
    } else {
        $nomnech = $_POST['nomnech'];
    }
    if (empty($_POST['nomneca'])) {
        $errors['nomneca'] = "Entrez le nom de aeroport <br/>";
    } else {
        $nomneca = $_POST['nomneca'];
    }
    if (empty($_POST['nomnecg'])) {
        $errors['nomnecg'] = "Entrez le nom de gare <br/>";
    } else {
        $nomnecg = $_POST['nomnecg'];
    }
    if (empty($_POST['nomnecr'])) {
        $errors['nomnecr'] = "Entrez le nom de restaurant <br/>";
    } else {
        $nomnecr = $_POST['nomnecr'];
    }
    if (empty($_POST['nomsite'])) {
        $errors['nomsite'] = "Entrez le nom de site <br/>";
    } else {
        $nomsite = $_POST['nomsite'];
    }
   

    if (isset($_FILES['cheminphoto'])) {
        $file = $_FILES['cheminphoto'];

        // Vérifier s'il y a une erreur lors du téléchargement
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Obtenir le nom et l'emplacement temporaire du fichier
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];

            // Déplacer le fichier téléchargé vers un emplacement permanent
            $file_destination = 'uploads/' . $file_name;
            move_uploaded_file($file_tmp, $file_destination);

            // Stocker le chemin de la photo dans la base de données
            $cheminphoto = $file_destination;
        } else {
            // Gérer l'erreur de téléchargement
            $errors['cheminphoto'] = "Erreur lors du téléchargement de la photo";
        }
    }

    
    if (!array_filter($errors)) {
        $nomville = mysqli_real_escape_string($conn, $_POST['nomville']);
        $descville = mysqli_real_escape_string($conn, $_POST['descville']);
        $nompays = mysqli_real_escape_string($conn, $_POST['nompays']);
        $nomcon = mysqli_real_escape_string($conn, $_POST['nomcon']);
        $nomnech = mysqli_real_escape_string($conn, $_POST['nomnech']);
        $nomneca = mysqli_real_escape_string($conn, $_POST['nomneca']);
        $nomnecg = mysqli_real_escape_string($conn, $_POST['nomnecg']);
        $nomnecr = mysqli_real_escape_string($conn, $_POST['nomnecr']);
        $nomsite = mysqli_real_escape_string($conn, $_POST['nomsite']);
        $cheminphoto = mysqli_real_escape_string($conn, $_POST['cheminphoto']);


        // Insertion dans la table "ville"

        $idpay = "SELECT idpays FROM pays where nompays ='$nompays';";
                
        $result = mysqli_query($conn, $idpay);
        $voyages = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $a=$voyages[0]['idpays'];


        if (empty($a) ){
             // Insertion dans la table "pays"
        $sql2 = "INSERT INTO pays (nompays) VALUES ('$nompays')";
        mysqli_query($conn, $sql2);
        $paysId = mysqli_insert_id($conn); 
        }
        $sql = "INSERT INTO ville (nomville, descville,idpays) VALUES ('$nomville','$descville','$a');";
        $conn->query($sql);
        
        $villeId =mysqli_insert_id($conn); 

        //Insertion dans la table continents
       // $sql3 = "INSERT INTO continent (nomcon) VALUES ('$nomcon')";
         //mysqli_query($conn, $sql3);
         //$continentId = mysqli_insert_id($conn); 
        
        // Insertion dans la table "necessaire"
        $sql4 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','hotel', '$nomnech');";
        $conn->query($sql4);
        $sql5 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','aeroport', '$nomneca');";
        $conn->query($sql5);
        $sql6 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','gare', '$nomnecg');";
        $conn->query($sql6);
        $sql7 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','restaurant', '$nomnecr');";
        $conn->query($sql7);
        // Insertion dans la table "sites"
        $sql8="INSERT INTO sites (idville, nomsite, cheminphoto) VALUES ('$villeId', '$nomsite', '$cheminphoto')";
        $conn->query($sql8);
       

        header('Location: indeex.php');
    }
    
    
    }
   


?>

<html lang="en">


<section >
    <h4 class="center">Ajouter une ville</h4>
    <form class="white" action="add.php" method="post"  >     <!-- pour permettre le téléchargement de fichiers. -->
        <label>Nom de la ville :</label>
        <input type="text" name="nomville" value="<?php echo htmlspecialchars($nomville) ?>">
        <div class="red-text"><?php echo $errors['nomville'] ?></div>
        <label>Description de la ville :</label>
        <!-- <input type="text" name="descville" value="<?php echo htmlspecialchars($descville) ?>">  -->
        <textarea name="descville" id="" cols="50" rows="5" value="<?php echo htmlspecialchars($descville)  ?>" ></textarea>
        <div class="red-text"><?php echo $errors['descville'] ?></div>
        <label>Pays :</label>
        <input type="text" name="nompays" value="<?php echo htmlspecialchars($nompays) ?>">
        <button type="button" > <a href="addpayscon.php">Ajouter</a> </button>
        <div class="red-text"><?php echo $errors['nompays'] ?></div>
        <!-- <label>Continent :</label>
        <input type="text" name="nomcon" value="<?php echo htmlspecialchars($nomcon) ?>">
        <div class="red-text"><?php echo $errors['nomcon'] ?></div> -->
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
                <button type="button" > <a href="">Ajouter</a> </button>
                 <br>
                <div class=""><?php echo $errors['nomcon'] ?></div>
        </div>



        <label>hotel :</label>
        <input type="text" name="nomnech" value="<?php echo htmlspecialchars($nomnech) ?>">
        <div class="red-text"><?php echo $errors['nomnech'] ?></div>

        <!-- <div>
                    <label>Hôtels :</label>
                    <input type="text" id="nomnech" name="nomnech" placeholder="Nom de l'hôtel"
                        value="<?php echo htmlspecialchars($nomnech) ?>">
                    <button type="button" onclick="ajouter('nomnech')">Ajouter</button>
                    <br>
                    <select id="nomnechs" multiple style="width:100px;" ></select>
                    <div class=""><?php echo $errors['nomnech'] ?></div>

        </div> -->

        <label>aeroport :</label>
        <input type="text" name="nomneca" value="<?php echo htmlspecialchars($nomneca) ?>">
        <div class="red-text"><?php echo $errors['nomneca'] ?></div>

        <!-- <div>
                <label>Aeroport :</label>
                <input type="text" id="nomneca" name="nomneca" placeholder="Nom de l'aeroport"
                       value="<?php echo htmlspecialchars($nomneca) ?>">
                <button type="button" onclick="ajouter('nomneca')">Ajouter</button>
               <br>
                <select id="nomnecas" multiple style="width:100px;">
                    
                </select>
                <div class=""><?php echo $errors['nomneca'] ?></div>

        </div> -->
        <label>gare :</label>
        <input type="text" name="nomnecg" value="<?php echo htmlspecialchars($nomnecg) ?>">
        <div class="red-text"><?php echo $errors['nomnecg'] ?></div>

        <!-- <div>
                <label>Gares :</label>
                <input type="text" id="nomnecg" name="nomnecg" placeholder="Nom de la gare"
                       value="<?php echo htmlspecialchars($nomnecg) ?>">
                <button type="button" onclick="ajouter('nomnecg')">Ajouter</button>
               <br>
                <select id="nomnecgs" multiple style="width:100px;">
                    
                </select>
                <div class=""><?php echo $errors['nomnecg'] ?></div>

        </div> -->
        <label>restaurant :</label>
        <input type="text" name="nomnecr" value="<?php echo htmlspecialchars($nomnecr) ?>">
        <div class="red-text"><?php echo $errors['nomnecr'] ?></div>
        <!-- <div>
                <label>Restaurants :</label>
                <input type="text" id="nomnecr" name="nomnecr" placeholder="Nom de la restaurant"
                       value="<?php echo htmlspecialchars($nomnecr) ?>">
                <button type="button" onclick="ajouter('nomnecr')">Ajouter</button>
               <br>
                <select id="nomnecrs" multiple style="width:100px;">
                    
                </select>
                <div class=""><?php echo $errors['nomnecr'] ?></div>

        </div> -->

        <label>nomsite :</label>
        <input type="text" name="nomsite" value="<?php echo htmlspecialchars($nomsite) ?>">
        <div class="red-text"><?php echo $errors['nomsite'] ?></div>
               
        <label for="cheminphoto">Choisissez une photo :</label>
        <input type="file" name="cheminphoto" >
        <div class="red-text"><?php echo $errors['cheminphoto'] ?></div>
       
        <div class="center">
            <input type="submit" value="Submit" name="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>
<script>
    function ajouter(element) {
  var input = document.getElementById(element);
  var liste = document.getElementById( element + "s");

  if (input.value !== "") {
    var option = document.createElement("option");
    option.text = input.value;
    liste.add(option);
    input.value = "";
    
   
  }
}
</script>
</html>

