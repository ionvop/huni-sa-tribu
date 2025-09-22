<?php

chdir("../");
require_once "common.php";
$db = new SQLite3("database.db");

if (isset($_GET["category"])) {
    $category = $_GET["category"];
} else {
    $category = "all";
}

?>

<html>
    <head>
        <title>
            Content Management | Huni Sa Tribu
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            button {
                color: #fff;
                border-radius: 2rem;
            }

            input:focus {
                outline: none;
            }

            table {
                border-collapse: collapse;
                width: 100%;

                & > thead {
                    position: sticky;
                    top: 0rem;
                }

                & > tbody {
                    & > tr {
                        border-bottom: 1px solid #fff;

                        & > td {
                            padding: 1rem;
                            text-align: center;
                        }
                    }
                }
            }
        </style>
    </head>
    <body>
        <div style="
            display: grid;
            grid-template-rows: max-content 1fr;
            height: 100%;
            box-sizing: border-box;
            overflow: hidden;">
            <?=renderHeader("content")?>
            <div style="
                padding: 5rem;
                background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/home.jpg');
                background-size: cover;
                background-position: bottom;
                overflow: auto;">
                <div style="
                    display: grid;
                    grid-template-columns: max-content 1fr max-content;">
                    <div>
                        <div style="
                            padding: 1rem;
                            font-size: 1.5rem;
                            font-weight: bold;">
                            Content Management
                        </div>
                        <div style="
                            padding: 1rem;
                            padding-top: 0rem;">
                            Manage cultural artifacts and media
                        </div>
                    </div>
                    <div></div>
                    <div style="
                        padding: 1rem;">
                        <a href="content/new/">
                            <button style="
                                background-color: #5c6;">
                                <div style="
                                    display: grid;
                                    grid-template-columns: repeat(2, max-content);">
                                    <div style="
                                        display: flex;
                                        align-items: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/></svg>
                                    </div>
                                    <div style="
                                        display: flex;
                                        align-items: center;
                                        padding-left: 1rem;">
                                        Add Content
                                    </div>
                                </div>
                            </button>
                        </a>
                    </div>
                </div>
                <div style="
                    display: grid;
                    grid-template-columns: max-content 1fr max-content;">
                    <div style="
                        padding: 1rem;
                        width: 30rem;">
                        <div style="
                            display: grid;
                            grid-template-columns: max-content 1fr;
                            border: 1px solid #fff;
                            background-color: #fff5;
                            border-radius: 1rem;">
                            <div style="
                                display: flex;
                                align-items: center;
                                padding: 1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                            </div>
                            <form style="
                                display: flex;
                                align-items: center;
                                padding: 1rem;
                                padding-left: 0rem;">
                                <input style="
                                    padding: 0rem;
                                    background-color: transparent;
                                    color: #fff;"
                                    placeholder="Search content"
                                    name="q"
                                    value="<?=$_GET["q"] ?? ""?>">
                            </form>
                        </div>
                    </div>
                    <div></div>
                    <div>
                        <div style="
                            display: grid;
                            grid-template-columns: repeat(5, max-content);">
                            <div style="
                                padding: 1rem;
                                cursor: pointer;">
                                <div style="
                                    padding: 1rem;
                                    border-radius: 1rem;
                                    <?=$category == "all" ? "background-color: #5c6;" : ""?>"
                                    id="btnAll">
                                    All Content
                                </div>
                            </div>
                            <div style="
                                padding: 1rem;
                                padding-left: 0rem;
                                cursor: pointer;">
                                <div style="
                                    padding: 1rem;
                                    border-radius: 1rem;
                                    <?=$category == "music" ? "background-color: #5c6;" : ""?>"
                                    id="btnMusic">
                                    Music
                                </div>
                            </div>
                            <div style="
                                padding: 1rem;
                                padding-left: 0rem;
                                cursor: pointer;">
                                <div style="
                                    padding: 1rem;
                                    border-radius: 1rem;
                                    <?=$category == "video" ? "background-color: #5c6;" : ""?>"
                                    id="btnVideo">
                                    Videos
                                </div>
                            </div>
                            <div style="
                                padding: 1rem;
                                padding-left: 0rem;
                                cursor: pointer;">
                                <div style="
                                    padding: 1rem;
                                    border-radius: 1rem;
                                    <?=$category == "artifact" ? "background-color: #5c6;" : ""?>"
                                    id="btnArtifacts">
                                    Artifacts
                                </div>
                            </div>
                            <div style="
                                padding: 1rem;
                                padding-left: 0rem;
                                cursor: pointer;">
                                <div style="
                                    padding: 1rem;
                                    border-radius: 1rem;
                                    <?=$category == "instrument" ? "background-color: #5c6;" : ""?>"
                                    id="btnInstruments">
                                    Instruments
                                </div>
                            </div>
                        </div>
                        <div style="
                            display: grid;
                            grid-template-columns: max-content 1fr max-content">
                            <div style="
                                display: flex;
                                align-items: center;
                                padding: 1rem;
                                font-size: 1.5rem;
                                font-weight: bold;
                                text-align: center;">
                                <?php
                                    $query = <<<SQL
                                        SELECT COUNT(*) FROM `content`
                                    SQL;

                                    $count = $db->query($query)->fetchArray()[0];
                                    echo "Total Content: {$count}";
                                ?>
                            </div>
                            <div></div>
                            <div style="
                                display: flex;
                                align-items: center;
                                padding: 1rem;">
                                <a style="
                                    text-decoration: underline;"
                                    href="content/archive/">
                                    Go to Archive
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="
                    padding: 1rem;
                    padding-top: 5rem;">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    TITLE
                                </th>
                                <th>
                                    TRIBE
                                </th>
                                <th>
                                    CATEGORY
                                </th>
                                <th>
                                    TYPE
                                </th>
                                <th>
                                    DATE
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = <<<SQL
                                    SELECT * FROM `content`
                                SQL;

                                $conditions = ["`is_archived` = 0"];
                                $bindings = [];

                                if (isset($_GET["category"])) {
                                    $conditions[] = "`category` = :category";
                                    $bindings["category"] = $_GET["category"];
                                }

                                if (isset($_GET["q"])) {
                                    $conditions[] = "(`title` LIKE :q OR `description` LIKE :q OR `tribe` LIKE :q OR `category` LIKE :q)";
                                    $bindings["q"] = "%{$_GET["q"]}%";
                                }

                                if (count($conditions) > 0) {
                                    $query .= " WHERE " . implode(" AND ", $conditions);
                                }

                                $stmt = $db->prepare($query);

                                foreach ($bindings as $key => $value) {
                                    $stmt->bindValue(":{$key}", $value);
                                }

                                $result = $stmt->execute();

                                $categoryMap = [
                                    "music" => "Music",
                                    "video" => "Video",
                                    "artifact" => "Artifact",
                                    "instrument" => "Instrument"
                                ];

                                $tribeMap = [
                                    "kagan" => "Kagan",
                                    "mandaya" => "Mandaya",
                                    "mansaka" => "Mansaka"
                                ];

                                $typeMap = [
                                    "image" => "Image",
                                    "video" => "Video",
                                    "audio" => "Audio"
                                ];

                                while ($content = $result->fetchArray()) {
                                    $content["title"] = htmlentities($content["title"]);
                                    $content["description"] = htmlentities($content["description"]);
                                    $type = getFileType($content["file"]);
                                    $date = date("m/d/y", $content["time"] + 28800);
                                    $contentElement = renderContent($content, 10);

                                    echo <<<HTML
                                        <tr>
                                            <td>
                                                $contentElement
                                            </td>
                                            <td>
                                                {$content["title"]}
                                            </td>
                                            <td>
                                                {$tribeMap[$content["tribe"]]}
                                            </td>
                                            <td>
                                                {$categoryMap[$content["category"]]}
                                            </td>
                                            <td>
                                                {$typeMap[$type]}
                                            </td>
                                            <td>
                                                {$date}
                                            </td>
                                            <td>
                                                <a href="content/edit/?id={$content['id']}">
                                                    <button style="
                                                        background-color: #5c6;">
                                                        Edit
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    HTML;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>
            const btnAll = document.getElementById("btnAll");
            const btnMusic = document.getElementById("btnMusic");
            const btnVideo = document.getElementById("btnVideo");
            const btnArtifacts = document.getElementById("btnArtifacts");
            const btnInstruments = document.getElementById("btnInstruments");

            btnAll.addEventListener("click", () => {
                let url = new URL(window.location);
                url.searchParams.delete("category");
                location.href = url;
            });

            btnMusic.addEventListener("click", () => {
                let url = new URL(window.location);
                url.searchParams.set("category", "music");
                location.href = url;
            });

            btnVideo.addEventListener("click", () => {
                let url = new URL(window.location);
                url.searchParams.set("category", "video");
                location.href = url;
            });

            btnArtifacts.addEventListener("click", () => {
                let url = new URL(window.location);
                url.searchParams.set("category", "artifact");
                location.href = url;
            });

            btnInstruments.addEventListener("click", () => {
                let url = new URL(window.location);
                url.searchParams.set("category", "instrument");
                location.href = url;
            });
        </script>
    </body>
</html>