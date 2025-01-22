<?php
require 'classes/class.enseignants.php';
$teach=new Enseignant();
require 'classes/class.coursdoc.php';
require 'classes/class.coursvid.php';
$vid=new Coursvid();
$doc=new Coursdoc();
session_start();
$cours =$doc->afficher_cours();
$vids =$vid->afficher_cours();
if(isset($_POST['id_per'])){
    $id_cour = $_POST['id_per'];
    $doc->setIdCour($id_cour);
    $doc->supprimercr();
    header("Location:gererCours.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des cours</title>
</head>
<body>
<?php include 'header.php'?>

<div class="font-[sans-serif] overflow-x-auto grid justify-end w-screen grid-cols-1 px-12">
    <h1 class="mx-6 text-3xl font-bold md:text-5xl text-start my-6">Gestion des Cours</h1>


    <table class="min-w-full bg-white mt-10 ">
        <thead class="bg-gray-800 whitespace-nowrap">
            <tr>
                <th class="p-4 text-left text-sm font-medium text-white">
                    TITRE
                </th>
                <th class="p-4 text-left text-sm font-medium text-white">
                    Description
                </th>
                <th class="p-4 text-left text-sm font-medium text-white">
                    Type
                </th>
                <th class="p-4 text-left text-sm font-medium text-white">
                    Pages/Secondes
                </th>
                
                <th class="p-4 text-left text-sm font-medium text-white">
                    Actions
                </th>
            </tr>
        </thead>

        <tbody class="whitespace-nowrap">
            <?php if (count($cours) > 0): ?>
            <?php foreach ($cours as $cour): ?>
            <tr class="even:bg-blue-50">
                <td class="p-4 text-sm text-black">
                    <?= htmlspecialchars($cour["titre"]) ?>
                </td>
                <td class="p-4 text-sm text-black">
                    <?= htmlspecialchars($cour["descri"]) ?>
                </td>
                <td class="p-4 text-sm text-black">
                    <?= htmlspecialchars($cour["type"]) ?>
                </td>
                <td class="p-4 text-sm text-black">
                    <?= htmlspecialchars($cour["pages"]) ?> pages
                </td>
                
                <td class="p-4">

                    <input type="hidden" name="id_user" value="<?= $cour['id_cour'] ?>">
                    <button type="submit" name="Delete" onclick="deletebtn('<?= $cour['id_cour'] ?>')"
                        class="sprm text-white  px-1 py-2.5 rounded-lg bg-white outline-none ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 fill-red-500 hover:fill-red-700"
                            viewBox="0 0 24 24">
                            <path
                                d="M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z"
                                data-original="#000000" />
                            <path d="M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z"
                                data-original="#000000" />
                        </svg>
                    </button>
                    </form>
                   
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif;?>
            <?php if (count($vids) > 0): ?>
            <?php foreach ($vids as $vid): ?>
            <tr class="even:bg-blue-50">
                <td class="p-4 text-sm text-black">
                    <?= htmlspecialchars($vid["titre"]) ?>
                </td>
                <td class="p-4 text-sm text-black">
                    <?= htmlspecialchars($vid["descri"]) ?>
                </td>
                <td class="p-4 text-sm text-black">
                    <?= htmlspecialchars($vid["type"]) ?>
                </td>
                <td class="p-4 text-sm text-black">
                    <?= htmlspecialchars($vid["seconds"]) ?> secondes
                </td>
                
                <td class="p-4">

                    <input type="hidden" name="id_user" value="<?= $vid['id_cour'] ?>">
                    <button type="submit" name="Delete" onclick="deletebtn('<?= $vid['id_cour'] ?>')"
                        class="sprm text-white  px-1 py-2.5 rounded-lg bg-white outline-none ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 fill-red-500 hover:fill-red-700"
                            viewBox="0 0 24 24">
                            <path
                                d="M19 7a1 1 0 0 0-1 1v11.191A1.92 1.92 0 0 1 15.99 21H8.01A1.92 1.92 0 0 1 6 19.191V8a1 1 0 0 0-2 0v11.191A3.918 3.918 0 0 0 8.01 23h7.98A3.918 3.918 0 0 0 20 19.191V8a1 1 0 0 0-1-1Zm1-3h-4V2a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v2H4a1 1 0 0 0 0 2h16a1 1 0 0 0 0-2ZM10 4V3h4v1Z"
                                data-original="#000000" />
                            <path d="M11 17v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Zm4 0v-7a1 1 0 0 0-2 0v7a1 1 0 0 0 2 0Z"
                                data-original="#000000" />
                        </svg>
                    </button>
                    </form>
                   
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5"></td>
            </tr>
            <?php endif; ?>


        </tbody>
    </table>
</div>
<div
        class=" deletemodal fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif] hidden">
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
                    <input type="hidden" id="id_per" name="id_per">
                    <div class="text-center space-x-4 mt-8">
                        <button type="submit"
                            class="px-4 py-2 rounded-lg text-white text-sm bg-red-600 hover:bg-red-700 active:bg-red-600">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 <script>
    const deletemodal = document.querySelector('.deletemodal');
    const sprm = document.querySelectorAll('.sprm');
    const pic = document.querySelectorAll('.pic');

    sprm.forEach(del => {
            del.addEventListener('click', () => {
                deletemodal.classList.toggle('hidden');
            });
        })

        pic.addEventListener('click', () => {
            deletemodal.classList.toggle('hidden');
        });

    function closeModal() {
        document.getElementById('roleModal').classList.add('hidden');
    }

    function deletebtn(id) {
        document.getElementById('id_per').value = id;
    }
 </script>
</body>
</html>