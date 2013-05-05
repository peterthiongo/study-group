<?php
include 'head.php';
include 'Classes/DB.php';

session_start();

//create DB 
$DB = new DB();

//check for user
if (isset($_SESSION['user']))
	$user = $_SESSION['user'];


//get test user choose to view :
if (isset($_GET['id'])){
	$test = $DB->getTestFromDB($_GET['id']);
	$questionsArr = $test->getQuestions();
?>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group - Begin test "<?php echo $test->getTestName()?>"
                </h3>
        		<a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
            </div>

            <br>
            <br>
            <div align="center">
	         	<a data-theme="c" data-inline="true"  data-role="button" href="">
		            	Test name :
	        	</a>
	        	<a data-inline="true" style="text-align :center; direction :RTL" data-role="button" href="">
	            	 <?php echo $test->getTestName()?>
	        	</a>
	        	<br>
	        	<div style=" text-align:center">              
                   <img style="width: 600px; height: 300px" src="excellent.png" />
            	</div>
	         	<p>
	         	*Your actions & answers are monitored for statistic usage
	         	</p>
        		<br>
        	    <a data-role="button" data-inline="true" data-theme="b" href="answer.php?id=<?php echo $test->getId()?>&q=1">
           			 Start Test
           		</a>
        	</div>
<?php

}//end of if id of test was selected

include 'tail.php';?>