<?php

include "common.php";
$user = getUser();

if ($user == false) {
    header("Location: login/");
    exit();
}

?>

<html>
    <head>
        <title>
            Home
        </title>
        <base href="./">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            
        </style>
    </head>
    <body>
        <div class="main">
            <div class="text -pad">
                Logged in user: <?=$user["username"]?>
            </div>
            <form action="server.php" class="-form logout -pad" method="post" enctype="multipart/form-data">
                <button class="-button" name="method" value="logout">
                    Logout
                </button>
            </form>
        </div>
        <script src="script.js"></script>
        <script>

        </script>
    </body>
</html>