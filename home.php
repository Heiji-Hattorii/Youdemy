<?php
require 'classes/class.enseignants.php';
$teach=new Enseignant();
session_start();

if(isset($_POST['id_cour'])){
    $teach->ajoutmescours($_SESSION['ID_user'],$_POST['id_cour']);
}
if(isset($_POST['title']) ){
    if(trim($_POST['title'])!==''){
   $titres= $teach->rechercher_cours_title($_POST['title']);
}
}


if (isset($_POST['categorieselect'])) {
    if(trim($_POST['categorieselect'])!==''){
        $slcs=$teach->rechercher_cours((int)($_POST['categorieselect']));}

} else{
    $cours=$teach->afficher_cours();
}

$categories=$teach->affichercategories();
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
<?php include 'header.php'?>

    <div class="search-form" style="text-align: center; margin: 20px;">
        <form method="POST" action="">
            <input type="text" name="title" placeholder="Rechercher par titre"
                style="padding: 10px; margin-right: 10px; border: 1px solid #ccc; border-radius: 5px;">

            <select name="categorieselect"
                style="padding: 10px; margin-right: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="">Toutes les catégories</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['id_categorie']) ?>">
                    <?= htmlspecialchars($cat['nom_categorie']) ?> <?= htmlspecialchars($cat['id_categorie']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button type="submit"
                style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px;">
                Rechercher
            </button>
        </form>
    </div>

    <div>
        <?php if (!empty($titres)): ?>
        <?php foreach($titres as $titre): ?>
        <div class="course-card">
            <?php if ($titre['type']=== 'Document'): ?>
            <img src="images/icones/Premium Photo _ Stack of old vintage books hand drawn color watercolor illustration Library and learning.jpg"
                alt="Image du cours">
            <?php elseif ($titre['type']=== 'Video'): ?>
            <img src="images/icones/02bqDexyTO6DiTPEV1yc2w.jpg" alt="Image du cours">
            <?php endif ?>
            <h3><?= htmlspecialchars($titre['titre']) ?></h3>
            <p><?= htmlspecialchars($titre['descri']) ?></p>
        </div>

        <?php endforeach; ?>
        <?php else: ?>
        <h3>il y a aucun cour de ce titre  1</h3>
        <?php endif; ?>
    </div>


    <div>
        <?php if (!empty($slcs)): ?>
        <?php foreach ($slcs as $slc): ?>
        <div class="course-card">
            <?php if ($slc['type']=== 'Document'): ?>
            <img src="images/icones/Premium Photo _ Stack of old vintage books hand drawn color watercolor illustration Library and learning.jpg"
                alt="Image du cours">
            <?php elseif ($slc['type']=== 'Video'): ?>
            <img src="images/icones/02bqDexyTO6DiTPEV1yc2w.jpg" alt="Image du cours">
            <?php endif ?>
            <h3><?= htmlspecialchars($slc['titre']) ?></h3>
            <p><?= htmlspecialchars($slc['descri']) ?></p>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <h3>Aucun cours dans cette categorie</h3>
        <?php endif; ?>
    </div>


    <div class="catalogue">
        <?php if (!empty($cours)): ?>
        <?php foreach($cours as $cour): ?>
        <div class="course-card">
            <?php if ($cour['type']=== 'Document'): ?>
            <img src="images/icones/Premium Photo _ Stack of old vintage books hand drawn color watercolor illustration Library and learning.jpg"
                alt="Image du cours">
            <?php elseif ($cour['type']=== 'Video'): ?>
            <img src="images/icones/02bqDexyTO6DiTPEV1yc2w.jpg" alt="Image du cours">
            <?php endif ?>
            <h3><?= htmlspecialchars($cour['titre']) ?></h3>
            <p><?= htmlspecialchars($cour['descri']) ?></p>
            <form method="POST" action="">
                <input type="hidden" name="id_cour" value="<?= htmlspecialchars($cour['id_cour']) ?>">
                <button class="ml-[10px] w-[50%] h-[25px] rounded-lg bg-blue-700 hover:bg-blue-800"
                    type="submit">S'inscrire</button>
            </form>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>Aucun cours disponible pour le moment </p>
        <?php endif; ?>
    </div>

</body>

</html>