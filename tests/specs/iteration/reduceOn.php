<?php

describe("L::reduceOn", function () {

	$add = function ($a, $b) {
		return $a + $b;
	};

	it("accumulates values in an array according to an accumulator function, taking the array first.", function () use ($add) {
		expect( L::reduceOn(array(1, 2, 3, 4, 5), $add) )
			->toBe( 15 );
	});

	it("is fully auto-curried.", function () use ($add) {
		$temp = L::reduceOn(array(1, 2, 3, 4, 5));
		expect( $temp($add) )
			->toBe( 15 );
	});

});

