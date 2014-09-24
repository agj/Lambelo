<?php

describe("L::partialRight", function () {

	$join3 = function ($a, $b, $c) {
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

});

