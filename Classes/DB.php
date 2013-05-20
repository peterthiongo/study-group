<?php
/**
 * will hold db connection and supporting methods
 * @author Nimrod Lahav
 *
 */

define ('RIGHT_ANSWER',4);


include 'Classes/test.php';
include 'Classes/question.php';
include 'Classes/user.php';
include 'Classes/turn.php';
require 'Classes/facebook.php';

class DB{
	
	private $mysqli;
	public $facebook;
	
	//defualt value for our DB
	function __construct(){
		//create db
		//@$this->mysqli = new mysqli('localhost','XX','XX','XX');
				//working in hebrew & english
		mysqli_set_charset($this->mysqli,'utf8');
		
		$this->facebook = new Facebook(array(
				'appId' => 'XX',
				'secret' => 'XX',
		));
	
	}
	
	function __destruct(){
		$this->mysqli->close();
	}
	
	function getAmountOfUserAnsweredTest($testID){
		$count = 0;
		$query = "SELECT  DISTINCT userID from turns WHERE testID = '$testID' ";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
		while (list($testID) = $sqlResult->fetch_row())
			$count++;
		
		return $count;
	}
	
	function getTotalAttemptsForTest($testID){
		$count = 0;
		$query = "SELECT userID from turns WHERE testID = '$testID' ";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
		while (list($testID) = $sqlResult->fetch_row())
			$count++;
	
		return $count;
	}
	
	function getAverageTestTime($testID){
		$timeArray = array();
		$query = "SELECT turn from turns WHERE testID = '$testID' ";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
		while (list($turnDB) = $sqlResult->fetch_row()){
			$turn = unserialize($turnDB);
			$timeArray[]=$turn->getTotalTime();
		}
		
		$sum = array_sum($timeArray);
		$average = $sum / count ($timeArray);
		return $average;
	}
	
	function getAverageTimeForQuestion($testID,$questionNum){
		$timeArray = array();
		$query = "SELECT turn from turns WHERE testID = '$testID' ";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
		while (list($turnDB) = $sqlResult->fetch_row()){
			$turn = unserialize($turnDB);
			$time=$turn->getAnswerTime();
			$timeArray[]=$time[$questionNum];
		}
	
		$sum = array_sum($timeArray);
		$average = $sum / count ($timeArray);
		return $average;
	}
	
	function getQuestionPieChart($questionNum,$testID){
		//get all turns
		$turns = $this->getTurnsByTestID($testID);
		
		//go over test and gets its question statistics
		$answersCount=array(0,0,0,0);
		
		foreach ($turns as $turn){
			$answers = $turn->getAnswers();
			$answersCount[$answers[$questionNum]-1]++;
		}
		
		return $answersCount;
	}
	
	/**
	 * function will write test object to DB
	 * @param  $test
	 */
	function saveTestToDB($test){
		//get test name
		$name = $this->makeSafe($test->getTestName());
		//get questions
		$questionsArr = $test->getQuestions();
		//is test public
		$public = $this->makeSafe($test->getPublic());
		if ($public)
			$public=1;
		else
			$public=0;
		
		//who made this test
		$originator = $this->makeSafe($test->getOriginator());
		//get questions text
		$questions="";
		//get answers text
		$answers="";
		//get the subject of the test
		$subject = $this->makeSafe($test->getSubject());

		//generate question text ans answers in Db format
		foreach ($questionsArr as $question){
			$answers .= $this->makeSafe($question->getRightAnswer());
			$answers .= ',';
			$answers .= $this->makeSafe($this->arrayToString($question->getAnswers()));
			$answers .= ',';
			$questions .= $this->makeSafe($question->getText());
			$questions .= ',';
		}
		//cut the last ","
		$answers = substr($answers, 0, -1);
		$questions = substr($questions, 0, -1);
		
		//insert to the DB
		$query= "INSERT INTO tests VALUES(null,'$questions','$answers','$name','$subject','$public','$originator',Now()) ";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
		echo "$sqlResult";
	}
	
	
	/**
	 * function will get test from DB by given test id
	 * will return test object
	 * @param  $id - id of test to get from DB
	 * @return $test - object of Test with details
	 */
	function getTestFromDB($id){
		//get test from DB by test id
		$query = "select * from tests where id = '$id'";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
		list($id,$questions,$answers,$name,$subject,$public,$originator,$date) = $sqlResult->fetch_row();
		
		$test = new Test($name, $originator);
		$test->setPublic($public);
		$test->setSubject($subject);
		$test->setQuestions($this->generateQuestions($questions, $answers));
		$test->setDate($date);
		$test->setId($id);
		
		return $test;
		
	}
	
