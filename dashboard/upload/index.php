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
                grid-template-columns: 1fr 5fr 1fr;
                min-height: 100%;
                background-color: #242;
                color: #fff;

                & > .content {
                    & > .header {
                        display: grid;
                        grid-template-columns: 1fr repeat(2, max-content);
                    }

                    & > .columns {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        
                        & > .column1 {
                            & > .upload {
                                background-color: #fff;
                                color: #000;
                                border-radius: 1rem;
                                height: 100%;
                                cursor: pointer;

                                & > .box {
                                    & > .icon {

                                        & > svg {
                                            width: 5rem;
                                            height: 5rem;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            button {
                padding: 1rem;
                background-color: #fff;
                border: none;
                border-radius: 1rem;
                font-weight: bold;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="main">
            <div></div>
            <form class="-form content" action="server.php" method="post" enctype="multipart/form-data">
                <div class="header">
                    <div></div>
                    <a class="-a cancel -pad" href="dashboard/">
                        <button type="button">
                            Cancel
                        </button>
                    </a>
                    <div class="publish -pad">
                        <button name="method" value="upload">
                            Publish
                        </button>
                    </div>
                </div>
                <div class="columns">
                    <div class="column1 column -pad">
                        <div class="upload -center__flex" id="panelInput">
                            <div class="box">
                                <div class="icon -pad -center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="currentColor"><path d="M240-160q-33 0-56.5-23.5T160-240v-80q0-17 11.5-28.5T200-360q17 0 28.5 11.5T240-320v80h480v-80q0-17 11.5-28.5T760-360q17 0 28.5 11.5T800-320v80q0 33-23.5 56.5T720-160H240Zm200-486-75 75q-12 12-28.5 11.5T308-572q-11-12-11.5-28t11.5-28l144-144q6-6 13-8.5t15-2.5q8 0 15 2.5t13 8.5l144 144q12 12 11.5 28T652-572q-12 12-28.5 12.5T595-571l-75-75v286q0 17-11.5 28.5T480-320q-17 0-28.5-11.5T440-360v-286Z"/></svg>
                                </div>
                                <div class="label -pad -center" id="panelLabel">
                                    Upload files here
                                </div>
                                <input type="file" accept="image/*,audio/*,video/*" name="media" id="inputMedia" style="display: none;">
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
            let panelInput = document.getElementById("panelInput");
            let panelLabel = document.getElementById("panelLabel");
            let inputMedia = document.getElementById("inputMedia");

            panelInput.addEventListener("click", () => {
                inputMedia.click();
            });

            panelInput.addEventListener("drop", (event) => {
                event.preventDefault();
                inputMedia.files = event.dataTransfer.files;
            });

            inputMedia.addEventListener("change", () => {
                panelLabel.textContent = "Upload files here";
                panelLabel.textContent = inputMedia.files[0].name;
            });
        </script>
    </body>
</html>