<?php

/**
 * will represent a user tuen (asnwer 4 questions)
 * and save data
 * @author Nimrod Lahav
 *
 */
class Turn{
	private $answers;
	private $results;
	private $answerTimeArray;
	
	function __construct(){
		
		$this->answers = array();
		$this->results = array();
		$this->answerTimeArray = array();
		
	}
	
	/**
	 * function will insert to time array the question's answer time (in seconds)
	 * @param unknown_type $time
	 */
	function setAnswerTime($time){
		$this->answerTimeArray[]=$time;
	}
	
	
	function userAnswerdRight(){
		$this->answers[]=true;
	}
	
	function userAnswerdWrong(){
		$this->answers[]=false;
	}
	
	
	
	
	
}