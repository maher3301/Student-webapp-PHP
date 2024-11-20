<?php
include('student_form.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Créer une nouvelle instance de la classe Student
    $stud = new Student();
    
    // Set student properties from the form data
    $stud->fname = $_POST['firstname'];
    $stud->lname = $_POST['lastname'];
    $stud->email = $_POST['email'];
    $stud->phone = $_POST['phone'];
    
    // Insert student data into the database
    if ($stud->create_stud()) {
        echo 'Etudiant bien ajouté';
    } else {
        echo 'Insertion échouée';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des étudiants</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajout de styles CSS supplémentaires pour centrer le tableau */
        .container {
            margin-top: 50px;
        }
        /* Style pour le footer */
        footer {
            background-color: white;
            padding: 20px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">ESSAT Formulaire</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="formulaire.php">Formulaire</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="recuperer_tableau.php">Résultats des étudiants</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
</head>
<body>

<div class="container">
    <h2>Résultats des étudiants</h2>
    <button id="showStudents" class="btn btn-primary">Afficher les étudiants</button>
    <table id="studentsTable" class="table table-striped" style="display:none;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Fetch and display student data from the database
        $stud = new Student();
        $sql = "SELECT * FROM students";
        $resultat = $stud->conn->query($sql);
        if ($resultat) {
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['firstname'] . "</td>";
                echo "<td>" . $row['lastname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>";
                // Formulaire de suppression avec bouton de soumission
                echo "<form action='delete_student.php' method='POST' style='display:inline-block;'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<button type='submit' class='btn btn-danger btn-sm'>Supprimer</button>";
                echo "</form>";
        
                // Formulaire de modification avec bouton de soumission
                echo "<button class='btn btn-primary btn-sm' onclick='showEditForm(" . $row['id'] . ")'>Modifier</button>";
                echo "<form id='editForm" . $row['id'] . "' action='update_student.php' method='POST' style='display:none;'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<input type='text' name='firstname' value='" . $row['firstname'] . "' placeholder='Prénom'>";
                echo "<input type='text' name='lastname' value='" . $row['lastname'] . "' placeholder='Nom'>";
                echo "<input type='email' name='email' value='" . $row['email'] . "' placeholder='Email'>";
                echo "<button type='submit' class='btn btn-primary btn-sm'>Enregistrer</button>";
                echo "</form>";
        
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Erreur lors de l'exécution de la requête : " . $stud->conn->errorInfo()[2] . "</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<footer>
    <div class="container">
        <p>&copy; 2024 Maher. Tous droits réservés.</p>
    </div> 
</footer>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.getElementById('showStudents').addEventListener('click', function() {
        var table = document.getElementById('studentsTable');
        if (table.style.display === 'none') {
            table.style.display = 'table';
        } else {
            table.style.display = 'none';
        }
    });

    function showEditForm(id) {
        var form = document.getElementById('editForm' + id);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script>
</body>
</html>
