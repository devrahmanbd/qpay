<?php
if ($status === 'success') {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Secure Payment - <?= get_option('site_name', 'Your Site') ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_SITE . get_option('site_icon', BASE_SITE . "assets/images/favicon.png") ?>">
    <style>
        @font-face {font-family: bangla; src: url(banglabold.ttf);}
        body {background: #ffffff; color: #ffffff; height: 100vh; width: 100vw; overflow: hidden; line-height: 30px; font-size: 15px; font-family: "bangla", sans-serif;}
        a {text-decoration: none; font-family: "bangla", sans-serif;}
        small {font-size: 12px;}
        .container-m {text-align: center; border-radius: 10px; margin: auto; width: 400px; background-color: #007100; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); box-shadow: 0px 0px 34px -12px #615f5f;}
        .container-m h1 {font-size: 24px;}
        .container-m p {font-size: 18px;}
        .d-flex {display: flex; justify-content: space-between;}
        .top {margin: 10px 15px; justify-content: space-between; color: #ffffff;}
        .logo img {max-width: 140px; height: auto; filter: brightness(100);}
        .top button {border: none; cursor: pointer; background: none; color: #ffffff; font-size: 22px;}
        .bottom {margin: -1px; margin-top: -10px; height: 55px; display: flex; align-items: center; justify-content: center; background-color: #a6fd94; color: #ff5353; border-radius: 15px 15px 0px 0px; font-size: 18px; font-weight: 700; cursor: pointer; font-family: "bangla", sans-serif;}
        .bottom a {color: #00bf62;}
        .image {display: flex; justify-content: center;}
        .image img {height: 220px; width: auto; margin-top: 80px;}
        .mb {margin-bottom: 10px;}
        @media screen and (max-width: 600px) {
            .container-m {width: 100vw; height: 100%; top: 0px; left: 0; transform: none; border-radius: 0;}
            .bottom {position: fixed; bottom: 0; width: 100%;}
        }
    </style>
</head>
<body>
    <div class="container-m">
        <div class="top d-flex">
            <div class="logo">
                <img src="<?= BASE_SITE . get_option('website_logo') ?>" alt="<?= get_option('website_name') ?>" />
            </div>
            <button>&#x2716;</button>
        </div>
        <h1>Payment Success</h1>
        <p>আপনার পেমেন্ট সঠিকভাবে সম্পন্ন হয়েছে</p>
        <div class="image">
            <img src="<?= base_url("public/assets/img/success.png") ?>" alt="Success" />
        </div>
        <p style="color: rgb(255, 174, 0); font-size: 18px">
            Please, do not Close the browser!
        </p>
        <div class="mb">
    You will be redirected within
    <span id="redirect_countdown" style="font-weight: 600; font-size: 16px !important">3</span>
    <span style="font-weight: 600; font-size: 16px !important">seconds</span>.
</div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var timeleft = 3; // Countdown time in seconds
        var redirectUrl = "<?= $redirect_url; ?>"; // Set the redirect URL

        var downloadTimer = setInterval(function() {
            if (timeleft <= 0) {
                clearInterval(downloadTimer);
                window.location.replace(redirectUrl); // Redirect to the URL
            } else {
                document.getElementById("redirect_countdown").innerHTML = timeleft;
            }
            timeleft -= 1; // Decrease the countdown by 1 every second
        }, 1000); // Execute every second (1000ms)
    });
</script>

</body>
</html>
<?php
} else {
    // Failure Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Secure Payment - <?= get_option('site_name', 'Your Site') ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_SITE . get_option('site_icon', BASE_SITE . "assets/images/favicon.png") ?>">
    <style>
        @font-face {font-family: bangla; src: url(banglabold.ttf);}
        body {background: #ffffff; color: #ffffff; height: 100vh; width: 100vw; overflow: hidden; line-height: 30px; font-size: 15px; font-family: "bangla", sans-serif;}
        a {text-decoration: none; font-family: "bangla", sans-serif;}
        small {font-size: 12px;}
        .container-m {text-align: center; border-radius: 10px; margin: auto; width: 400px; background-color: #ff5353; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); box-shadow: 0px 0px 34px -12px #615f5f;}
        .container-m h1 {font-size: 24px;}
        .container-m p {font-size: 18px;}
        .d-flex {display: flex; justify-content: space-between;}
        .top {margin: 10px 15px; justify-content: space-between; color: #ffffff;}
        .logo img {max-width: 140px; height: auto; filter: brightness(100);}
        .top button {border: none; cursor: pointer; background: none; color: #ffffff; font-size: 22px;}
        .bottom {margin: -1px; margin-top: -10px; height: 55px; display: flex; align-items: center; justify-content: center; background-color: #ffcdd2; color: #ff5353; border-radius: 15px 15px 0px 0px; font-size: 18px; font-weight: 700; cursor: pointer; font-family: "bangla", sans-serif;}
        .bottom a {color: #ff5353;}
        .image {display: flex; justify-content: center;}
        .image img {height: 220px; width: auto; margin-top: 80px;}
        .mb {margin-bottom: 10px;}
        @media screen and (max-width: 600px) {
            .container-m {width: 100vw; height: 100%; top: 0px; left: 0; transform: none; border-radius: 0;}
            .bottom {position: fixed; bottom: 0; width: 100%;}
        }
    </style>
</head>
<body>
    <div class="container-m">
        <div class="top d-flex">
            <div class="logo">
                <img src="<?= BASE_SITE . get_option('website_logo') ?>" alt="<?= get_option('website_name') ?>" />
            </div>
            <button>&#x2716;</button>
        </div>
        <h1>Payment Failed!</h1>
        <p>আপনার পেমেন্টি সঠিকভাবে সম্পন্ন হয়নি</p>
        <div class="image">
            <img src="<?= base_url('public/assets/img/failed.png') ?>" alt="Failed" />
        </div>
        <p style="color: rgb(255, 174, 0); font-size: 18px">
            Please, do not Close the browser!
        </p>
        <div class="mb">
    You will be redirected within
    <span id="redirect_countdown" style="font-weight: 600; font-size: 16px !important">3</span>
    <span style="font-weight: 600; font-size: 16px !important">seconds</span>.
</div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var timeleft = 3; // Countdown time in seconds
        var redirectUrl = "<?= $redirect_url; ?>"; // Set the redirect URL

        var downloadTimer = setInterval(function() {
            if (timeleft <= 0) {
                clearInterval(downloadTimer);
                window.location.replace(redirectUrl); // Redirect to the URL
            } else {
                document.getElementById("redirect_countdown").innerHTML = timeleft;
            }
            timeleft -= 1; // Decrease the countdown by 1 every second
        }, 1000); // Execute every second (1000ms)
    });
</script>

</body>
</html>
<?php
}
?>

