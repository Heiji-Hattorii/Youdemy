<?php
require 'classes/class.enseignants.php';
require 'classes/class.coursvid.php';
require 'classes/class.coursdoc.php';
require 'classes/class.categories.php';
require 'classes/class.etudiants.php';


$vid = new Coursvid();
$doc = new Coursdoc();
$catt = new Categorie();
$teach = new Enseignant();
$mee=new Etudiant();

session_start();

if (isset($_SESSION['ID_user'])) {
    if ($_SESSION['ROLE'] === 'etudiant') {
        if (isset($_POST['id_cour']) && !empty($_POST['id_cour'])) {
            $teach->ajoutmescours($_SESSION['ID_user'], $_POST['id_cour']);
        } else {
        }
    }
}
    else {
        $_SESSION['ROLE'] = 'visiteur';
        if (isset($_POST['id_cour'])) {
            header("Location: login.php");
            exit;
        
    }
}

if (isset($_POST['title']) && trim($_POST['title']) !== '') {
    $titres = $teach->rechercher_cours_title($_POST['title']);
}
$total_pages='';
if (isset($_POST['categorieselect']) && trim($_POST['categorieselect']) !== '') {
    $slcs = $teach->rechercher_cours((int)$_POST['categorieselect']);
} else {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 4;
    $offset = ($page - 1) * $limit/2;

    $docs = $doc->afficher_cours_pagination($offset, $limit/2);
    $vids = $vid->afficher_cours_pagination($offset, $limit/2);

    $total_docs = $doc->count_cours();
    $total_vids = $vid->count_cours();
    $total_courses = $total_docs + $total_vids;
    $total_pages = ceil($total_courses / $limit);
}

