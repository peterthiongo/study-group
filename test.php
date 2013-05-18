<?php  
include 'head.php';

$data = array(1,2);
$label = "hi,you";
$data = serialize($data);
$title="cool";
?>

        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group
                </h3>
            </div>
            <div data-role="content">
            <h3>"graph.php?title=<?php echo $title?>&data=<?php echo $data?>&label=<?php echo $label?>"</h3>
                <h2 align='center'>
                    Hi
                    <br>
                    <br>
                    Welcome to Study Group 
                </h2>
              <img src="graph.php?title=<?php echo $title?>&data=<?php echo $data?>&label=<?php echo $label?>" /> 
                 <div style=" text-align:center">
                	<a href="index.php">               
                        <img style="width: 160px; height: 200px" src="exam.png" />
                	</a>
                </div>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-theme="b" data-role="button" href="viewTests.php">
                    	view/answer tests
                	</a>
                </div>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-role="button" href="newTest.php">
                    	create new test
                	</a>
                 </div>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-theme="a" data-role="button" href="viewTestStatistics.php">
                    	tests statistics
                	</a>
                 </div>
                <div align="center">
                	<a style="width: 250px;" data-inline="true" data-theme="e" data-role="button" href="www.aboutOrHelp.com">
                    	about / help
                	</a>
                </div>
            </div>

<?php include 'tail.php';?>



