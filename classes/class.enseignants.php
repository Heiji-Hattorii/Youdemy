<?php
require 'classes/class.databse.php';
require 'classes/class.signUsers.php';

class Enseignant extends signUsers{

    public function rechercher_cours($id_categorie) {
         $pdo=$this->connexion();
        $stmt = $pdo->prepare("SELECT cours.*, categorie.id_categorie, categorie.nom_categorie 
        FROM cours 
        JOIN categorie ON cours.id_categorie = categorie.id_categorie 
        WHERE cours.id_categorie = :id_categorie");
                   $stmt->bindParam(':id_categorie', $id_categorie);
                   $stmt->execute();
                   return $stmt->fetchAll();
                }
            public function rechercher_cours_title($title) {
            $pdo=$this->connexion();
            $stmt = $pdo->prepare("SELECT * from cours  where titre LIKE :titre");
            $title = '%' . $title . '%'; 
            $stmt->bindParam(':titre', $title);
            $stmt->execute();
            return $stmt->fetchAll();}

            public function lesinscritsamescours($id_user){
            $pdo=$this->connexion();
            $stmt=$pdo->prepare("SELECT 
            mes_cours.id_user ,
            mes_cours.date_inscription ,
            users.email ,
            users.identifiant , 
            cours.titre,
            cours.id_cour
            FROM 
            mes_cours
            INNER JOIN 
            users 
            ON mes_cours.id_user = users.id_user
            INNER JOIN 
            cours 
            ON mes_cours.id_cour = cours.id_cour
            WHERE 
            cours.id_teach = :id_enseignant; ");
            $stmt->bindParam(':id_enseignant',$id_user);
            $stmt->execute();
            return $stmt->fetchAll();
            }
            public function countmescours($id_user){
                $pdo=$this->connexion();
                $stmt=$pdo->prepare("SELECT COUNT(*) FROM cours WHERE id_teach = :id_teach");
                $stmt->bindParam(':id_teach',$id_user);
                $stmt->execute();
                $result=$stmt->fetch();
                return $result['COUNT(*)'];
            }
            public function countmesinscris($id_user){
                $pdo=$this->connexion();
                $stmt=$pdo->prepare("SELECT COUNT(DISTINCT  mes_cours.id_user) FROM mes_cours inner join cours on mes_cours.id_cour=cours.id_cour where cours.id_teach=:id_user");
                $stmt->bindParam(':id_user',$id_user);
                $stmt->execute();
                $result=$stmt->fetch();
                return $result['COUNT(DISTINCT  mes_cours.id_user)'];
            }


            public function countmescoursinscris($id_user){
                $pdo=$this->connexion();
                $stmt=$pdo->prepare("SELECT COUNT(DISTINCT mes_cours.id_cour)  FROM mes_cours inner join cours on mes_cours.id_cour=cours.id_cour where cours.id_teach=:id_user");
                $stmt->bindParam(':id_user',$id_user);
                $stmt->execute();
                $result=$stmt->fetch();
                return $result['COUNT(DISTINCT mes_cours.id_cour)'];
            }

            public function countmescoursvideo($id_user){
                $pdo=$this->connexion();
                $stmt=$pdo->prepare("SELECT COUNT(*) FROM cours WHERE id_teach = :id_teach AND cours.type='Video'");
                $stmt->bindParam(':id_teach',$id_user);
                $stmt->execute();
                $result=$stmt->fetch();
                return $result['COUNT(*)'];
            }






            public function ajoutmescours($id_user,$id_cour){
                $pdo=$this->connexion();
                $stmt = $pdo->prepare("INSERT INTO mes_cours (id_user, id_cour) VALUES (:id_user,:id_cour)");
                $stmt->bindParam(':id_user', $id_user);
                $stmt->bindParam(':id_cour', $id_cour);
                $stmt->execute();
            }
            public function mescours($id_user){
                $pdo=$this->connexion();
                $stmt = $pdo->prepare("SELECT mes_cours.id_inscription,mes_cours.id_user,mes_cours.id_cour,mes_cours.date_inscription,cours.titre,cours.descri,cours.type,cours.ftype FROM  mes_cours INNER JOIN cours ON mes_cours.id_cour = cours.id_cour where id_user=:id_user");
                $stmt->bindParam(':id_user', $id_user);
                $stmt->execute();
                return $stmt->fetchAll();
            }
        


            
}



?>