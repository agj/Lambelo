<?php

header('Content-Type: text/plain');

$__tester__expectationResults;
$__tester__currentPath = array();


function describe($description, $fn) {
	global $__tester__currentPath;

	$originalPath = $__tester__currentPath;
	$__tester__currentPath[] = $description;
	$fn();
	$__tester__currentPath = $originalPath;
}

function it($description, $fn) {
	global $__tester__expectationResults;
	global $__tester__currentPath;

	$br = "\n";
	$brbr = $br . $br;

	$__tester__expectationResults = array();
	$fn();

	echo implode(' ', $__tester__currentPath) . ' ' . $description . $brbr;

	$hasErrors = false;

	foreach ($__tester__expectationResults as $result) {
		if (!$result->isCorrect) {
			echo 'ERROR: Expected' .$br. $result->value .$br. $result->comparison .$br. $result->expectation .$brbr;
			$hasErrors = true;
		}
	}

	if (!$hasErrors) {
		if (count($__tester__expectationResults) === 0)
			echo 'ERROR: No checks made.';
	}
}

function expect($value) {
	return new __tester__Checker($value);
}



class __tester__Checker {

	function __construct($value) {
		$this->value = $value;
	}

	public function toBe($expectation) {
		$this->resultFor($this->value, 'to be', $expectation)
			->isCorrect($this->value === $expectation);
		return $this;
	}

	/////

	private $value;

	private function resultFor($value, $comparison, $expectation) {
		global $__tester__expectationResults;
		$r = new __tester__Result($value, $comparison, $expectation);
		$__tester__expectationResults[] = $r;
		return $r;
	}
}



class __tester__Result {

	public $value;
	public $comparison;
	public $expectation;
	public $isCorrect = false;

	function __construct($value, $comparison, $expectation) {
		$this->value = var_export($value, true);
		$this->comparison = $comparison;
		$this->expectation = var_export($expectation, true);
	}

	public function isCorrect($yes) {
		$this->isCorrect = $yes;
	}

}

