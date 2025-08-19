<?php

chdir("../");
include "common.php";

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
                & > .content {
                    display: grid;
                    grid-template-columns: max-content 1fr;
                    overflow: hidden;
                
                    & > .content {
                        overflow: auto;
                    }
                }
            }
        </style>
    </head>
    <body>
        <div class="main -main">
            <?=renderHeader("content")?>
            <div class="content">
                <?=renderNavigation("content")?>
                <div class="content">
                    <div class="top">
                        <div class="title -pad -title">
                            All Content
                        </div>
                        <div class="new -pad">
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
                        </div>
                    </div>
                    <div class="subtitle">
                        Manage cultural artifacts and track management
                    </div>
                    <div class="search -pad">
                        <div class="box">
                            <div class="icon -pad">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                            </div>
                            <div class="input -pad">
                                <input type="text" class="-input">
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="box">
                            <div class="date header -pad -center__flex">
                                Date
                            </div>
                        </div>
                        <div class="box">
                            <div class="title header -pad -center__flex">
                                Title
                            </div>
                        </div>
                        <div class="box">
                            <div class="tribe header -pad -center__flex">
                                Tribe
                            </div>
                        </div>
                        <div class="box">
                            <div class="category header -pad -center__flex">
                                Category
                            </div>
                        </div>
                        <div class="box">
                            <div class="type header -pad -center__flex">
                                Type
                            </div>
                        </div>
                        <div class="box">
                            <div class="engagement header -pad -center__flex">
                                Engagement
                            </div>
                        </div>
                        <div class="box">
                            <div class="webviews header -pad -center__flex">
                                Web Views
                            </div>
                        </div>
                        <div class="box">
                            <div class="appscans header -pad -center__flex">
                                App Scans
                            </div>
                        </div>
                        <div class="box">
                            <div class="actions header -pad -center__flex">
                                Actions
                            </div>
                        </div>
                        <?php
                            // TODO: add render
                        ?>
                    </div>
                    <div class="stats">
                        <div class="box">
                            <div class="content">
                                <div class="value">
                                    0
                                </div>
                                <div class="label">
                                    Total Content
                                </div>
                            </div>
                            <div class="webviews">
                                <div class="value">
                                    0
                                </div>
                                <div class="label">
                                    Total Web Views
                                </div>
                            </div>
                            <div class="appscans">
                                <div class="value">
                                    0
                                </div>
                                <div class="label">
                                    Total App Scans
                                </div>
                            </div>
                            <div class="engagement">
                                <div class="value">
                                    0%
                                </div>
                                <div class="label">
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