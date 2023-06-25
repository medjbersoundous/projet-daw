<?php
include("config/connect.php");

// Vérifier si les données ont été soumises via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $idVille = $_POST["idVille"];
    $nomVille = $_POST["nomVille"];
    $descVille = $_POST["descVille"];
    $pays = $_POST["pays"];
    $sites = $_POST["sites"];
    $hotel = $_POST["hotel"];
    $resto = $_POST["resto"];
    $gare = $_POST["gare"];
    $aeroport = $_POST["aeroport"];
    $image=$_POST["image"];
    
    
    // Vérifier si une image a été téléchargée
   

    // Insérer les données dans la base de données
    $sql2 = "SELECT idpays FROM pays WHERE nompays='$pays'";
    $result = mysqli_query($conn, $sql2);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $idpays = $row['idpays'];

        // Effectuer la mise à jour dans la base de données
        $sqlUpdate = "UPDATE ville SET nomville = '$nomVille', descville = '$descVille', idpays = $idpays WHERE idville = $idVille";
        if (mysqli_query($conn, $sqlUpdate)) {
            // Supprimer les anciens enregistrements de sites pour cette ville
            mysqli_query($conn, "DELETE FROM sites WHERE idville = $idVille");
            mysqli_query($conn, "DELETE FROM necessaire WHERE idville = $idVille");

            // Insérer le nouveau site avec l'image
            mysqli_query($conn, "INSERT INTO sites (idville, nomsite, cheminphoto) VALUES ($idVille, '$sites', '$image')");
            mysqli_query($conn, "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ($idVille, 'restaurant', '$resto')");
            mysqli_query($conn, "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ($idVille, 'hotel', '$hotel')");
            mysqli_query($conn, "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ($idVille, 'gare', '$gare')");
            mysqli_query($conn, "INSERT INTO necessaire (idville, typenec, nomnec) VALUES ($idVille, 'aeroport', '$aeroport')");
            
          

      


            echo "Mise à jour effectuée avec succès.";
        } else {
            echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
        }
    } else {
        echo "Erreur lors de la récupération de l'ID du pays.";
    }

    // Redirection vers la page de détails de la ville modifiée ou vers la liste des villes
    header("Location: ville.php?id=$idVille");
    exit();
}

// Affichage du formulaire de modification
$idVille = isset($_GET['id']) ? $_GET['id'] : null;

if ($idVille): 
    $sql = "SELECT ville.*, pays.nompays AS nom_pays, sites.*
    FROM ville
    JOIN pays ON ville.idpays = pays.idpays
    JOIN sites ON ville.idville = sites.idville
    WHERE ville.idville = $idVille";
    $rslt = mysqli_query($conn, $sql);
    $ville = mysqli_fetch_assoc($rslt);
    mysqli_free_result($rslt);
    mysqli_close($conn);
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Détails de la ville</title>
        <link rel="stylesheet" href="modifier.css">
    </head>
    <body>
     <section>
     <h1>Modifier</h1>

<?php if ($ville): ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <input type="hidden" name="idVille" value="<?php echo $ville['idville']; ?>">
          <!-- nom ville -->
         
        <div><label for="nomVille">Nom :</label>
        <input type="text" name="nomVille" value="<?php echo $ville['nomville']; ?>">
 </div>
    </div>
      <!-- descville -->
       <div> <label for="descVille">descVille :</label>
         <textarea name="descVille"><?php echo $ville['descville']; ?></textarea>
  </div>
      <!-- pays -->
     <div>   <label for="pays">Pays :</label>
        <input type="text" name="pays" value="<?php echo $ville['nom_pays']; ?>">
   </div>
      <!-- site -->
    <div>    <label for="sites">Sites :</label>
        <input type="text" name="sites" value="<?php echo $ville['nomsite']; ?>">
    </div>
      <!--image site -->
    <div>    <label for="sites">image site :</label>
    <input type="text" name="image" id="image">
    </div>
        
        <!-- Liste des hôtels -->
       <div>
       <label for="hotel">Hotels:</label>
        <input type="text" name="hotel" id="hotel" placeholder="Hotels" />
      </div>
     
       </div>
        
        <!-- Liste des restaurants -->
       <div> <label for="resto">Restaurant:</label>
        <input type="text" name="resto" id="restaurant" placeholder="Restaurants" />
       
     </div>
        
        <!-- Liste des gares -->
        <div>
        <label for="gare">Gares:</label>
        <input type="text" name="gare" id="gare" placeholder="Gares" />
       
     
        </div>
        
        <!-- Liste des aéroports -->
       <div>
       <label for="aeroport">Aeroport:</label>
        <input type="text" name="aeroport" id="aeroport" placeholder="Aeroport" />
       
     
       </div>
        
      
       <div class="center">
       <input type="submit" value="Enregistrer" name="submit">
       </div>
    </form>
<?php else: ?>
    <p>Ville non trouvée.</p>
<?php endif; ?>
     </section>
        <script>
        function ajouter(event, parent, child) {
            event.preventDefault();

            const list = document.getElementById(parent);
            var input = document.getElementById(child);
            var text = input.value;

            if (text !== "") {
                var option = document.createElement("option");
                option.text = text;
                list.add(option);
                input.value = "";
            }
        }
        </script>
    </body>
    </html>
<?php else: ?>
    <p>Identifiant de ville non spécifié.</p>
<?php endif; ?>