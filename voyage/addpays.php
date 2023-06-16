<?php
//Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si le formulaire est soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $nompays = $_POST["nompays"];
        $nomcon = $_POST["nomcon"];

        // Vérifier si le continent existe dans la base de données
        $stmt = $conn->prepare("SELECT idcon FROM continent WHERE nomcon = :nomcon");
        $stmt->bindParam(':nomcon', $nomcon);
        $stmt->execute();
        $row = $stmt->fetch();

        // Debug: Afficher les informations récupérées
        var_dump($nomcon);
        var_dump($row);

        if ($row && $row['idcon']) {
            // Le continent existe, récupérer son ID
            $idcon = $row['idcon'];

            // Préparer et exécuter la requête d'insertion
            $stmt = $conn->prepare("INSERT INTO pays (nompays, idcon) VALUES (:nompays, :idcon)");
            $stmt->bindParam(':nompays', $nompays);
            $stmt->bindParam(':idcon', $idcon);
            $stmt->execute();

            echo "Le pays a été ajouté avec succès à la base de données.";
        } else {
            // Le continent n'existe pas, afficher un message d'erreur avec les informations de débogage
            echo "Le continent spécifié n'existe pas dans la base de données.";
        }
    }
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}

$conn = null;
?> 




<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un pays</title>
    <link rel="stylesheet" href="modifier.css">
</head>
<body>
    <h2>Ajouter un pays</h2>
    <form action="addpays.php" method="POST">
        <label for="nompays">Nom du pays:</label>
        <input type="text" name="nompays" id="nompays" required>
        <br><br>
        
        <div>
            <label for="nomcon">Continent :</label>
             <select id="nomcon" name="nomcon" required>
                <option value="<?php echo htmlspecialchars($nomcon) ?>">Sélectionnez un continent</option>   
                    <?php
                   $continents = array("africa", "europe", "america", "asia", "ocean");
                   foreach ($continents as $nomcon) {
                  echo "<option value=\"$nomcon\">$nomcon</option>";
                   }
                    ?>
                </select>
                <div class=""><?php echo $errors['nomcon'] ?></div>
        </div>
        
        <input type="submit" value="Ajouter">
    </form>
</body>
</html>


