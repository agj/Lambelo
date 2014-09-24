<?php

describe("L::autoCurryTo", function () {

	$join3 = function ($a = 'x', $b = 'x', $c = 'x') {
		return $a . $b . $c;
	};

	it("makes a function take arguments partially until all are passed; also takes a reference arity.", function () use ($join3) {
		$autoCurriedJoin3Arity1 = L::autoCurryTo(1, $join3);

		expect( $autoCurriedJoin3Arity1('a', 'b', 'c') )
			->toBe( 'abc' );
		expect( $autoCurriedJoin3Arity1('a') )
			->toBe('axx');

		$autoCurriedJoin3Arity2 = L::autoCurryTo(2, $join3);

		$temp = $autoCurriedJoin3Arity2('a');
		$temp = $temp('b');

		expect( $temp )
			->toBe( 'abx' );
	});

	it("is fully auto-curried", function () use ($join3) {
		$temp = L::autoCurryTo(2);
		$temp = $temp($join3);
		$temp = $temp('a');
		expect( $temp('b') )
			->toBe( 'abx' );
	});

});

