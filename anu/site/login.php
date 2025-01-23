<?php
// Memastikan koneksi database dengan path yang benar
require_once __DIR__ . '/db.php';
session_start();

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Menggunakan prepared statement untuk mencegah SQL injection
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: /anu/site/site/index.html");
            exit;
        } else {
            $error = "Password yang Anda masukkan salah!";
        }
    } else {
        $error = "Username tidak ditemukan dalam sistem!";
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no">
    <title>Akademik UHO</title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    
    <!-- CSRF Token -->
    <meta name="csrf-param" content="_csrf-frontend">
    <meta name="csrf-token" content="yq_ZpusEk82S9G5Q8Q3Ti_7hluV8WTsp9sXyItUwfZSd_KrAoGzl_NqcDAeIXL7O06v8iwUDbUuisaZ1nAFOpw==">

    <!-- Stylesheets -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/icon.css" rel="stylesheet">
    <link href="css/materialize.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <div class="navborder">
        <nav class="white" role="navigation">
            <div class="nav-wrapper">
            <a id="logo-container" href="/" class="brand-logo"><img src="images/ungu-no-bg2.png" width="170px"></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="/" class="activenav">Home</a></li>
                <!-- <li><a href="#/afiliasi/all" >Pencarian Data</a></li>
                <li><a href="#/repositories/all" >Grafik Statistik</a></li> -->
                <!-- <li><a href="#/search/all" >Info Grafis</a></li> -->
                <!--  <li><a href="#/about" >About</a></li>-->
                <!-- <li><a href="#/suggest" >FAQ</a></li>
                <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">About<i class="material-icons right">arrow_drop_down</i></a></li>
                <ul id="dropdown1" class="dropdown-content">
                <li class="divider"></li>
                <li><a href="#/about/index/1">Siakad</a></li> -->
                <!-- <li><a href="#/about/index/2">Introduce</a></li> -->
                <!-- <li><a href="#">Tutorial</a></li> -->
                <!-- </ul> -->
                <li>
                <a href="/site/login.html">
                    Login
                </a>
                </li>
            </ul>
            <ul id="nav-mobile" class="sidenav" style="transform: translateX(-105%);">
                <li><a href="#/" class="activenav">Home</a></li>
                <li><a href="#/afiliasi/all">Pencarian Data</a></li>
                <li><a href="#/repositories/all">Grafik Statistik</a></li>
                <!-- <li><a href="#/search/all" >Info Grafis</a></li> -->
                <!--  <li><a href="#/about" >About</a></li>-->
                <!--<li><a href="#/suggest" >Suggest</a></li>-->
                <li><a href="#/faq">Faq</a></li>
                <li><a href="#/about">About (Video)</a></li>
                <li>
                <a href="/site/login.html">
                    Login
                </a>
                </li>
            </ul>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            </div>
        </nav>
        </div>
        
        <div class="search-wrapper">
        <div class="row" style="background-color:#4D2BA0;margin-bottom:15px;height:48px;">
            <div class="col s12 l12 m12">
            <div class="row">
                
                
                <div class="col s12 12 m12">
                <nav class="pull-right hide-on-small-only" style="background:none;box-shadow:none;height: 30px;">
                    <ul class="right">
                    <li><a style="color:white;" href="#" class="blinking">Tutorial Siakad </a></li>
                    
                    </ul>
                </nav>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="pola">
        <div class="section" style="background-image: url(images/bg.jpg);background-repeat: no-repeat;background-size: cover;">
            <div class="row">
                <div class="col s2 4 m4">

                

                </div>
                <div class="col s8 4 m4">

                    <div class="site-login">
    <h1>Login</h1>
        <p>Please fill out the following fields to login:</p>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="card-panel">
            <form id="login-form" action="" method="post" onsubmit="return validateLogin()">
                <input type="hidden" name="_csrf-frontend" value="yq_ZpusEk82S9G5Q8Q3Ti_7hluV8WTsp9sXyItUwfZSd_KrAoGzl_NqcDAeIXL7O06v8iwUDbUuisaZ1nAFOpw==">
                
                <div class="form-group">
                    <label for="loginform-username">Username</label>
                    <input type="text" id="loginform-username" class="form-control" name="username" required autofocus>
                </div>

                <div class="form-group">
                    <label for="loginform-password">Password</label>
                    <input type="password" id="loginform-password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="loginform-rememberme" name="LoginForm[rememberMe]" value="1" checked>
                            Remember Me
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
                                
                </div>
                <div class="col s2 4 m4">

                

                </div>
            </div>
        </div>
        </div>
        <div class="footer-header">
        <!-- <div class="">
            <!-- <center>
            <ul>
                <li class="rel-links"><a class="hvr-grow" data-uk-tooltip="" href="http://sinta2.ristekdikti.go.id" target="_blank">Web UHO</a></li>
                <li class="rel-links"><a class="hvr-grow" data-uk-tooltip="" href="http://anjani.ristekdikti.go.id" target="_blank">Wisuda</a></li>
                <li class="rel-links"><a class="hvr-grow" data-uk-tooltip="" href="http://arjuna.ristekdikti.go.id" target="_blank">Sitedi</a></li>
                <li class="rel-links"><a class="hvr-grow" data-uk-tooltip="" href="http://garuda.ristekdikti.go.id" target="_blank">BAK</a></li>
                <li class="rel-links"><a class="hvr-grow" data-uk-tooltip="" href="http://idmenulis.ristekdikti.go.id/" target="_blank">E-Green</a></li>
                <li class="rel-links"><a class="hvr-grow" data-uk-tooltip="" title="Pangkalan Data Pendidikan Tinggi Ristekdikti" href="http://forlap.dikti.go.id" target="_blank">PDDIKTI</a></li>
                <li class="rel-links"><a class="hvr-grow" data-uk-tooltip="" href="http://risbang.ristekdikti.go.id/" target="_blank">Risbang</a></li>
                <li class="rel-links"><a class="hvr-grow" data-uk-tooltip="" href="http://belmawa.ristekdikti.go.id/" target="_blank">Belmawa</a></li>
            </ul>
            </center> 
        </div> -->
        </div>
        <footer class="page-footer teal">
        <div class="row">
            <div class="col ml2 s12 text-center">
            Copyright © 2020  Server 2<br>Universitas Halu Oleo
                All Rights Reserved.
            </div>
        </div>
        
        </footer>
        <script type="text/javascript">
        $(document).ready(function() {
            $('.collapsible').collapsible();
            $('.sidenav').sidenav();
        });
        </script>
        <script type="text/javascript">
        </script>
       

<script src="js/jquery.js"></script>
<script src="js/yii.js"></script>
<script src="js/yii.validation.js"></script>
<script src="js/yii.activeForm.js"></script>
<script src="js/jquery-2.1.1.min.js"></script>
<script src="js/materialize.min.js"></script>
<script src="js/my.js"></script>
<script>jQuery(function ($) {
jQuery('#login-form').yiiActiveForm([{"id":"loginform-username","name":"username","container":".field-loginform-username","input":"#loginform-username","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"Username cannot be blank."});}},{"id":"loginform-password","name":"password","container":".field-loginform-password","input":"#loginform-password","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, {"message":"Password cannot be blank."});}},{"id":"loginform-rememberme","name":"rememberMe","container":".field-loginform-rememberme","input":"#loginform-rememberme","error":".help-block.help-block-error","validate":function (attribute, value, messages, deferred, $form) {yii.validation.boolean(value, messages, {"trueValue":"1","falseValue":"0","message":"Remember Me must be either \u00221\u0022 or \u00220\u0022.","skipOnEmpty":1});}}], []);
});</script>        
    
<script>
function validateLogin() {
    const username = document.getElementById('loginform-username').value;
    const password = document.getElementById('loginform-password').value;
    
    if (!username.trim()) {
        alert('Username tidak boleh kosong');
        return false;
    }
    if (!password.trim()) {
        alert('Password tidak boleh kosong');
        return false;
    }
    return true;
}

// Initialize Materialize components
document.addEventListener('DOMContentLoaded', function() {
    M.Sidenav.init(document.querySelectorAll('.sidenav'));
    M.Collapsible.init(document.querySelectorAll('.collapsible'));
});
</script>
</body></html>