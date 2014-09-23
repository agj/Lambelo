
Lambelo
=======

A very much in-progress, small **PHP 5.3** library designed to facilitate functional programming.
This means making the best of anonymous functions, a.k.a. lambdas or closures.


## Example

The following exemplifies using the `L::map` function on an array,
which transforms each value by passing it through a supplied function,
and returns a new array (equivalent to PHP's native `array_map`).

```php
require_once 'functional.php';

$times10 = function ($n) {
	return $n * 10;
};

// Use straight:

L::map($times10, array(1, 2, 3, 4)); // > array(10, 20, 30, 40)

// Or take advantage of the auto-currying functionality:

$mapTimes10 = L::map($times10);

$mapTimes10(array(5, 6, 7));  // > array(50, 60, 70)
$mapTimes10(array(8, 9, 10)); // > array(80, 90, 100)
```


## Why

I'm currently mostly doing javascript programming, and with it I've been exploring functional concepts.
When I need to do PHP work, it's become painful enough that I figured I needed the tool to streamline my workflow.
While I know of certain PHP libraries that claim to facilitate functional programming, they don't make it easy to compose functions;
particularly lacking is partial application/currying.
That's why I felt the need to start this one.


## Acknowledgements

I've drawn inspiration from libraries such as these:

* [allong.es](https://github.com/raganwald/allong.es)
* [Ramda](http://ramdajs.com/)
* [Lemonad](http://fogus.github.io/lemonad/)
* [Underscore.php](http://brianhaveri.github.io/Underscore.php/)
* [Functional PHP](https://github.com/lstrojny/functional-php)
* [iter](https://github.com/nikic/iter)
