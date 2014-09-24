<?php

describe("L::compose", function () {

	$timesTwo = function ($n) {
		return $n * 2;
	};
	$appendX = function ($v) {
		return $v . 'x';
	};

	it("strings a series of functions from right to left.", function () use ($timesTwo, $appendX) {
		$timesTwoX = L::compose($appendX, $timesTwo);

		expect( $timesTwoX(10) )
			->toBe( '20x' );
	});

});

