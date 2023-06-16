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
  // VERIFIER SI LES INPUTS SONT VIDE OU NON 
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
   
  // VERIFECATION DES ERREURS 
    
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
       // si le pays existe deja 
        $idpay = "SELECT idpays FROM pays where nompays ='$nompays';";
                
        $result = mysqli_query($conn, $idpay);
        $voyages = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $a=$voyages[0]['idpays'];

        //################################################################################ -->
        if (empty($a) ){
             // c'est le pays n'existe pas  Insertion dans la table "pays"
        $sql2 = "INSERT INTO pays (nompays) VALUES ('$nompays')";
        mysqli_query($conn, $sql2);
        $paysId = mysqli_insert_id($conn); 
        }
        $sql = "INSERT INTO ville (nomville, descville,idpays) VALUES ('$nomville','$descville','$a');";
        $conn->query($sql);
        
        $villeId =mysqli_insert_id($conn); 

       
        //################################################################################
        // Insertion dans la table "necessaire" LES VALEURS DE HOTEL, GARE, AEROPORT ET RESTAURANT


        $sql4 = "SELECT nomnec FROM necessaire WHERE idvil ='$idvil';";
        if (!empty($_POST["hotels"])) {
            foreach ($_POST["hotels"] as $value) {
                $value = ucwords($value);
                
      $sql4 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','hotel', '$value');";
     
      mysqli_query($conn, $sql4);
      
    
      }
      $sql5 = "SELECT nomnec FROM necessaire WHERE idvil ='$idvil';";

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
      $sql7 = "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ( '$villeId','aeroport', '$value');";
        mysqli_query($conn, $sql7);
    
    }
  
  }

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

$sql8="INSERT INTO sites (idville, nomsite, cheminphoto) VALUES ('$villeId', '$nomsite', '$cheminphoto')";
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
    <link rel="stylesheet" href="addville.css">
</head>
<body>
    

