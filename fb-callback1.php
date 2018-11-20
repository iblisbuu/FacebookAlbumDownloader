<?php 
require_once "config.php";
?>	
<html>
<head>
	<title>User Album</title>
	<link rel="stylesheet" href="lib/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
</head>
<script>
	function hello(id){
		alert(id);
	}
	function showHint(id) {
		var str = id;
    if (str.length == 0) { 
        document.getElementById("sliderBox").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("sliderBox").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "photos.php?album_id=" + str, true);
        xmlhttp.send();
    }
}
</script>
<body>
<?php
try {
	$accessToken = $helper->getAccessToken();
} catch (\Facebook\Exceptions\FacebookResponseException $e) {
	echo "Response Exception: " . $e->getMessage();
	exit();
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
	echo "SDK Exception: " . $e->getMessage();
	exit();
}
$oAuth2Client = $FB->getOAuth2Client();
if (!$accessToken->isLongLived())
	$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
$response = $FB->get("/me?fields=first_name", $accessToken);
$userData = $response->getGraphNode();
$userId = $userData['id'];
$userName = $userData['first_name'];
$_SESSION['userName'] = $userName;
$response = $FB->get("/{$userId}/albums?fields=id,name,cover_photo,count", $accessToken);
$userData = $response->getGraphEdge()->asArray();
echo '<form action="multipledown.php">';
echo "<div class='row'>";
$userAlbumId = array();
foreach($userData as $data){
	$id = isset($data['id'])?$data['id']:'';
	$name = isset($data['name'])?$data['name']:'';
	$cover_photo_id = isset($data['cover_photo']['id'])?$data['cover_photo']['id']:'';
	$count = isset($data['count'])?$data['count']:'';
	$downloadLink = "download.php?album_id={$id}&album_name={$name}";
	$displayLink = "photos.php?album_id={$id}";
	$drivelink ="movetodrive.php?album_id={$id}&album_name={$name}&access_token={$accessToken}";
	echo "<div class='fb-album col-md-3' style='padding:10px;text-align:center;'>";
	// echo "<a href='{$displayLink}'>";
	echo "<img src='https://graph.facebook.com/v2.9/{$cover_photo_id}/picture?access_token={$accessToken}' alt='' style='height:200px;width:200px;border-radius:10%;' onclick='showHint({$id});'/>";
	//onclick='hello({$id});'
	// echo "</a>";
	echo "<h3>{$name}</h3>";
	$photoCount = ($count > 1)?$count. 'Photos':$count. 'Photo';
	echo "<p><span style='color:#888;'>{$photoCount}</p>";
	echo "<p><a href= '{$downloadLink}'>Download Album</a>";  
	echo "<a href= '{$drivelink}'> / Move in Drive /  </a>";
	echo "<input name='select[]' type='checkbox' class='select' value='{$id}'/></p>";
	echo "</div><br>";
}
echo "</div>";
echo '<input type="submit" name="multiple_down" value="Download Selected" class="margin-bottom margin-left text-center btn btn--green btn-animated" >';
echo '<input type="submit" name="multiple_upload" value="Upload Selected" class="margin-bottom margin-left text-center btn btn--green btn-animated">';
echo '</form>';
	$_SESSION['fbaccess_token'] = (string) $accessToken;
	$alldownloadLink = "alldownload.php?access_token={$accessToken}";
	$allmovetodrive = "allmovetodrive.php?access_token={$accessToken}";
echo "<div class='row '>";
	echo "<a href='{$alldownloadLink}' class='margin-left text-center btn btn--green btn-animated'>Download All Albums</a>";
	echo "<a href='{$allmovetodrive}' class='margin-left text-center btn btn--green btn-animated'>all move to drive</a>";
echo "</div>";
	//header('Location: index.php');
//var_dump($userAlbumId);
?>
<!-- <div class="slideshow-container" >
<div class="mySlides fade" id="myvideo"> -->
<div id="sliderBox">
	
</div>
<!-- </div>
</div> -->
<script>
	var slideIndex = 0;
showSlides();
function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; 
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1} 
    slides[slideIndex-1].style.display = "block"; 
    setTimeout(showSlides, 3000); // Change image every 2 seconds
}
var elem = document.documentElement;
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}
</script>
</body>
</html>
