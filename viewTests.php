<?php
include 'Classes/DB.php';
session_start();
include 'head.php';
//create DB 
$DB = new DB();

//check for user
if (isset($_SESSION['user']))
	$user = $_SESSION['user'];


//get all tests
$testsArr = $DB->getAllTest();

?>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group - View & Answer Tests
                </h3>
        		<a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
            </div>
<br>
            	<h3 align="center">Click on any test to start</h3>
                <h5 align="center">currently <?php echo count($testsArr)?> tests in the system : </h5>
                
         <ul  data-role="listview" data-divider-theme="b" data-inset="true">

            <?php foreach ($testsArr as $test){?>
            <li  data-theme="c">
                <a style="text-align :center; dir :RTL" href="viewTestDetails.php?id=<?php echo $test->getId()?>" data-transition="pop">
                    <?php echo $test->getTestName()?>
                </a>
            </li>
            
            <?php  } //end of foreach test?>
        </ul>
   

<?php include 'tail.php';?>