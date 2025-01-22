<?php 
require_once 'classes/class.databse.php';
class Users extends Database
{   protected int $id_user;
    protected string $identifiant;
    protected string $email;
    protected DateTime $create_at;

    public function valideDonnees($identifiant, $email, $pass, $cpass)
    {
        if (empty($identifiant) || empty($email) || empty($pass) || empty($cpass)) {
            return "Erreur : Les champs ne peuvent pas être vides.";
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $identifiant)) {
            return "Erreur : Les champs prénom et nom ne doivent contenir que des lettres.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'L\'email n\'est pas valide!!!';
        }

        if (!preg_match("/^[a-zA-Z0-9$*-+*.&#:?!;,]{8,}$/", $pass)) {
            return 'Le mot de passe doit contenir au moins 8 caractères, avec des lettres et des chiffres.';
        }

        if ($pass !== $cpass) {
            return 'Les mots de passe ne correspondent pas.';
        }

        return true;
    }


    public function login($email, $password)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $pdo = $this->Connexion();
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['pass'])) {
                session_start();
                $_SESSION['ID_user'] = $user['id_user'];
                $_SESSION['ROLE'] = $user['role'];
                $_SESSION['STATUS'] = $user['status'];
                if($_SESSION['STATUS']==='en attente'){
                    header('Location: attente.php');
                }
                else{
                header('Location: homy.php');}
                exit;

                
            } else {
                return "Email ou mot de passe incorrect.";
            }
        } catch (Exception $e) {
            return "Erreur lors de login : " . $e->getMessage();
        }
    }

    public function logout()
    {
        try {
            unset($_SESSION['ID_user']);
            session_unset();
            session_destroy();
            header("Location: homy.php");
            exit();
        } catch (Exception $e) {
            return "Erreur lors de logout : " . $e->getMessage();
        }
    }
   
}
?>