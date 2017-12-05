<?php

describe("L::flatten", function () {

	it("flattens nested arrays into a single level", function () {
		expect( L::flatten(array('a', array('b', array(array('c'), 'd'), 'e'), 'f')) )
			->toBe( array('a', 'b', 'c', 'd', 'e', 'f') );
	});

});

