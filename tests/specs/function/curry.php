<?php

describe("L::curry", function () {

	$join3 = function ($a, $b, $c) {
		return $a . $b . $c;
	};

	it("makes a function take arguments partially until all are passed.", function () use ($join3) {
		$curriedJoin3 = L::curry($join3);

		expect( $curriedJoin3('a', 'b', 'c') )
			->toBe( 'abc' );

		$temp = $curriedJoin3('a');
		$temp = $temp('b');
		$temp = $temp('c');

		expect( $temp )
			->toBe( 'abc' );

		$temp = $curriedJoin3('a', 'b');
		$temp = $temp('c');

		expect( $temp )
			->toBe( 'abc' );
	});

});

