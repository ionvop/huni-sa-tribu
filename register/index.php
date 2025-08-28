<?php

chdir("../");
require_once "common.php";

?>

<html>
    <head>
        <title>
            Register
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body > .main {
                & > .content {
                    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("assets/register.jpg");
                    background-size: cover;
                    background-position: bottom;

                    & > .form {
                        margin: auto;
                        width: 30rem;

                        & > .title {
                            font-weight: bold;
                        }

                        & > .form {
                            padding-top: 0rem;

                            & > .box {
                                background-color: #fff5;
                                border-radius: 1rem;

                                & > .title {
                                    padding-bottom: 0rem;
                                }

                                & > .description {
                                    padding-top: 0rem;
                                    color: #555;
                                }

                                & > .tabs {
                                    padding-top: 0rem;

                                    & > .box {
                                        display: grid;
                                        grid-template-columns: repeat(2, 1fr);
                                        background-color: #fff5;
                                        border-radius: 1rem;

                                        & > .tab {
                                            padding: 0.5rem;

                                            & > .box {
                                                padding: 0.5rem;
                                            }
                                        }

                                        & > .register {
                                            & > .box {
                                                background-color: #fff5;
                                                border-radius: 1rem;
                                            }
                                        }
                                    }
                                }

                                & > .field {
                                    & > .input {
                                        padding-top: 0rem;
                                    }
                                }

                                & > .email {
                                    & > .input {
                                        display: grid;
                                        grid-template-columns: 1fr max-content;

                                        & > .verify {
                                            padding-left: 1rem;
                                        }
                                    }
                                }

                                & > .password {
                                    & > .input {
                                        & > .box {
                                            display: grid;
                                            grid-template-columns: 1fr max-content;
                                            background-color: #fff;
                                            border-radius: 1rem;

                                            & > .show {
                                                padding: 0rem 1rem;
                                            }
                                        }
                                    }
                                }

                                & > .send {
                                    & > button {
                                        width: 100%;
                                        background-color: var(--theme-brown-light);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            .-input {
                padding: 0.5rem;
            }

            .-button {
                padding: 0.5rem;
            }

            .-iconlabel {
                & > .label {
                    padding-left: 0.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="main -main">
            <?=renderHeader("login")?>
            <div class="content -center__flex">
                <div class="form">
                    <div class="title -pad -title -center">
                        Admin Portal
                    </div>
                    <div class="form -pad">
                        <form action="server.php" class="-form box" method="post" enctype="multipart/form-data">
                            <div class="title -pad">
                                Staff Authentication
                            </div>
                            <div class="description -pad -subtitle">
                                Sign in to your account or create a new admin account
                            </div>
                            <div class="tabs -pad">
                                <div class="box">
                                    <div class="login tab -pad">
                                        <a href="login/" class="-a box -pad -center">
                                            Sign In
                                        </a>
                                    </div>
                                    <div class="register tab -pad">
                                        <div class="box -pad -center">
                                            Sign Up
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fullname field">
                                <div class="label -pad">
                                    Fullname
                                </div>
                                <div class="input -pad">
                                    <input type="text" class="-input" name="fullname" placeholder="Enter your full name" required maxlength="50">
                                </div>
                            </div>
                            <div class="email field">
                                <div class="label -pad">
                                    Email Address
                                </div>
                                <div class="input -pad">
                                    <div class="input -center__flex">
                                        <input type="text" class="-input" name="email" id="inputEmail" placeholder="Enter your email address" required maxlength="50">
                                    </div>
                                    <div class="verify -center__flex" id="panelVerify">
                                        <button class="-button" onclick="btnVerify_click()">
                                            <div class="-iconlabel">
                                                <div class="icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-287q5 0 10.5-1.5T501-453l283-177q8-5 12-12.5t4-16.5q0-20-17-30t-35 1L480-520 212-688q-18-11-35-.5T160-659q0 10 4 17.5t12 11.5l283 177q5 3 10.5 4.5T480-447Z"/></svg>
                                                </div>
                                                <div class="label">
                                                    Verify
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="username field">
                                <div class="label -pad">
                                    Username
                                </div>
                                <div class="input -pad">
                                    <input type="text" class="-input" name="username" placeholder="Choose a username" required maxlength="20">
                                </div>
                            </div>
                            <div class="password field">
                                <div class="label -pad">
                                    Password
                                </div>
                                <div class="input -pad">
                                    <div class="box">
                                        <div class="input">
                                            <input type="password" class="-input" id="inputPassword" name="password" placeholder="Enter your password" required maxlength="50">
                                        </div>
                                        <div class="show -center__flex" onclick="btnTogglePassword_click()" id="btnTogglePassword">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-134 0-244.5-72T61-462q-5-9-7.5-18.5T51-500q0-10 2.5-19.5T61-538q64-118 174.5-190T480-800q134 0 244.5 72T899-538q5 9 7.5 18.5T909-500q0 10-2.5 19.5T899-462q-64 118-174.5 190T480-200Z"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="repassword password field">
                                <div class="label -pad">
                                    Confirm Password
                                </div>
                                <div class="input -pad">
                                    <div class="box">
                                        <div class="input">
                                            <input type="password" class="-input" id="inputRepassword" name="repassword" placeholder="Enter your password" required maxlength="50">
                                        </div>
                                        <div class="show -center__flex" onclick="btnToggleRepassword_click()" id="btnToggleRepassword">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-134 0-244.5-72T61-462q-5-9-7.5-18.5T51-500q0-10 2.5-19.5T61-538q64-118 174.5-190T480-800q134 0 244.5 72T899-538q5 9 7.5 18.5T909-500q0 10-2.5 19.5T899-462q-64 118-174.5 190T480-200Z"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="send -pad">
                                <button class="-button" name="method" value="register">
                                    Sign Up
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="script.js"></script>
        <script>
            let inputEmail = document.getElementById("inputEmail");
            let panelVerify = document.getElementById("panelVerify");
            let inputPassword = document.getElementById("inputPassword");
            let btnTogglePassword = document.getElementById("btnTogglePassword");
            let inputRepassword = document.getElementById("inputRepassword");
            let btnToggleRepassword = document.getElementById("btnToggleRepassword");
            let passwordVisible = false;
            let repasswordVisible = false;

            async function btnVerify_click() {
                if (confirm(`Is this email correct?\n\n${inputEmail.value}`) == false) return;
                inputEmail.disabled = true;
                let originalPanelVerify = panelVerify.innerHTML;

                panelVerify.innerHTML = /*html*/`
                    <svg width="24px" height="24px" fill="#e3e3e3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z"><animateTransform attributeName="transform" type="rotate" dur="0.75s" values="0 12 12;360 12 12" repeatCount="indefinite"/></path></svg>
                `;

                let response = await fetch("api/", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        method: "send_email_verification",
                        email: inputEmail.value
                    })
                });

                response = await response.json();
                console.log(response);

                if (response.success == false) {
                    inputEmail.disabled = false;
                    panelVerify.innerHTML = originalPanelVerify;
                    alert(response.message);
                    return;
                }

                alert("An email has been sent. Please verify your email within 10 minutes.");

                while (true) {
                    response = await fetch("api/", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            method: "check_email_status",
                            email: inputEmail.value
                        })
                    });

                    response = await response.json();

                    if (response.success) {
                        break;
                    }

                    await new Promise(resolve => setTimeout(resolve, 4000));
                }

                inputEmail.disabled = false;
                inputEmail.readOnly = true;

                panelVerify.innerHTML = /*html*/`
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m382-354 339-339q12-12 28-12t28 12q12 12 12 28.5T777-636L410-268q-12 12-28 12t-28-12L182-440q-12-12-11.5-28.5T183-497q12-12 28.5-12t28.5 12l142 143Z"/></svg>
                `;
            }

            function btnTogglePassword_click() {
                passwordVisible = !passwordVisible;
                
                if (passwordVisible) {
                    inputPassword.type = "text";
                    
                    btnTogglePassword.innerHTML = /*html*/`
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M764-84 624-222q-35 11-71 16.5t-73 5.5q-134 0-245-72T61-462q-5-9-7.5-18.5T51-500q0-10 2.5-19.5T61-538q22-39 47-76t58-66l-83-84q-11-11-11-27.5T84-820q11-11 28-11t28 11l680 680q11 11 11.5 27.5T820-84q-11 11-28 11t-28-11ZM480-320q11 0 21-1t20-4L305-541q-3 10-4 20t-1 21q0 75 52.5 127.5T480-320Zm0-480q134 0 245.5 72.5T900-537q5 8 7.5 17.5T910-500q0 10-2 19.5t-7 17.5q-19 37-42.5 70T806-331q-14 14-33 13t-33-15l-80-80q-7-7-9-16.5t1-19.5q4-13 6-25t2-26q0-75-52.5-127.5T480-680q-14 0-26 2t-25 6q-10 3-20 1t-17-9l-33-33q-19-19-12.5-44t31.5-32q25-5 50.5-8t51.5-3Zm79 226q11 13 18.5 28.5T587-513q1 8-6 11t-13-3l-82-82q-6-6-2.5-13t11.5-7q19 2 35 10.5t29 22.5Z"/></svg>
                    `;
                } else {
                    inputPassword.type = "password";

                    btnTogglePassword.innerHTML = /*html*/`
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-134 0-244.5-72T61-462q-5-9-7.5-18.5T51-500q0-10 2.5-19.5T61-538q64-118 174.5-190T480-800q134 0 244.5 72T899-538q5 9 7.5 18.5T909-500q0 10-2.5 19.5T899-462q-64 118-174.5 190T480-200Z"/></svg>
                    `;
                }
            }

            function btnToggleRepassword_click() {
                repasswordVisible = !repasswordVisible;
                
                if (repasswordVisible) {
                    inputRepassword.type = "text";
                    
                    btnToggleRepassword.innerHTML = /*html*/`
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M764-84 624-222q-35 11-71 16.5t-73 5.5q-134 0-245-72T61-462q-5-9-7.5-18.5T51-500q0-10 2.5-19.5T61-538q22-39 47-76t58-66l-83-84q-11-11-11-27.5T84-820q11-11 28-11t28 11l680 680q11 11 11.5 27.5T820-84q-11 11-28 11t-28-11ZM480-320q11 0 21-1t20-4L305-541q-3 10-4 20t-1 21q0 75 52.5 127.5T480-320Zm0-480q134 0 245.5 72.5T900-537q5 8 7.5 17.5T910-500q0 10-2 19.5t-7 17.5q-19 37-42.5 70T806-331q-14 14-33 13t-33-15l-80-80q-7-7-9-16.5t1-19.5q4-13 6-25t2-26q0-75-52.5-127.5T480-680q-14 0-26 2t-25 6q-10 3-20 1t-17-9l-33-33q-19-19-12.5-44t31.5-32q25-5 50.5-8t51.5-3Zm79 226q11 13 18.5 28.5T587-513q1 8-6 11t-13-3l-82-82q-6-6-2.5-13t11.5-7q19 2 35 10.5t29 22.5Z"/></svg>
                    `;
                } else {
                    inputRepassword.type = "password";

                    btnToggleRepassword.innerHTML = /*html*/`
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#111111"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-134 0-244.5-72T61-462q-5-9-7.5-18.5T51-500q0-10 2.5-19.5T61-538q64-118 174.5-190T480-800q134 0 244.5 72T899-538q5 9 7.5 18.5T909-500q0 10-2.5 19.5T899-462q-64 118-174.5 190T480-200Z"/></svg>
                    `;
                }
            }
        </script>
    </body>
</html>