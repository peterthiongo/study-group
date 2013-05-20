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
?>

        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group
                </h3>
            </div>
            <div data-role="content">
                <h2 align='center'>
                    Hi <?php echo $user->getName();?> 
                    <br>
                    <img src="http://graph.facebook.com/<?php echo $facebookUser?>/picture?type=normal" />
                    <br>
                    Welcome to Study Group 
                </h2>
                 <div style=" text-align:center">
                	<a href="index.php">               
                        <img style="width: 160px; height: 200px" src="exam.png" />
                	</a>
                </div>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-theme="b" data-role="button" href="viewTests.php">
                    	view/answer tests
                	</a>
                </div>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-role="button" href="newTest.php">
                    	create new test
                	</a>
                 </div>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-theme="a" data-role="button" href="viewTestStatistics.php">
                    	tests statistics
                	</a>
                 </div>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-theme="c" data-role="button" href="facebookInvite.php">
                    	invite facebook friends
                	</a>
                </div>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-theme="e" data-role="button" href="about.php">
                    	about / help
                	</a>
                </div>
            </div>

<?php }
else { //let user register with facebook first 
$button1TXT = "Login";
$params = array(
		redirect_uri => "http://www.nimrod-lahav.com/study/"
);
$txt=$DB->facebook->getLoginUrl($params);
$button1URL = $txt;

?>
   <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group
                </h3>
            </div>
            <div data-role="content">
                <h2 align='center'>
                   Hi, please sign in with facebook before using this app
                    <br>
                    <br>
                </h2>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-theme="a" data-role="button" href="<?php echo $button1URL?>">
                    	<?php echo $button1TXT?>
                	</a>
                 </div>
                </div></div> 
<?php } include 'tail.php';?>