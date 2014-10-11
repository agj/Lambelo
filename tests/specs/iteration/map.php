<?php

describe("L::map", function () {

	$double = function ($a) {
		return $a * 2;
	};

	it("transforms each value in an array given a transform function.", function () use ($double) {
		expect( L::map($double, array(1, 2, 3, 4, 5)) )
			->toBe( array(2, 4, 6, 8, 10) );
	});

	it("is fully auto-curried.", function () use ($double) {
		$temp = L::map($double);
		expect( $temp(array(1, 2, 3, 4, 5)) )
			->toBe( array(2, 4, 6, 8, 10) );
	});

});

