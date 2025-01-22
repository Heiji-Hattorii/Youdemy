<?php
require 'classes/class.databse.php';
require 'classes/class.users.php';

class Admin extends Users{
    public function afficher_users(){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function update_status($id_user, $status) {
        $query = "UPDATE users SET status = :status WHERE id_user = :id_user";
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id_user', $id_user);

        if ($stmt->execute()) {
            header("Location: gererusers.php"); 
            exit();
        } else {
            echo "Erreur update status!";
        }
    }
    public function supprimerUser($id_user){
        $query = "DELETE FROM users  WHERE id_user = :id_user";
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_user', $id_user);

        if ($stmt->execute()) {
            header("Location: gererusers.php"); 
            exit();
        } else {
            echo "Erreur  suppression de user !";
        }

    }

    public function countcours(){
        $pdo = $this->Connexion();
        $stmt=$pdo->prepare("SELECT COUNT(*) FROM cours");
        $stmt->execute();
        $result=$stmt->fetch();
        return $result['COUNT(*)'];

    }
    public function courplusetudiant(){
        $pdo = $this->Connexion();
        $stmt=$pdo->prepare("SELECT cours.id_cour, cours.titre, COUNT(mes_cours.id_user) AS etudiants FROM cours INNER JOIN mes_cours ON cours.id_cour=mes_cours.id_cour group by mes_cours.id_cour order by etudiants desc limit 1");
        $stmt->execute();
        $result=$stmt->fetch();
        return $result;

    }
    public function repartition(){
        $pdo=$this->Connexion();
        $stmt=$pdo->prepare("SELECT cours.id_categorie, categorie.nom_categorie,COUNT(*) AS nb_cours FROM cours INNER JOIN categorie ON cours.id_categorie=categorie.id_categorie GROUP BY cours.id_categorie ORDER BY nb_cours DESC ");
        $stmt->execute();
        return $stmt->fetchAll();
       
    }



}
?>