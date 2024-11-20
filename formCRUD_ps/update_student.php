<?php
include('student_form.php');

// Ajoutez les en-têtes de sécurité
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$email) {
        echo "Adresse email invalide";
        exit; // Arrêtez le script si l'email est invalide
    }

    $stud = new Student();
    
    // Construire la requête SQL de mise à jour
    $sql = "UPDATE students SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id";
    $stmt = $stud->conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        echo "Étudiant mis à jour avec succès";
    } else {
        echo "Erreur lors de la mise à jour de l'étudiant";
        // Logguer l'erreur dans un fichier de journal
        error_log("Erreur lors de la mise à jour de l'étudiant : " . $stmt->errorInfo()[2], 0);
    }
}
?>
