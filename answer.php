<?php
include 'head.php';
include 'Classes/DB.php';

session_start();

//create DB 
$DB = new DB();

//check for user
if (isset($_SESSION['user']))
	$user = $_SESSION['user'];

//save user start question time
$time=time(true);

//get test user choose to view :
if (isset($_GET['id'])){
	$test = $DB->getTestFromDB($_GET['id']);
	$questionsArr = $test->getQuestions();
	
	//check on which question the user is 
	if (isset($_GET['q'])){
		$questionNumber = $_GET['q'];
		//if this is the first question we creat a user turn
		if ($questionNumber == 1){
			$turn = new Turn($test->getId(),$user->getId());
			$_SESSION['turn'] = $turn;
		}
		//the user is in the middle of the turn and take it from session
		else if (isset($_SESSION['turn'])){
			$turn = $_SESSION['turn'];
		
			//take the users answer
			$userAnswer = $_GET['answer'];
			$userAnswer = $DB->makeSafe($userAnswer);
			
			//check if the user is right or wrong 
			if ($userAnswer == RIGHT_ANSWER)
				$turn->userAnswerdRight();
			else
				$turn->userAnswerdWrong();
			//take the user time
			$answerTime = $time - $_GET['time'];
			$answerTime = $DB->makeSafe($answerTime);
			$turn->setAnswerTime($answerTime);
			$turn->setAnswers($userAnswer);
			
			if ($questionNumber == count($questionsArr)+1){
				$turn->calculateTurnScore();
				$turn->calculateTotalTime();
			}
		}
		else $turn = $_SESSION['turn'];
		
	}
?>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group - View "<?php echo $test->getTestName()?>" Test
                </h3>
        		<a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
            </div>
            <br>
            <br>
<?php 	

	if ($questionNumber <= count($questionsArr)){
	//get the question
	$question = $questionsArr[$questionNumber-1];
?>

            <div align="center">
	         	<a data-theme="b" data-inline="true"  data-role="button" href="">
		            	Test name :
	        	</a>
	        	<br>
	         	<a data-inline="true"  style="text-align :center; direction :RTL" data-role="button" href="">
		            	<?php echo $test->getTestName()?>
	        	</a>
	        	<br>
	        	 <a data-theme="b" data-inline="true"  data-role="button" href="">
		            	Question <?php echo $questionNumber?>:
	        	</a>
	        	<br>
	        	<a data-inline="true" style="text-align :center; direction :RTL" data-role="button" href="">
	            	<?php echo $question->getText()?>
	        	</a>
	        	<br>

	        	<a data-theme="b" data-inline="true"  data-role="button" href="">
		            	Answers 
	        	</a>
	        	<br>
	        	<h4 align="center">*choose from 1 answer below (click on it)</h4>
	        	<div style=" text-align:center">              
                   <img style="width: 100px; height: 100px" src="greenArrow.png" />
            	</div>
	        	<?php $answers = $question->getRandomAnswersIndexed();
	        	$answer1 = explode("|||",$answers[0]);
	        	$answer2 = explode("|||",$answers[1]);
	        	$answer3 = explode("|||",$answers[2]);
	        	$answer4 = explode("|||",$answers[3]);
	        	?>
						<br>
		                <a  data-theme="c" data-role="button" style="text-align :center; direction :RTL" href="answer.php?id=<?php echo $_GET['id']?>&q=<?php echo $questionNumber+1?>&answer=<?php echo $answer1[1]?>&time=<?php echo $time?>">
		                    <?php echo $answer1[0]?>
		                </a>
		                <br>
		                <a data-theme="c"  data-role="button" style="text-align :center; direction :RTL" href="answer.php?id=<?php echo $_GET['id']?>&q=<?php echo $questionNumber+1?>&answer=<?php echo $answer2[1]?>&time=<?php echo $time?>">
		                    <?php echo $answer2[0]?>
		                </a>
		                <br>
		                <a  data-theme="c" data-role="button" style="text-align :center; direction :RTL" href="answer.php?id=<?php echo $_GET['id']?>&q=<?php echo $questionNumber+1?>&answer=<?php echo $answer3[1]?>&time=<?php echo $time?>">
		                   <?php echo $answer3[0]?>
		                </a>
		                <br>
		                <a  data-theme="c" data-role="button" style="text-align :center; direction :RTL" href="answer.php?id=<?php echo $_GET['id']?>&q=<?php echo $questionNumber+1?>&answer=<?php echo $answer4[1]?>&time=<?php echo $time?>">
		                    <?php echo $answer4[0]?>
		                </a>
		            
		            <br>
        	</div>


<?php
	}else {//user finished the test ?>
	        	<div style=" text-align:center">              
                   <img style="width: 300px; height: 50px" src="Finished.png" />
            	</div>
            	<br>
            	<div align="center">
            	<h3>Your Test Results</h3>
	        	</div>
            <?php for ($i = 0 ; $i < count($questionsArr) ; $i++){?>
            <div align="center">
            	<br>
                <h4>
                    Question <?php echo $i+1?>
                </h4>
                <a style="text-align :center; dir :RTL">
                    <?php echo $questionsArr[$i]->getText();?>
                </a><br>
                <h5>
                   Your Answer :
                </h5>
                <a style="text-align :center; dir :RTL">
                   <?php 
                   $answerArr = $turn->getAnswers();
                   $answer = $answerArr[$i];
                   
                   if ($answer == RIGHT_ANSWER)
                   		$answerText = $questionsArr[$i]->getRightAnswer();
                   else{
                   		$answerText = $questionsArr[$i]->getAnswers();
                   		$answerText = $answerText[$answer];
					}
                   	echo $answerText;	?>
                </a>
                <h5>
                   You Were : <?php echo $turn->getRightOrWrong($i)?>
                </h5>
                <?php $results = $turn->getResults(); if (!$results[$i]){?>
	                <h5>
	                   Right Answer :
	                </h5>
	                <a style="text-align :center; dir :RTL">
	                   <?php echo $questionsArr[$i]->getRightAnswer();?>
	                </a><br>
                <?php }?>
                <h5>
                   You answered in  : <?php $time = $turn->getAnswerTime(); echo $time[$i]?> seconds
                </h5>        	        	
            <?php  } //end of foreach question?>	
                <br><br>
               <h3>
                   Total Score : <?php echo $turn->getTotalRightAnswers()?> / <?php echo count($questionsArr)?> 
               </h3>
               <h3>
                   Your Grade : <?php echo $turn->getScore()?>
                </h3>
               <h3>
                   Total Test Time (sec) : <?php echo $turn->getTotalTime()?>
                </h3>
                <a data-role="button"  data-inline="true" href="index.php">
            		main menu
            	</a> 
              </div> 
              <?php 
              //write this turn into DB
              $DB->writeTurnToDB($turn);
              ?>

<?php 
}//end of user finished the test
	
	
}//end of if id of test was selected

include 'tail.php';?>