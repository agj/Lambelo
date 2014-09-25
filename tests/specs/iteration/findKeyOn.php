<?php

describe("L::findKeyOn", function () {

	$isEven = function ($n) {
		return $n % 2 === 0;
	};

	it("gets the first item's key in an array that satisfies a predicate, taking the array first.", function () use ($isEven) {
		expect( L::findKeyOn(array(1, 3, 5, 6, 7), $isEven) )
			->toBe( 3 );
	});

	it("is fully auto-curried", function () use ($isEven) {
		$temp = L::findKeyOn(array(1, 3, 5, 6, 7));
		expect( $temp($isEven) )
			->toBe( 3 );
	});

});

