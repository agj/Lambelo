<?php

describe("L::filterOn", function () {

	$isEven = function ($n) {
		return $n % 2 === 0;
	};

	it("filters an array to contain only those items that satisfy a predicate, taking the array first.", function () use ($isEven) {
		expect( L::filterOn(array(1, 2, 5, 6, 7), $isEven) )
			->toBe( array( 1 => 2, 3 => 6 ) );
	});

	it("is fully auto-curried", function () use ($isEven) {
		$temp = L::filterOn(array(1, 2, 5, 6, 7));
		expect( $temp($isEven) )
			->toBe( array( 1 => 2, 3 => 6 ) );
	});

});

