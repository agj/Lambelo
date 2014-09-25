<?php

describe("L::partialRight", function () {

	$join3 = function ($a = 'x', $b = 'x', $c = 'x') {
		return $a . $b . $c;
	};

	it("prepares a function with any number of arguments, which are placed after subsequent arguments.", function () use ($join3) {
		$_that = L::partialRight($join3, 'that');
		expect( $_that('what', 'is') )
			->toBe( 'whatisthat' );

		$_arewe = L::partialRight($join3, 'are', 'we');
		expect( $_arewe('who') )
			->toBe( 'whoarewe' );
	});

	it("is fully auto-curried", function () use ($join3) {
		$temp = L::partialRight($join3);
		$temp = $temp('a', 'b');
		expect( $temp('c') )
			->toBe( 'cab' );
	});

});

