<?php

describe("L::callOn", function () {

	$join = function ($a, $b) {
		return $a . $b;
	};

	it("calls a function with the supplied arguments, taking the arguments first.", function () use ($join) {
		expect( L::callOn('first', 'second', $join) )
			->toBe( 'firstsecond' );
	});

});

