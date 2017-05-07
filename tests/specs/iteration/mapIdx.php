<?php

describe("L::mapIdx", function () {

	$doubleWithKey = function ($value, $key) {
		return $key . '-' . ($value * 2);
	};

	it("transforms each value in an array given a transform function, which takes both value and key.", function () use ($doubleWithKey) {
		expect( L::mapIdx($doubleWithKey, array(1, 2, 3, 4, 5)) )
			->toBe( array('0-2', '1-4', '2-6', '3-8', '4-10') );
	});

	it("is fully auto-curried.", function () use ($doubleWithKey) {
		$temp = L::mapIdx($doubleWithKey);
		expect( $temp(array(1, 2, 3, 4, 5)) )
			->toBe( array('0-2', '1-4', '2-6', '3-8', '4-10') );
	});

});

