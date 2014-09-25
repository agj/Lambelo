<?php

describe("L::findKey", function () {

	$isEven = function ($n) {
		return $n % 2 === 0;
	};

	it("gets the first item's key in an array that satisfies a predicate.", function () use ($isEven) {
		expect( L::findKey($isEven, array(1, 3, 5, 6, 7)) )
			->toBe( 3 );
	});

	it("is fully auto-curried", function () use ($isEven) {
		$temp = L::findKey($isEven);
		expect( $temp(array(1, 3, 5, 6, 7)) )
			->toBe( 3 );
	});

});

