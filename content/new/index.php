<?php

chdir("../../");
include "common.php";

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
                & > .content {
                    display: grid;
                    grid-template-columns: max-content 1fr;
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

                                & > .preview {
                                    & > .box {
                                        box-sizing: border-box;
                                        height: 100%;
                                        border: 1px solid #555;
                                        border-radius: 1rem;
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
                                    grid-template-columns: 1fr max-content;

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
            }

            .-input {
                border: 1px solid #555;
            }

            .-select {
                border: 1px solid #555;
            }
        </style>
    </head>
    <body>
        <div class="main -main">
            <?=renderHeader("content")?>
            <div class="content">
                <?=renderNavigation("content", "")?>
                <div class="content -pad">
                    <form action="server.php" class="-form box" method="post" enctype="multipart/form-data">
                        <div class="media">
                            <div class="preview -pad">
                                <div class="box -pad">

                                </div>
                            </div>
                            <div class="upload -pad -center">
                                <input type="file" name="media" required>
                            </div>
                        </div>
                        <div class="form">
                            <div class="title field">
                                <div class="label -pad">
                                    Title
                                </div>
                                <div class="input -pad">
                                    <input type="text" class="-input" name="title" required>
                                </div>
                            </div>
                            <div class="tribe field">
                                <div class="label -pad">
                                    Tribe
                                </div>
                                <div class="input -pad">
                                    <select name="tribe" class="-select">
                                        <option>
                                            Ata-Manobo
                                        </option>
                                        <option>
                                            Mandaya
                                        </option>
                                        <option>
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
                                    <input type="text" class="-input" name="description">
                                </div>
                            </div>
                            <div class="categories field">
                                <div class="label -pad">
                                    Categories
                                </div>
                                <div class="input -pad">
                                    <select name="categories" class="-select">
                                        <option>
                                            Instrument
                                        </option>
                                        <option>
                                            Dance
                                        </option>
                                        <option>
                                            Music
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="type field">
                                <div class="label -pad">
                                    Type
                                </div>
                                <div class="input -pad">
                                    <select name="type" class="-select">
                                        <option>
                                            Instrument
                                        </option>
                                        <option>
                                            Video
                                        </option>
                                        <option>
                                            Audio
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="submit">
                                <div></div>
                                <div class="button -pad">
                                    <button class="-button" name="method" value="upload">
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>

        </script>
    </body>
</html>