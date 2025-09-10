<?php

chdir("../../../");
require_once "common.php";
$db = new SQLite3("database.db");
$user = getUser();

if ($user == false) {
    header("Location: login/");
    exit;
}

if (isset($_GET["id"]) == false) {
    alert("QR code not found.");
}

$query = <<<SQL
    SELECT * FROM `qr` WHERE `id` = :id
SQL;

$stmt = $db->prepare($query);
$stmt->bindValue(":id", $_GET["id"]);
$qr = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

?>

<html>
    <head>
        <title>
            QR Code
        </title>
        <base href="../../../">
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
                    & > .box {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        border-radius: 1rem;
                        border: 1px solid #555;

                        & > .image {
                            & > img {
                                width: 100%;
                                height: 100%;
                                box-sizing: border-box;
                                object-fit: contain;
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
            <?=renderNavigation("visitor", "new")?>
            <div class="content -pad">
                <form action="server.php" class="-form box" id="formEdit" method="post" enctype="multipart/form-data">
                    <div class="image -pad">
                        <img src="" id="imgQr">
                    </div>
                    <div class="form">
                        <div class="name field">
                            <div class="label -pad">
                                Name
                            </div>
                            <div class="input -pad">
                                <input class="-input" name="name" value="<?=htmlentities($qr["name"])?>" placeholder="Enter name" id="inputName">
                            </div>
                        </div>
                        <div class="type field">
                            <div class="label -pad">
                                Type
                            </div>
                            <div class="input -pad">
                                <select name="type" class="-select" value="<?=$qr["type"]?>" id="selectType">
                                    <option value="entrance">
                                        Entrance
                                    </option>
                                    <option value="music">
                                        Music
                                    </option>
                                    <option value="instrument">
                                        Instrument
                                    </option>
                                    <option value="video">
                                        Video
                                    </option>
                                    <option value="artifact">
                                        Artifact
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="content field" style="display: none;" id="panelContent">
                            <div class="label -pad">
                                Content
                            </div>
                            <div class="input -pad">
                                <select name="content" class="-select" id="selectContent"></select>
                            </div>
                        </div>
                        <div class="status field">
                            <div class="label -pad">
                                Status
                            </div>
                            <div class="input -pad">
                                <select name="status" class="-select" value="<?=$qr["status"]?>">
                                    <option value="active">
                                        Active
                                    </option>
                                    <option value="inactive">
                                        Inactive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="submit">
                            <div></div>
                            <div class="delete -pad">
                                <button type="button" class="-button" onclick="btnDelete_click()">
                                    Delete
                                </button>
                            </div>
                            <div class="button -pad">
                                <button class="-button" name="method" value="edit_qr">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?=$qr["id"]?>">
                </form>
            </div>
        </div>
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
        <script>
            let formEdit = document.getElementById("formEdit");
            let imgQr = document.getElementById("imgQr");
            let qrContent = <?=json_encode($qr["code"])?>;
            let inputName = document.getElementById("inputName");
            let selectType = document.getElementById("selectType");
            let panelContent = document.getElementById("panelContent");
            let selectContent = document.getElementById("selectContent");

            QRCode.toDataURL(qrContent, (err, url) => {
                if (err) {
                    throw err;
                }

                imgQr.src = url;
            });

            function btnDelete_click() {
                if (confirm("Are you sure you want to delete this QR?") == false) {
                    return;
                }

                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "method";
                input.value = "delete_qr";
                formEdit.appendChild(input);
                formEdit.submit();
            }

            selectType.onchange = async () => {
                if (selectType.value == "entrance") {
                    panelContent.style.display = "none";
                    return;
                }

                panelContent.style.display = "block";
                let response = await fetch("api/content/?category=" + selectType.value);
                let json = await response.json();
                console.log(json);

                if (response.ok == false) {
                    alert(json.error);
                    return;
                }

                selectContent.innerHTML = "";

                for (let content of json) {
                    let option = document.createElement("option");
                    option.value = content["id"];
                    option.textContent = content["title"];
                    selectContent.appendChild(option);
                }

                selectContent.onchange();
            }
        
            selectContent.onchange = () => {
                let option = selectContent.options[selectContent.selectedIndex];
                inputName.value = option.textContent;
            }
        </script>
    </body>
</html>