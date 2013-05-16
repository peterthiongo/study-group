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
	private $testID;
	private $score = 0;
	private $totalTime = 0;
	private $userId;
	private $turnId;
	
	/**
	 * each turn will hold user id and test id
	 * @param unknown_type $testId
	 * @param unknown_type $userID
	 */
	function __construct($testId,$userID){
		
		$this->testID =  $testId;
		$this->answers = array();
		$this->results = array();
		$this->answerTimeArray = array();
		$this->userId = $userID;
		//create id for this turn
		$this->turnId = time(true);

	}
	
	function getTurnUserID(){
		return $this->userId;
	}
	
	function getTurnId(){
		return $this->turnId;
	}
	
	function getTestID(){
		return $this->testID;
	}
	
	function calculateTotalTime(){
		$totalTime=0;
		foreach ($this->answerTimeArray as $time)
			$totalTime+=$time;
		
		$this->totalTime=$totalTime;
	}
	
	function getTotalTime(){
		return $this->totalTime;
	}
	/**
	 * function will insert to time array the question's answer time (in seconds)
	 * @param unknown_type $time
	 */
	function setAnswerTime($time){
		$this->answerTimeArray[]=$time;
	}
	
	
	function userAnswerdRight(){
		$this->results[]=true;
	}
	
	function userAnswerdWrong(){
		$this->results[]=false;
	}
	
	function setAnswers($answer){
		$this->answers[]=$answer;
	}
	
	function getAnswerTime(){
		return $this->answerTimeArray;
	}
	
	function getAnswers(){
		return $this->answers;
	}
	
	function getResults(){
		return $this->results;
	}
	
	function getRightOrWrong($questionNum){
		if ($this->results[$questionNum])
			return "Right";
		else
			return "Wrong";
	}
	
	function getTotalRightAnswers(){
		$count = 0;
		foreach ($this->results as $result)
			if ($result)
				$count++;
		
		return $count;
	}
	
	function calculateTurnScore(){
		$questionPoints = 100/ count($this->answers);
		
		$score = 0;
		
		foreach ($this->results as $result)
			if ($result)
				$score+=$questionPoints;
		
		$this->score = $score;
	}
	
	function getScore(){
		return $this->score;
	}
	
	
	
	
	
}