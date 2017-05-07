<?php

describe("L::mapIdxOn", function () {

	$doubleWithKey = function ($value, $key) {
		return $key . '-' . ($value * 2);
	};

	it("transforms each value in an array given a transform function (which takes value and key,) taking the array first.", function () use ($doubleWithKey) {
		expect( L::mapIdxOn(array(1, 2, 3, 4, 5), $doubleWithKey) )
			->toBe( array('0-2', '1-4', '2-6', '3-8', '4-10') );
	});

	it("is fully auto-curried.", function () use ($doubleWithKey) {
		$temp = L::mapIdxOn(array(1, 2, 3, 4, 5));
		expect( $temp($doubleWithKey) )
			->toBe( array('0-2', '1-4', '2-6', '3-8', '4-10') );
	});

});

