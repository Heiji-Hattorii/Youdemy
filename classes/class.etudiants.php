<?php
require_once 'classes/class.signUsers.php';
class Etudiant extends signUsers{
    public function verifierInscription($id_user, $id_cour) {
        $pdo=$this->Connexion();
        $sql = "SELECT * FROM mes_cours WHERE id_user = :id_user AND id_cour = :id_cour";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_cour', $id_cour);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
?>