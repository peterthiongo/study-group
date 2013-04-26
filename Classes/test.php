<?php
/**
 * this will hold a single tests
 * @author Nimrod Lahav
 *
 */
class Test{
	private $name;
	private $questions = array();
	
	function __construct($Name){
		$this->name = $Name;
	}
	
	function getTestName(){
		return $this->name;
	}
	
	function getQuestions(){
		return $this->questions;
	}
	
	function getQuestionAmount(){
		return count($this->questions);
	}
	
	function addQuestion($question){
		$this->questions[]=$question;
	}
	
	function getQuestion($location){
		return $this->questions[$location];
	}
}

?>