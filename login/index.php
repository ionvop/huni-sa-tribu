<?php

chdir("../");
require_once "common.php";

?>

<html>
    <head>
        <title>
            Login | Huni Sa Tribu
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

            input {
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
            padding: 1rem;
            height: 100%;
            box-sizing: border-box;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/home.jpg');
            background-size: cover;
            background-position: bottom;">
            <div style="
                display: grid;
                grid-template-rows: 1fr repeat(2, max-content) 1fr;
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
                    ADMIN PORTAL
                </div>
                <div style="
                    display: grid;
                    grid-template-columns: 1fr max-content 1fr;">
                    <div></div>
                    <div style="
                        padding: 1rem;
                        width: 30rem;">
                        <form style="
                            padding: 1rem;
                            background-color: #0005;
                            border-radius: 1rem;"
                            action="server.php"
                            method="post"
                            enctype="multipart/form-data">
                            <div style="
                                padding: 1rem;
                                font-weight: bold;">
                                Sign in to your account
                            </div>
                            <div style="
                                padding: 1rem;
                                color: #aaa;">
                                Username
                            </div>
                            <div style="
                                padding: 1rem;
                                padding-top: 0rem;">
                                <input name="username"
                                    required>
                            </div>
                            <div style="
                                padding: 1rem;
                                color: #aaa;">
                                Password
                            </div>
                            <div style="
                                padding: 1rem;
                                padding-top: 0rem;">
                                <input type="password"
                                    name="password"
                                    required>
                            </div>
                            <div style="
                                padding: 1rem;
                                text-align: center;">
                                <button style="
                                    background-color: #5c6;"
                                    name="method"
                                    value="login">
                                    Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                    <div></div>
                </div>
                <div></div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>

        </script>
    </body>
</html>