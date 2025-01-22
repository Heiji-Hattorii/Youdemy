<!-- <?php
// require_once 'classes/class.cours.php';
// class Coursvid extends Cours {
//     public function ajoutercr($id_teach,$titre,$descri,$type,$id_categorie,$seconds,$content,$ftype){
//         $pdo = $this->Connexion();
//         $stmt = $pdo->prepare("INSERT INTO cours (id_teach,titre,descri,type,id_categorie,seconds ,content ,ftype) VALUES (:id_teach,:titre, :descri,:type,:id_categorie,:seconds,:content ,:ftype)");
//         $stmt->bindParam(':titre',$titre);
//         $stmt->bindParam(':content', $content); 
//         $stmt->bindParam(':descri', $descri);
//         $stmt->bindParam(':id_categorie', $id_categorie);
//         $stmt->bindParam(':type', $type);
//         $stmt->bindParam(':ftype', $ftype);
//         $stmt->bindParam(':id_teach', $id_teach);
//         $stmt->bindParam(':seconds', $seconds);



//         if ($stmt->execute()) {
//             return "Fichier enregistre avec succes";
//         } else {
//             return "Erreur lors de enregistrement";
//         }
//     }
//     public function afficher_cours(){
//         $pdo = $this->Connexion();
//         $stmt = $pdo->prepare("SELECT id_cour,titre,descri,type,ftype,content,seconds FROM cours where type='Video'");
//         $stmt->execute();
//         return $stmt->fetchAll();
//     }
    


// }
?> -->

<?php
require_once 'classes/class.cours.php';

class Coursvid extends Cours {
    protected $seconds;

    public function __construct($id_teach = null, $titre = null, $descri = null, $type = null, $content = null, $ftype = null, $seconds = null, $id_cour = null,$id_categorie=null) {
        parent::__construct($id_teach, $titre, $descri, $type, $content, $ftype,$id_cour,$id_categorie);
        $this->seconds = $seconds;
    }

    
    public function ajoutercr(){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("INSERT INTO cours (id_teach,titre,descri,type,id_categorie,seconds ,content ,ftype) VALUES (:id_teach,:titre, :descri,:type,:id_categorie,:seconds,:content ,:ftype)");
        $stmt->bindParam(':titre',$this->titre);
        $stmt->bindParam(':content', $this->content); 
        $stmt->bindParam(':descri', $this->descri);
        $stmt->bindParam(':id_categorie', $this->id_categorie);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':ftype', $this->ftype);
        $stmt->bindParam(':id_teach', $this->id_teach);
        $stmt->bindParam(':seconds', $this->seconds);

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
             SET titre = :titre, content = :content, descri = :descri,seconds=:seconds ,type = :type,ftype = :ftype 
             WHERE id_cour = :id_cour"
        );
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':descri', $this->descri);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':ftype', $this->ftype);
        $stmt->bindParam(':id_cour', $this->id_cour);
        $stmt->bindParam(':seconds', $this->seconds);


        if ($stmt->execute()) {
            return "Fichier mis à jour avec succès.";
        } else {
            return "Erreur lors de la mise à jour.";
        }
    }
    public function afficher_cours(){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("SELECT id_cour,titre,descri,type,ftype,content,seconds FROM cours where type='Video'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function afficher_cours_pagination($offset, $limit) {
        $pdo = $this->Connexion();
    
        // Remplacez cette requête SQL par celle qui correspond à votre base de données
        $query = "SELECT * FROM cours where type='Video' LIMIT :offset, :limit";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSeconds() {
        return $this->seconds;
    }

    public function setSeconds($seconds) {
        $this->seconds = $seconds;
    }
}
?>
