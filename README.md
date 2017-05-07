
Lambelo 1.1.0
=============

A very much in-progress, small **PHP 5.3+** library designed to facilitate functional programming.
This means making the best of anonymous functions, a.k.a. lambdas or closures.


Example
-------

The following exemplifies using the `L::map()` (and `L::mapOn()`) utility on an array,
which passes each value to a function an constructs a new array with the return values.
It does the same as, and uses, PHP's native `array_map`, but makes it more composable by virtue of being curried automatically (taking arguments not only all at once but also one by one as required).

```php
require_once 'lambelo.php';

$treble = function ($n) {
	return $n * 3;
};

// L::map() takes the function first.

$trebleAll = L::map($treble);

$trebleAll(array(1, 2, 3)); // array(3, 6, 9)
$trebleAll(array(4, 5, 6)); // array(12, 15, 18)

// L::mapOn() takes the array first.

$halve = function ($n) {
	return $n / 2;
};

$onPrimes = L::mapOn(array(2, 3, 5, 7));

$onPrimes($treble); // array(6, 9, 15, 21)
$onPrimes($halve);  // array(1, 1.5, 2.5, 3.5)
```

When it makes sense, Lambelo's utilities have an accompanying `~On` function that takes the function last.


Why
---

I'm currently mostly doing javascript programming, and with it I've been exploring functional concepts.
When I need to do PHP work, it's become painful enough that I figured I needed the tool to streamline my workflow.
While I know of certain PHP libraries that claim to facilitate functional programming, they don't make it easy to compose functions;
particularly lacking is partial application/currying.
That's why I felt the need to start this one.


Documentation
-------------

There is currently no documentation, but the tests demonstrate all of the available utilities. Check the `tests` folder.


License
-------

This software and code is released into the public domain. The author relinquishes his rights over it for perpetuity. However, no warranties are offered at all over its content and use. The author shall not be liable over the results of its use.


Acknowledgements
----------------

I've drawn inspiration from libraries such as these:

* [allong.es](https://github.com/raganwald/allong.es)
* [Ramda](http://ramdajs.com/)
* [Lemonad](http://fogus.github.io/lemonad/)
* [Underscore.php](http://brianhaveri.github.io/Underscore.php/)
* [Functional PHP](https://github.com/lstrojny/functional-php)
* [iter](https://github.com/nikic/iter)
