<?php

chdir("../../");
require_once "common.php";

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
                <form action="server.php" class="-form box" method="post" enctype="multipart/form-data">
                    <div class="media">
                        <div class="preview -pad">
                            <div class="box -pad -center__flex" id="panelMedia">

                            </div>
                        </div>
                        <div class="upload -pad -center">
                            <input type="file" id="inputMedia" accept="image/*, video/*, audio/*" onchange="inputMedia_change(event)" name="media" required>
                        </div>
                    </div>
                    <div class="form">
                        <div class="title field">
                            <div class="label -pad">
                                Title
                            </div>
                            <div class="input -pad">
                                <input type="text" class="-input" name="title" placeholder="Add title" required>
                            </div>
                        </div>
                        <div class="tribe field">
                            <div class="label -pad">
                                Tribe
                            </div>
                            <div class="input -pad">
                                <select name="tribe" class="-select" required>
                                    <option value="">
                                        Select Tribe
                                    </option>
                                    <option value="ata-manobo">
                                        Ata-Manobo
                                    </option>
                                    <option value="mandaya">
                                        Mandaya
                                    </option>
                                    <option value="mansaka">
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
                                 <textarea name="description" class="-textarea" placeholder="Add description"></textarea>
                            </div>
                        </div>
                        <div class="categories field">
                            <div class="label -pad">
                                Categories
                            </div>
                            <div class="input -pad">
                                <select name="category" class="-select" required>
                                    <option value="">
                                        Select Category
                                    </option>
                                    <option value="instrument">
                                        Instrument
                                    </option>
                                    <option value="video">
                                        Video
                                    </option>
                                    <option value="music">
                                        Music
                                    </option>
                                    <option value="artifact">
                                        Artifact
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
        <script src="script.js"></script>
        <script>
            let panelMedia = document.getElementById("panelMedia");
            let inputMedia = document.getElementById("inputMedia");

            function inputMedia_change(event) {
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
        </script>
    </body>
</html>