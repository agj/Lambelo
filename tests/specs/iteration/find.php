<?php

describe("L::find", function () {

	$isEven = function ($n) {
		return $n % 2 === 0;
	};

	it("gets the first item in an array that satisfies a predicate.", function () use ($isEven) {
		expect( L::find($isEven, array(1, 3, 5, 6, 7)) )
			->toBe( 6 );
	});

	it("is fully auto-curried", function () use ($isEven) {
		$temp = L::find($isEven);
		expect( $temp(array(1, 3, 5, 6, 7)) )
			->toBe( 6 );
	});

});

