<?php

describe("L::equals", function () {

	it("compares two values", function () {
		expect( L::equals('a', 'a') )
			->toBe( true );
		expect( L::equals('a', 'b') )
			->toBe( false );
	});

	it("is fully auto-curried.", function () {
		$temp = L::equals('a');
		expect( $temp('b') )
			->toBe( false );
	});

});

