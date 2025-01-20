<?php 
require 'classes/class.enseignants.php';
$teach= new Enseignant();
session_start();

$categories=$teach->affichercategories();
$tagcat=$teach->tagaucateg();

if(isset($_POST['nom_categorie'])){
    $teach->addcategorie($_POST['nom_categorie']);
    header("Location:gestionTagCateg.php");

    }
if(isset($_POST['id_cat_sup'])){
        $teach->deletecategorie($_POST['id_cat_sup']);
        header("Location:gestionTagCateg.php");
    
        }
if(isset($_POST['idtagmod']) && isset($_POST['nomtagmod'])){
            $teach->modifiertag($_POST['idtagmod'],$_POST['nomtagmod']);
            header("Location:gestionTagCateg.php");
        
        }


if(isset($_POST['id_tag_sup'])){
            $teach->deletetag($_POST['id_tag_sup']);
            header("Location:gestionTagCateg.php");
        
            }
if(isset($_POST['idcatmod']) && isset($_POST['nomcatmod'])){
                $teach->modifiercategorie($_POST['idcatmod'],$_POST['nomcatmod']);
                header("Location:gestionTagCateg.php");
            
            }






elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_categorie']) && isset($_POST['tags'])) {
    $id_categorie = $_POST['id_categorie'];
    $tags = $_POST['tags'];
