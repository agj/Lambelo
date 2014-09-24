<?php

describe("L::arity", function () {

	$join3 = function ($a = 'x', $b = 'x', $c = 'x') {
		return $a . $b . $c;
	};

	it("makes a function take only a specific number of arguments passed to it.", function () use ($join3) {
		$joinUpTo2 = L::arity(2, $join3);

		expect( $joinUpTo2('a', 'b', 'c') )
			->toBe( 'abx' );
	});

});

