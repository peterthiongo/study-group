<?php
include 'Classes/DB.php';
session_start();
include 'head.php';
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
		            	Test subject :
	        	</a>
				<br>
	        	<a data-inline="true" style="text-align :center; direction :RTL" data-role="button" href="">
	            	 <?php echo $test->getSubject()?>
	        	</a>
	        	
	        	<br>

	        	<?php foreach ($questionsArr as $question){?>
	        	 <a data-theme="b" data-inline="true"  data-role="button" href="">
		            	Question : 
	        	</a>
	        	<br>
	        	<a data-inline="true" style="text-align :center; direction :RTL" data-role="button" href="">
	            	<?php echo $question->getText()?>
	        	</a>
	        	<br>

	        	
	        	<a data-theme="b" data-inline="true"  data-role="button" href="">
		            	Answers : 
	        	</a>
	        	<?php $answers = $question->getRandomAnswers();?>
		            <select data-inline="true" id="selectmenu1" name="">
		                <option style="text-align :center; direction :RTL" value="value">
		                    <?php echo $answers[0]?>
		                </option>
		                <option style="text-align :center; direction :RTL" value="value">
		                    <?php echo $answers[1]?>
		                </option>
		                <option style="text-align :center; direction :RTL" value="value">
		                   <?php echo $answers[2]?>
		                </option>
		                <option style="text-align :center; direction :RTL" value="value">
		                    <?php echo $answers[3]?>
		                </option>
		            </select>
	        
	        	
	        	<?php } //end of foreach question?>
	        	<br>
	        	<a data-theme="b" data-inline=true  data-role="button" href="">
		            	Date created :
	        	</a>
	        	<br>
	        	<a data-inline="true" style="text-align :center; direction :RTL" data-role="button" href="">
	            	<?php echo $test->getDate()?>
	        	</a>
	        	<br>
	        	<?php 
	        	$userID = $test->getOriginator();
	        	$name =  json_decode(file_get_contents("http://graph.facebook.com/$userID"))->name;
	        	?>
		        <h4>Created by : <?php echo $name?> </h4>
		        <br>
		        <img src="http://graph.facebook.com/<?php echo $userID?>/picture" />
        	
        	<br><br>
        	    <a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
        	</div>


<?php

}//end of if id of test was selected

include 'tail.php';?>