$tagsArray = explode('-', $tags);
foreach ($tagsArray as $tag) {
$teach->addtag($tag,$_POST['id_categorie']);
header("Location:gestionTagCateg.php");
}
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une catégorie et des tags</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
<?php include 'header.php'?>
<div  class="bg-gray-100 py-8 w-screen">

    <h1 class="text-2xl font-bold text-center mb-6 text-gray-700  ">Ajouter une Catégorie
        et des Tags</h1>
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md grid grid-cols-2 gap-[20px]">

        <div>
            <form action="" method="POST" class="space-y-4 mb-8">
                <div>
                    <label for="nom_categorie" class="block text-gray-600 font-medium">Nom de la catégorie :</label>
                    <input type="text" id="nom_categorie" name="nom_categorie"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nom de la catégorie" required>
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 focus:outline-none">Ajouter
                    Catégorie</button>
            </form>
        </div>

        <div>
            <!-- Formulaire pour ajouter des tags à une catégorie -->
            <form action="" method="POST" class="space-y-4">
                <div>
                    <label for="id_categorie" class="block text-gray-600 font-medium">Sélectionner la catégorie:</label>
                    <select id="id_categorie" name="id_categorie"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Choisir une catégorie</option>
                        <?php if(!empty($categories)): ?>
                        <?php foreach ($categories as $categ) : ?>
                        <option value="<?= htmlspecialchars($categ['id_categorie']) ?> ">
                            <?= htmlspecialchars($categ['nom_categorie']) ?></option>
                        <?php endforeach ;?>
                        <?php endif; ?>
                    </select>
                </div>

                <div>
                    <label for="tags" class="block text-gray-600 font-medium">Tags (met le caractere"-" si vous voulee
                        entre plius qu un tag) :</label>
                    <input type="text" id="tags" name="tags"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Entrez des mots-cle" required>
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 focus:outline-none">Ajouter
                    Tags</button>
            </form>
        </div>

    </div>

    <div class="font-[sans-serif] overflow-x-auto  mx-auto grid justify-center w-[80%] grid-cols-1 ">

        <table class="min-w-full bg-white mt-10 ">
            <thead class="bg-gray-800 whitespace-nowrap">
                <tr>
                    <th class="p-4 text-left text-sm font-medium text-white">
                        Categorie
                    </th>
                    <th class="p-4 text-left text-sm font-medium text-white">
                        TAG
                    </th>

                </tr>
            </thead>

            <tbody class="whitespace-nowrap">
                <?php if (count($tagcat) > 0): ?>
                <?php foreach ($tagcat as $tigo): ?>
                <tr class="even:bg-blue-50">
                    <td class="p-4 text-sm text-black">
                        <div class="flex items-center space-x-2">
                            <span><?= htmlspecialchars($tigo["nom_categorie"]) ?></span>
                            <button title="Modifier" name="editcategorie"
                                onclick="editCategory('<?= htmlspecialchars($tigo['id_categorie']) ?>', '<?= $tigo['nom_categorie'] ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 fill-blue-500 hover:fill-blue-700" viewBox="0 0 20 20">
                                    <path
                                        d="M17.414 2.586a2 2 0 00-2.828 0L9.586 7.586l-2 2a1 1 0 00-.293.707v3a1 1 0 001 1h3a1 1 0 00.707-.293l2-2 5-5a2 2 0 000-2.828l-1.586-1.586zm-9.828 7.828l1.414-1.414 2 2L9.586 12H8v-1.586l-.414-.414zM5 17v-1.586l6-6 2 2-6 6H5zm-2 0a1 1 0 01-1-1v-2a1 1 0 01.293-.707l8-8L9.414 7.414l-8 8A1 1 0 011 17h2z" />
                                </svg>
                            </button>
                            <button title="Supprimer" name="deletecategorie"
                                onclick="deleteCategory('<?= $tigo['id_categorie'] ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-red-500 hover:fill-red-700"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 3a1 1 0 112 0v1a1 1 0 11-2 0V5z" />
                                </svg>
                            </button>
                        </div>
                    </td>
                    <td class="p-4 text-sm text-black">
                        <?php if(!empty($tigo["groupe"])):?>
                        <?php $tags = explode('_', $tigo["groupe"]);?>
                        <div class="flex items-center space-x-2 ">

                            <?php foreach ($tags as $tag):?>
                            <button
                                class="px-[5px] bg-gray-200 rounded-full text-sm hover:bg-gray-300"><?= htmlspecialchars($tag) ?></button>
                            <button title="Modifier"
                                onclick="editTag('<?= $tigo['id_tag'] ?>','<?= $tigo['tag'] ?>')">
                        
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 fill-blue-500 hover:fill-blue-700" viewBox="0 0 20 20">
                                    <path
                                        d="M17.414 2.586a2 2 0 00-2.828 0L9.586 7.586l-2 2a1 1 0 00-.293.707v3a1 1 0 001 1h3a1 1 0 00.707-.293l2-2 5-5a2 2 0 000-2.828l-1.586-1.586zm-9.828 7.828l1.414-1.414 2 2L9.586 12H8v-1.586l-.414-.414zM5 17v-1.586l6-6 2 2-6 6H5zm-2 0a1 1 0 01-1-1v-2a1 1 0 01.293-.707l8-8L9.414 7.414l-8 8A1 1 0 011 17h2z" />
                                </svg>
                            </button>
                            <button title="Supprimer"
                                onclick="deleteTag('<?= $tigo['id_tag'] ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-red-500 hover:fill-red-700"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v10a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 3a1 1 0 112 0v1a1 1 0 11-2 0V5z" />
                                </svg>
                            </button>
                            <?php endforeach;?>
                        </div>

                        <?php endif  ?>
                    </td>


                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5">aucune categorie trouve</td>
                </tr>
                <?php endif; ?>


            </tbody>
        </table>
    </div>









    <!-- suppression           ************************************************************************ -->

    <div id="modaldeletecategorie"
        class=" modaldeletecategorie fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif] hidden">
        <div class="  w-full max-w-lg bg-white shadow-lg rounded-lg p-6 relative">
            <svg xmlns="http://www.w3.org/2000/svg"
                class=" pic w-3.5 cursor-pointer shrink-0 fill-gray-400 hover:fill-red-500 float-right"
                viewBox="0 0 320.591 320.591">
                <path
                    d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                    data-original="#000000"></path>
                <path
                    d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                    data-original="#000000"></path>
            </svg>

            <div class="my-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-14 fill-red-500 inline" viewBox="0 0 24 24">
                    <path
                        d="M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z"
                        data-original="#000000" />
                    <path d="M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z"
                        data-original="#000000" />
                </svg>

                <h4 class="text-gray-800 text-base font-semibold mt-4">Are you sure you want to delete it?</h4>
                <form method="POST">
                    <input type="hidden" id="id_cat_sup" name="id_cat_sup">
                    <div class="text-center space-x-4 mt-8">
                        <button type="submit"
                            class="px-4 py-2 rounded-lg text-white text-sm bg-red-600 hover:bg-red-700 active:bg-red-600">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>







    <div id="modalmodifiercategorie"
        class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Modifier le status :</h2>

            <form method="POST">
                <input type="hidden" id="idcatmod" name="idcatmod">

                <div class="mb-4">
                    <label for="banner" class="block text-sm font-medium text-gray-600 mb-1">
                        La categorie :
                    </label>
                    <input type="text" id="nomcatmod" name="nomcatmod">

                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400"
                        onclick="closeModal()">
                        Annuler
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>










 <!-- suppression           ************************************************************************ -->

 <div id="modaldeletetag"
        class=" modaldeletecategorie fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif] hidden">
        <div class="  w-full max-w-lg bg-white shadow-lg rounded-lg p-6 relative">
            <svg xmlns="http://www.w3.org/2000/svg"
                class=" pic w-3.5 cursor-pointer shrink-0 fill-gray-400 hover:fill-red-500 float-right"
                viewBox="0 0 320.591 320.591">
                <path
                    d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                    data-original="#000000"></path>
                <path
                    d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                    data-original="#000000"></path>
            </svg>

            <div class="my-4 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-14 fill-red-500 inline" viewBox="0 0 24 24">
                    <path
                        d="M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z"
                        data-original="#000000" />
                    <path d="M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z"
                        data-original="#000000" />
                </svg>

                <h4 class="text-gray-800 text-base font-semibold mt-4">Are you sure you want to delete it?</h4>
                <form method="POST">
                    <input type="hidden" id="id_tag_sup" name="id_tag_sup">
                    <div class="text-center space-x-4 mt-8">
                        <button type="submit"
                            class="px-4 py-2 rounded-lg text-white text-sm bg-red-600 hover:bg-red-700 active:bg-red-600">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>







    <div id="modalmodifiertag"
        class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Modifier le status :</h2>

            <form method="POST">
                <input type="hidden" id="idtagmod" name="idtagmod">

                <div class="mb-4">
                    <label for="banner" class="block text-sm font-medium text-gray-600 mb-1">
                        La categorie :
                    </label>
                    <input type="text" id="nomtagmod" name="nomtagmod">

                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400"
                        onclick="closeModal()">
                        Annuler
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>


    </div>














    <script>
    function editTag(idtagmod, nomtagmod) {
        document.getElementById('idtagmod').value = idtagmod;
        document.getElementById('nomtagmod').value = nomtagmod;
        console.log(idtagmod);
        console.log(nomtagmod);



        document.getElementById('modalmodifiertag').classList.remove('hidden');
    }

    function deleteTag(idtagsup) {
        document.getElementById('id_tag_sup').value = idtagsup;

        
        document.getElementById('modaldeletetag').classList.remove('hidden');
    }

    function editCategory(idcatmod, nomcatmod) {
        document.getElementById('idcatmod').value = idcatmod;
        document.getElementById('nomcatmod').value = nomcatmod;

        document.getElementById('modalmodifiercategorie').classList.remove('hidden');
    }

    function deleteCategory(idcatsup) {
        document.getElementById('id_cat_sup').value = idcatsup;


        document.getElementById('modaldeletecategorie').classList.remove('hidden');

    }
    </script>


</body>

</html>