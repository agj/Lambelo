<?php

describe("L::partial", function () {

	$join3 = function ($a, $b, $c) {
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

});

