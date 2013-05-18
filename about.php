<?php  
include 'head.php';
include 'Classes/DB.php';
session_start();
?>

        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="a" data-role="header">
                <h3>
                    Study Group - About
                </h3>
            </div>
            <div  align="center" data-role="content">
                <h2 align='center'>
                This app was made by Nimrod Lahav as a open source code.
                </h2>
                <p>Checkout the source code at :</p>
                <br>
                <a href="http://github.com/Nimrod007/study-group">http://github.com/Nimrod007/study-group</a>
                <br>
                <p>you can enter you own test / watch tests statistics / view tests</p>
                <br>
                <p>Need more help ? contact us</p>
                <a href="mailto:n.l.telaviv@gmail.com?Subject=Help with study group">Send Mail</a>
           		<br>
           		<br>
                <a data-role="button" data-theme="b" href="index.php" data-icon="home" data-iconpos="right" class="ui-btn-right">
           			 Home
           		</a>
           	</div>

<?php include 'tail.php';?>