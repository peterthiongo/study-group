<?php  
include 'Classes/DB.php';
session_start();
include 'head.php';
$DB=new DB();

$facebook=$DB->facebook;

//check login status of user :
// Get User ID
$facebookUser = $DB->facebook->getUser();
// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.


if ($facebookUser) {
	try {
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
		$userName=$user_profile['name'];

		$userID=$user_profile['id'];
		$user = new User($userID,$userName);
		$_SESSION['user'] = $user;
	} catch (FacebookApiException $e) {
			error_log($e);
			$facebookUser = false;
	}
}

if ($facebookUser) {

//create the request for invetation
$canvas_page = "http://apps.facebook.com/study_group/index.php";

$message = "Study Group - create and answer tests online";
$app_id = 'XX';
$filter=urlencode("['app_non_users']");

$requests_url = "http://www.facebook.com/dialog/apprequests?&filters=$filter&app_id="
                . $app_id . "&redirect_uri=" . urlencode($canvas_page)
                . "&title=Join us - StudyGroup&message=" . $message;

if (empty($_REQUEST["request_ids"])) {
        $_SESSION['invite']=true;
        echo("<script> top.location.href='" . $requests_url . "'</script>");
} else {
        $_SESSION['userMsg']="Thanks for sharing our app !";
        header("Location: index.php");
        break;
}

} 
include 'tail.php';


?>