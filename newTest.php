<?php
include 'Classes/DB.php';
session_start();
//$DB = new DB();

//will indicate if user finished entering the question for the test
$finishTest = false;
//will indicate if user allready gave this test a name
$testHasName = true;
//will indicate if user wished to delete this test and go back to menu
$canelTest = false;

//check if this is a open test or a new test
if (isset($_SESSION['newTest']))
	$test = $_SESSION['newTest'];
else{
	$testHasName = false;
}

//check if user entered a test name
if (isset($_POST['testName'])){
	//user created a new test
	$test = new Test($_POST['testName']);
	$testHasName = true;
}


//check for input from pre question 
if (isset($_POST['question'])){
	//get all user input fields
	$text = $_POST['question'];
	$right = $_POST['rAnswer'];
	$Answers = array();
	$Answers[]= $_POST['w1Answer'];
	$Answers[]= $_POST['w2Answer'];
	$Answers[]= $_POST['w3Answer'];
	$question = new Question($text, $Answers, $right);
	//add them to the test
	$test->addQuestion($question);
}

//check if user finished the tests
if (isset($_POST['Finish'])){
	$finishTest = true;
	
}

//check if user canceled the tests
if (isset($_POST['Cancel'])){
	$canelTest = true;
}




//if we have a test opened allready get details and save :
if (isset($test)){
	//check question number
	$questionNumber = $test->getQuestionAmount()+1;
	
	//save tests into session
	$_SESSION['newTest'] = $test;
	
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title>
        </title>
        <link rel="stylesheet" href="https://s3.amazonaws.com/codiqa-cdn/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
        <link rel="stylesheet" href="my.css" />
        <script src="https://s3.amazonaws.com/codiqa-cdn/jquery-1.7.2.min.js">
        </script>
        <script src="https://s3.amazonaws.com/codiqa-cdn/mobile/1.2.0/jquery.mobile-1.2.0.min.js">
        </script>
        <script src="my.js">
        </script>
        <!-- User-generated css -->
        <style>
        </style>
        <!-- User-generated js -->
        <script>
            try {

    $(function() {

    });

  } catch (error) {
    console.error("Your javascript has an error: " + error);
  }
        </script>
    </head>
    <body>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group - Create New Test
                </h3>
            </div>
            
<?php 
//if this is a new test - ask for its name            
if (!$testHasName){ ?>

<div align="center">
	<form action="newTest.php" method="post" id="form"> 
		<div align='center' data-role="fieldcontain">
			<h2 align='center'>
				Enter Test Name:
			</h2>
            <input name="testName" id="textinput1" placeholder="" value="" type="text">
        </div>
		<input name="Submit" data-inline="true"  type="submit" value="Create Test" />
	</form>
</div>

<?php
} //end of testHasName if           

//user has allready enterd the name , continue to ask for questions :
else if (!$finishTest){ ?>
            
<div data-role="content">

	<h2 align='center'>
		Test Name : <?php echo $test->getTestName();?>
	</h2>
	
	<h3 align='center'>
		Question: <?php echo $questionNumber?>
	</h3>
	
	<form action="newTest.php" method="post" id="form">
	<br>
		<div align='center' data-role="fieldcontain">
			<h4 align='center'>Enter Question Text :</h4>
			<textarea name="question" id="textarea1" placeholder=""></textarea>
		</div>
		
        <div align='center' data-role="fieldcontain">
        	<h4 align='center'>Right Answer:</h4>
            <input name="rAnswer" id="textinput1" placeholder="" value="" type="text">
        </div>
        
        <div align='center' data-role="fieldcontain">
			<h4 align='center'>Wrong Answer #1:</h4>
            <input name="w1Answer" id="textinput2" placeholder="" value="" type="text">
        </div>
        
        <div align='center' data-role="fieldcontain">
			<h4 align='center'>Wrong Answer #2:</h4>
            <input name="w2Answer" id="textinput3" placeholder="" value="" type="text">
        </div>
        
        <div align='center' data-role="fieldcontain">
			<h4 align='center'>Wrong Answer #3:</h4>
            <input name="w3Answer" id="textinput4" placeholder="" value="" type="text">
        </div>
        
        <input name="Submit" data-inline="true"  type="submit" value="Next Question" />
        <input name="Finish" data-inline="true"  type="submit" value="Finish Test" />
        <input name="Cancel" data-inline="true"  type="submit" value="Cancel Test" />

 	</form>
  
<?php }
//end of $finishTest check
//check if user wished to delete this test
else if ($canelTest){
unset($_SESSION['newTest']);
?>
	<div align="center">
	<br>
	<h2 align='center'>Test Discarded</h2>
	<br>
		<a data-role="button"  data-inline="true" href="index.php">
           main menu
        </a>
	</div>
	
<?php

} 
//end of $canelTest
//user finished entering the question show the test and button
else{
unset($_SESSION['newTest']);
?>
	<div align="center">
	<br>
	<h2 align='center'>Test Saved</h2>
	<br>
		<a data-role="button"  data-inline="true" href="index.php">
            main menu
        </a>
	</div>
	
<?php
}

?>
      </div>
            <div data-theme="a" data-role="footer" data-position="fixed">
                <h3>
                    Nimrod Lahav app
                </h3>
            </div>
        </div>
    </body>
</html>
