<?php

describe("L::propOn", function () {

	it("extracts a property's value from an object, taking the object first.", function () {
		expect( L::propOn(array('hi' => 10), 'hi') )
			->toBe( 10 );
	});

	it("is fully auto-curried.", function () {
		$temp = L::propOn(array('hi' => 10));
		expect( $temp('hi') )
			->toBe( 10 );
	});

});

