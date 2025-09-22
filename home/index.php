<?php

chdir("../");
require_once "common.php";

?>

<html>
    <head>
        <title>
            Home | Huni Sa Tribu
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            button {
                padding-left: 5rem;
                padding-right: 5rem;
                color: #fff;
                border-radius: 2rem;
            }
        </style>
    </head>
    <body>
        <div style="
            display: grid;
            grid-template-rows: max-content 1fr;
            height: 100%;
            box-sizing: border-box;">
            <?=renderHeader("home")?>
            <div style="
                overflow: auto;">
                <div style="
                    padding: 5rem;
                    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/home.jpg');
                    background-size: cover;
                    background-position: bottom;">
                    <div style="
                        padding: 1rem;
                        font-size: 2rem;
                        font-weight: bold;">
                        Welcome admin!
                    </div>
                    <div style="
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);">
                        <div style="
                            padding: 1rem;
                            padding-top: 0rem;">
                            Manage museum content, track visitors engagement, and oversee the cultural heritage preservation system.
                        </div>
                        <div></div>
                    </div>
                    <div style="
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);">
                        <div style="
                            padding: 1rem;">
                            <img style="
                                width: 100%;"
                                src="assets/content.png">
                        </div>
                        <div style="
                            display: grid;
                            grid-template-rows: repeat(2, max-content) 1fr max-content;">
                            <div style="
                                padding: 1rem;
                                font-size: 2rem;
                                font-weight: bold;">
                                CONTENT<br>
                                MANAGEMENT
                            </div>
                            <div style="
                                padding: 1rem;
                                padding-top: 0rem;">
                                Manage cultural artifacts, music, instruments, and video content
                            </div>
                            <div></div>
                            <div style="
                                padding: 1rem;
                                text-align: center;">
                                <a href="content/">
                                    <button style="
                                        background-color: #5c6;">
                                        Access Content Management
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="
                    padding: 5rem;
                    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/visitors_bg.jpg');
                    background-size: cover;
                    background-position: bottom;">
                    <div style="
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);">
                        <div style="
                            display: grid;
                            grid-template-rows: repeat(2, max-content) 1fr max-content;">
                            <div style="
                                padding: 1rem;
                                font-size: 2rem;
                                font-weight: bold;">
                                VISITORS<br>
                                MANAGEMENT
                            </div>
                            <div style="
                                padding: 1rem;
                                padding-top: 0rem;">
                                Tracks visitors, manage QR codes, and view analytics
                            </div>
                            <div></div>
                            <div style="
                                padding: 1rem;
                                text-align: center;">
                                <a href="visitors/">
                                    <button style="
                                        background-color: #000a;">
                                        Access Visitors Management
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div style="
                            padding: 1rem;">
                            <img style="
                                width: 100%;"
                                src="assets/visitors.png">
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