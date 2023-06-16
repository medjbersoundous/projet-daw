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
        $errors['nomville'] = "Entrez un nom de ville ";
    } else {
        $nomville = $_POST['nomville'];
    }

    if (empty($_POST['descville'])) {
        $errors['descville'] = "Entrez une description de ville ";
    } else {
        $descville = $_POST['descville'];
    }

    if (empty($_POST['nompays'])) {
        $errors['nompays'] = "Entrez un nom de pays ";
    } else {
        $nompays = $_POST['nompays'];
    }
   
    if (empty($_POST['nomcon'])) {
        $errors['nomcon'] = "Entrez un nom de continent ";
    } else {
        $nomcon = $_POST['nomcon'];
    }

    if (empty($_POST['nomnech'])) {
        $errors['nomnech'] = "Entrez le nom de hotel ";
    } else {
        $nomnech = $_POST['nomnech'];
    }
    if (empty($_POST['nomneca'])) {
        $errors['nomneca'] = "Entrez le nom de aeroport ";
    } else {
        $nomneca = $_POST['nomneca'];
    }
    if (empty($_POST['nomnecg'])) {
        $errors['nomnecg'] = "Entrez le nom de gare ";
    } else {
        $nomnecg = $_POST['nomnecg'];
    }
    if (empty($_POST['nomnecr'])) {
        $errors['nomnecr'] = "Entrez le nom de restaurant ";
    } else {
        $nomnecr = $_POST['nomnecr'];
    }
    if (empty($_POST['nomsite'])) {
        $errors['nomsite'] = "Entrez le nom de site ";
    } else {
        $nomsite = $_POST['nomsite'];
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

        //################################################################################ -->
        // Insertion dans la table "ville"

        $idpay = "SELECT idpays FROM pays where nompays ='$nompays';";
                
        $result = mysqli_query($conn, $idpay);
        $voyages = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $a=$voyages[0]['idpays'];

        //################################################################################ -->
        if (empty($a) ){
             // Insertion dans la table "pays"
        $sql2 = "INSERT INTO pays (nompays) VALUES ('$nompays')";
        mysqli_query($conn, $sql2);
        $paysId = mysqli_insert_id($conn); 
        }
        $sql = "INSERT INTO ville (nomville, descville,idpays) VALUES ('$nomville','$descville','$a');";
        $conn->query($sql);
        
        $villeId =mysqli_insert_id($conn); 


        //################################################################################
        // Insertion dans la table "necessaire"


        $sql4 = "SELECT nomnec FROM necessaire WHERE idvil ='$idvil';";
        if (!empty($_POST["hotels"])) {
            foreach ($_POST["hotels"] as $value) {
                $value = ucwords($value);
                
      $sql4 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','hotel', '$value');";
     
      mysqli_query($conn, $sql4);
      
    
      }
      $sql5 = "SELECT nomnec FROM necessaire WHERE idvil ='$idvil';";
    //   $conn->query($sql5);
      if (!empty($_POST["restaurants"])) {
          foreach ($_POST["restaurants"] as $value) {
              $value = ucwords($value);
              $sql5 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','restaurant', '$value');";
            mysqli_query($conn, $sql5);
          
        }
      }
      $sql6 = "SELECT nomnec FROM necessaire WHERE idvil ='$idvil';";
    if (!empty($_POST["gares"])) {
    foreach ($_POST["gares"] as $value) {
      $value = ucwords($value);
      $sql6 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','gare', '$value');";
        mysqli_query($conn, $sql6);
    
    }
  }
  $sql7 = "SELECT nomnec FROM necessaire WHERE idvil ='$idvil';";
  if (!empty($_POST["aeroports"])) {
    foreach ($_POST["aeroports"] as $value) {
      $value = ucwords($value);
      $sql7 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','restaurant', '$value');";
        mysqli_query($conn, $sql7);
    
    }
  
  }

}
        $sql8= "INSERT INTO sites (idville, nomsite, cheminphoto) VALUES ('$villeId', '$value', '$cheminphoto')";
        $conn->query($sql8);
    
        header('Location: indeex.php');
    }
}
    
    
   


?>

<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>projet daw</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
   <link rel="stylesheet" href="add.css">
</head>

