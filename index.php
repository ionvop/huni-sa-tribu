<?php

require_once "common.php";
$user = getUser();

if ($_SERVER["REQUEST_URI"] != "/") {
    http_response_code(404);
    exit;
}

if ($user != false) {
    header("Location: home/");
}

?>

<html>
    <head>
        <title>
            Huni Sa Tribu
        </title>
        <base href="./">
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
            padding: 1rem;
            height: 100%;
            box-sizing: border-box;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/home.jpg');
            background-size: cover;
            background-position: bottom;">
            <div style="
                display: grid;
                grid-template-rows: 1fr repeat(2, max-content) 1fr max-content 1fr;
                height: 100%;
                box-sizing: border-box;
                border-radius: 1rem;
                border: 1px solid #fff;">
                <div></div>
                <div style="
                    padding: 1rem;
                    text-align: center;
                    font-size: 1.5rem;
                    font-family: 'Times New Roman', Times, serif;">
                    HUNI SA TRIBU<br>
                    ADMINISTRATIVE ACCESS
                </div>
                <div style="
                    padding: 1rem;
                    text-align: center;">
                    Upload, manage, and update contents.
                </div>
                <div></div>
                <div style="
                    text-align: center;">
                    <a href="login/">
                        <button style="
                            background-color: #5c6;">
                            SIGN IN
                        </button>
                    </a>
                </div>
                <div></div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>

        </script>
    </body>
</html>