<?php
require 'classes/class.users.php';
class signUsers extends Users{

    public function signup($identifiant, $email, $pass, $cpass,$role)
    {
        $validationResult = $this->valideDonnees($identifiant,$email, $pass, $cpass);
        if ($validationResult !== true) {
            return $validationResult;
        }

        try {

            if($role==='enseignant'){
                $status='en attente';
            }
            else{
                $status='active';
            }
            $pass_hash = password_hash($pass, PASSWORD_BCRYPT);
            
            $sql = "INSERT INTO users (identifiant, email, pass,role,status ) VALUES (:identifiant, :email, :pass ,:role,:status)";
            $pdo = $this->Connexion();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'identifiant' => $identifiant,
                'email' => $email,
                'pass' => $pass_hash,
                'role' => $role,
                'status' => $status,

            ]);
        } catch (Exception $e) {
            die("erreur lors de l'insertion des données de new user !!!");
        }

        header('Location: login.php');
    }
}




?>