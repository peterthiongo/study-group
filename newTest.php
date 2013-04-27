<?php
include 'head.php';
include 'Classes/DB.php';
session_start();

//get user details
$user = $_SESSION['user'];

//open DB 
$DB = new DB();

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
	//user created a new test - get its name
	$test = new Test($_POST['testName'],$user->getId());
	//get the test subject
	$test->setSubject($_POST['subject']);
	//indicate we can start questions input
	$testHasName = true;
	//check if test is public
	if ($_POST['public'] == 'on')
		$test->setPublic(true);
	else
		$test->setPublic(false);
}


//check for input from pre question 
if (isset($_POST['question'])){
	//get all user input fields
	$text = $_POST['question'];
	$right = str_replace(",", "|", $_POST['rAnswer']);
	$Answers = array();
	$Answers[]= str_replace(",", "|", $_POST['w1Answer']);
	$Answers[]= str_replace(",", "|", $_POST['w2Answer']);
	$Answers[]= str_replace(",", "|", $_POST['w3Answer']);
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
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group - Create New Test
                </h3>
        		<a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
            </div>
            
<?php 
//if this is a new test - ask for its name            
if (!$testHasName){ ?>

<div align="center">
	<form action="newTest.php" method="post" id="form"> 
		<div align='center' data-role="fieldcontain">
			<h2 align='center'>
				Test Name:
			</h2>
            <input name="testName" id="textinput1" placeholder="" value="" type="text">
            
			<h2 align='center'>
				Test Subject:
			</h2>
            <input name="subject" id="textinput1" placeholder="" value="" type="text">
            <br>
            <br>
            <div align="center">
	            <select name="public" id="toggleswitch1" data-theme="b" data-role="slider" size="width=800">
             	    <option value="on">
	                    public
	                </option>
	                <option value="off">
	                    private
	                </option>
	            </select>
	            <p align="center">public test will show for all users</p>
            </div>
            
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
$DB->saveTestToDB($test);
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
include 'tail.php';
?>
