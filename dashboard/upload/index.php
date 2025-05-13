<?php

chdir("../../");
include "common.php";
$db = new SQLite3("database.db");
$user = GetUser($db);

if ($user == false) {
    Alert("You are not logged in.");
}

?>

<html>
    <head>
        <title>
            Upload
        </title>
        <base href="../../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>

        </style>
    </head>
    <body>
        <div class="main">
            <form class="-form content" action="server.php" method="post" enctype="multipart/form-data">
                <div class="header">
                    <div></div>
                    <div class="cancel">
                        <button>
                            Cancel
                        </button>
                    </div>
                    <div class="publish">
                        <button>
                            Publish
                        </button>
                    </div>
                </div>
                <div class="columns">
                    <div class="column1 column">
                        <div class="upload">
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script src="script.js"></script>
        <script>

        </script>
    </body>
</html>