	/**
	 * function will write turn (object) into DB 
	 * using searlize
	 * function checks for safe input
	 * @param unknown_type $turn
	 */
	function writeTurnToDB($turn){
		//get user id
		$userID = $turn->getTurnUserID();
		//get turn id
		$turnID = $turn->getTurnId();
		//get test id
		$testID = $turn->getTestID();
		
		//write into DB
		
		//searlize the object 
		$turnDB = serialize($turn);
		
		$query= "INSERT INTO turns VALUES('$turnID','$userID','$testID','$turnDB') ";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
		
		//done
	}
	
	function getUsersTests($userID){
		$testsIDs = array();
		
		$query = "SELECT testID from turns WHERE userID = '$userID' ";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
		
		while (list($testID) = $sqlResult->fetch_row())
			$testsIDs[]=$testID;
		
		$testsIDs = array_unique($testsIDs);
		
		$tests = array();
		
		foreach ($testsIDs as $testID){
			$tests[] = $this->getTestFromDB($testID);
		}
		
		return $tests;
	}
	
	function getTurnFromDB(){		
		$query = "SELECT * from turns";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
		
		list($turnID,$userID,$testID,$turnDB) = $sqlResult->fetch_row();
		$turn = unserialize($turnDB);
		
		return $turn;
	}
	
	
	function getTurnsByTestID($testID){
		$turns = array();
		$query = "SELECT * from turns WHERE testID = $testID";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
	
		while (list($turnID,$userID,$testID,$turnDB) = $sqlResult->fetch_row()){
			$turn = unserialize($turnDB);
			$turns[]=$turn;
		}
	
		return $turns;
	}
	
	
	/**
	 * function will return list of test from DB sorted by test name
	 */
	function getAllTest(){
		//will hold all tests
		$testArr = array();
		//get all test from DB sorted by name
		$query = "select * from tests ORDER BY name ASC";
		$sqlResult =  $this->mysqli->query($query,MYSQLI_STORE_RESULT);
		while (list($id,$questions,$answers,$name,$subject,$public,$originator,$date) = $sqlResult->fetch_row()){
			$test = new Test($name, $originator);
			$test->setPublic($public);
			$test->setSubject($subject);
			$test->setQuestions($this->generateQuestions($questions, $answers));
			$test->setDate($date);
			$test->setId($id);
			$testArr[]=$test;
		}
		return $testArr;
	}
	/**
	 * function gets questions and answers from DB and creates questions array
	 * @param  $questions
	 * @param  $answers
	 * @return $questions Array 
	 */
	function generateQuestions($questions,$answers){
		//will hold questions
		$questionsArr = array();
		//get all questions
		$questionsTextArr = $this->stringToArray($questions);
		
		//get all answers to araay :
		$answersArr = $this->stringToArray($answers);
		
		//all 4 answers are for 1 question and first answer is the right 1
		for ($i = 0 ; $i < count($questionsTextArr) ; $i++){
			//get right answer :
			$right = str_replace("|", ",",$answersArr[$i*4]);
			$wrongArr = array();
			$wrongArr[] = str_replace("|", ",",$answersArr[$i*4+1]);
			$wrongArr[] = str_replace("|", ",",$answersArr[$i*4+2]);
			$wrongArr[] = str_replace("|", ",",$answersArr[$i*4+3]);
			$text = $questionsTextArr[$i];
			$question = new Question($text, $wrongArr, $right);
			$questionsArr[] = $question;
			
		}
		return $questionsArr;
	}
	
	
	
	
	/**
	 * function gets a input and returns it as safe string for DB insert
	 */
	function makeSafe($input){
		return $this->mysqli->real_escape_string($input);
	}
	
	/**
	 * function takes a array and transfers it to a string
	 * for example : array{'item1','item2','item3'} will look like item1,item2,item3
	 * Enter description here ...
	 * @param unknown_type $array
	 */
	function arrayToString($array){
		$string="";
		foreach ($array as $object){
			$string .= ",$object";
		}
		$string = substr($string,1);
		return $string;
	}
	
	/**
	 * function takes a string "one,two,3" and returns array : myArray{one,two,3};
	 * @param  $string
	 */
	function stringToArray($string){
		if ($string != null)
			return $string = explode(",", $string);
	}
}

?>