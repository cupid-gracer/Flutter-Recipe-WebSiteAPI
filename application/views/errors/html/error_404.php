<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$site_url = ((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http';
$site_url .= '://' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
$site_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$site_url = str_replace("admin/", "", $site_url);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Error</title>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            * {
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
            }

            body {
                padding: 0;
                margin: 0;
            }

            #notfound {
                position: relative;
                height: 100vh;
            }

            #notfound .notfound {
                position: absolute;
                left: 50%;
                top: 50%;
                -webkit-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .notfound {
                max-width: 410px;
                width: 100%;
                text-align: center;
            }

            .notfound .notfound-404 {
                height: 280px;
                position: relative;
                z-index: -1;
            }

            .notfound .notfound-404 h1 {
                font-family: 'Montserrat', sans-serif;
                font-size: 230px;
                margin: 0px;
                font-weight: 900;
                position: absolute;
                left: 50%;
                -webkit-transform: translateX(-50%);
                -ms-transform: translateX(-50%);
                transform: translateX(-50%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-size: cover;
                background-position: center;
            }


            .notfound h2 {
                font-family: 'Montserrat', sans-serif;
                color: #000;
                font-size: 24px;
                font-weight: 700;
                text-transform: uppercase;
                margin-top: 0;
            }

            .notfound p {
                font-family: 'Montserrat', sans-serif;
                color: #000;
                font-size: 14px;
                font-weight: 400;
                margin-bottom: 20px;
                margin-top: 0px;
            }

            .notfound a {
                font-family: 'Montserrat', sans-serif;
                font-size: 14px;
                text-decoration: none;
                text-transform: uppercase;
                background: #0046d5;
                display: inline-block;
                padding: 15px 30px;
                border-radius: 40px;
                color: #fff;
                font-weight: 700;
                -webkit-box-shadow: 0px 4px 15px -5px #0046d5;
                box-shadow: 0px 4px 15px -5px #0046d5;
            }


            @media only screen and (max-width: 767px) {
                .notfound .notfound-404 {
                    height: 142px;
                }
                .notfound .notfound-404 h1 {
                    font-size: 112px;
                }
            }
        </style>
    </head>
    <body>
        <div id="notfound">
            <div class="notfound">
                <div class="icon">
                    <img src="<?php echo $site_url; ?>assets/images/error.png" alt="error img" />
                </div>
                <h2><?php echo $heading; ?></h2>
                <p><?php echo $message; ?></p>
                <a href="<?php echo $site_url; ?>">Go To Homepage</a>
            </div>
        </div>
    </body>
</html>

