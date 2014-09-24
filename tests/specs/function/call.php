<?php

describe("L::call", function () {

	$join = function ($a, $b) {
		return $a . $b;
	};

	it("calls a function with the supplied arguments.", function () use ($join) {
		expect( L::call($join, 'first', 'second') )
			->toBe( 'firstsecond' );
	});

});

