<?php
include('config/connect.php');


$villes = [];
if (isset($_GET['delete'])) {
    $villeId = $_GET['delete'];

    // Supprimer les sites associés à la ville
    $sqlDeleteSites = "DELETE FROM sites WHERE idville = $villeId";
    mysqli_query($conn, $sqlDeleteSites);
    $sqlDeletenec = "DELETE FROM necessaire WHERE idville = $villeId";
    mysqli_query($conn, $sqlDeletenec);

    // Supprimer la ville
    $sqlDeleteVille = "DELETE FROM ville WHERE idville = $villeId";
    mysqli_query($conn, $sqlDeleteVille);

    // Rediriger vers la même page après la suppression
    header("Location: indeex.php");
    exit();
}
if (isset($_POST['submit'])) {

    $continent = $_POST['continent'];
    $pays = $_POST['pays'];
    $ville = $_POST['ville'];
    $sites = $_POST['sites'];


    $sql = "SELECT ville.idville, ville.nomville, pays.nompays FROM ville
    INNER JOIN pays ON ville.idpays = pays.idpays";

if (!empty($continent)) {
$sql .= " INNER JOIN continent ON pays.idcon = continent.idcon
          AND continent.nomcon LIKE '%$continent%'";
}

if (!empty($pays)) {
$sql .= " AND pays.nompays LIKE '%$pays%'";
}

if (!empty($ville)) {
$sql .= " AND ville.nomville LIKE '%$ville%'";
}

if (!empty($sites)) {
$sql .= " INNER JOIN sites ON ville.idville = sites.idville 
          AND sites.nomsite LIKE '%$sites%'";
}


  
    $result = mysqli_query($conn, $sql);

 
    if (mysqli_num_rows($result) > 0) {
       
        $villes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
     
        $villes = [];
    }
  
    mysqli_free_result($result);
   
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>projet daw</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
   <link rel="stylesheet" href="style.css">
</head>


<body >

<div class="contente">
    <nav>
        <h2>Étudiant 1: </h2>
        <ul>
          <li>Nom: Chouiref</li>
          <li>Prenom: Sidali</li>
          <li>Spécialité: informatique</li>
          <li>Section:1</li>
          <li>Groupe:6</li>
          <li>Mail: sidali20012017@outlook.com</li>

        </ul>
        <h2>Étudiant 2: </h2>
        <ul>
          <li>Nom: Medjber</li>
          <li>Prenom: Soundous</li>
          <li>Spécialité: informatique</li>
          <li>Section:1</li>
          <li>Groupe:6</li>
          <li>Mail:medjbersoundous@gmail.com</li>

        </ul>
        <hr>
        <ul>
            <li><a href="addville.php">Ajouter Ville</a></li>
        </ul>
    </nav>
   <div class="home">
    <header> 
    
    <div class="slideshow-container">

<div >
    <div class="text"> <h3 >IKTISHAF | اكتشاف</h3> </div>
  <img src="travel2.avif" alt="hey" style="width:1300px; height:250px">
</div>

</header>

   
    <section class="pre">
        
     <form action="indeex.php" method="POST">
    <div class="input">
        <span>Continent:</span>
        <input type="text" name="continent">
    </div>
    <div class="input">
        <span>Pays:</span>
        <input type="text" name="pays">
    </div>
    <div class="input">
        <span>Ville:</span>
        <input type="text" name="ville">
    </div>
    <div class="input">
        <span>Site:</span>
        <input type="text" name="sites">
    </div>
    <div class="btn">
    <button class="btn-submit" type="submit" name="submit">Valider</button>
</div>
</form>



       
        <hr>
        <h2 class="titre-recherche">Tout ce que vous devez savoir sur votre destination :</h2>
        <div class="resultat">
            <ul class="liste-pagination">
            <?php
          if ($villes) {
            foreach ($villes as $ville) {
              echo '<li class="pagination-item">' . '<a href="ville.php?id=' . $ville['idville'] . '">' . $ville['nomville'] . '</a>' .
                '<a href="modifier.php?id=' . $ville['idville'] . '"><i class="fa-solid fa-pen-to-square"></i></a>' .
                '<span class="icon"><a href="indeex.php?delete=' . $ville['idville'] . '"><i class="fa-solid fa-trash"></i></a></span>' .
                '</li>';
            }
          } else {
       echo '<li>Aucun résultat trouvé.</li>';
      }
?>
            </ul>
            <div class="pagination">
    <button class="prev" hidden >Previous</button>
    <button class="next" hidden>Next</button>
  </div>

        </div>


    </section>
   </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/min/tiny-slider.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
      var slider = tns({
        container: '.liste-pagination',
        items: 4,
        slideBy: 'page',
        controls: {
          prevButton: '.prev',
          nextButton: '.next',
        },
      });
      var prevButton = document.querySelector('.prev');
      var nextButton = document.querySelector('.next');

      // Style the previous button
      prevButton.style.padding = '5px 10px';
      prevButton.style.margin = '0 2px';
      prevButton.style.backgroundColor = '#e0e0e0';
      prevButton.style.color = '#000';
      prevButton.style.borderRadius = '3px';

      // Style the next button
      nextButton.style.padding = '5px 10px';
      nextButton.style.margin = '0 2px';
      nextButton.style.backgroundColor = '#e0e0e0';
      nextButton.style.color = '#000';
      nextButton.style.borderRadius = '3px';
    });
</script>
</html>