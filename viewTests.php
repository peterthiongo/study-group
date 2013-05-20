<?php
include 'Classes/DB.php';
session_start();
include 'head.php';
//create DB 
$DB = new DB();
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
	$friends = $facebook->api('/me/friends');
	$friendsIdArr = array();
	foreach ($friends['data'] as $friend){
		$friendsIdArr[]=$friend['id'];
	}
}


//get all tests
$testsArr = $DB->getAllTest();
$testsArrFinal  = array();
foreach ($testsArr as $test){
	if ($test->getPublic())
		$testsArrFinal[]=$test;
	else{
		//check if this test originator is my friend
		$originator = $test->getOriginator();
		if (in_array($originator,$friendsIdArr))
			$testsArrFinal[]=$test;
	}
}

?>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group - View & Answer Tests
                </h3>
        		<a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
            </div>
<br>
            	<h3 align="center">Click on any test to start</h3>
                <h5 align="center">currently <?php echo count($testsArrFinal)?> tests in the system : </h5>
                
         <ul  data-role="listview" data-divider-theme="b" data-inset="true">

            <?php foreach ($testsArrFinal as $test){?>
            <li  data-theme="c">
                <a style="text-align :center; dir :RTL" href="viewTestDetails.php?id=<?php echo $test->getId()?>" data-transition="pop">
                    <?php echo $test->getTestName()?>
                </a>
            </li>
            
            <?php  } //end of foreach test?>
        </ul>

<?php include 'tail.php';?>