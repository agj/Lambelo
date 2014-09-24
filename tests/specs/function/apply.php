<?php

describe("L::apply", function () {

	$join = function ($a, $b) {
		return $a . $b;
	};

	it("calls a function with an array of arguments.", function () use ($join) {
		expect( L::apply($join, array('first', 'second')) )
			->toBe( 'firstsecond' );
	});

});

