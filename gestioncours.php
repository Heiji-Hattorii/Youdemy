<?php
require 'classes/class.enseignants.php';
$teach=new Enseignant();
require 'classes/class.coursdoc.php';
require 'classes/class.coursvid.php';
$vid=new Coursvid();
$doc=new Coursdoc();
session_start();
if(isset($_POST['sup'])){
    $doc->setIdCour($_POST['id_cour']);
    $doc->supprimercr();
}
$docs =$doc->afficher_cours();
$vids =$vid->afficher_cours();

$erreur='';


if (isset($_POST['submit'])) {
    if (isset($_POST['title']) && isset($_POST['descri'])  && isset($_POST['opt'])  && isset($_POST['id_mod'])  ) {
        if(isset($_FILES['docmod']) && $_FILES['docmod']['error']===0){
        $fileExtension=explode('.',$_FILES ['docmod']['name']);
        $docextension=strtolower(end($fileExtension));
        $accepter=array('pdf','docx','txt');
        if(in_array($docextension,$accepter)){
            if($_FILES['docmod']['size']<1000000){
                    $nouveaunom=uniqid('',true).".".$docextension;
                    $newpath="uploads/".$nouveaunom;
                    move_uploaded_file($_FILES['docmod']['tmp_name'],$newpath);
                    $doc->setIdCour($_POST['id_mod']);
                    $doc->setDescri($_POST['descri']);
                    $doc->setTitre($_POST['title']);
                    $doc->setType($_POST['opt']);
                    $doc->setContent($newpath);
                    $doc->setPages($_POST['pages']);
                    $doc->setFtype($_FILES['docmod']['type']);
                    $doc->updatecr();
                    header("Location: gestioncours.php"); 

            }
            else{
                $erreur= "dossier volumineux !!";
            }
        }
        else {
            $erreur= " il ya un prob !!";
        }}
        elseif(isset($_FILES['vidmod']) && $_FILES['vidmod']['error']===0) {
            $fileExtension=explode('.',$_FILES ['vidmod']['name']);
        $docextension=strtolower(end($fileExtension));
        $accepter=array('mp4','webm','wmv');
        if(in_array($docextension,$accepter)){
            if($_FILES['vidmod']['size']<50000000){
                    $nouveaunom=uniqid('',true).".".$docextension;
                    $newpath="uploads/".$nouveaunom;
                    move_uploaded_file($_FILES['vidmod']['tmp_name'],$newpath);
                    $vid->setIdCour($_POST['id_mod']);
                    $vid->setDescri($_POST['descri']);
                    $vid->setTitre($_POST['title']);
                    $vid->setType($_POST['opt']);
                    $vid->setContent($newpath);
                    $vid->setSeconds($_POST['sec']);
                    $vid->setFtype($_FILES['vidmod']['type']);
                    $vid->updatecr();
                    header("Location: gestioncours.php"); 

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
    }}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="relative h-[100vh] w-[100%]">
    <?php include 'header.php'?>

    <section class="pt-12 mb-12">
        <div class="container mx-auto">
            <h2 class="text-3xl font-bold text-center mb-5">Mes Cours</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mx-[10px]">
                <?php if (!empty($docs)) : ?>
                <?php foreach ($docs as $doc) : ?>

                <div class=" bg-white shadow-lg rounded-lg overflow-x">
                    <div class="p-6">
                        <div class="text-xl font-bold mb-2"><?= htmlspecialchars($doc['titre']) ?></div>
                        <div class="text-gray-600 mb-4"><?= htmlspecialchars($doc['descri']) ?></div>
                        <div class="text-gray-600"><?= htmlspecialchars($doc['type']) ?></div>
                        <div class="text-gray-600"><?= htmlspecialchars($doc['content']) ?></div>

                        <form action="" method="post">
                            <input type="hidden" name="id_cour" value="<?= htmlspecialchars($doc['id_cour']) ?>">
                            <button type="submit" class="rounded-lg bg-green-600 hover:bg-green-800 w-[50%] mb-2"
                                name="sup">supprimer</button>
                        </form>
                        <div>
                            <button class="rounded-lg bg-green-600 hover:bg-green-800 w-[50%]" name="modifier" onclick="modifiercr('<?= htmlspecialchars($doc['id_cour']) ?>',
                           '<?= htmlspecialchars($doc['titre']) ?>',
                           '<?= htmlspecialchars($doc['descri']) ?>',
                           '<?= htmlspecialchars($doc['type']) ?>',
                           '<?= htmlspecialchars($doc['content']) ?>',
                           '<?= htmlspecialchars((int)$doc['pages']) ?>',0)">Modifier</button>
                        </div>

                        <div class="w-[100px] rounded-lg">

                            <a href="<?= htmlspecialchars($doc['content']) ?>" download
                                class="text-blue-600 hover:underline">telecharger fichier</a><br />
                            <a href="<?= htmlspecialchars($doc['content']) ?>"
                                class="text-blue-600 hover:underline">lire
                                fichier</a> <br />
                        </div>
                    </div>
                    <span>
                        <embed src="<?= htmlspecialchars($doc['content']) ?>"
                            type="<?= htmlspecialchars($doc['ftype']) ?>" class=" m-1 w-[100%] h-[60%]">
                    </span>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!empty($vids)) : ?>
                <?php foreach ($vids as $vid) : ?>

                <div class=" bg-white shadow-lg rounded-lg overflow-x">
                    <div class="p-6">
                        <div class="text-xl font-bold mb-2"><?= htmlspecialchars($vid['titre']) ?></div>
                        <div class="text-gray-600 mb-4"><?= htmlspecialchars($vid['descri']) ?></div>
                        <div class="text-gray-600"><?= htmlspecialchars($vid['type']) ?></div>
                        <div class="text-gray-600"><?= htmlspecialchars($vid['content']) ?></div>

                        <form action="" method="post">
                            <input type="hidden" name="id_cour" value="<?= htmlspecialchars($vid['id_cour']) ?>">
                            <button type="submit" class="rounded-lg bg-green-600 hover:bg-green-800 w-[50%] mb-2"
                                name="sup">supprimer</button>
                        </form>
                        <div>
                            <button class="rounded-lg bg-green-600 hover:bg-green-800 w-[50%]" name="modifier" onclick="modifiercr('<?= htmlspecialchars($vid['id_cour']) ?>',
                      '<?= htmlspecialchars($vid['titre']) ?>',
                      '<?= htmlspecialchars($vid['descri']) ?>',
                      '<?= htmlspecialchars($vid['type']) ?>',
                      '<?= htmlspecialchars($vid['content']) ?>',0,
                      '<?= htmlspecialchars((int)$vid['seconds']) ?>')">
                                Modifier
                            </button>
                        </div>

                        <div class="w-[100px] rounded-lg">

                            <a href="<?= htmlspecialchars($vid['content']) ?>" download
                                class="text-blue-600 hover:underline">telecharger fichier</a><br />
                            <a href="<?= htmlspecialchars($vid['content']) ?>"
                                class="text-blue-600 hover:underline">lire
                                fichier</a> <br />
                        </div>
                    </div>
                    <span>
                        <embed src="<?= htmlspecialchars($vid['content']) ?>"
                            type="<?= htmlspecialchars($vid['ftype']) ?>" class=" m-1 w-[100%] h-[60%]">
                    </span>
                </div>
                <?php endforeach; ?>
                <?php else : ?>
                <!-- <p>Aucun fichier disponible </p> -->
                <?php endif; ?>
            </div>
        </div>
    </section>
    <div class=" opaque bg-black opacity-75 absolute hidden  w-[100%] h-[100%] top-0 left-0 fixed"></div>

    <div id="modalmodifier"
        class=" fixed modalmodifier h-[100vh] flex items-center hidden  w-[100%] h-[100%] absolute top-0 left-0">

        <form class="space-y-4 font-[sans-serif] max-w-md mx-auto align-center " method="POST"
            enctype="multipart/form-data">

            <input type="hidden" id="id_mod" name="id_mod">
            <input type="text" id="title" name="title" placeholder="Titre"
                class="px-4 py-3 bg-black w-full text-white text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded" />
            <input type="text" id="descri" name="descri" placeholder="Description"
                class="px-4 py-3 bg-black w-full text-white text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded" />
            <input type="text" id="categorie" name="categorie" placeholder="Categorie"
                class="px-4 py-3 bg-black text-white w-full text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded" />
            <select name="opt" id="opt" class="bg-black text-white w-full">
                <option value="__">...</option>
                <option value="Document">Document</option>
                <option value="Video">Video</option>
            </select>
            <input type="file" id="docmod" name="docmod" accept=".pdf,.doc,.docx" class=" myfile hidden">
            <input type="file" id="vidmod" name="vidmod" accept="video/*" class="myfile hidden">
            <input type="number" name="pages" id="pages" placeholder="Entrer le nombre des pages " class="hidden">
            <input type="number" name="sec" id="sec" placeholder="Entrer le nombre des secondes" class="hidden">
            <button type="submit" name="submit"
                class="!mt-8 w-full px-4 py-2.5 mx-auto block text-sm bg-blue-500 text-white rounded hover:bg-blue-600">Ajouter</button>
        </form>
    </div>
    <script>
    let pages = document.getElementById("pages");
    let sec = document.getElementById("sec");
    document.addEventListener("DOMContentLoaded", () => {
        let docu = document.getElementById("opt");
        let doc = document.querySelector("#docmod");
        let vid = document.querySelector("#vidmod");
        docu.addEventListener("change", () => {
            if (docu.value == "Document") {
                doc.classList.remove('hidden');
                doc.classList.add('block');
                vid.classList.remove('block');
                vid.classList.add('hidden');
                document.getElementById("sec").classList.add('hidden');
                document.getElementById("pages").classList.remove('hidden');

            } else {
                vid.classList.remove('hidden');
                vid.classList.add('block');
                doc.classList.remove('block');
                doc.classList.add('hidden');
                document.getElementById("pages").classList.add('hidden');
                document.getElementById("sec").classList.remove('hidden');
            }
        })
    })


    function modifiercr(id, titre, descri, type, content, page, seconds) {
        document.getElementById('id_mod').value = id;
        document.getElementById('title').value = titre;
        document.getElementById('descri').value = descri;
        document.getElementById('opt').value = type;

        if (type === "Document") {
            document.getElementById('docmod').classList.remove('hidden');
            document.getElementById('vidmod').classList.add('hidden');
            document.getElementById("pages").classList.remove('hidden');
            document.getElementById("pages").value = page;
        } else if (type === "Video") {
            document.getElementById('vidmod').classList.remove('hidden');
            document.getElementById('docmod').classList.add('hidden');
            document.getElementById("sec").classList.remove('hidden')
            document.getElementById("sec").value = seconds;
        }

        document.getElementById('modalmodifier').classList.remove('hidden');
        document.querySelector('.opaque').classList.remove('hidden');


    }
    </script>

</body>

</html>