<?php
include 'head.php';
include 'Classes/DB.php';

session_start();

//create DB 
$DB = new DB();

//check for user
if (isset($_SESSION['user']))
	$user = $_SESSION['user'];



if (isset($_GET['id'])){
	$test = $DB->getTestFromDB($_GET['id']);
	$questionsArr = $test->getQuestions();
	
	//get how many people answered the test
	
	//get average answer time of the test
	
	//show all question 
	
	//each question show pie of corect and wrong 
	
	//each question show average answer time
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
	        	<a data-theme="b" data-inline="true"  data-role="button" href="">
		            	Created by :
	        	</a>
	        	<br>
	        	<a data-inline="true" style="text-align :center; direction :RTL" data-role="button" href="">
	           		<?php echo $test->getOriginator()?>
	        	</a>
        	
        	<br><br>
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
   

<?php include 'tail.php';?>