<?php

include "common.php";
$user = getUser();

if ($user == false) {
    header("Location: login/");
    exit();
}

?>

<html>
    <head>
        <title>
            Home
        </title>
        <base href="./">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body > .main {
                & > .content {
                    padding: 5rem;

                    & > .title {
                        color: #11c36d;
                        font-weight: bold;
                    }

                    & > .description {
                        color: #555;
                        font-weight: bold;
                    }

                    & > .pages {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        padding-top: 5rem;

                        & > .page {
                            & > .box {
                                border: 3px solid #555;
                                border-radius: 1rem;

                                & > .icon {
                                    & > .box {
                                        border-radius: 50%;
                                    }
                                }

                                & > .description {
                                    color: #555;
                                    font-weight: bold;
                                }

                                & > .summary {
                                    display: grid;
                                    grid-template-columns: repeat(2, 1fr);

                                    & > .item {
                                        display: grid;
                                        grid-template-columns: max-content 1fr;

                                        & > .icon {
                                            & > .box {
                                                border-radius: 50%;
                                                width: 1rem;
                                                height: 1rem;
                                            }
                                        }
                                    }
                                }

                                & > .button {
                                    & > button {
                                        width: 100%;
                                        color: #fff;
                                    }
                                }
                            }
                        }

                        & > .content {
                            & > .box {
                                & > .icon {
                                    & > .box {
                                        background-color: #91d6b5;
                                    }
                                }

                                & > .summary {
                                    & > .item {
                                        & > .icon {
                                            & > .box {
                                                background-color: #91d6b5;
                                            }
                                        }
                                    }
                                }

                                & > .button {
                                    & > button {
                                        background-color: #00823c;
                                    }
                                }
                            }
                        }

                        & > .visitor {
                            & > .box {
                                & > .icon {
                                    & > .box {
                                        background-color: #9c857a;
                                    }
                                }

                                & > .summary {
                                    & > .item {
                                        & > .icon {
                                            & > .box {
                                                background-color: #9c857a;
                                            }
                                        }
                                    }
                                }

                                & > .button {
                                    & > button {
                                        background-color: #5a321e;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        </style>
    </head>
    <body>
        <div class="main -main">
            <?=renderHeader("home")?>
            <div class="content -pad">
                <div class="title -pad -title -center">
                    Admin Portal
                </div>
                <div class="description -pad -center">
                    Manage museum content, track visitor engagement, and oversee the<br>
                    cultural heritage preservation system.
                </div>
                <div class="pages">
                    <div class="content page -pad">
                        <div class="box -pad">
                            <div class="icon -pad -center__flex">
                                <div class="box -pad">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#00de38"><path d="M400-120q-66 0-113-47t-47-113q0-66 47-113t113-47q23 0 42.5 5.5T480-418v-382q0-17 11.5-28.5T520-840h160q17 0 28.5 11.5T720-800v80q0 17-11.5 28.5T680-680H560v400q0 66-47 113t-113 47Z"/></svg>
                                </div>
                            </div>
                            <div class="title -pad -title -center">
                                Content Management
                            </div>
                            <div class="description -pad -center">
                                Manage cultural artifacts, music, instruments, and video content
                            </div>
                            <div class="summary">
                                <div class="item">
                                    <div class="icon -pad">
                                        <div class="box">

                                        </div>
                                    </div>
                                    <div class="label -pad">
                                        All Content
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon -pad">
                                        <div class="box">
                                            
                                        </div>
                                    </div>
                                    <div class="label -pad">
                                        Music Library
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon -pad">
                                        <div class="box">

                                        </div>
                                    </div>
                                    <div class="label -pad">
                                        Instruments
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon -pad">
                                        <div class="box">

                                        </div>
                                    </div>
                                    <div class="label -pad">
                                        Video Content
                                    </div>
                                </div>
                            </div>
                            <a href="content/" class="-a button -pad">
                                <button class="-button">
                                    Access Content Management
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="visitor page -pad">
                        <div class="box -pad">
                            <div class="icon -pad -center__flex">
                                <div class="box -pad">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#5a321e"><path d="M40-272q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v32q0 33-23.5 56.5T600-160H120q-33 0-56.5-23.5T40-240v-32Zm698 112q11-18 16.5-38.5T760-240v-40q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v40q0 33-23.5 56.5T840-160H738ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113Z"/></svg>
                                </div>
                            </div>
                            <div class="title -pad -title -center">
                                Visitor Management
                            </div>
                            <div class="description -pad -center">
                                Track visitors, manage QR codes, and view analytics
                            </div>
                            <div class="summary">
                                <div class="item">
                                    <div class="icon -pad">
                                        <div class="box">

                                        </div>
                                    </div>
                                    <div class="label -pad">
                                        Visitor Tracking
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon -pad">
                                        <div class="box">

                                        </div>
                                    </div>
                                    <div class="label -pad">
                                        QR Codes
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon -pad">
                                        <div class="box">

                                        </div>
                                    </div>
                                    <div class="label -pad">
                                        Analytics
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon -pad">
                                        <div class="box">

                                        </div>
                                    </div>
                                    <div class="label -pad">
                                        Engagement
                                    </div>
                                </div>
                            </div>
                            <div class="button -pad">
                                <button class="-button">
                                    Access Visitor Management
                                </button>
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