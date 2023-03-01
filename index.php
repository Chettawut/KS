<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>เทพกระษัตรี2019 ( ศูนย์ประสานงานช่วยเหลือแรงงานภูเก็ต )
    </title>

    <?php include_once('css.php'); ?>
    <link rel="icon" href="img/logo_main.jpg">
    <style>
    * {
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, "segoe ui", roboto, oxygen, ubuntu, cantarell, "fira sans", "droid sans", "helvetica neue", Arial, sans-serif;
        font-size: 16px;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    @media screen and (max-width: 480px) {
        .login {
            width: 200px;
        }
    }

    @media (min-width:1025px) {
        .login {
            width: 200px;
        }
    }

    .login {
        width: 380px;
        background-color: #ffffff;
        box-shadow: 0 0 9px 0 rgba(0, 0, 0, 0.3);
        margin: 100px auto;
    }

    .login h4 {
        text-align: center;
        color: #5b6574;
        font-size: 24px;
        padding: 15px 0 10px 0;
        border-bottom: 1px solid #83AF9B;
    }

    .login form {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding-top: 20px;
    }

    .login form label {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 50px;
        height: 50px;
        background-color: #83AF9B;
        color: #ffffff;
    }

    .login form input[type="password"],
    .login form input[type="text"] {
        width: 290px;
        height: 50px;
        border: 1px solid #dee0e4;
        margin-bottom: 20px;
        padding: 0 15px;
    }

    .login form input[type="submit"] {
        width: 100%;
        padding: 15px;
        margin-top: 20px;
        background-color:  #83AF9B ;
        border: 0;
        cursor: pointer;
        font-weight: bold;
        color: #ffffff;
        transition: background-color 0.2s;
    }

    .login form input[type="submit"]:hover {
        background-color: #2F9599 ;
        transition: background-color 0.2s;
    }

    .modal-css {
        pointer-events: auto;
        width: 100%;
    }
    </style>
</head>

<body>

    <?php include_once('header.php'); ?>

    <?php 
    if(isset($_GET['log']))
    {
        if($_GET['log']=='username')
        $message = "Username ไม่ถูกต้อง";
        else if($_GET['log']=='password')
        $message = "Password ไม่ถูกต้อง";
        else if($_GET['log']=='disable')
        $message = "คุณไม่ได้เป็นพนักงานบริษัทนี้แล้ว";
        echo "<script type='text/javascript'>alert('$message');</script>";
        // header( "Location: index.php");
        echo "<script type='text/javascript'>window.location.replace('..');</script>";

    }
    ?>
    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                
            </div>
        </div>
    </div>


    <?php include_once('footer.php'); ?>


</body>

</html>