<?php

describe("L::unique", function () {

	it("removes repeated elements", function () {
		expect( L::unique(array('a', 'b', 1, 1, 2, 'a')) )
			->toBe( array('a', 'b', 1, 2) );
	});

});

