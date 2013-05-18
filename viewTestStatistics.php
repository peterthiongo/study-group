<?php
include 'Classes/DB.php';
session_start();
include 'head.php';
$DB=new DB();

if (isset($_SESSION['user'])){
	$user = $_SESSION['user'];
	if (isset($_GET['id'])){
		$test = $DB->getTestFromDB($_GET['id']);
		$questionsArr = $test->getQuestions();
		
		//get how many people answered the test
		$totalUsersAnswered = $DB->getAmountOfUserAnsweredTest($test->getId());
		//get total attempts
		$totalAttempts = $DB->getTotalAttemptsForTest($test->getId());
		//get average test time of the test
		$averageTestTime = $DB->getAverageTestTime($test->getId());
		//show all question 
		
		//each question show pie of corect and wrong 
	?>
	        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group - View Test Statistics
                </h3>
        		<a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
            </div>
	          <div align="center">
	         	<h4>Test name :</h4>
	         	<a data-inline="true"  style="text-align :center; direction :RTL" data-role="button" href="">
		            	<?php echo $test->getTestName()?>
	        	</a>
	         	<h4>Total User Answered This Test : <?php echo $totalUsersAnswered?></h4>
	         	<h4>Total Attempts for this Test : <?php echo $totalAttempts?></h4>
	        	<h4>Average Test Time (in seconds) : <?php echo $averageTestTime?></h4>
	        	<?php $questionNum=0; foreach ($questionsArr as $question){ ?>
	        	<h4>Question : <?php echo $questionNum+1?></h4>
	        	<a data-inline="true" style="text-align :center; direction :RTL" data-role="button" href="">
	            	<?php echo $question->getText()?>
	        	</a>
	        	<h4>Average Answer Time (sec) : <?php echo $DB->getAverageTimeForQuestion($test->getId(),$questionNum)?></h4>
	        	<h4>Answers :</h4>
	        	<?php $answers = $question->getAnswers();?>
	        	<font color="5360ff"><h5>1)  <?php echo $answers[0]?></h5></font>	        	
	        	<font color="ff1e30"><h5>2)  <?php echo $answers[1]?></h5></font>	        	
	        	<font color="0b8500"><h5>3) <?php echo $answers[2]?></h5></font>        	
	        	<font color="7006ff"><h5>4)  <?php echo $question->getRightAnswer();?></h5></font>
	        	<?php 
	        	//calculate questions total answers
	        	$answersArr = serialize($DB->getQuestionPieChart($questionNum, $test->getId()));
	        	?>
	        	<img src="pie.php?title=Answer Pie&data=<?php echo $answersArr?>" />        	
	        	<?php $questionNum++; } //end of foreach question?>
	        	<br>
	        	<h4>Date created : <?php echo $test->getDate()?></h4>
		        <h4>Created by : <?php echo $test->getOriginator()?></h4>
        	    <a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
        	</div>	
<?php 
} else {
	//get all tests
	$testsArr = $DB->getUsersTests($user->getId());

?>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group - View Test Statistics
                </h3>
        		<a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
            </div>
<br>
            	<h3 align="center">Click on a test to see its statistics</h3>
            	<h5 align="center">* You can only view test you answered</h5>
                <h5 align="center">currently <?php echo count($testsArr)?> tests in the system you have answered : </h5>
                
         <ul  data-role="listview" data-divider-theme="b" data-inset="true">

            <?php foreach ($testsArr as $test){?>
            <li  data-theme="c">
                <a style="text-align :center; dir :RTL" href="viewTestStatistics.php?id=<?php echo $test->getId()?>" data-transition="pop">
                    <?php echo $test->getTestName()?>
                </a>
            </li>
            
            <?php  }} //end of foreach test?>
        </ul>
   

<?php } include 'tail.php';?>