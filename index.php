<?php  
include 'head.php';
include 'Classes/DB.php';

session_start();
//check for user
if (isset($_SESSION['user']))
	$user = $_SESSION['user'];


//check if user aborted creating a test
if (isset($_SESSION['newTest']))
	unset($_SESSION['newTest']);

//new user, create http://localhost/study/?user=1
else{
	//for testing purpose this will be a facebook user
	if (isset($_GET['user']))
		$user = new User(2,'Phillip');
	else
		$user = new User(1,'Nimrod');
	
	//save the user to the session
	$_SESSION['user'] = $user;
}

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
                	<a style="width: 250px;" data-inline="true" data-theme="a" data-role="button" href="www.testStatistics.com">
                    	tests statistics
                	</a>
                 </div>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-theme="e" data-role="button" href="www.aboutOrHelp.com">
                    	about / help
                	</a>
                </div>
            </div>

<?php include 'tail.php';?>