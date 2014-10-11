<?php

describe("L::reduce", function () {

	$add = function ($a, $b) {
		return $a + $b;
	};

	it("accumulates values in an array according to an initial value and an accumulator function.", function () use ($add) {
		expect( L::reduce($add, 0, array(1, 2, 3, 4, 5)) )
			->toBe( 15 );
	});

	it("is fully auto-curried.", function () use ($add) {
		$temp = L::reduce($add);
		$temp = $temp(0);
		expect( $temp(array(1, 2, 3, 4, 5)) )
			->toBe( 15 );
	});

});

