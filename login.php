<?php
require_once 'classes/class.Users.php';
$user=new Users();
$message = '';

if(isset($_POST['email']) && isset($_POST['password']) ){
   $return = $user->login($_POST['email'],$_POST['password']);

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
<body class="h-[100vh] flex items-center" >
    <form class="space-y-4 font-[sans-serif] max-w-md mx-auto align-center" action="" method="POST">
    
        <input type="email" id="email" name="email" placeholder="email" class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded">
        <input type="password" id="password" name="password" placeholder="password" class="px-4 py-3 bg-gray-100 w-full text-sm outline-none border-b-2 border-transparent focus:border-blue-500 rounded">
        <button type="submit"   class="!mt-8 w-full px-4 py-2.5 mx-auto block text-sm bg-blue-500 text-white rounded hover:bg-blue-600">register</button>
        <?php if (!empty($message)): ?>
                    <div class="error "><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>
    </form>
</body>
</html>
