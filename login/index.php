<html>
    <head>
        <title>
            Login
        </title>
        <base href="../">
        <link rel="stylesheet" href="style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body > .main {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                background-color: #cfc;
                min-height: 100%;

                & > .content {
                    display: grid;
                    grid-template-rows: 1fr max-content 1fr;

                    & > .login {
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

                        & > .password {
                            & > .forgot {
                                display: grid;
                                grid-template-columns: 1fr max-content;
                            }
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
                <form class="-form login" action="server.php" method="post" enctype="multipart/form-data">
                    <div class="title -pad -title -center">
                        Login
                    </div>
                    <div class="subtitle -pad -center">
                        Sign-in to continue
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
                    <div class="email field">
                        <div class="label -pad">
                            Email / Contact #
                        </div>
                        <div class="input -pad">
                            <input class="-input" name="email" placeholder="example@gmail.com" required>
                        </div>
                    </div>
                    <div class="password field">
                        <div class="label -pad">
                            Password
                        </div>
                        <div class="input -pad">
                            <input class="-input" type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="forgot">
                            <div></div>
                            <a class="-a button -pad" href="forgot/">
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                    <div class="submit -pad -center">
                        <button class="-button" name="method" value="login">
                            Sign-in
                        </button>
                    </div>
                    <div class="register -pad -center">
                        <a class="-a" href="register/">
                            Don't have an account?
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