<?php
    ob_start("ob_gzhandler");
if(!strip_tags($_GET['img']) || !isset($_GET['img']) || $_GET['img'] == "" ){
	// If they tried to access this file directly, send them elsewhere
	header("Location http://yourhomepageORerrorpage.com/index.php");
}

// We keep user authentication in a session, so we'll need access to that
session_start();

$reqpath = strip_tags($_GET['img']); // Use strip_tags to be safer

// User albums are structured like so
// ourURL.com/me/userphotos/<username>/<album>/...
// $reqpath will now have the <username>/<album>/... part
// <username> matches the username stored in the session variable
// so we get a substring from the start of $reqpath to the first /

$foundslash = strpos($reqpath,'/');  // Get the position of the first slash

if($foundslash === FALSE){  // $foundslash could return 0 or other "false" variables, use ===
	header("Location:http://phphosting.osvin.net/couponApp");
}

// Save their username off...
$username = substr($reqpath,0,$foundslash);

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache,must-revalidate");
header("Cache-Control: post-check=0, pre-check=0",false);
header("Pragma: no-cache");
header("Content-type: image/jpeg");

// Assume they aren't authorized unless everything lines up
$authed = FALSE;
if($_SESSION['validated'] && $_SESSION['uid'] == $username){
    $authed = TRUE; // By requireding validated and uid to be correct
		    // We prevent loggedin users from seeing other people's
		    // pictures
} 

if($authed){
    // If they're authorized, read userphotos/$PATH
    // The .htaccess file is in userphotos (since that's the top level we care to protect)
    // so the path is relative to that folder. auth.php is up one level to keep photos
    // and code as separate as possible
    @readfile("userphotos/".strip_tags($_GET['img'])); // Read and send image file
}else{
    @readfile("./path/to/jpg/to/use/if/not/authed.jpg");
}
?>