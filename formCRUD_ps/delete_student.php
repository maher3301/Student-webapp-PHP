<?php
include('student_form.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $stud = new Student();
    
    if ($stud->delete_stud($id)) {
        // Redirection vers la page principale après la suppression
        header("Location: recuperer_tableau.php");
        exit();
    } else {
        echo "Erreur lors de la suppression de l'étudiant";
    }
}
?>
