<?php
require_once 'classes/class.users.php';
$user=new Users();
session_start();

$users=$user->afficher_users();
if(isset($_POST['id_status']) && isset($_POST['statussel'])){
    $user->update_status($_POST['id_status'], $_POST['statussel']) ;
}
elseif(isset($_POST['id_per'])){
    $user->supprimerUser($_POST['id_per']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="flex flex-col w-screen">
    <?php include 'header.php'?>

    <div class="font-[sans-serif] overflow-x-auto grid justify-end w-screen grid-cols-1 px-12">
        <h1 class="mx-6 text-3xl font-bold md:text-5xl text-start my-6">Gestion des utilisateurs</h1>


        <table class="min-w-full bg-white mt-10 ">
            <thead class="bg-gray-800 whitespace-nowrap">
                <tr>
                    <th class="p-4 text-left text-sm font-medium text-white">
                        identifiant
                    </th>
                    <th class="p-4 text-left text-sm font-medium text-white">
                        Email
                    </th>
                    <th class="p-4 text-left text-sm font-medium text-white">
                        Status
                    </th>
                    <th class="p-4 text-left text-sm font-medium text-white">
                        Role
                    </th>
                    <th class="p-4 text-left text-sm font-medium text-white">
                        Joined At
                    </th>
                    <th class="p-4 text-left text-sm font-medium text-white">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="whitespace-nowrap">
                <?php if (count($users) > 0): ?>
                <?php foreach ($users as $user): ?>
                <tr class="even:bg-blue-50">
                    <td class="p-4 text-sm text-black">
                        <?= htmlspecialchars($user["identifiant"]) ?>
                    </td>
                    <td class="p-4 text-sm text-black">
                        <?= htmlspecialchars($user["email"]) ?>
                    </td>
                    <td class="p-4 text-sm text-black">
                        <?= htmlspecialchars($user["status"]) ?>
                    </td>
                    <td class="p-4 text-sm text-black">
                        <?= htmlspecialchars($user["role"]) ?>
                    </td>
                    <td class="p-4 text-sm text-black">
                        <?= htmlspecialchars($user["created_at"]) ?>
                    </td>
                    <td class="p-4">
                        <button class="mr-4 " title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class=" w-5 fill-blue-500 hover:fill-blue-700"
                                onclick="status('<?= $user['id_user'] ?>','<?= htmlspecialchars($user['status']) ?>')"
                                viewBox="0 0 348.882 348.882">
                                <path
                                    d="m333.988 11.758-.42-.383A43.363 43.363 0 0 0 304.258 0a43.579 43.579 0 0 0-32.104 14.153L116.803 184.231a14.993 14.993 0 0 0-3.154 5.37l-18.267 54.762c-2.112 6.331-1.052 13.333 2.835 18.729 3.918 5.438 10.23 8.685 16.886 8.685h.001c2.879 0 5.693-.592 8.362-1.76l52.89-23.138a14.985 14.985 0 0 0 5.063-3.626L336.771 73.176c16.166-17.697 14.919-45.247-2.783-61.418zM130.381 234.247l10.719-32.134.904-.99 20.316 18.556-.904.99-31.035 13.578zm184.24-181.304L182.553 197.53l-20.316-18.556L294.305 34.386c2.583-2.828 6.118-4.386 9.954-4.386 3.365 0 6.588 1.252 9.082 3.53l.419.383c5.484 5.009 5.87 13.546.861 19.03z"
                                    data-original="#000000" />
                                <path
                                    d="M303.85 138.388c-8.284 0-15 6.716-15 15v127.347c0 21.034-17.113 38.147-38.147 38.147H68.904c-21.035 0-38.147-17.113-38.147-38.147V100.413c0-21.034 17.113-38.147 38.147-38.147h131.587c8.284 0 15-6.716 15-15s-6.716-15-15-15H68.904C31.327 32.266.757 62.837.757 100.413v180.321c0 37.576 30.571 68.147 68.147 68.147h181.798c37.576 0 68.147-30.571 68.147-68.147V153.388c.001-8.284-6.715-15-14.999-15z"
                                    data-original="#000000" />
                            </svg>
                        </button>

                        <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                        <button type="submit" name="Delete" onclick="deletebtn('<?= $user['id_user'] ?>')"
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
                    <td colspan="5">aucun utilisateur trouve</td>
                </tr>
                <?php endif; ?>


            </tbody>
        </table>
    </div>

    <!-- status modification ****************************************************************************************** -->

    <div id="modalstatus" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Modifier le status :</h2>

            <form method="POST">
                <input type="hidden" id="id_status" name="id_status">

                <div class="mb-4">
                    <label for="banner" class="block text-sm font-medium text-gray-600 mb-1">
                        Status:
                    </label>
                    <select id="statussel" name="statussel"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                        <option value="en attente">En attente</option>
                        <option value="active">Activer</option>
                        <option value="suspendue">Suspendre</option>
                    </select>
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

    function status(id, status) {
        document.getElementById('id_status').value = id;
        document.getElementById('statussel').value = status;

        document.getElementById('modalstatus').classList.remove('hidden');
    }


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