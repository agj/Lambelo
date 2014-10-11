<?php

describe("L::filter", function () {

	$isEven = function ($n) {
		return $n % 2 === 0;
	};

	it("filters an array to contain only those items that satisfy a predicate.", function () use ($isEven) {
		expect( L::filter($isEven, array(1, 2, 5, 6, 7)) )
			->toBe( array( 1 => 2, 3 => 6 ) );
	});

	it("is fully auto-curried", function () use ($isEven) {
		$temp = L::filter($isEven);
		expect( $temp(array(1, 2, 5, 6, 7)) )
			->toBe( array( 1 => 2, 3 => 6 ) );
	});

});

