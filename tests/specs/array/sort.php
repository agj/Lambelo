<?php

describe("L::sort", function () {

	it("sorts array", function () {
		expect( L::sort(array(2, 4, 3, 1)) )
			->toBe( array(1, 2, 3, 4) );
	});

});