<section >
    <h4 class="center">Ajouter une ville</h4>
    
    <form class="white" action="addville.php" method="post" enctype="multipart/form-data" >     <!-- pour permettre le téléchargement de fichiers. -->


       <!-- ######################### NOM DE VILLE ###################################################### -->


       <label>Nom de la ville :</label>
        <input type="text" name="nomville" value="<?php echo htmlspecialchars($nomville) ?>" id="nomville" placeholder="nom de la ville">
        <div class="red-text"><?php echo $errors['nomville'] ?></div>


         <!-- ############################# DESC VILLE ################################################### -->

        <label>Description de la ville :</label>
        <textarea name="descville" id="" cols="50" rows="5" value="<?php echo htmlspecialchars($descville)  ?>" ></textarea>
        <div class="red-text"><?php echo $errors['descville'] ?></div>


         <!-- ############################## PARTIE PAYS ################################################## -->


        <label>Pays :</label>
        <input type="text" name="nompays" value="<?php echo htmlspecialchars($nompays) ?>" placeholder="nom de pays">
        <button type="button" > <a href="addpays.php">nouveau</a> </button>
        <!-- <button type="button" class="btnplus" id="nouveauPaysBtn"><span>+</span></button> -->
        <div class="red-text"><?php echo $errors['nompays'] ?></div>



        <!-- ####################################PARTIE CONTI############################################ -->

        <div class="con">
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
                <!-- <button type="button" class="btnplus" id="nouveauContinentBtn"> <span>+</span> </button> -->
                <br>
                <button type="button" > <a href="addcon.php">nouveau</a> </button>
                <div class=""><?php echo $errors['nomcon'] ?></div>
        </div>

         <!-- #################################PARTIE HOTEL ############################################### -->


        <label for="hotel">Hotels:</label>
      <input type="text" name="nomnech" id="hotel" placeholder="Hotels" />
      <button onclick="ajouter(event,'hotel_list','hotel')">ajouterHotel</button>
      <select id="hotel_list" name="hotels[]" multiple>

        <?php
        if (isset($_GET["nomvilmod"])) {
          foreach ($updateHotels as $value) {
            echo "<option>" . $value . "</option>";
          }
        }
        ?>
      </select>
       <!-- ################################### PARTIE RESTAURANT ############################################# -->
      <label for="restaurant">Restaurant:</label>
      <input type="text" name="nomnecr" id="restaurant" placeholder="Restaurants" />
      <button onclick="ajouter(event,'restaurants_list','restaurant')">ajouterRestaurant</button>
      <select id="restaurants_list" name="restaurants[]" multiple>
          <?php
        if (isset($_GET["nomvilmod"])) {
            foreach ($updateRestaurant as $value) {
                echo "<option>" . $value . "</option>";
            }
        }
        ?>
      </select>
      <br />


      <!-- ################################# PARTIE GARE ############################################### -->


      <label for="gare">Gares:</label>
      <input type="text" name="nomnecg" id="gare" placeholder="Gares" />
      <button onclick="ajouter(event,'gares_list','gare')">ajouterGare</button>
      <select name="gares[]" id="gares_list" multiple>
        <?php
        if (isset($_GET["nomvilmod"])) {
          foreach ($updateGares as $value) {
            echo "<option>" . $value . "</option>";
          }
        }
        ?>
      </select>
        <br>
      <!-- ################################################################################ -->
        <label for="aeroport">Aeroport:</label>
      <input type="text" name="nomneca" id="aeroport" placeholder="Aeroport" />
      <button onclick="ajouter(event,'aeroports_list','aeroport')">ajouterGare</button>
      <select name="aeroports[]" id="aeroports_list" multiple>
        <?php
        if (isset($_GET["nomvilmod"])) {
          foreach ($updateAeroports as $value) {
            echo "<option>" . $value . "</option>";
          }
        }
        ?>
      </select>
        <br>
 <!-- ################################## PARTIE SITE ############################################## -->
      <br>

      <label>nomsite :</label>
        <input type="text" name="nomsite" value="<?php echo htmlspecialchars($nomsite) ?>">
        <div class="red-text"><?php echo $errors['nomsite'] ?></div>
      <!-- <label for="site">Sites:</label>
      <input type="text" name="site" id="site" placeholder="Site" />
      <button onclick="ajoutersit(event,'sites_list','site')">ajoutersite</button>
      <select id="sites_list" name="sites[]" multiple>
        <?php
        if (isset($_GET["nomvilmod"])) {
          foreach ($updateSites as $value) {
            echo "<option>" . $value . "</option>";
          }
        }
        ?>
      </select>
      <div class="btnSPhoto" id="sitebtn"></div><br /> -->
               
      
      <!-- ################################## PARTIE PHOTO ############################################## -->

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


function ajoutersit(event, parent, child) {
  event.preventDefault();

  const list = document.getElementById(parent);
  var input = document.getElementById(child);
  var text = input.value;
  var p = document.createElement("option");

  p.textContent = text;
  p.selected = true;
  p.addEventListener("dblclick", function () {
    list.removeChild(p);
    sitebtn.removeChild(b);
  });
  list.appendChild(p);
  var b = document.createElement("input");
  b.name = "photosite" + i++;
  b.textContent = "ajoutersite";
  b.type = "file";
  b.accept = "image/*";
  sitebtn.appendChild(b);

  //list.insertBefore(p,list.firstElementChild);
}
const modalSection = document.getElementById("modalSection");
const showModal = () => {
  modalSection.style.display = "flex";
};

const hideModal = () => {
  modalSection.style.display = "none";
};

// Show the modal when needed (e.g., on button click)
const showButton = document.getElementById("nouveauPaysBtn");
showButton.addEventListener("click", showModal);

// Hide the modal when needed (e.g., on close button click)
const closeButton = document.getElementById("closeModalButton");
closeButton.addEventListener("click", hideModal);

</script>
</body>
</html>