<section >
    <h4 class="center">Ajouter une ville</h4>
    <form class="white" action="addville.php" method="POST" enctype="multipart/form-data" >     <!-- pour permettre le téléchargement de fichiers. -->
       <!-- ################################################################################ -->
    <div>
    <label>Nom de la ville :</label>
        <input type="text" name="nomville" value="<?php echo htmlspecialchars($nomville) ?>">
        <div class="red-text"><?php echo $errors['nomville'] ?></div>
        <div class="list"></div>
        <div class="btn"></div>
    </div>
         <!-- ################################################################################ -->
       <div>
       <label>Description de la ville :</label>
     
     <textarea name="descville" id="" cols="50" rows="5" value="<?php echo htmlspecialchars($descville)  ?>" ></textarea>
     <div class="list"></div>
     <div class="red-text"><?php echo $errors['descville'] ?></div>
       </div>
       <div>
       <label>Pays :</label>
        <input type="text" name="nompays" value="<?php echo htmlspecialchars($nompays) ?>">
        <button type="button" > <a href="addpayscon.php">Ajouter</a> </button>
        <div class="red-text"><?php echo $errors['nompays'] ?></div>
        <div class="list"></div>
       </div>
        <!-- ################################################################################ -->
        <div>
            <label for="continent">Continent :</label>
             <select id="continent"  name="nomcon" required>
                <option value="<?php echo htmlspecialchars($nomcon) ?>">Sélectionnez un continent</option>   
                    <?php
                   $continents = array("africa", "europe", "america", "asia", "ocean");
                   foreach ($continents as $nomcon) {
                  echo "<option value=\"$nomcon\">$nomcon</option>";
                   }
                    ?>
                </select>
                <button type="button" > <a href="">Ajouter</a> </button>
                <div class="list"></div>
                <div class="red-text"><?php echo $errors['nomcon'] ?></div>
        </div>

         <!-- ################################################################################ -->
      <div>
      <label for="hotel">Hotels:</label>
      <input type="text" name="nomnech" id="hotel" placeholder="Hotels" />
      <button onclick="ajouter(event,'hotel_list','hotel')">Ajouter</button>
      <select id="hotel_list"  name="hotels[]" class="list" multiple>
        <?php
        if (isset($_GET["nomvilmod"])) {
          foreach ($updateHotels as $value) {
            echo "<option>" . $value . "</option>";
          }
        }
        ?>
      </select>
      </div>
       <!-- ################################################################################ -->
     <div>
     <label for="restaurant">Restaurant:</label>
      <input type="text" name="nomnecr" id="restaurant" placeholder="Restaurants" />
      <button onclick="ajouter(event,'restaurants_list','restaurant')">Ajouter</button>
      <select id="restaurants _list" class="list" name="restaurants[]" multiple>
          <?php
        if (isset($_GET["nomvilmod"])) {
            foreach ($updateRestaurant as $value) {
                echo "<option>" . $value . "</option>";
            }
        }
        ?>
      </select>
      
     </div>
      <!-- ################################################################################ -->
     <div>
     <label for="gare">Gares:</label>
      <input type="text" name="nomnecg" id="gare" placeholder="Gares" />
      <button onclick="ajouter(event,'gares_list','gare')">Ajouter</button>
      <select name="gares[]" id="gares_list"class="list" multiple>
        <?php
        if (isset($_GET["nomvilmod"])) {
          foreach ($updateGares as $value) {
            echo "<option>" . $value . "</option>";
          }
        }
        ?>
      </select>
       
     </div>
      <!-- ################################################################################ -->
      <div>
      <label for="aeroport">Aeroport:</label>
      <input type="text" name="nomneca" id="aeroport" placeholder="Aeroport" />
      <button onclick="ajouter(event,'aeroports_list','aeroport')">Ajouter</button>
      <select name="aeroports[]" id="aeroports_list" class="list" multiple>
        <?php
        if (isset($_GET["nomvilmod"])) {
          foreach ($updateAeroports as $value) {
            echo "<option>" . $value . "</option>";
          }
        }
        ?>
      </select>
       
      </div>
 <!-- ################################################################################ -->
     <div>

        <label>nomsite :</label>
        <input type="text" name="nomsite" placeholder="site">
        <div class="red-text"><?php echo $errors['nomsite'] ?></div>
        <div class="btn"></div>
        <div class="list"></div>
     </div>
               
        <!-- <label for="cheminphoto">Choisissez une photo :</label>
        <input type="file" id="cheminphoto" name="cheminphoto" multiple="multiple" placeholder="photo1.png" required> -->
      
       
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

let i = 0;
function ajouter(event, parent, child) {
  event.preventDefault();

  const list = document.getElementById(parent);
  var input = document.getElementById(child);
  var text = input.value;

  var p = document.createElement("option");

  p.textContent = text;
  p.selected = true;
  p.addEventListener("dblclick", function () {
    list.removeChild(p);
  });
  list.appendChild(p);
  //list.insertBefore(p,list.firstElementChild);
}

</script>
</html>