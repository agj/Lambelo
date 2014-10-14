<?php

describe("L::foldOn", function () {

	$add = function ($a, $b) {
		return $a + $b;
	};

	it("accumulates values in an array according to an initial value and an accumulator function, taking the array and the initial value first.", function () use ($add) {
		expect( L::foldOn(array(1, 2, 3, 4, 5), 0, $add) )
			->toBe( 15 );
	});

	it("is fully auto-curried.", function () use ($add) {
		$temp = L::foldOn(array(1, 2, 3, 4, 5));
		$temp = $temp(0);
		expect( $temp($add) )
			->toBe( 15 );
	});

});

