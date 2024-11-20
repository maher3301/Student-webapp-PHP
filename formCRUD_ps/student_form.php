<?php
class Student
{  
    public $id, $fname, $lname, $email, $phone;
    public $conn; // Change visibility to protected

    private $serv = 'localhost', $user = 'root', $pass = '', $bdname = 'essat2';

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->serv;dbname=$this->bdname", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            // echo 'Connexion réussie'; // Vous pouvez retirer cette ligne pour éviter d'afficher le message à chaque fois
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function create_stud()
    {
        $req = "INSERT INTO students (firstname, lastname, email, phone) VALUES (:firstname, :lastname, :email, :phone)";
        $stmt = $this->conn->prepare($req);
        return $stmt->execute(array(
            ':firstname' => $this->fname,
            ':lastname' => $this->lname,
            ':email' => $this->email,
            ':phone' => $this->phone
        ));
    }

    public function delete_stud($id)
    {
        $req = "DELETE FROM students WHERE id = :id";
        $stmt = $this->conn->prepare($req);
        return $stmt->execute(array(':id' => $id));
    }

    public function update_stud($id, $firstname, $lastname, $email)
    {
        $req = "UPDATE students SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($req);
        return $stmt->execute(array(
            ':id' => $id,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email
        ));
    }
    public function edit($id)
    {
        $req = "SELECT * FROM students WHERE id = :id";
        $stmt = $this->conn->prepare($req);
        $stmt->execute(array(':id' => $id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

