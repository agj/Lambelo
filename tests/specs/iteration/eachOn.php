<?php

describe("L::eachOn", function () {

	it("runs a function on each value in an array, then returns the same array, taking the array first.", function () {
		$arr = array(1, 2, 3, 4, 5);
		$count = 0;

		$check = function ($a) use (&$count, $arr) {
			$count++;
			expect( $a )->toBeIn( $arr );
		};

		expect( L::eachOn($arr, $check) )
			->toBe( $arr );
		expect( $count )
			->toBe( 5 );
	});

	it("is fully auto-curried.", function () use ($check) {
		$arr = array(1, 2, 3, 4, 5);
		$count = 0;

		$check = function ($a) use (&$count, $arr) {
			$count++;
			expect( $a )->toBeIn( $arr );
		};

		$temp = L::eachOn($arr);
		expect( $temp($check) )
			->toBe( $arr );
		expect( $count )
			->toBe( 5 );
	});

});

