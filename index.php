<?php
	require_once "config.php";
	$redirectURL = "https://enigmatic-dawn-26709.herokuapp.com/fb-callback.php";
	$permissions = ['user_photos'];
	$loginURL = $helper->getLoginUrl($redirectURL, $permissions);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
    <link rel="stylesheet" href="lib/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>
	<!-- <nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="index.php" style="font-size: 40px !important;">Facebook Album Downloader</a>
</nav> -->
 <header class="header">
            <div class="header__text-box">
                <h1 class="heading-primary">
                    <span class="heading-primary--main">Facebook</span>
                    <span class="heading-primary--sub">Album Downloader</span>
                </h1>
                <a href="<?php echo $loginURL; ?>" class="btn btn--white btn--animated">Login with Facebook</a>
            </div>
        </header>
</body>
</html>
