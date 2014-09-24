<?php

describe("L::flipTo", function () {

	$join3 = function ($a = 'x', $b = 'x', $c = 'x') {
		return $a . $b . $c;
	};

	it("makes a function receive its arguments backwards; takes a reference arity.", function () use ($join3) {
		$flippedJoinArity2 = L::flipTo(2, $join3);

		expect( $flippedJoinArity2('a', 'b', 'c') )
			->toBe( 'bax' );
	});

	it("is fully auto-curried", function () use ($join3) {
		$temp = L::flipTo(2);
		$temp = $temp($join3);
		expect( $temp('a', 'b', 'c') )
			->toBe( 'bax' );
	});

});

