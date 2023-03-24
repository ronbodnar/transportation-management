<div class="container">
    <div class="row d-flex flex-column flex-sm-row justify-content-center align-items-center">
        <div class="col-md-8 login-form">
            <div class="login-form-logo">
                <img src="<?php echo getRelativePath(); ?>assets/img/header.png?v=<?php filemtime(getRelativePath() . 'assets/img/header.png'); ?>" />
            </div>

            <form class="form-signin" id="loginForm" action="<?php echo getRelativePath(); ?>login.php" method="POST" novalidate>
                <h5 class="h5 m-4 text-center">Account Login</h5>

                <div id="message" class="text-danger text-center"></div>

                <div class="form-group">
                    <label for="username" style="margin-left: 1px;">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
                </div>

                <div class="form-group">
                    <label class="mt-3" for="password" style="margin-left: 1px;">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                </div>

                <button class="btn btn-mron mt-5" type="submit">Log in</button>

                <div class="pt-4">
                    <p class="small">
                        <a href="" id="forgotPassword">Forgot password?</a>
                    </p>
                </div>
            </form>

            <form class="form-signin" id="forgotPasswordForm" action="<?php echo getRelativePath(); ?>login.php" method="POST" style="display: none;" novalidate>
                <h5 class="text-muted m-4 text-center">Reset Password</h5>

                <div id="message" class="text-danger text-center"></div>

                <div class="form-group">
                    <label for="recoveryUsername" style="margin-left: 1px;">E-mail or Username</label>
                    <input type="text" name="recoveryUsername" id="recoveryUsername" class="form-control" placeholder="" required autofocus>
                </div>

                <button class="btn btn-mron mt-4" type="submit">Reset Password</button>

                <div class="pt-4">
                    <p class="small">
                        <a href="" id="backToLogin">Back to log in</a>
                    </p>
                </div>
            </form>
        </div>
    </div>