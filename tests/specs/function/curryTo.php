<?php

describe("L::curryTo", function () {

	$join3 = function ($a = 'x', $b = 'x', $c = 'x') {
		return $a . $b . $c;
	};

	it("makes a function take arguments partially until all are passed; also takes a reference arity.", function () use ($join3) {
		$curriedJoin3Arity1 = L::curryTo(1, $join3);

		expect( $curriedJoin3Arity1('a', 'b', 'c') )
			->toBe( 'abc' );
		expect( $curriedJoin3Arity1('a') )
			->toBe('axx');

		$curriedJoin3Arity2 = L::curryTo(2, $join3);

		$temp = $curriedJoin3Arity2('a');
		$temp = $temp('b');

		expect( $temp )
			->toBe( 'abx' );
	});

	it("is fully auto-curried", function () use ($join3) {
		$temp = L::curryTo(2);
		$temp = $temp($join3);
		$temp = $temp('a');
		expect( $temp('b') )
			->toBe( 'abx' );
	});

});

