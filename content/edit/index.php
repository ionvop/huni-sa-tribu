<?php

chdir("../../");
require_once "common.php";
$db = new SQLite3("database.db");

if (isset($_GET["id"]) == false) {
    alert("This content does not exist.");
}

$query = <<<SQL
    SELECT * FROM `content` WHERE `id` = :id
SQL;

$stmt = $db->prepare($query);
$stmt->bindValue(":id", $_GET["id"]);
$content = $stmt->execute()->fetchArray();

if ($content == false) {
    alert("This content does not exist.");
}

?>

<html>
    <head>
        <title>
            Edit Content | Huni Sa Tribu
        </title>
        <base href="../../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            button {
                color: #fff;
                border-radius: 2rem;
            }

            input {
                background-color: #fff5;
                color: #fff;
                backdrop-filter: blur(5px);
                border: 1px solid #fff;
                border-radius: 1rem;
            }

            select {
                background-color: #fff5;
                color: #fff;
                backdrop-filter: blur(5px);
                border: 1px solid #fff;
                border-radius: 1rem;
            }

            option {
                background-color: #fff;
                color: #000;
            }

            textarea {
                background-color: #fff5;
                color: #fff;
                backdrop-filter: blur(5px);
                border: 1px solid #fff;
                border-radius: 1rem;
            }
        </style>
    </head>
    <body>
        <div style="
            padding: 5rem;
            height: 100%;
            box-sizing: border-box;
            overflow: auto;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/home.jpg');
            background-size: cover;
            background-position: bottom;">
            <div style="
                display: grid;
                grid-template-columns: max-content 1fr;">
                <a style="
                    display: block;
                    padding: 1rem;"
                    href="content/">
                    BACK
                </a>
                <div></div>
            </div>
            <div style="
                padding: 1rem;
                padding-top: 5rem;
                font-size: 2rem;
                font-weight: bold;">
                Upload a Content
            </div>
            <div style="
                padding: 1rem;">
                <form style="
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    background-color: #0005;"
                    action="server.php"
                    method="post"
                    enctype="multipart/form-data">
                    <div style="
                        padding: 1rem;">
                        <div style="
                            padding: 1rem;
                            font-weight: bold;">
                            CATEGORY
                        </div>
                        <div style="
                            padding: 1rem;
                            padding-top: 0rem;">
                            <input value="<?=$content["category"]?>"
                                disabled>
                        </div>
                        <div style="
                            padding: 1rem;
                            font-weight: bold;">
                            TITLE
                        </div>
                        <div style="
                            padding: 1rem;
                            padding-top: 0rem;">
                            <input name="title"
                                value="<?=htmlentities($content["title"])?>"
                                required>
                        </div>
                        <div style="
                            padding: 1rem;
                            font-weight: bold;">
                            TRIBE
                        </div>
                        <div style="
                            padding: 1rem;
                            padding-top: 0rem;">
                            <select name="tribe"
                                required>
                                <option value="kagan"
                                    <?=$content["tribe"] == "kagan" ? "selected" : ""?>>
                                    Kagan
                                </option>
                                <option value="mandaya"
                                    <?=$content["tribe"] == "mandaya" ? "selected" : ""?>>
                                    Mandaya
                                </option>
                                <option value="mansaka"
                                    <?=$content["tribe"] == "mansaka" ? "selected" : ""?>>
                                    Mansaka
                                </option>
                            </select>
                        </div>
                        <div style="
                            padding: 1rem;
                            font-weight: bold;">
                            DESCRIPTION
                        </div>
                        <div style="
                            padding: 1rem;
                            padding-top: 0rem;">
                            <textarea name="description"><?=htmlentities($content["description"])?></textarea>
                        </div>
                    </div>
                    <div style="
                        display: grid;
                        grid-template-rows: max-content 1fr repeat(2, max-content);
                        padding: 1rem;">
                        <div style="
                            padding: 1rem;
                            text-align: center;"
                            id="panelPreview">
                            <?php
                                $type = getFileType($content["file"]);

                                switch ($type) {
                                    case "image":
                                        echo <<<HTML
                                            <img style="
                                                width: 100%;
                                                max-height: 20rem;
                                                object-fit: contain;"
                                                src="uploads/{$content['file']}">
                                        HTML;

                                        break;
                                    case "video":
                                        echo <<<HTML
                                            <video style="
                                                width: 100%;
                                                max-height: 20rem;
                                                object-fit: contain;"
                                                src="uploads/{$content['file']}"
                                                controls></video>
                                        HTML;

                                        break;
                                    case "audio":
                                        echo <<<HTML
                                            <audio style="
                                                width: 100%;"
                                                src="uploads/{$content['file']}"
                                                controls></audio>
                                        HTML;

                                        break;
                                }
                            ?>
                        </div>
                        <div></div>
                        <div style="
                            padding: 1rem;
                            text-align: center;">
                            <?php
                                $query = <<<SQL
                                    SELECT * FROM `qr` WHERE `content_id` = :id
                                SQL;

                                $stmt = $db->prepare($query);
                                $stmt->bindValue(":id", $content["id"]);
                                $qr = $stmt->execute()->fetchArray();

                                if ($content["category"] == "artifact" || $content["category"] == "event") {
                                    if ($qr == false) {
                                        echo <<<HTML
                                            <button style="
                                                background-color: #000a;"
                                                name="method"
                                                value="generateQr">
                                                <div style="
                                                    display: grid;
                                                    grid-template-columns: repeat(2, max-content);">
                                                    <div style="
                                                        display: flex;
                                                        align-items: center;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M120-560v-240q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v240q0 17-11.5 28.5T400-520H160q-17 0-28.5-11.5T120-560Zm80-40h160v-160H200v160Zm-80 440v-240q0-17 11.5-28.5T160-440h240q17 0 28.5 11.5T440-400v240q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-40h160v-160H200v160Zm320-360v-240q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v240q0 17-11.5 28.5T800-520H560q-17 0-28.5-11.5T520-560Zm80-40h160v-160H600v160Zm160 480v-80h80v80h-80ZM520-360v-80h80v80h-80Zm80 80v-80h80v80h-80Zm-80 80v-80h80v80h-80Zm80 80v-80h80v80h-80Zm80-80v-80h80v80h-80Zm0-160v-80h80v80h-80Zm80 80v-80h80v80h-80Z"/></svg>
                                                    </div>
                                                    <div style="
                                                        display: flex;
                                                        align-items: center;
                                                        padding-left: 1rem;">
                                                        Generate QR
                                                    </div>
                                                </div>
                                            </button>
                                        HTML;
                                    } else {
                                        echo <<<HTML
                                            <a href="visitors/qr/view?id={$qr['id']}">
                                                <button style="
                                                    background-color: #000a;"
                                                    type="button">
                                                    <div style="
                                                        display: grid;
                                                        grid-template-columns: repeat(2, max-content);">
                                                        <div style="
                                                            display: flex;
                                                            align-items: center;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M120-560v-240q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v240q0 17-11.5 28.5T400-520H160q-17 0-28.5-11.5T120-560Zm80-40h160v-160H200v160Zm-80 440v-240q0-17 11.5-28.5T160-440h240q17 0 28.5 11.5T440-400v240q0 17-11.5 28.5T400-120H160q-17 0-28.5-11.5T120-160Zm80-40h160v-160H200v160Zm320-360v-240q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v240q0 17-11.5 28.5T800-520H560q-17 0-28.5-11.5T520-560Zm80-40h160v-160H600v160Zm160 480v-80h80v80h-80ZM520-360v-80h80v80h-80Zm80 80v-80h80v80h-80Zm-80 80v-80h80v80h-80Zm80 80v-80h80v80h-80Zm80-80v-80h80v80h-80Zm0-160v-80h80v80h-80Zm80 80v-80h80v80h-80Z"/></svg>
                                                        </div>
                                                        <div style="
                                                            display: flex;
                                                            align-items: center;
                                                            padding-left: 1rem;">
                                                            View QR
                                                        </div>
                                                    </div>
                                                </button>
                                            </a>
                                        HTML;
                                    }
                                }
                            ?>
                        </div>
                        <div style="
                            display: grid;
                            grid-template-columns: 1fr repeat(2, max-content) 1fr;">
                            <div></div>
                            <div style="
                                padding: 1rem;">
                                <button style="
                                    background-color: #000a;"
                                    name="method"
                                    value="archive"
                                    id="btnArchive">
                                    <div style="
                                        display: grid;
                                        grid-template-columns: repeat(2, max-content);">
                                        <div style="
                                            display: flex;
                                            align-items: center;">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-120q-33 0-56.5-23.5T200-200v-520q-17 0-28.5-11.5T160-760q0-17 11.5-28.5T200-800h160q0-17 11.5-28.5T400-840h160q17 0 28.5 11.5T600-800h160q17 0 28.5 11.5T800-760q0 17-11.5 28.5T760-720v520q0 33-23.5 56.5T680-120H280Zm120-160q17 0 28.5-11.5T440-320v-280q0-17-11.5-28.5T400-640q-17 0-28.5 11.5T360-600v280q0 17 11.5 28.5T400-280Zm160 0q17 0 28.5-11.5T600-320v-280q0-17-11.5-28.5T560-640q-17 0-28.5 11.5T520-600v280q0 17 11.5 28.5T560-280Z"/></svg>
                                        </div>
                                        <div style="
                                            display: flex;
                                            align-items: center;
                                            padding-left: 1rem;">
                                            Archive
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <div style="
                                padding: 1rem;">
                                <button style="
                                    background-color: #5c6;"
                                    name="method"
                                    value="edit">
                                    <div style="
                                        display: grid;
                                        grid-template-columns: repeat(2, max-content);">
                                        <div style="
                                            display: flex;
                                            align-items: center;">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h447q16 0 30.5 6t25.5 17l114 114q11 11 17 25.5t6 30.5v447q0 33-23.5 56.5T760-120H200Zm280-120q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM280-560h280q17 0 28.5-11.5T600-600v-80q0-17-11.5-28.5T560-720H280q-17 0-28.5 11.5T240-680v80q0 17 11.5 28.5T280-560Z"/></svg>
                                        </div>
                                        <div style="
                                            display: flex;
                                            align-items: center;
                                            padding-left: 1rem;">
                                            Save
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <div></div>
                        </div>
                    </div>
                    <input type="hidden"
                        name="id"
                        value="<?=$content["id"]?>">
                </form>
            </div>
        </div>
        <script src="script.js"></script>
        <script>
            const panelPreview = document.getElementById("panelPreview");
            const inputFile = document.getElementById("inputFile");
            const btnArchive = document.getElementById("btnArchive");

            inputFile.onchange = (event) => {
                let file = event.target.files[0];
                let reader = new FileReader();

                reader.onload = (event) => {
                    panelPreview.innerHTML = "";

                    if (file.type.includes("image")) {
                        let image = document.createElement("img");
                        image.style.width = "100%";
                        image.style.maxHeight = "20rem";
                        image.style.objectFit = "contain";
                        image.src = event.target.result;
                        panelPreview.appendChild(image);
                    } else if (file.type.includes("video")) {
                        let video = document.createElement("video");
                        video.style.width = "100%";
                        video.style.maxHeight = "20rem";
                        video.style.objectFit = "contain";
                        video.src = event.target.result;
                        video.controls = true;
                        panelPreview.appendChild(video);
                    } else if (file.type.includes("audio")) {
                        let audio = document.createElement("audio");
                        audio.style.width = "100%";
                        audio.src = event.target.result;
                        audio.controls = true;
                        panelPreview.appendChild(audio);
                    }
                }

                reader.readAsDataURL(file);
            }

            btnArchive.onclick = () => {
                if (confirm("Are you sure you want to archive this content?") == false) return false;
            }
        </script>
    </body>
</html>