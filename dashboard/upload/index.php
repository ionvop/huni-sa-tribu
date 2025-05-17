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
            body > .main {
                display: grid;
                grid-template-columns: 1fr 2fr 1fr;
            }
        </style>
    </head>
    <body>
        <div class="main">
            <div></div>
            <form class="-form content" action="server.php" method="post" enctype="multipart/form-data">
                <div class="header">
                    <div></div>
                    <div class="cancel -pad">
                        <button>
                            Cancel
                        </button>
                    </div>
                    <div class="publish -pad">
                        <button>
                            Publish
                        </button>
                    </div>
                </div>
                <div class="columns">
                    <div class="column1 column -pad">
                        <div class="upload -center_flex">
                            <div class="box">
                                Upload files here
                            </div>
                        </div>
                    </div>
                    <div class="column2 column">
                        <div class="title field">
                            <div class="label -pad">
                                Title
                            </div>
                            <div class="input -pad">
                                <input class="-input" name="title" placeholder="Title" required>
                            </div>
                        </div>
                        <div class="group field">
                            <div class="label -pad">
                                Group
                            </div>
                            <div class="input -pad">
                                <input class="-input" name="group" placeholder="Group" required>
                            </div>
                        </div>
                        <div class="board field">
                            <div class="label -pad">
                                Board
                            </div>
                            <div class="input -pad">
                                <input class="-input" name="board" placeholder="Board" required>
                            </div>
                        </div>
                        <div class="description field">
                            <div class="label -pad">
                                Description
                            </div>
                            <div class="input -pad">
                                <textarea class="-textarea" name="description" placeholder="Description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div></div>
        </div>
        <script src="script.js"></script>
        <script>

        </script>
    </body>
</html>