<?php
require_once 'classes/class.databse.php';

class Categorie extends Database{

    public function addcategorie($nom_categorie){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("INSERT INTO categorie ( nom_categorie) VALUES (:nom_categorie)");
        $stmt->bindParam(':nom_categorie', $nom_categorie);
        $stmt->execute();
    
    }
    public function modifiercategorie($id_categorie,$nom_categorie){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("UPDATE categorie set  nom_categorie=:nom_categorie where id_categorie=:id_categorie ");
        $stmt->bindParam(':nom_categorie', $nom_categorie);
        $stmt->bindParam(':id_categorie', $id_categorie);

        $stmt->execute();
    
    }


    public function deletecategorie($id_categorie){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("DELETE FROM categorie where id_categorie=:id_categorie ");
        $stmt->bindParam(':id_categorie', $id_categorie);
        $stmt->execute();
    }
    
    public function affichercategories(){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("SELECT * FROM categorie");
        $stmt->execute();
        return $stmt->fetchAll();
    
    }

}

?>