$categories = $catt->affichercategories();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue de cours</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .catalogue {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        padding: 20px;
    }

    .course-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 300px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }

    .course-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .course-card h3 {
        margin: 15px;
        font-size: 1.5em;
        color: #333;
    }

    .course-card p {
        margin: 0 15px 10px;
        color: #666;
        line-height: 1.5;
    }

    .course-card .course-type {
        display: inline-block;
        margin: 10px 15px 15px;
        padding: 5px 10px;
        background: #007BFF;
        color: #fff;
        border-radius: 5px;
        font-size: 0.9em;
    }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="search-form" style="text-align: center; margin: 20px;">
        <form method="POST" action="">
            <input type="text" name="title" placeholder="Rechercher par titre"
                style="padding: 10px; margin-right: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <select name="categorieselect"
                style="padding: 10px; margin-right: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="">Toutes les catégories</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['id_categorie'])?>">
                    <?= htmlspecialchars($cat['nom_categorie']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button name="submit" type="submit"
                style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px;">Rechercher</button>
        </form>
    </div>





    <?php if (!empty($titres)): ?>
    <?php foreach ($titres as $titre): ?>
    <div class="course-card">
        <img src="images/icones/<?= $titre['type'] === 'Document' ? 'Premium Photo _ Stack of old vintage books hand drawn color watercolor illustration Library and learning.jpg' : '02bqDexyTO6DiTPEV1yc2w.jpg'; ?>"
            alt="Image du cours">
        <h3><?= htmlspecialchars($titre['titre']) ?></h3>
        <p><?= htmlspecialchars($titre['descri']) ?></p>
        <p><?= htmlspecialchars($titre['pages'] | $titre['seconds'] ) ?></p>

    </div>
    <?php endforeach; ?>
    <?php elseif (!empty($slcs)): ?>
    <?php foreach ($slcs as $slc): ?>
    <div class="course-card">
        <img src="images/icones/<?= $slc['type'] === 'Document' ? 'Premium Photo _ Stack of old vintage books hand drawn color watercolor illustration Library and learning.jpg' :'02bqDexyTO6DiTPEV1yc2w.jpg'; ?>"
            alt="Image du cours">
        <h3><?= htmlspecialchars($slc['titre']) ?></h3>
        <p><?= htmlspecialchars($slc['descri']) ?></p>
        <p><?= htmlspecialchars($slc['pages'] | $slc['seconds'] ) ?></p>

    </div>
    <?php endforeach; ?>

    <?php else: ?>
    <div class="catalogue">
        <?php if (!empty($docs)): ?>
        <?php foreach ($docs as $doc): ?>
        <div class="course-card">
            <img src="images/icones/Premium Photo _ Stack of old vintage books hand drawn color watercolor illustration Library and learning.jpg"
                alt="Image du cours">
            <h3><?= htmlspecialchars($doc['titre']) ?></h3>
            <p><?= htmlspecialchars($doc['descri']) ?></p>
            <p><?= htmlspecialchars($doc['pages']) ?></p>
            <?php if ($_SESSION['ROLE'] === 'etudiant'): ?>
            <?php $idUser = $_SESSION['ID_user'];
            $idCour = $doc['id_cour']; 

            $estInscrit = $mee->verifierInscription($idUser, $idCour);
            ?>
            <?php if($estInscrit) :?>
            <button class="ml-[10px] w-[50%] h-[25px] rounded-lg bg-gray-500" disabled>Déjà inscrit</button>
            <?php else: ?>
            <form method="POST" action="">
                <input type="hidden" name="id_cour" value="<?= htmlspecialchars($doc['id_cour']) ?>">
                <button class="ml-[10px] w-[50%] h-[25px] rounded-lg bg-blue-700 hover:bg-blue-800"
                    type="submit">S'inscrire</button>
            </form>
            <?php endif; ?>

            <?php elseif($_SESSION['ROLE'] === 'visiteur') :?>
            <form method="POST" action="">
                <input type="hidden" name="id_cour" value="<?= htmlspecialchars($doc['id_cour']) ?>">
                <button class="ml-[10px] w-[50%] h-[25px] rounded-lg bg-blue-700 hover:bg-blue-800"
                    type="submit">S'inscrire</button>
            </form>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($vids)): ?>
        <?php foreach ($vids as $vid): ?>
        <div class="course-card">
            <img src="images/icones/02bqDexyTO6DiTPEV1yc2w.jpg" alt="Image du cours">
            <h3><?= htmlspecialchars($vid['titre']) ?></h3>
            <p><?= htmlspecialchars($vid['descri']) ?></p>
            <p><?= htmlspecialchars($vid['seconds']) ?></p>
            <?php if ($_SESSION['ROLE'] === 'etudiant'): ?>
            <?php $idUser = $_SESSION['ID_user'];
            $idCour = $vid['id_cour']; 

            $estInscrit = $mee->verifierInscription($idUser, $idCour);
            ?>
            <?php if($estInscrit) :?>
            <button class="ml-[10px] w-[50%] h-[25px] rounded-lg bg-gray-500" disabled>Déjà inscrit</button>
            <?php else: ?>
            <form method="POST" action="">
                <input type="hidden" name="id_cour" value="<?= htmlspecialchars($vid['id_cour']) ?>">
                <button class="ml-[10px] w-[50%] h-[25px] rounded-lg bg-blue-700 hover:bg-blue-800"
                    type="submit">S'inscrire</button>
            </form>
            <?php endif; ?>

            <?php elseif($_SESSION['ROLE'] === 'visiteur') :?>
            <form method="POST" action="">
                <input type="hidden" name="id_cour" value="<?= htmlspecialchars($vid['id_cour']) ?>">
                <button class="ml-[10px] w-[50%] h-[25px] rounded-lg bg-blue-700 hover:bg-blue-800"
                    type="submit">S'inscrire</button>
            </form>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>


    <div class="pagination" style="text-align: center; margin: 20px;">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>"
            style="padding: 10px 15px; margin: 0 5px; text-decoration: none; background-color: <?= $i == $page ? '#007BFF' : '#ccc'; ?>; color: white; border-radius: 5px;">
            <?= $i ?>
        </a>
        <?php endfor; ?>
    </div>
    <?php endif;?>
</body>

</html>