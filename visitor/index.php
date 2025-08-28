<?php

chdir("../");
require_once "common.php";

?>

<html>
    <head>
        <title>
            Visitor Management
        </title>
        <base href="../">
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
                    overflow: auto;
                    background-color: #f5fafa;

                    & > .cards {
                        display: grid;
                        grid-template-columns: repeat(4, 1fr);

                        & > .card {
                            & > .box {
                                background-color: #fff;
                                border-radius: 1rem;
                                border: 1px solid #555;
                            }
                        }
                    }

                    & > .table {
                        & > .box {
                            border-radius: 1rem;
                            overflow: auto;
                            border: 1px solid #555;
                            background-color: #fff;

                            & > .table {
                                padding-top: 1rem;
                                min-height: 20rem;

                                & > table {
                                    border-collapse: collapse;
                                    width: 100%;

                                    & > thead {
                                        position: sticky;
                                        top: 0rem;
                                        background-color: #f5fafa;
                                        border-bottom: 1px solid #555;

                                        & > tr {
                                            & > th {
                                                padding: 1rem;   
                                            }
                                        }
                                    }

                                    & > tbody {
                                        background-color: #fff;

                                        & > tr {
                                            border-bottom: 1px solid #aaa;
                                        }
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
        <div class="main">
            <?=renderNavigation("visitor", "visitor")?>
            <div class="content">
                <div class="title -pad -title">
                    Visitor Tracking
                </div>
                <div class="description -pad">
                    Monitor visitor engagement across web and mobile platforms
                </div>
                <div class="cards">
                    <div class="visitors card -pad">
                        <div class="box">
                            <div class="label -pad">
                                Total Visitors
                            </div>
                            <div class="value -pad -title">
                                0
                            </div>
                            <div class="details -pad -subtitle">
                                +0% from last week
                            </div>
                        </div>
                    </div>
                    <div class="interactions card -pad">
                        <div class="box">
                            <div class="label -pad">
                                Content Interactions
                            </div>
                            <div class="value -pad -title">
                                0
                            </div>
                            <div class="details -pad -subtitle">
                                App interactions
                            </div>
                        </div>
                    </div>
                    <div class="score card -pad">
                        <div class="box">
                            <div class="label -pad">
                                Total App Score
                            </div>
                            <div class="value -pad -title">
                                0 min
                            </div>
                            <div class="details -pad -subtitle">
                                +0 min from last week
                            </div>
                        </div>
                    </div>
                    <div class="return card -pad">
                        <div class="box">
                            <div class="label -pad">
                                Return Visitors
                            </div>
                            <div class="value -pad -title">
                                0%
                            </div>
                            <div class="details -pad -subtitle">
                                Visitors returning
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table -pad">
                    <div class="box">
                        <div class="title -pad -title">
                            Detailed Visitor Engagement
                        </div>
                        <div class="description -pad">
                            Tracking of visitor interactions with content
                        </div>
                        <div class="table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            School
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Content Viewed
                                        </th>
                                        <th>
                                            Type
                                        </th>
                                        <th>
                                            Favorite Content
                                        </th>
                                        <th>
                                            Return Visitor
                                        </th>
                                        <th>
                                            Engagement
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // TODO
                                    ?>
                                </tbody>
                            </table>
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