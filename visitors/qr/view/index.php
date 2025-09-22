<?php

chdir("../../../");
require_once "common.php";
$db = new SQLite3("database.db");

if (isset($_GET["id"]) == false) {
    alert("This QR does not exist.");
}

$query = <<<SQL
    SELECT * FROM `qr` WHERE `id` = :id
SQL;

$stmt = $db->prepare($query);
$stmt->bindValue(":id", $_GET["id"]);
$qr = $stmt->execute()->fetchArray();

$query = <<<SQL
    SELECT * FROM `content` WHERE `id` = :id
SQL;

$stmt = $db->prepare($query);
$stmt->bindValue(":id", $qr["content_id"]);
$content = $stmt->execute()->fetchArray();

?>

<html>
    <head>
        <title>
            New Content | Huni Sa Tribu
        </title>
        <base href="../../../">
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
                    href="visitors/qr/">
                    BACK
                </a>
                <div></div>
            </div>
            <div style="
                padding: 1rem;
                padding-top: 5rem;
                font-size: 2rem;
                font-weight: bold;">
                EDIT
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
                            NAME
                        </div>
                        <div style="
                            padding: 1rem;
                            padding-top: 0rem;">
                            <input value="<?=$content['title']?>"
                                disabled>
                        </div>
                        <div style="
                            padding: 1rem;
                            font-weight: bold;">
                            STATUS
                        </div>
                        <div style="
                            padding: 1rem;
                            padding-top: 0rem;">
                            <select name="status"
                                required>
                                <option value="active"
                                    <?=$qr["status"] == "active" ? "selected" : ""?>>
                                    Active
                                </option>
                                <option value="inactive"
                                    <?=$qr["status"] == "inactive" ? "selected" : ""?>>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                    <div style="
                        display: grid;
                        grid-template-rows: max-content 1fr max-content;
                        padding: 1rem;">
                        <div style="
                            padding: 1rem;
                            text-align: center;">
                            <img style="
                                width: 10rem;
                                height: 10rem;"
                                src=""
                                id="imgQr">
                        </div>
                        <div></div>
                        <div style="
                            display: grid;
                            grid-template-columns: 1fr repeat(2, max-content) 1fr;">
                            <div></div>
                            <div style="
                                padding: 1rem;">
                                <button style="
                                    background-color: #000a;"
                                    name="method"
                                    value="deleteQr"
                                    id="btnDelete">
                                    <div style="
                                        display: grid;
                                        grid-template-columns: repeat(2, max-content);">
                                        <div style="
                                            display: flex;
                                            align-items: center;">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-120q-33 0-56.5-23.5T200-200v-520q-17 0-28.5-11.5T160-760q0-17 11.5-28.5T200-800h160q0-17 11.5-28.5T400-840h160q17 0 28.5 11.5T600-800h160q17 0 28.5 11.5T800-760q0 17-11.5 28.5T760-720v520q0 33-23.5 56.5T680-120H280Zm120-160q17 0 28.5-11.5T440-320v-280q0-17-11.5-28.5T400-640q-17 0-28.5 11.5T360-600v280q0 17 11.5 28.5T400-280Zm160 0q17 0 28.5-11.5T600-320v-280q0-17-11.5-28.5T560-640q-17 0-28.5 11.5T520-600v280q0 17 11.5 28.5T560-280Z"/></svg>
                                        </div>
                                        <div style="
                                            display: flex;
                                            align-items: center;
                                            padding-left: 1rem;">
                                            Delete
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <div style="
                                padding: 1rem;">
                                <button style="
                                    background-color: #5c6;"
                                    name="method"
                                    value="editQr">
                                    <div style="
                                        display: grid;
                                        grid-template-columns: repeat(2, max-content);">
                                        <div style="
                                            display: flex;
                                            align-items: center;">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h447q16 0 30.5 6t25.5 17l114 114q11 11 17 25.5t6 30.5v447q0 33-23.5 56.5T760-120H200Zm280-120q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM280-560h280q17 0 28.5-11.5T600-600v-80q0-17-11.5-28.5T560-720H280q-17 0-28.5 11.5T240-680v80q0 17 11.5 28.5T280-560Z"/></svg>
                                        </div>
                                        <div style="
                                            display: flex;
                                            align-items: center;
                                            padding-left: 1rem;">
                                            Save
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <div></div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?=$qr['id']?>">
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
        <script src="script.js"></script>
        <script>
            const imgQr = document.getElementById("imgQr");
            const btnDelete = document.getElementById("btnDelete");
            const qrContent = <?=json_encode($qr["code"])?>;
            
            QRCode.toDataURL(qrContent, (err, url) => {
                if (err) {
                    throw err;
                }

                imgQr.src = url;
            });

            btnDelete.onclick = () => confirm("Are you sure you want to delete this QR?");
        </script>
    </body>
</html>