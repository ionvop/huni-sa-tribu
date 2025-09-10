<?php

chdir("../");
require_once "common.php";
$db = new SQLite3("database.db");
$selected = "all";

$query = <<<SQL
    SELECT * FROM `uploads`
SQL;

$conditions = [];
$binds = [];
$selected = "all";

if (isset($_GET["category"])) {
    switch ($_GET["category"]) {
        case "music":
        case "instrument":
        case "video":
        case "artifact":
            $selected = $_GET["category"];
            $conditions[] = "`category` = :category";
            $binds[":category"] = $_GET["category"];
            break;
    }
}

if (isset($_GET["q"])) {
    $conditions[] = "(`title` LIKE :q OR `description` LIKE :q)";
    $binds[":q"] = "%{$_GET["q"]}%";
}

$result = buildQuery($db, $query, $conditions, $binds);

$tribeMap = [
    "ata-manobo" => "Ata-Manobo",
    "mandaya" => "Mandaya",
    "mansaka" => "Mansaka"
];

$categoryMap = [
    "instrument" => "Instrument",
    "music" => "Music",
    "video" => "Video",
    "artifact" => "Artifact"
];

$typeMap = [
    "image" => "Image",
    "video" => "Video",
    "audio" => "Audio"
]

?>

<html>
    <head>
        <title>
            Content Management
        </title>
        <base href="../">
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
                    background-color: #f5fafa;
                    overflow: auto;

                    & > .top {
                        display: grid;
                        grid-template-columns: 1fr max-content;

                        & > .title {
                            & > .title {
                                font-weight: bold;
                            }

                            & > .search {
                                & > .box {
                                    display: grid;
                                    grid-template-columns: max-content 1fr;
                                    width: 30rem;
                                    border: 1px solid #555;
                                    border-radius: 1rem;
                                    background-color: #fff;

                                    & > .icon {
                                        padding-left: 1rem;
                                        padding-right: 1rem;
                                    }

                                    & > .input {
                                        & > input {
                                            border: none;
                                        }
                                    }
                                }
                            }
                        }

                        & > .new {
                            & > button {
                                background-color: var(--theme-green-dark);
                                font-weight: bold;
                                color: #fff;
                            }
                        }
                    }

                    & > .table {
                        & > .box {
                            border-radius: 1rem;
                            overflow: auto;
                            border: 1px solid #555;
                            height: 20rem;
                            background-color: #fff;

                            & > table {
                                border-collapse: collapse;
                                width: 100%;

                                & > thead {
                                    position: sticky;
                                    top: 0rem;
                                    background-color: #f5fafa;
                                    border-bottom: 1px solid #555;
                                }

                                & > tbody {
                                    background-color: #fff;

                                    & > tr {
                                        border-bottom: 1px solid #aaa;

                                        & > td {
                                            padding: 1rem;
                                            text-align: center;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    & > .stats {
                        & > .box {
                            display: grid;
                            grid-template-columns: repeat(3, 1fr);
                            background-color: #fff;
                            border-radius: 1rem;
                            border: 1px solid #555;
                        }
                    }
                }
            }
        </style>
    </head>
    <body>
        <div class="main">
            <?=renderNavigation("content", $selected)?>
            <div class="content">
                <div class="top">
                    <div class="title">
                        <div class="title -pad -title">
                            All Content
                        </div>
                        <div class="description -pad">
                            Manage cultural artifacts and track engagement
                        </div>
                        <div class="search -pad">
                            <div class="box">
                                <div class="icon -center__flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                                </div>
                                <form class="-form input">
                                    <input type="text" class="-input" name="q" <?=(isset($_GET["q"])) ? 'value="'.$_GET["q"].'"' : ''?> placeholder="Search content...">
                                     <?=isset($_GET["category"]) ? '<input type="hidden" name="category" value="'.$_GET["category"].'">' : ''?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <a href="content/new/" class="-a new -pad">
                        <button class="-button">
                            <div class="-iconlabel">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-440H240q-17 0-28.5-11.5T200-480q0-17 11.5-28.5T240-520h200v-200q0-17 11.5-28.5T480-760q17 0 28.5 11.5T520-720v200h200q17 0 28.5 11.5T760-480q0 17-11.5 28.5T720-440H520v200q0 17-11.5 28.5T480-200q-17 0-28.5-11.5T440-240v-200Z"/></svg>
                                </div>
                                <div class="label">
                                    Add Content
                                </div>
                            </div>
                        </button>
                    </a>
                </div>
                <div class="table -pad">
                    <div class="box">
                        <table>
                            <thead>
                                <tr>
                                    <th class="-pad">
                                        Date
                                    </th>
                                    <th class="-pad">
                                        Title
                                    </th>
                                    <th class="-pad">
                                        Tribe
                                    </th>
                                    <th class="-pad">
                                        Category
                                    </th>
                                    <th class="-pad">
                                        Type
                                    </th>
                                    <th class="-pad">
                                        Engagement
                                    </th>
                                    <th class="-pad">
                                        App Score
                                    </th>
                                    <th class="-pad">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                        $row["title"] = htmlentities($row["title"]);
                                        $date = date("m/d/Y", $row["time"]);

                                        echo <<<HTML
                                            <tr>
                                                <td>
                                                    {$date}
                                                </td>
                                                <td>
                                                    {$row["title"]}
                                                </td>
                                                <td>
                                                    {$tribeMap[$row["tribe"]]}
                                                </td>
                                                <td>
                                                    {$categoryMap[$row["category"]]}
                                                </td>
                                                <td>
                                                    {$typeMap[$row["type"]]}
                                                </td>
                                                <td>
                                                    0%
                                                </td>
                                                <td>
                                                    0
                                                </td>
                                                <td>
                                                    <a href="content/edit/?id={$row['id']}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z"/></svg>
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
                <div class="stats -pad">
                    <div class="box -pad">
                        <div class="content stat">
                            <div class="box">
                                <div class="value -pad -title -center">
                                    0
                                </div>
                                <div class="label -pad -subtitle -center">
                                    Total Content
                                </div>
                            </div>
                        </div>
                        <div class="score stat">
                            <div class="box">
                                <div class="value -pad -title -center">
                                    0
                                </div>
                                <div class="label -pad -subtitle -center">
                                    Total App Score
                                </div>
                            </div>
                        </div>
                        <div class="engagement stat">
                            <div class="box">
                                <div class="value -pad -title -center">
                                    0%
                                </div>
                                <div class="label -pad -subtitle -center">
                                    Avg. Engagement
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>

        </script>
    </body>
</html>