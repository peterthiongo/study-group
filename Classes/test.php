<?php
/**
 * this will hold a single tests
 * @author Nimrod Lahav
 *
 */
class Test{
	private $name;
	private $questions = array();
	private $public = false;
	private $subject;
	private $originatorId;
	private $date;
	private $id;
	
	function __construct($Name,$originatorID){
		$this->name = $Name;
		$this->originatorId =  $originatorID;
	}
	
	function setId($ID){
		$this->id = $ID;
	}
	
	function getId(){
		return $this->id;
	}
	
	function getOriginator(){
		return $this->originatorId;
	}
	
	function getDate(){
		return $this->date;
	}
	
	function setDate($Date){
		$this->date = $Date;
	}
	
	function setQuestions($Questions){
		$this->questions = $Questions;
	}
	
	function getPublic(){
		return $this->public;
	}
	
	function setPublic($Public){
		$this->public=$Public;
	}
	
	function setSubject($Subject){
		$this->subject=$Subject;
	}
	
	function getSubject(){
		return $this->subject;
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