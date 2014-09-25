<?php

describe("L::partial", function () {

	$join3 = function ($a = 'x', $b = 'x', $c = 'x') {
		return $a . $b . $c;
	};

	it("prepares a function with any number of arguments.", function () use ($join3) {
		$what = L::partial($join3, 'what');
		expect( $what('are', 'you') )
			->toBe( 'whatareyou' );
		
		$whoAre = L::partial($join3, 'who', 'are');
		expect( $whoAre('you') )
			->toBe( 'whoareyou' );
	});

	it("is fully auto-curried.", function () use ($join3) {
		$temp = L::partial($join3);
		$temp = $temp('a', 'b');
		expect( $temp('c') )
			->toBe( 'abc' );
	});

});

