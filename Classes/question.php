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
}


?>