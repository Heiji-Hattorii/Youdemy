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
                header('Location: home.php');
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
            header("Location: home.php");
            exit();
        } catch (Exception $e) {
            return "Erreur lors de logout : " . $e->getMessage();
        }
    }
    public function afficher_cours(){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("SELECT * FROM cours");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function afficher_users(){
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function update_status($id_user, $status) {
        $query = "UPDATE users SET status = :status WHERE id_user = :id_user";
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id_user', $id_user);

        if ($stmt->execute()) {
            header("Location: gererusers.php"); 
            exit();
        } else {
            echo "Erreur  update role!";
        }
    }
    public function supprimerUser($id_user){
        $query = "DELETE FROM users  WHERE id_user = :id_user";
        $pdo = $this->Connexion();
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_user', $id_user);

        if ($stmt->execute()) {
            header("Location: gererusers.php"); 
            exit();
        } else {
            echo "Erreur  update role!";
        }

    }
}
?>