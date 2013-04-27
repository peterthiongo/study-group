<?php
include 'head.php';
include 'Classes/DB.php';

session_start();

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
                    Study Group - View Tests
                </h3>
        		<a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
            </div>
            <br>
            <br>
  
         <ul  data-role="listview" data-divider-theme="b" data-inset="true">
            <li  data-role="list-divider" role="heading" >
                <h3 align="center">currently <?php echo count($testsArr)?> tests in the system : </h3>
            </li>
            <?php foreach ($testsArr as $test){?>
            <li data-theme="c">
                <a href="viewTest.php?id=<?php echo $test->getId()?>" data-transition="pop">
                    <?php echo $test->getTestName()?>
                </a>
            </li>
            
            <?php  } //end of foreach test?>
        </ul>
   






<?php include 'tail.php';?>