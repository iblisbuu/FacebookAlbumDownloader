<?php 
require_once "config.php";
?>
<html lang="en">
<head>
  <title>Album Photos</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<style>
* {box-sizing: border-box}
body {font-family: Verdana, sans-serif; margin:0}
.mySlides {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 3s;
  animation-name: fade;
  animation-duration: 3s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}
.text-center{
    text-align:center !important;
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text {font-size: 11px}
}
</style>
<body>
<button class='text-center btn btn--green btn-animated' onclick="openFullscreen();">Open Fullscreen</button>

<?php
$album_id = isset($_GET['album_id'])?$_GET['album_id']:header("Location: index.php");
$accessToken = $_SESSION['fbaccess_token'];
$response = $FB->get("/{$album_id}/photos?fields=source&limit=100", $accessToken);
$userData = $response->getGraphEdge();
$userData1 = $userData->asArray();
if($FB->next($userData))
{
    $nextFeed = $FB->next($userData)->asArray();
    $userData = array_merge($userData1,$nextFeed);
}
$imgLink = array();
// echo "<div class='container'>";
// echo "<div class='row'>";
foreach($userData as $data){
    $imgId = isset($data['id'])?$data['id']:'';
    $imgSource = isset($data['source'])?$data['source']:'';
    array_push($imgLink, $imgSource);
    echo '<div class="slideshow-container" >';
    echo ' <div class="mySlides fade" id="myvideo">';
    echo  "<img src='{$imgSource}' style='height:450px;width:775px;border-radius:2%;' alt=''>";
    echo '</div>';
    echo '</div>';
    }
?>

</body>
</html>