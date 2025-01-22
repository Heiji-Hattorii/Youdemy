<?php
require_once 'classes/class.databse.php';

abstract class Cours extends Database {

    protected $id_teach;
    protected $titre;
    protected $descri;
    protected $type;
    protected $content;
    protected $ftype;
    protected $id_cour;
    protected $id_categorie;

    public function __construct($id_teach, $titre, $descri, $type, $content, $ftype, $id_cour,$id_categorie) {
        $this->id_teach = $id_teach;
        $this->titre = $titre;
        $this->descri = $descri;
        $this->type = $type;
        $this->content = $content;
        $this->ftype = $ftype;
        $this->id_cour = $id_cour;
        $this->id_categorie=$id_categorie;
    }

    abstract public function ajoutercr();

    abstract public function afficher_cours();

    public function supprimercr() {
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("DELETE FROM cours WHERE id_cour = :id_cour");
        $stmt->bindParam(':id_cour', $this->id_cour);
        if ($stmt->execute()) {
            return "Fichier supprimé avec succès.";
        } else {
            return "Erreur lors de la suppression.";
        }
    }

     abstract public function updatecr();

    public function getIdCateg() {
        return $this->id_categorie;
    }

    public function setIdCateg($id_categorie) {
        $this->id_categorie = $id_categorie;
    }
    public function getIdTeach() {
        return $this->id_teach;
    }

    public function setIdTeach($id_teach) {
        $this->id_teach = $id_teach;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function getDescri() {
        return $this->descri;
    }

    public function setDescri($descri) {
        $this->descri = $descri;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getFtype() {
        return $this->ftype;
    }

    public function setFtype($ftype) {
        $this->ftype = $ftype;
    }

    public function getIdCour() {
        return $this->id_cour;
    }

    public function setIdCour($id_cour) {
        $this->id_cour = $id_cour;
    }


public function count_cours() {
    $pdo = $this->Connexion(); 

    $query = "SELECT COUNT(*) as total FROM cours"; 
    $result = $pdo->prepare($query); 
    $result->execute(); 
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return $row['total']; 
}

}
?>
