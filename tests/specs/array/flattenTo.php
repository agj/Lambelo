<?php

describe("L::flattenTo", function () {

	it("flattens nested arrays into a single level", function () {
		expect( L::flattenTo(2, array('a', array('b', array(array('c'), 'd'), 'e'), 'f')) )
			->toBe( array('a', 'b', array('c'), 'd', 'e', 'f') );
	});

	it("is fully auto-curried.", function () {
		$temp = L::flattenTo(2);
		expect( $temp(array('a', array('b', array('c', array('d'))))) )
			->toBe( array('a', 'b', 'c', array('d')) );
	});

});

