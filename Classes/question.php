<?php

class Question{
	
	private $questionText;
	private $answers = array();
	private $rightAnswer;
	
	function __construct($text,$Answers,$right){
		$this->questionText = $text;
		$this->answers = $Answers;
		$this->rightAnswer = $right;
	}
	
	function getText(){
		return $this->questionText;
	}
	
	function getAnswers(){
		return $this->answers;
	}
	
	function getRightAnswer(){
		return $this->rightAnswer;
	}
	
	function getRandomAnswers(){
		$answersArr=$this->answers;
		$answersArr[]=$this->rightAnswer;
		shuffle($answersArr);
		return $answersArr;
	}
	
	function getRandomAnswersIndexed(){
		$answersArr=$this->answers;
		$answersArr[]=$this->rightAnswer;
		$index = 1;
		$answersArrIndexed=array();
		foreach ($answersArr as $answer){
			$answersArrIndexed[]=$answer.="|||$index";
			$index++;
		}
		
		shuffle($answersArrIndexed);
		return $answersArrIndexed;
	}
}

?>