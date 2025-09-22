<?php

chdir("../../");
require_once "common.php";

?>

<html>
    <head>
        <title>
            New Content | Huni Sa Tribu
        </title>
        <base href="../../">
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
                    BACK TO HOME
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
                            <select name="category"
                                required>
                                <option value="">
                                    Select a category
                                </option>
                                <option value="music">
                                    Music
                                </option>
                                <option value="video">
                                    Video
                                </option>
                                <option value="artifact">
                                    Artifact
                                </option>
                                <option value="instrument">
                                    instrument
                                </option>
                            </select>
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
                                <option value="">
                                    Select a tribe
                                </option>
                                <option value="kagan">
                                    Kagan
                                </option>
                                <option value="mandaya">
                                    Mandaya
                                </option>
                                <option value="mansaka">
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
                            <textarea name="description"></textarea>
                        </div>
                    </div>
                    <div style="
                        display: grid;
                        grid-template-rows: repeat(2, max-content) 1fr max-content;
                        padding: 1rem;">
                        <div style="
                            padding: 1rem;
                            text-align: center;"
                            id="panelPreview">
                        </div>
                        <div style="
                            padding: 1rem;
                            text-align: center;">
                            <input style="
                                padding: 0rem;
                                width: initial;
                                background-color: transparent;
                                border: none;"
                                type="file"
                                name="file"
                                accept="image/*, video/*, audio/*"
                                id="inputFile"
                                required>
                        </div>
                        <div></div>
                        <div style="
                            padding: 1rem;
                            text-align: center;">
                            <button style="
                                background-color: #5c6;"
                                name="method"
                                value="upload">
                                UPLOAD
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="script.js"></script>
        <script>
            const panelPreview = document.getElementById("panelPreview");
            const inputFile = document.getElementById("inputFile");

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
        </script>
    </body>
</html>