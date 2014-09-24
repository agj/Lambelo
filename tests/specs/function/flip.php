<?php

describe("L::flip", function () {

	$join3 = function ($a, $b, $c) {
		return $a . $b . $c;
	};

	it("makes a function receive its arguments backwards.", function () use ($join3) {
		$flippedJoin = L::flip($join3);

		expect( $flippedJoin('a', 'b', 'c') )
			->toBe( 'cba' );

		expect( $flippedJoin('a', 'b', 'c', 'd'))
			->toBe( 'cba' );
	});

});

