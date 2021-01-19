<?php
    session_start();
    require_once "app/php/Modal.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- config -->
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <title>Document</title>
    <!-- end config -->

    <!-- libs -->

    <!-- bootstrap -->
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- end libs -->

    <!-- site libs -->
    <script data-main="libs/main" src="libs/require.js"></script>

    <link rel="stylesheet" href="libs/css/main.css">
    <!-- end site libs -->
</head>

<body>
    <div class="body_background">
        <div class="over_Shadow">
            <div class="login_entry">
                <h1>Sign In</h1>
                <form action="/app/php/control/signin.php" method="POST">
                    <div class="form_input_text">
                        <img src="res/images/icons/user.png" alt="">
                        <input type="text" name="userName" placeholder="Username" onfocus="render_outline()"  onfocusout="render_outline_hide()" required>
                    </div>
                    <div class="form_input_text">
                        <img src="res/images/icons/email.png" alt="" >
                        <input type="Email" name="email" placeholder="Email" onfocus="render_outline()"  onfocusout="render_outline_hide()" required>
                    </div>
                    <div class="form_input_text form_input_password">
                        <img src="res/images/icons/password.png" alt="">
                        <input type="password" name="password" placeholder="Password" onfocus="render_outline()" onfocusout="render_outline_hide()" required>
                        <img src="res/images/icons/view.png" alt="" onclick="password_toggle()">
                    </div>
                    <div class="button_element">
                    <button type="Submit" name="Submit">Submit</button>
                    <button type="Reset" >Reset</button>
                    </div>
                </form>
                <a href="">Forgot Password</a>
            </div>
            <div class="system_heading">
                <h2>Hilltop Wines & Spirits</h2>
            </div>
        </div>    
    </div>
</body>
</html>