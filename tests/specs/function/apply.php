<?php

describe("L::apply", function () {

	$join3 = function ($a, $b, $c) {
		return $a . $b . $c;
	};

	it("calls a function with an array of arguments.", function () use ($join3) {
		expect( L::apply($join3, array('first', 'second', 'third')) )
			->toBe( 'firstsecondthird' );
	});

	it("is fully auto-curried", function () use ($join3) {
		$temp = L::apply($join3);
		expect( $temp(array('first', 'second', 'third')) )
			->toBe( 'firstsecondthird' );
	});

});

