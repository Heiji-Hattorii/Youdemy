<?php
require_once 'classes/class.users.php';
$user=new Users();
$message = '';

if(isset($_POST['identifiant']) && isset($_POST['email']) && isset($_POST['password'])  && isset($_POST['cpassword'])  && isset($_POST['role'])){
   $return = $user->signup($_POST['identifiant'],$_POST['email'],$_POST['password'],$_POST['cpassword'],$_POST['role']);
   if ($return) {
    $message = $return;
}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="h-[100vh] flex items-center">
    <form class="space-y-4 font-[sans-serif] max-w-md mx-auto align-center" method="POST">
        <input type="text" name="identifiant" placeholder="identifiant"
            class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded" />
        <input type="email" name="email" placeholder="Enter Email"
            class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded" />

        <input type="password" name="password" placeholder="Enter Password"
            class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded" />
        <input type="password" name="cpassword" placeholder="Verify Password"
            class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded" />
        <select name="role" id="role">
            <option value="enseignant">Enseignant</option>
            <option value="etudiant">Etudiant</option>

        </select>

        <div class="flex">
            <input type="checkbox" class="w-4" />
            <label class="text-sm ml-4 ">Remember me</label>
        </div>

        <button type="submit"
            class="!mt-8 w-full px-4 py-2.5 mx-auto block text-sm bg-blue-500 text-white rounded hover:bg-blue-600">Submit</button>

        <?php if (!empty($message)): ?>
        <div class="error "><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
    </form>
</body>

</html>