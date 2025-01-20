<?php
require 'classes/class.enseignants.php';
$teach=new Enseignant();
$erreur='';
session_start();
if (isset($_POST['submit'])) {
    if (isset($_POST['titre']) && isset($_POST['description'])  && isset($_POST['id_categorie']) && isset($_POST['type']) ) {
        if(isset($_FILES['doc']) && $_FILES['doc']['error']===0){
        $fileExtension=explode('.',$_FILES ['doc']['name']);
        $docextension=strtolower(end($fileExtension));
        $accepter=array('pdf','docx','txt');
        if(in_array($docextension,$accepter)){
            if($_FILES['doc']['size']<1000000){
                    $nouveaunom=uniqid('',true).".".$docextension;
                    $newpath="uploads/".$nouveaunom;
                    move_uploaded_file($_FILES['doc']['tmp_name'],$newpath);
                    $teach->ajoutercr($_SESSION['ID_user'],$_POST['titre'],$_POST['description'],$_POST['type'],$_POST['id_categorie'],$newpath,$_FILES['doc']['type']);
            }
            else{
                $erreur= "dossier volumineux !!";
            }
        }
        else {
            $erreur= " il ya un prob !!";
        }}
        elseif(isset($_FILES['vid']) && $_FILES['vid']['error']===0) {
            $fileExtension=explode('.',$_FILES ['vid']['name']);
        $docextension=strtolower(end($fileExtension));
        $accepter=array('mp4','webm','wmv');
        if(in_array($docextension,$accepter)){
            if($_FILES['vid']['size']<50000000){
                    $nouveaunom=uniqid('',true).".".$docextension;
                    $newpath="uploads/".$nouveaunom;
                    move_uploaded_file($_FILES['vid']['tmp_name'],$newpath);
                    $teach->ajoutercr($_SESSION['ID_user'],$_POST['titre'],$_POST['description'],$_POST['type'],$_POST['id_categorie'],$newpath,$_FILES['vid']['type']);
            }
            else{
                $erreur= "dossier volumineux !!";
            }
        }
        else {
            $erreur= " il ya un prob !!";
        }}
        else{
            $erreur="il ya un erreeeeur avec ce file !";
        }
if($erreur){
    $message=$erreur;
}

}
}
$categories=$teach->affichercategories();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
<?php include 'header.php'?>
<div class="grid grid-cols-1 h-[100vh] top-0 items-center">



    <form class="space-y-4 font-[sans-serif] max-w-md mx-auto align-center" method="POST" enctype="multipart/form-data">
        <?php if(!empty($message)):?>
        <div><?= htmlspecialchars($message) ?></div>
        <?php endif?>
        <input type="text" name="titre" placeholder="Titre"
            class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded" />
        <input type="text" name="description" placeholder="Description"
            class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded" />
        <select name="id_categorie" id="id_categorie" placeholder="Categorie"
            class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded" />
        <option value="">...</option>
        <?php if(!empty($categories)): ?>
        <?php foreach ($categories as $categ) : ?>
        <option value="<?= htmlspecialchars($categ['id_categorie']) ?> ">
            <?= htmlspecialchars($categ['nom_categorie']) ?></option>
        <?php endforeach ;?>
        <?php endif; ?>

        </select>
        <select name="type" id="type">
            <option value="">...</option>
            <option value="Document">Document</option>
            <option value="Video">Video</option>
        </select>
        <input type="file" id="doc" name="doc" accept=".pdf,.doc,.docx" class="hidden">
        <input type="file" id="vid" name="vid" accept="video/*" class="hidden">
        <button type="submit" name="submit"
            class="!mt-8 w-full px-4 py-2.5 mx-auto block text-sm bg-blue-500 text-white rounded hover:bg-blue-600">Ajouter</button>
    </form>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        let docu = document.getElementById("type");
        let doc = document.querySelector("#doc");
        let vid = document.querySelector("#vid");
        docu.addEventListener("change", () => {
            if (docu.value == "Document") {
                doc.classList.remove('hidden');
                doc.classList.add('block');
                vid.classList.remove('block');
                vid.classList.add('hidden');

            } else {
                vid.classList.remove('hidden');
                vid.classList.add('block');
                doc.classList.remove('block');
                doc.classList.add('hidden');
            }
        })

    })
    </script>
</body>

</html>