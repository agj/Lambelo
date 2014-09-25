<?php

describe("L::skip", function () {

	it("prevents a function from being called the first number of times.", function () {
		$count = 0;
		$increase = function () use (&$count) {
			$count++;
		};

		expect( $count )
			->toBe( 0 );

		$increaseAfter2 = L::skip(2, $increase);
		$increaseAfter2();
		$increaseAfter2();

		expect( $count )
			->toBe( 0 );

		$increaseAfter2();

		expect( $count )
			->toBe( 1 );
	});

	it("is fully auto-curried.", function () {
		$count = 0;
		$increase = function () use (&$count) {
			$count++;
		};

		expect( $count )
			->toBe( 0 );

		$skip2 = L::skip(2);
		$increaseAfter2 = $skip2($increase);
		$increaseAfter2();
		$increaseAfter2();

		expect( $count )
			->toBe( 0 );

		$increaseAfter2();

		expect( $count )
			->toBe( 1 );
	});

});

