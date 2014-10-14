<?php

describe("L::reduce", function () {

	$add = function ($a, $b) {
		return $a + $b;
	};

	it("accumulates values in an array according to an accumulator function.", function () use ($add) {
		expect( L::reduce($add, array(1, 2, 3, 4, 5)) )
			->toBe( 15 );
	});

	it("is fully auto-curried.", function () use ($add) {
		$temp = L::reduce($add);
		expect( $temp(array(1, 2, 3, 4, 5)) )
			->toBe( 15 );
	});

});

