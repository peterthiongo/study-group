<?php

class User{
	private $name;
	private $id;
	
	function __construct($ID,$Name){
		$this->id=$ID;
		$this->name = $Name;
	}
	
	function getId(){
		return $this->id;
	}
	
	function getName(){
		return $this->name;
	}
	
	function setName($Name){
		$this->name = $Name;
	}
	
	
}