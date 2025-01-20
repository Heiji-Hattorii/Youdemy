<?php
require 'classes/class.enseignants.php';
session_start();

$teach=new Enseignant();
$cours=$teach->mescours($_SESSION['ID_user']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

<div>
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
            <span class="course-type"><?= htmlspecialchars($cour['type']) ?></span>
            
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>Aucun cours disponible pour le moment </p>
        <?php endif; ?>
    </div>
    </div>
</body>
</html>