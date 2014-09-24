<?php

describe("L::sequence", function () {

	$timesTwo = function ($n) {
		return $n * 2;
	};
	$appendX = function ($v) {
		return $v . 'x';
	};

	it("strings a series of functions from left to right.", function () use ($timesTwo, $appendX) {
		$timesTwoX = L::sequence($timesTwo, $appendX);

		expect( $timesTwoX(10) )
			->toBe( '20x' );
	});

});

