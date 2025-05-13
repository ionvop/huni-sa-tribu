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
                display: grid;
                grid-template-columns: 1fr 2fr 1fr;
                background-color: #cfc;
                min-height: 100%;

                & > .content {
                    display: grid;
                    grid-template-rows: 1fr max-content 1fr;

                    & > .register {
                        & > .socials {
                            display: grid;
                            grid-template-columns: 1fr repeat(2, max-content) 1fr;

                            & > .icon {
                                & > img {
                                    width: 2rem;
                                    height: 2rem;
                                }
                            }
                        }

                        & > .columns {
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
                        }
                    }
                }
            }
        </style>
    </head>
    <body>
        <div class="main">
            <div></div>
            <div class="content">
                <div></div>
                <form class="-form register" action="server.php" method="post" enctype="multipart/form-data">
                    <div class="title -pad -title -center">
                        Create new Account
                    </div>
                    <div class="subtitle -pad -center">
                        Sign-up to continue
                    </div>
                    <div class="socials">
                        <div></div>
                        <div class="google icon -pad">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg">
                        </div>
                        <div class="facebook icon -pad">
                            <img src="https://www.svgrepo.com/show/448224/facebook.svg">
                        </div>
                        <div></div>
                    </div>
                    <div class="columns">
                        <div class="column1 column">
                            <div class="username field">
                                <div class="label -pad">
                                    Username
                                </div>
                                <div class="input -pad">
                                    <input class="-input" name="username" placeholder="JohnDoe" required>
                                </div>
                            </div>
                            <div class="lastname field">
                                <div class="label -pad">
                                    Lastname
                                </div>
                                <div class="input -pad">
                                    <input class="-input" name="lastname" placeholder="Doe" required>
                                </div>
                            </div>
                            <div class="email field">
                                <div class="label -pad">
                                    Email
                                </div>
                                <div class="input -pad">
                                    <input class="-input" type="email" name="email" placeholder="example@gmail.com" required>
                                </div>
                            </div>
                            <div class="password field">
                                <div class="label -pad">
                                    Password
                                </div>
                                <div class="input -pad">
                                    <input class="-input" type="password" name="password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="repassword field">
                                <div class="label -pad">
                                    Re-type Password
                                </div>
                                <div class="input -pad">
                                    <input class="-input" type="password" name="repassword" placeholder="Re-type Password" required>
                                </div>
                            </div>
                        </div>
                        <div class="column2 column">
                            <div class="birthdate field">
                                <div class="label -pad">
                                    Birthdate
                                </div>
                                <div class="input -pad">
                                    <input class="-input" type="date" name="birthdate" required>
                                </div>
                            </div>
                            <div class="firstname">
                                <div class="label -pad">
                                    Firstname
                                </div>
                                <div class="input -pad">
                                    <input class="-input" name="firstname" placeholder="John" required>
                                </div>
                            </div>
                            <div class="contact field">
                                <div class="label -pad">
                                    Contact #
                                </div>
                                <div class="input -pad">
                                    <input class="-input" type="tel" name="contact" placeholder="09123456789" required>
                                </div>
                            </div>
                            <div class="gender field">
                                <div class="label -pad">
                                    Gender
                                </div>
                                <div class="input -pad">
                                    <select class="-select" name="gender" required>
                                        <option value="">
                                            Select gender
                                        </option>
                                        <option value="male">
                                            Male
                                        </option>
                                        <option value="female">
                                            Female
                                        </option>
                                        <option value="other">
                                            Other
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit -pad -center">
                        <button class="-button" name="method" value="register">
                            Sign-in
                        </button>
                    </div>
                    <div class="login -pad -center">
                        <a class="-a" href="login/">
                            Already have an account?
                        </a>
                    </div>
                </form>
                <div></div>
            </div>
            <div></div>
        </div>
        <script src="script.js"></script>
        <script>
            
        </script>
    </body>
</html>