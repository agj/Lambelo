<?php

describe("L::sortBy", function () {

	$sorter = function ($a, $b) {
		return $b[1] - $a[1];
	};

	it("sorts array according to a sorting function", function () use ($sorter) {
		expect( L::sortBy($sorter, array(array('d', 4),  array('a', 1), array('c', 3), array('b', 2))) )
			->toBe( array(array('a', 1), array('b', 2), array('c', 3), array('d', 4)) );
	});

	it("is fully auto-curried.", function () use ($sorter) {
		$temp = L::sortBy($sorter);
		expect( $temp(array(array('d', 4),  array('a', 1), array('c', 3), array('b', 2))) )
			->toBe( array(array('a', 1), array('b', 2), array('c', 3), array('d', 4)) );
	});

});

