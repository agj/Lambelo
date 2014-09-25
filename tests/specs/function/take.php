<?php

describe("L::take", function () {

	it("prevents a function from being called more than a number of times.", function () {
		$count = 0;
		$increase = function () use (&$count) {
			$count++;
		};

		expect( $count )
			->toBe( 0 );

		$increaseOnly2 = L::take(2, $increase);
		$increaseOnly2();
		$increaseOnly2();

		expect( $count )
			->toBe( 2 );

		$increaseOnly2();
		$increaseOnly2();

		expect( $count )
			->toBe( 2 );
	});

	it("is fully auto-curried.", function () {
		$count = 0;
		$increase = function () use (&$count) {
			$count++;
		};

		expect( $count )
			->toBe( 0 );

		$take2 = L::take(2);
		$increaseOnly2 = $take2($increase);
		$increaseOnly2();
		$increaseOnly2();

		expect( $count )
			->toBe( 2 );

		$increaseOnly2();
		$increaseOnly2();

		expect( $count )
			->toBe( 2 );
	});

});

