<?php 
require 'classes/class.enseignants.php';
session_start();
$user=new Enseignant();
$users=$user->lesinscritsamescours($_SESSION['ID_user']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include 'header.php'?>
<div class="font-[sans-serif] overflow-x-auto grid justify-end w-screen grid-cols-1 px-12">
        <h1 class="mx-6 text-3xl font-bold md:text-5xl text-start my-6">Listes des inscriptions</h1>


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
                        Cours
                    </th>
                    <th class="p-4 text-left text-sm font-medium text-white">
                        Date d inscription
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
                        <?= htmlspecialchars($user["titre"]) ?>
                    </td>
                    <td class="p-4 text-sm text-black">
                        <?= htmlspecialchars($user["date_inscription"]) ?>
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

</body>
</html>