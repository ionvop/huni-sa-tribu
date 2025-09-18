<?php

chdir("../../");
require_once "common.php";
$db = new SQLite3("database.db");

$query = <<<SQL
    SELECT * FROM `content` WHERE `id` = :id
SQL;

$stmt = $db->prepare($query);
$stmt->bindValue(":id", $_GET["id"]);
$post = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if ($post == false) {
    alert("Invalid post.");
}

?>

<html>
    <head>
        <title>
            Content Management
        </title>
        <base href="../../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body > .main {
                display: grid;
                grid-template-columns: max-content 1fr;
                height: 100%;
                overflow: hidden;

                & > .content {
                    overflow: hidden;
                
                    & > .box {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        height: 100%;
                        border: 3px solid #555;
                        border-radius: 1rem;

                        & > .media {
                            display: grid;
                            grid-template-rows: minmax(0, 1fr) max-content;
                            overflow: hidden;

                            & > .preview {
                                overflow: hidden;

                                & > .box {
                                    box-sizing: border-box;
                                    height: 100%;
                                    border: 1px solid #555;
                                    border-radius: 1rem;
                                    overflow: hidden;

                                    & > img {
                                        box-sizing: border-box;
                                        max-width: 100%;
                                        max-height: 100%;
                                    }

                                    & > video {
                                        max-width: 100%;
                                        max-height: 100%;
                                    }
                                }
                            }
                        }

                        & > .form {
                            overflow: auto;

                            & > .field {
                                & > .input {
                                    padding-top: 0rem;
                                }
                            }

                            & > .submit {
                                display: grid;
                                grid-template-columns: 1fr max-content max-content;

                                & > .delete {
                                    & > button {
                                        background-color: #500;
                                        color: #fff;
                                    }
                                }

                                & > .button {
                                    & > button {
                                        background-color: var(--theme-green-dark);
                                        color: #fff;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            .-input {
                border: 1px solid #555;
            }

            .-select {
                border: 1px solid #555;
            }

            .-textarea {
                border: 1px solid #555;
            }
        </style>
    </head>
    <body>
        <div class="main">
            <?=renderNavigation("content", "new")?>
            <div class="content -pad">
                <form action="server.php" class="-form box" method="post" id="formEdit" enctype="multipart/form-data">
                    <div class="media">
                        <div class="preview -pad">
                            <div class="box -pad -center__flex" id="panelMedia">
                                <?php
                                    $filepath = "uploads/{$post['file']}";

                                    if (strpos(mime_content_type($filepath), "image/") === 0) {
                                        echo <<<HTML
                                            <img src="$filepath">
                                        HTML;
                                    } else if (strpos(mime_content_type($filepath), "video/") === 0) {
                                        echo <<<HTML
                                            <video controls>
                                                <source src="$filepath">
                                            </video>
                                        HTML;
                                    } else if (strpos(mime_content_type($filepath), "audio/") === 0) {
                                        echo <<<HTML
                                            <audio controls>
                                                <source src="$filepath">
                                            </audio>
                                        HTML;
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="upload -pad -center">
                            <input type="file" id="inputMedia" accept="image/*, video/*, audio/*" name="media">
                        </div>
                    </div>
                    <div class="form">
                        <div class="title field">
                            <div class="label -pad">
                                Title
                            </div>
                            <div class="input -pad">
                                <input type="text" class="-input" name="title" value="<?=htmlentities($post["title"])?>" required>
                            </div>
                        </div>
                        <div class="tribe field">
                            <div class="label -pad">
                                Tribe
                            </div>
                            <div class="input -pad">
                                <select name="tribe" class="-select">
                                    <option value="ata-manobo" <?=$post["tribe"] == "ata-manobo" ? "selected" : ""?>>
                                        Ata-Manobo
                                    </option>
                                    <option value="mandaya" <?=$post["tribe"] == "mandaya" ? "selected" : ""?>>
                                        Mandaya
                                    </option>
                                    <option value="mansaka" <?=$post["tribe"] == "mansaka" ? "selected" : ""?>>
                                        Mansaka
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="description field">
                            <div class="label -pad">
                                Description
                            </div>
                            <div class="input -pad">
                                <textarea name="description" class="-textarea" placeholder="Add description"><?=htmlentities($post["description"])?></textarea>
                            </div>
                        </div>
                        <div class="categories field">
                            <div class="label -pad">
                                Categories
                            </div>
                            <div class="input -pad">
                                <select name="category" class="-select">
                                     <option value="instrument" <?=$post["category"] == "instrument" ? "selected" : ""?>>
                                        Instrument
                                    </option>
                                    <option value="video" <?=$post["category"] == "video" ? "selected" : ""?>>
                                        Video
                                    </option>
                                    <option value="music" <?=$post["category"] == "music" ? "selected" : ""?>>
                                        Music
                                    </option>
                                    <option value="artifact" <?=$post["category"] == "artifact" ? "selected" : ""?>>
                                        Artifact
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="submit">
                            <div></div>
                            <div class="delete -pad">
                                <button type="button" class="-button" id="btnDelete">
                                    Delete
                                </button>
                            </div>
                            <div class="button -pad">
                                <button class="-button" name="method" value="edit">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?=$post["id"]?>">
                </form>
            </div>
        </div>
        <script src="script.js"></script>
        <script>
            let panelMedia = document.getElementById("panelMedia");
            let inputMedia = document.getElementById("inputMedia");
            let formEdit = document.getElementById("formEdit");
            let btnDelete = document.getElementById("btnDelete");

            inputMedia.onchange = (event) => {
                let file = event.target.files[0];
                let reader = new FileReader();

                reader.onload = (event) => {
                    panelMedia.innerHTML = "";

                    if (file.type.includes("image")) {
                        let image = document.createElement("img");
                        image.src = event.target.result;
                        panelMedia.innerHTML = "";
                        panelMedia.appendChild(image);
                    } else if (file.type.includes("video")) {
                        let video = document.createElement("video");
                        video.src = event.target.result;
                        video.controls = true;
                        panelMedia.innerHTML = "";
                        panelMedia.appendChild(video);
                    } else if (file.type.includes("audio")) {
                        let audio = document.createElement("audio");
                        audio.src = event.target.result;
                        audio.controls = true;
                        panelMedia.innerHTML = "";
                        panelMedia.appendChild(audio);
                    }
                }

                reader.readAsDataURL(file);
            }

            btnDelete.onclick = () => {
                if (confirm("Are you sure you want to delete this post?") == false) return;
                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "method";
                input.value = "delete";
                formEdit.appendChild(input);
                formEdit.submit();
            }
        </script>
    </body>
</html>