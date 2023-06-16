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
        //Récupérer les données du formulaire
        $nomcon = $_POST["nomcon"];
        
       // Préparer et exécuter la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO continent (nomcon) VALUES (:nomcon)");
        $stmt->bindParam(':nomcon', $nomcon);
        $stmt->execute();

        echo "Le continent a été ajouté avec succès à la base de données.";
    }
} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}

$conn = null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un continent</title>
    <link rel="stylesheet" href="modifier.css">
</head>
<body>
    <h2>Ajouter un continent</h2>
    <form action="addcon.php" method="POST">
        <label for="nomcon">Nom du continent:</label>
        <input type="text" name="nomcon" id="nomcon" required>
        <br><br>
        
        <input type="submit" value="Ajouter">
    </form>
</body>
</html>

