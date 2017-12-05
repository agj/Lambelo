<?php

describe("L::keys", function () {

	it("returns an array of the keys of the array.", function () {
		expect( L::keys(array('a' => 1, 'b' => 2, 'c' => 3)) )
			->toBe( array('a', 'b', 'c') );
	});


});

