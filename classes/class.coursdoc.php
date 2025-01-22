<?php
require_once 'classes/class.cours.php';
class Coursdoc extends Cours{
    protected $pages;

    public function __construct($id_teach = null, $titre = null, $descri = null, $type = null, $content = null, $ftype = null, $pages = null, $id_cour = null,$id_categorie=null) {
        parent::__construct($id_teach, $titre, $descri, $type, $content, $ftype,$id_cour,$id_categorie);
        $this->pages = $pages;
    }
    public function ajoutercr(){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("INSERT INTO cours (id_teach,titre,descri,type,id_categorie,pages ,content ,ftype) VALUES (:id_teach,:titre, :descri,:type,:id_categorie,:pages,:content ,:ftype)");
        $stmt->bindParam(':titre',$this->titre);
        $stmt->bindParam(':content', $this->content); 
        $stmt->bindParam(':descri', $this->descri);
        $stmt->bindParam(':id_categorie', $this->id_categorie);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':ftype', $this->ftype);
        $stmt->bindParam(':id_teach', $this->id_teach);
        $stmt->bindParam(':pages', $this->pages);

        if ($stmt->execute()) {
            $this->id_cour = $pdo->lastInsertId();;
            return "Fichier enregistre avec succes";
        } else {
            return "Erreur lors de enregistrement";
        }
    }

    public function updatecr() {
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare(
            "UPDATE cours 
             SET titre = :titre, content = :content, descri = :descri, type = :type, pages=:pages,ftype = :ftype 
             WHERE id_cour = :id_cour"
        );
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':descri', $this->descri);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':ftype', $this->ftype);
        $stmt->bindParam(':id_cour', $this->id_cour);
        $stmt->bindParam(':pages', $this->pages);


        if ($stmt->execute()) {
            return "Fichier mis à jour avec succès.";
        } else {
            return "Erreur lors de la mise à jour.";
        }
    }





    public function getIdTeach() {
        return $this->id_teach;
    }

    public function setIdTeach($id_teach) {
        $this->id_teach = $id_teach;
    }
    public function afficher_cours(){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("SELECT id_cour,titre,descri,type,ftype,content,pages FROM cours where type='Document'");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getPages() {
        return $this->pages;
    }

    public function setPages($pages) {
        $this->pages = $pages;
    }




    public function afficher_cours_pagination($offset, $limit) {
        $pdo = $this->Connexion();
    
        // Remplacez cette requête SQL par celle qui correspond à votre base de données
        $query = "SELECT * FROM cours where type='Document' LIMIT :offset, :limit";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>