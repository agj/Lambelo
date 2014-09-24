<?php

describe("L::autoCurry", function () {

	$join3 = function ($a, $b, $c) {
		return $a . $b . $c;
	};

	it("makes a function take arguments partially until all are passed.", function () use ($join3) {
		$autoCurriedJoin3 = L::autoCurry($join3);

		expect( $autoCurriedJoin3('a', 'b', 'c') )
			->toBe( 'abc' );

		$temp = $autoCurriedJoin3('a');
		$temp = $temp('b');
		$temp = $temp('c');

		expect( $temp )
			->toBe( 'abc' );

		$temp = $autoCurriedJoin3('a', 'b');
		$temp = $temp('c');

		expect( $temp )
			->toBe( 'abc' );
	});

});

