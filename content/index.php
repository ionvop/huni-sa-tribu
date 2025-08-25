<?php

chdir("../");
include "common.php";
$db = new SQLite3("database.db");
$selected = "all";

$query = "SELECT * FROM `uploads`";

if (isset($_GET["category"])) {
    switch ($_GET["category"]) {
        case "music":
        case "instrument":
        case "video":
        case "artifact":
            $selected = $_GET["category"];
            $query .= " WHERE `category` = :category";
            break;
    }
}

if (isset($_GET["q"])) {
    $query .= (strpos($query, "WHERE") === false) ? " WHERE" : " AND";
    $query .= " `title` LIKE :q OR `description` LIKE :q";
}

$stmt = $db->prepare($query);

if (isset($_GET["category"])) {
    $stmt->bindValue(":category", ucfirst($_GET["category"]));
}

if (isset($_GET["q"])) {
    $stmt->bindValue(":q", "%{$_GET["q"]}%");
}

$result = $stmt->execute();

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

                & > .navigation {
                    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("assets/content.jpg");
                    color: #fff;

                    & > .back {
                        cursor: pointer;
                        transition-duration: 0.1s;

                        &:hover {
                            background-color: #fff5;
                        }
                    }

                    & > .title {
                        font-weight: bold;
                    }

                    & > .description {
                        padding-top: 0rem;
                        padding-bottom: 3rem;
                        border-bottom: 1px solid #fff5;
                    }

                    & > .categories {
                        & > .title {
                            padding: 2rem;
                            font-weight: bold;
                            color: #fffa;
                        }

                        & > .tabs {
                            & > .tab {
                                cursor: pointer;
                                transition-duration: 0.1s;

                                & > .box {
                                    border-radius: 1rem;
                                }

                                & > .box--selected {
                                    background-color: #fff;
                                    color: var(--theme-green);
                                }

                                &:hover {
                                    background-color: #fff5;
                                }
                            }
                        }
                    }
                }

                & > .content {
                    background-color: #f5fafa;

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
                            overflow: hidden;
                            border: 1px solid #555;

                            & > table {
                                border-collapse: collapse;
                                width: 100%;

                                & > thead {
                                    border-bottom: 1px solid #555;

                                    & > tr {
                                        & > th {
                                            /* border-bottom: 1px solid #555; */
                                        }
                                    }
                                }

                                & > tbody {
                                    background-color: #fff;
                                }
                            }
                        }
                    }
                }
            }
        </style>
    </head>
    <body>
        <div class="main">
            <div class="navigation">
                <a href="./" class="-a back -pad">
                    <div class="-iconlabel">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m313-440 196 196q12 12 11.5 28T508-188q-12 11-28 11.5T452-188L188-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l264-264q11-11 27.5-11t28.5 11q12 12 12 28.5T508-715L313-520h447q17 0 28.5 11.5T800-480q0 17-11.5 28.5T760-440H313Z"/></svg>
                        </div>
                        <div class="label">
                            Back to Admin
                        </div>
                    </div>
                </a>
                <div class="title -pad -title">
                    Content Management
                </div>
                <div class="description -pad">
                    Manage cultural artifacts and media
                </div>
                <div class="categories">
                    <div class="title -pad">
                        CONTENT CATEGORIES
                    </div>
                    <div class="tabs">
                        <a href="content/" class="-a all tab -pad">
                            <div class="box <?=$selected == "all" ? "box--selected" : "" ?> -pad">
                                All Content
                            </div>
                        </a>
                        <a href="content/?category=music" class="-a music tab -pad">
                            <div class="box <?=$selected == "music" ? "box--selected" : "" ?> -pad">
                                Music
                            </div>
                        </a>
                        <a href="content/?category=instrument" class="-a instruments tab -pad">
                            <div class="box <?=$selected == "instrument" ? "box--selected" : "" ?> -pad">
                                Instruments
                            </div>
                        </a>
                        <a href="content/?category=video" class="-a videos tab -pad">
                            <div class="box <?=$selected == "video" ? "box--selected" : "" ?> -pad">
                                Videos
                            </div>
                        </a>
                        <a href="content/?category=artifact" class="-a artifacts tab -pad">
                            <div class="box <?=$selected == "artifact" ? "box--selected" : "" ?> -pad">
                                Artifacts
                            </div>
                        </a>
                    </div>
                </div>
            </div>
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
                                        echo renderContentRow($row);
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>

        </script>
    </body>
</html>