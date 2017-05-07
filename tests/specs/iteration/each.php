<?php

describe("L::each", function () {

	it("runs a function on each value in an array, then returns the same array.", function () {
		$arr = array(1, 2, 3, 4, 5);
		$count = 0;

		$check = function ($a) use (&$count, $arr) {
			$count++;
			expect( $a )->toBeIn( $arr );
		};

		expect( L::each($check, $arr) )
			->toBe( $arr );
		expect( $count )
			->toBe( 5 );
	});

	it("is fully auto-curried.", function () {
		$arr = array(1, 2, 3, 4, 5);
		$count = 0;

		$check = function ($a) use (&$count, $arr) {
			$count++;
			expect( $a )->toBeIn( $arr );
		};

		$temp = L::each($check);
		expect( $temp($arr) )
			->toBe( $arr );
		expect( $count )
			->toBe( 5 );
	});

});

