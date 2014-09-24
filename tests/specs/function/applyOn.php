<?php

describe("L::applyOn", function () {

	$join = function ($a, $b) {
		return $a . $b;
	};

	it("calls a function with an array of arguments, taking the arguments first.", function () use ($join) {
		expect( L::applyOn(array('first', 'second'), $join) )
			->toBe( 'firstsecond' );
	});

});

