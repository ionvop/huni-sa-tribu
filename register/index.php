<?php

chdir("../");
require_once "common.php";

?>

<html>
    <head>
        <title>
            Register | Huni Sa Tribu
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
                                Sign Up
                            </div>
                            <div id="panelStep1">
                                <div style="
                                    padding: 1rem;
                                    color: #aaa;">
                                    Last name
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;">
                                    <input name="lastname"
                                        id="inputLastName"
                                        required>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    color: #aaa;">
                                    First name
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;">
                                    <input name="firstname"
                                        id="inputFirstName"
                                        required>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    text-align: center;">
                                    <button style="
                                        background-color: #000;"
                                        type="button"
                                        id="btnStep1Next">
                                        Next
                                    </button>
                                </div>
                            </div>
                            <div style="
                                display: none;"
                                id="panelStep2">
                                <div style="
                                    padding: 1rem;
                                    color: #aaa;">
                                    Email address
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;">
                                    <input type="email"
                                        name="email"
                                        id="inputEmail"
                                        required>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    text-align: center;">
                                    <button style="
                                        background-color: #000;"
                                        type="button"
                                        id="btnStep2Next">
                                        Next
                                    </button>
                                </div>
                            </div>
                            <div style="
                                display: none;"
                                id="panelStep3">
                                <div style="
                                    padding: 1rem;
                                    color: #aaa;">
                                    Username
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;">
                                    <input name="username"
                                        id="inputUsername"
                                        required>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    text-align: center;">
                                    <button style="
                                        background-color: #000;"
                                        type="button"
                                        id="btnStep3Next">
                                        Next
                                    </button>
                                </div>
                            </div>
                            <div style="
                                display: none;"
                                id="panelStep4">
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
                                        id="inputPassword"
                                        required>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    color: #aaa;">
                                    Confirm password
                                </div>
                                <div style="
                                    padding: 1rem;
                                    padding-top: 0rem;">
                                    <input type="password"
                                        name="repassword"
                                        id="inputRepassword"
                                        required>
                                </div>
                                <div style="
                                    padding: 1rem;
                                    text-align: center;">
                                    <button style="
                                        background-color: #5c6;"
                                        name="method"
                                        value="register">
                                        Sign Up
                                    </button>
                                </div>
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
            const panelStep1 = document.getElementById("panelStep1");
            const inputLastName = document.getElementById("inputLastName");
            const inputFirstName = document.getElementById("inputFirstName");
            const btnStep1Next = document.getElementById("btnStep1Next");
            const panelStep2 = document.getElementById("panelStep2");
            const inputEmail = document.getElementById("inputEmail");
            const btnStep2Next = document.getElementById("btnStep2Next");
            const panelStep3 = document.getElementById("panelStep3");
            const inputUsername = document.getElementById("inputUsername");
            const btnStep3Next = document.getElementById("btnStep3Next");
            const panelStep4 = document.getElementById("panelStep4");
            const inputPassword = document.getElementById("inputPassword");
            const inputRepassword = document.getElementById("inputRepassword");

            btnStep1Next.onclick = () => {
                if (inputLastName.value == "" || inputFirstName.value == "") return;
                panelStep1.style.display = "none";
                panelStep2.style.display = "block";
            }

            btnStep2Next.onclick = () => {
                if (inputEmail.value == "") return;
                panelStep2.style.display = "none";
                panelStep3.style.display = "block";
            }

            btnStep3Next.onclick = () => {
                if (inputUsername.value == "") return;
                panelStep3.style.display = "none";
                panelStep4.style.display = "block";
            }
        </script>
    </body>
</html>