<?php

describe("L::prop", function () {

	it("extracts a property's value from an object.", function () {
		expect( L::prop('hi', array('hi' => 10)) )
			->toBe( 10 );
	});

	it("is fully auto-curried.", function () {
		$temp = L::prop('hi');
		expect( $temp(array('hi' => 10)) )
			->toBe( 10 );
	});

});

