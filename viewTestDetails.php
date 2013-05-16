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
            <div align="center">
	         	<a data-theme="a" data-inline="true"  data-role="button" href="">
		            	Test name :
	        	</a>
	         	<a data-inline="true"  style="text-align :center; direction :RTL" data-role="button" href="">
		            	<?php echo $test->getTestName()?>
	        	</a>
	        	<br>
	         	<a data-theme="a" data-inline="true"  data-role="button" href="">
		            	Test subject :
	        	</a>
	        	<a data-inline="true" style="text-align :center; direction :RTL" data-role="button" href="">
	            	 <?php echo $test->getSubject()?>
	        	</a>
	        	<br>
	        	<a data-theme="a" data-inline="true"  data-role="button" href="">
		            	Date created :
	        	</a>
	        	<a data-inline="true" style="text-align :center; direction :RTL" data-role="button" href="">
	            	<?php echo $test->getDate()?>
	        	</a>
	        	<br>
	        	<a data-theme="a" data-inline="true"  data-role="button" href="">
		            	Created by :
	        	</a>
	        	<a data-inline="true" style="text-align :center; direction :RTL" data-role="button" href="">
	           		<?php echo $test->getOriginator()?>
	        	</a>
	        	<br><br>
               <a style="width: 250px;" data-inline="true" data-theme="b" data-role="button" href="viewTest.php?id=<?php echo $test->getId()?>">
                    	View Test
               </a>
               <a style="width: 250px;" data-inline="true" data-theme="b" data-role="button" href="answer.php?id=<?php echo $test->getId()?>&q=1">
                    	Answer Test
               </a>
  
        	
        	</div>

<?php

}//end of if id of test was selected

include 'tail.php';?>