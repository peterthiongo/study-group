<?php
/**
 * will hold db connection and supporting methods
 * @author Nimrod Lahav
 *
 */


include 'Classes/test.php';
include 'Classes/question.php';

class DB{
	
	private $mysqli;
	
	
	
	//defualt value for our DB
	function __construct(){
		@$this->mysqli = new mysqli('localhost','study','study','study');
	
	}
	
	function __destruct(){
		$this->mysqli->close();
	}
	
	
	
	
	
}

?>