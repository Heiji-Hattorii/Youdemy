<?php
require 'classes/class.databse.php';
require 'classes/class.users.php';

class Enseignant extends Users{
    public function ajoutercr($id_teach,$titre,$descri,$type,$id_categorie,$content,$ftype){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("INSERT INTO cours (id_teach,titre,descri,type,id_categorie, content ,ftype) VALUES (:id_teach,:titre, :descri,:type,:id_categorie,:content ,:ftype)");
        $stmt->bindParam(':titre',$titre);
        $stmt->bindParam(':content', $content); 
        $stmt->bindParam(':descri', $descri);
        $stmt->bindParam(':id_categorie', $id_categorie);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':ftype', $ftype);
        $stmt->bindParam(':id_teach', $id_teach);


        if ($stmt->execute()) {
            return "Fichier enregistre avec succes";
        } else {
            return "Erreur lors de enregistrement";
        }
    }

    public function updatecr($id_cour,$titre,$descri,$type,$content,$ftype){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("UPDATE cours SET titre = :titre , content=:content ,descri=:descri,type=:type,ftype=:ftype WHERE id_cour = :id_cour");
        $stmt->bindParam(':titre',$titre);
        $stmt->bindParam(':content', $content); 
        $stmt->bindParam(':descri', $descri);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':ftype', $ftype);
        $stmt->bindParam(':id_cour', $id_cour);



        if ($stmt->execute()) {
            return "Fichier update avec succes";
            header("Location: gestioncours.php"); 

        } else {
            return "Erreur lors de enregistrement";
        }
    }


    public function supprimercr($id_cour){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("DELETE FROM cours where id_cour=:id_cour");
        $stmt->bindParam(':id_cour',$id_cour);
        if ($stmt->execute()) {
            return "Fichier est supprimer";
        } else {
            return "Erreur lors de suppression ";
        }

    }
    public function addtag($tag,$id_categorie){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("INSERT INTO tags (tag, id_categorie) VALUES (:tag, :id_categorie)");
        $stmt->bindParam(':tag', $tag);
        $stmt->bindParam(':id_categorie', $id_categorie);
        $stmt->execute();
    
    }
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
    public function tagaucateg(){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("SELECT categorie.id_categorie,categorie.nom_categorie,tags.tag,GROUP_CONCAT(tags.tag SEPARATOR '_ ') as groupe,tags.id_tag FROM categorie LEFT JOIN  tags ON categorie.id_categorie = tags.id_categorie group by  categorie.id_categorie");
        $stmt->execute();
        return $stmt->fetchAll();
    }



    public function modifiertag($id_tag,$tag){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("UPDATE tags set  tag=:tag where id_tag=:id_tag ");
        $stmt->bindParam(':tag', $tag);
        $stmt->bindParam(':id_tag', $id_tag);

        $stmt->execute();
    
    }


    public function deletetag($id_tag){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("DELETE FROM tags where id_tag=:id_tag ");
        $stmt->bindParam(':id_tag', $id_tag);
        $stmt->execute();
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
        $stmt = $pdo->prepare("SELECT
    mes_cours.id_inscription,
    mes_cours.id_user,
    mes_cours.id_cour,
    mes_cours.date_inscription,
    cours.titre,
    cours.descri,
    cours.type,
    cours.ftype FROM  mes_cours INNER JOIN cours ON mes_cours.id_cour = cours.id_cour where id_user=:id_user");
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        return $stmt->fetchAll();
    }





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






            
}



?>