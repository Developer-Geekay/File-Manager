<?php

require_once('config.php');

if(isset($_POST['submit']) && $_POST['submit'] == 'login'){
    Authenticate();
    if($_SESSION['auth_state']){
        redirect('manager.php'. '?p=');
    }else{
        redirect('login.php');
    }
}

include 'header.php';
?>


<div id="wrapper" class="container-fluid fm-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                        <img src="images/logo.png" alt="">
                    </div>
                    <div class="text-center">
                        <h1 class="card-title"><?php echo APP_TITLE; ?></h1>
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <form class="form-signin" action="" method="post" autocomplete="off">
                                <div class="form-group">
                                    <label for="fm_usr">Username</label>
                                    <input type="text" class="form-control" id="fm_usr" name="fm_usr" required>
                                </div>

                                <div class="form-group">
                                    <label for="fm_pwd">Password</label>
                                    <input type="password" class="form-control" id="fm_pwd" name="fm_pwd" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block" role="button" name="submit" value="login">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php 
include 'footer.php'; ?>