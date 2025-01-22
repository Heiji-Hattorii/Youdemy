<?php
require 'classes/class.enseignants.php';
require 'classes/class.categories.php';
require 'classes/class.coursdoc.php';
require 'classes/class.coursvid.php';
require 'classes/class.tags.php';

$vid=new Coursvid();
$doc=new Coursdoc();
$catt=new Categorie();
$tag=new Tag();
$coursId='';

$teach=new Enseignant();
$erreur='';
session_start();
if (isset($_POST['submit'])) {
    if (isset($_POST['titre']) && isset($_POST['description'])  && isset($_POST['id_categorie']) && isset($_POST['type']) ) {
        if(isset($_FILES['doc']) && $_FILES['doc']['error']===0 && isset($_POST['pages'])){
        $fileExtension=explode('.',$_FILES ['doc']['name']);
        $docextension=strtolower(end($fileExtension));
        $accepter=array('pdf','docx','txt');
        if(in_array($docextension,$accepter)){
            if($_FILES['doc']['size']<1000000){
                    $nouveaunom=uniqid('',true).".".$docextension;
                    $newpath="uploads/".$nouveaunom;
                    move_uploaded_file($_FILES['doc']['tmp_name'],$newpath);
                    $doc->setIdTeach($_SESSION['ID_user']);                    ;
                    $doc->setTitre($_POST['titre']);
                    $doc->setDescri($_POST['description']);
                    $doc->setType($_POST['type']);
                    $doc->setIdCateg($_POST['id_categorie']);
                    $doc->setPages($_POST['pages']);
                    $doc->setContent($newpath);
                    $doc->setFtype($_FILES['doc']['type']);
                    $doc->ajoutercr();
                    $coursId = $doc->getIdCour(); 
                    $tags = isset($_POST['tags']) ? explode(',', $_POST['tags']) : [];
                    if ($coursId && !empty($tags) && is_array($tags)) {
                        foreach ($tags as $tagId) {
                            $tag->addTagToCours($tagId, $coursId);
                        }

                    }
                    
            }
            else{
                $erreur= "dossier volumineux !!";}
        }
        else {
            $erreur= " il ya un prob !!";}}
        elseif(isset($_FILES['vid']) && $_FILES['vid']['error']===0 && isset($_POST['sec'])) {
            $fileExtension=explode('.',$_FILES ['vid']['name']);
        $docextension=strtolower(end($fileExtension));
        $accepter=array('mp4','webm','wmv');
        if(in_array($docextension,$accepter)){
            if($_FILES['vid']['size']<50000000){
                    $nouveaunom=uniqid('',true).".".$docextension;
                    $newpath="uploads/".$nouveaunom;
                    move_uploaded_file($_FILES['vid']['tmp_name'],$newpath);
                    $vid->setIdTeach($_SESSION['ID_user']);                    ;
                    $vid->setTitre($_POST['titre']);
                    $vid->setDescri($_POST['description']);
                    $vid->setType($_POST['type']);
                    $vid->setIdCateg($_POST['id_categorie']);
                    $vid->setSeconds($_POST['sec']);
                    $vid->setContent($newpath);
                    $vid->setFtype($_FILES['vid']['type']);
                    $vid->ajoutercr();
                    $coursId = $vid->getIdCour(); 
                    $tags = isset($_POST['tags']) ? explode(',', $_POST['tags']) : [];
                    if ($coursId && !empty($tags) && is_array($tags)) {
                        foreach ($tags as $tagId) {
                            $tag->addTagToCours($tagId, $coursId);
                        }
                    }
                    
                }
} else {
    $erreur = "Échec de l'ajout du cours.";
}
            }
            else{
                $erreur= "dossier volumineux !!";
            } }
        else {
            $erreur= " il ya un prob !!"; }}

if($erreur){
    $message=$erreur;}

$categories=$catt->affichercategories();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    .tag-item.selected {
        background-color: #3b82f6;
        /* Couleur bleue */
        color: white;
    }
    </style>
</head>

<body>
    <?php include 'header.php'?>
    <div class="grid grid-cols-1 h-[100vh] top-0 items-center">



        <form class="space-y-4 font-[sans-serif] max-w-md mx-auto align-center" method="POST"
            enctype="multipart/form-data">
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
            <div>
                <label for="tags">Sélectionnez des tags :</label>
                <div id="tags-container" class="flex flex-wrap gap-2">
                    <?php
        $tags = $tag->alltags(); 
        if (!empty($tags)) :
            foreach ($tags as $tag) : ?>
                    <div class="tag-item cursor-pointer px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                        data-id="<?= htmlspecialchars($tag['id_tag']) ?>">
                        <?= htmlspecialchars($tag['tag']) ?>
                    </div>
                    <?php endforeach;
        endif; ?>
                </div>
                <input type="hidden" id="selected-tags" name="tags" value="" />
            </div>
            <input type="file" id="doc" name="doc" accept=".pdf,.doc,.docx" class="hidden">
            <input type="file" id="vid" name="vid" accept="video/*" class="hidden">
            <input type="number" name="pages" id="pages" placeholder="Entrer le nombre des pages " class="hidden">
            <input type="number" name="sec" id="sec" placeholder="Entrer le nombre des secondes" class="hidden">

            <button type="submit" name="submit"
                class="!mt-8 w-full px-4 py-2.5 mx-auto block text-sm bg-blue-500 text-white rounded hover:bg-blue-600">Ajouter</button>
        </form>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        let docu = document.getElementById("type");
        let pages = document.getElementById("pages");
        let sec = document.getElementById("sec");
        let doc = document.querySelector("#doc");
        let vid = document.querySelector("#vid");
        docu.addEventListener("change", () => {
            if (docu.value == "Document") {
                doc.classList.remove('hidden');
                doc.classList.add('block');
                vid.classList.remove('block');
                vid.classList.add('hidden');
                pages.classList.toggle('hidden');
                sec.classList.add('hidden');
            } else {
                vid.classList.remove('hidden');
                vid.classList.add('block');
                doc.classList.remove('block');
                doc.classList.add('hidden');
                sec.classList.toggle('hidden');
                pages.classList.add('hidden');
            }
        })
        const tagsContainer = document.getElementById("tags-container");
        const selectedTagsInput = document.getElementById("selected-tags");
        let selectedTags = [];

        tagsContainer.addEventListener("click", (e) => {
            const tagItem = e.target;
            if (tagItem.classList.contains("tag-item")) {
                const tagId = tagItem.dataset.id;

                if (selectedTags.includes(tagId)) {
                    selectedTags = selectedTags.filter(id => id !== tagId);
                    tagItem.classList.remove("selected");
                } else {
                    selectedTags.push(tagId);
                    tagItem.classList.add("selected");
                }

                selectedTagsInput.value = selectedTags.join(",");
            }
        });

    })
    </script>
</body>

</html>