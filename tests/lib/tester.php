<?php

header('Content-Type: text/plain');

$__tester__expectationResults;
$__tester__currentPath = array();

$__tester__catchError = function ($fn) {
	$error = null;
	try {
		set_error_handler(function ($id, $text, $file, $line, $context) {
			if (error_reporting() === 0) return false;
			throw new ErrorException($text, 0, $id, $file, $line);
		});
		$fn();
		restore_error_handler();
	} catch (Exception $e) {
		$error = $e;
	}
	return $error;
};


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
	global $__tester__catchError;

	$br = "\n";
	$brbr = $br . $br;

	$__tester__expectationResults = array();

	$error = $__tester__catchError($fn);

	echo implode(' ', $__tester__currentPath) . ' ' . $description . $brbr;

	if ($error) {
		echo 'ERROR: An exception was thrown:' .$br;
		echo $error;

	} else {
		$hasErrors = false;

		foreach ($__tester__expectationResults as $result) {
			if (!$result->isCorrect) {
				echo 'ERROR: Expected' .$br. $result->value .$br. $result->comparison .$br. $result->expectation .$brbr;
				$hasErrors = true;
			}
		}

		if (!$hasErrors) {
			if (count($__tester__expectationResults) === 0)
				echo 'ERROR: No check was made!';
		}
	}
}

function expect($value) {
	return new __tester__Expect($value);
}



class __tester__Expect {

	function __construct($value) {
		$this->value = $value;
	}

	public function toBe($expectation) {
		$this->resultFor($this->value, 'to be', $expectation)
			->isCorrect($this->value === $expectation);
		return $this;
	}

	public function toThrow() {
		global $__tester__catchError;
		$error = $__tester__catchError($this->value);
		$this->resultFor($this->value, 'to throw')
			->isCorrect(is_callable($this->value) && isset($error));
		return $this;
	}

	/////

	private $value;

	private function resultFor($value, $comparison, $expectation = null) {
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

	function __construct($value, $comparison, $expectation = null) {
		$this->value = var_export($value, true);
		$this->comparison = $comparison;
		if ($expectation) $this->expectation = var_export($expectation, true);
	}

	public function isCorrect($yes) {
		$this->isCorrect = $yes;
	}

}

