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
                    Study Group - View "<?php echo $test->getTestName()?>" Test
                </h3>
        		<a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
            </div>
            <br>
            <br>
         	<a data-role="button" href="">
            	Test name : <?php echo $test->getTestName()?>
        	</a>
        	<a data-role="button" href="">
            	Test subject : <?php echo $test->getSubject()?>
        	</a>
        	
        	<?php foreach ($questionsArr as $question){?>
        	<a data-role="button" href="">
            	question : <?php echo $question->getText()?>
        	</a>
        	<div align="center" data-role="fieldcontain">
        	<?php $answers = $question->getRandomAnswers();?>
	            <select id="selectmenu1" name="">
	                <option value="value">
	                    1)<?php echo $answers[0]?>
	                </option>
	                <option value="value">
	                    2)<?php echo $answers[1]?>
	                </option>
	                <option value="value">
	                   3)<?php echo $answers[2]?>
	                </option>
	                <option value="value">
	                    4)<?php echo $answers[3]?>
	                </option>
	            </select>
        	</div>
        	
        	<?php } //end of foreach question?>
        	<a data-role="button" href="">
            	<?php echo $test->getDate()?>
        	</a>
        	<a data-role="button" href="">
           		<?php echo $test->getOriginator()?>
        	</a>

<?php

}//end of if id of test was selected

include 'tail.php';?>