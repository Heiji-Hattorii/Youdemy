<?php
require_once 'classes/class.databse.php';

class Tag extends Database{

public function addtag($tag){
    $pdo = $this->Connexion();
    $stmt = $pdo->prepare("INSERT INTO tag (tag) VALUES (:tag)");
    $stmt->bindParam(':tag', $tag);
    $stmt->execute();

}
public function alltags(){
    $pdo = $this->Connexion();
    $stmt = $pdo->prepare("SELECT id_tag, tag FROM tag");
    $stmt->execute();
    return $stmt->fetchAll();
}



public function modifiertag($id_tag,$tag){
    $pdo = $this->Connexion();
    $stmt = $pdo->prepare("UPDATE tag set tag=:tag where id_tag=:id_tag ");
    $stmt->bindParam(':tag', $tag);
    $stmt->bindParam(':id_tag', $id_tag);
    $stmt->execute();

}


public function deletetag($id_tag){
    $pdo = $this->Connexion();
    $stmt = $pdo->prepare("DELETE FROM tag where id_tag=:id_tag ");
    $stmt->bindParam(':id_tag', $id_tag);
    $stmt->execute();
}

public function addTagToCours($id_tag,$id_cour){
    $pdo = $this->Connexion();
    $stmt = $pdo->prepare("INSERT INTO cours_tags (id_cour, id_tag)VALUES (:id_cour, :id_tag)
        ON DUPLICATE KEY UPDATE id_tag = id_tag ");
    $stmt->bindParam(':id_tag', $id_tag);
    $stmt->bindParam(':id_cour', $id_cour);
    $stmt->execute();

}


}


?>