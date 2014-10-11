<?php

describe("L::mapOn", function () {

	$double = function ($a) {
		return $a * 2;
	};

	it("transforms each value in an array given a transform function, taking the array first.", function () use ($double) {
		expect( L::mapOn(array(1, 2, 3, 4, 5), $double) )
			->toBe( array(2, 4, 6, 8, 10) );
	});

	it("is fully auto-curried.", function () use ($double) {
		$temp = L::mapOn(array(1, 2, 3, 4, 5));
		expect( $temp($double) )
			->toBe( array(2, 4, 6, 8, 10) );
	});

});

