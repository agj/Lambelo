<?php

describe("L::findOn", function () {

	$isEven = function ($n) {
		return $n % 2 === 0;
	};

	it("gets the first item in an array that satisfies a predicate, taking the array first.", function () use ($isEven) {
		expect( L::findOn(array(1, 3, 5, 6, 7), $isEven) )
			->toBe( 6 );
	});

	it("is fully auto-curried", function () use ($isEven) {
		$temp = L::findOn(array(1, 3, 5, 6, 7));
		expect( $temp($isEven) )
			->toBe( 6 );
	});

});

