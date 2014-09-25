<?php

class L {

	static function __callStatic($name, $args) {
		$fn = self::$fns[$name];
		if (!$fn) throw new Exception("Lambelo has no function " . var_export($name, true) . ".");
		return call_user_func_array($fn, $args);
	}

	static $fns;
}

call_user_func( function () { // Creating a closure to prevent variable leakage.

	// Internal utils.

	$ascSort = function ($left, $right) {
		if ($left === $right) return 0;
		if ($left > $right)   return -1;
		if ($left < $right)   return 1;
	};


	// Function.

	$sequence = function () {
		$fns = func_get_args();
		return function () use ($fns) {
			return L::reduce( function ($memo, $fn) {
				return $fn($memo);
			}, array_slice($fns, 1), call_user_func_array($fns[0], func_get_args()));
		};
	};

	$compose = function () {
		$fns = func_get_args();
		$fns = array_reverse($fns);
		return call_user_func_array(L::sequence(), $fns);
	};

	$call = function ($fn) {
		$args = array_slice(func_get_args(), 1);
		return call_user_func_array($fn, $args);
	};

	$callOn = function () {
		$all = func_get_args();
		$args = array_slice($all, 0, -1);
		$fn = end($all);
		return call_user_func_array($fn, $args);
	};

	$apply = function ($fn, $args) {
		return call_user_func_array($fn, $args);
	};

	$autoCurryTo = function ($arity, $fn) use (&$autoCurryTo) {
		return function () use ($fn, $arity, $autoCurryTo) {
			$numArgs = func_num_args();
			if ($numArgs >= $arity) {
				return call_user_func_array($fn, func_get_args());
			} else {
				$args = func_get_args();
				return $autoCurryTo($arity - $numArgs, function () use ($fn, $args) {
					return call_user_func_array($fn, array_merge($args, func_get_args()));
				});
			}
		};
	};

	$autoCurry = function ($fn) use ($autoCurryTo) {
		$ref = new ReflectionFunction($fn);
		$arity = $ref->getNumberOfRequiredParameters();
		return $autoCurryTo($arity, $fn);
	};

	$partial = function ($fn) {
		$args = array_slice(func_get_args(), 1);
		return function () use ($fn, $args) {
			return call_user_func_array($fn, array_merge($args, func_get_args()));
		};
	};

	$partialRight = function ($fn) {
		$args = array_slice(func_get_args(), 1);
		return function () use ($fn, $args) {
			return call_user_func_array($fn, array_merge(func_get_args(), $args));
		};
	};

	$flipTo = function ($arity, $fn) {
		return function () use ($fn, $arity) {
			$args = array_slice(func_get_args(), 0, $arity);
			while (count($args) < $arity) {
				$args[] = null;
			}
			$args = array_reverse($args);
			return call_user_func_array($fn, $args);
		};
	};

	$flip = function ($fn) use ($flipTo) {
		$ref = new ReflectionFunction($fn);
		$arity = $ref->getNumberOfRequiredParameters();
		return $flipTo($arity, $fn);
	};

	$arity = function ($n, $fn) {
		return function () use ($n, $fn) {
			$args = array_slice(func_get_args(), 0, $n);
			return call_user_func_array($fn, $args);
		};
	};

	$skip = function ($count, $fn) {
		return function () use (&$count, $fn) {
			if ($count <= 0) return call_user_func_array($fn, func_get_args());
			$count--;
		};
	};

	$take = function ($count, $fn) {
		return function () use (&$count, $fn) {
			if ($count <= 0) return;
			$count--;
			return call_user_func_array($fn, func_get_args());
		};
	};


	// Iteration.

	$map = function ($fn, $arr) {
		return array_map($fn, $arr);
	};

	$reduce = function ($fn, $arr, $initial = null) {
		if (func_num_args() < 3) {
			$initial = reset($arr);
			$arr = array_slice($arr, 1);
		}
		return array_reduce($arr, $fn, $initial);
	};

	$reduceOn = function ($arr, $fn, $initial = null) {
		if (func_num_args() < 3) {
			$initial = reset($arr);
			$arr = array_slice($arr, 1);
		}
		return array_reduce($arr, $fn, $initial);
	};

	$filter = function ($fn, $arr) {
		return array_filter($arr, $fn);
	};

	$find = function ($fn, $arr) {
		foreach ($arr as $key => $value) {
			if ($fn($value, $key, $arr)) return $value;
		}
		return null;
	};

	$findKey = function ($fn, $arr) {
		foreach ($arr as $key => $value) {
			if ($fn($value, $key, $arr)) return $key;
		}
		return null;
	};

	$each = function ($fn, $arr) {
		foreach ($arr as $key => $value) {
			$fn($value, $key, $arr);
		}
		return $arr;
	};


	// Extraction.

	$prop = function ($prop, $obj) {
		return $obj[$prop];
	};

	$keys = function ($arr) {
		return array_keys($arr);
	};


	// Comparison.

	$equals = function ($a, $b) {
		return $a === $b;
	};


	// Convenience.

	$flatten = function ($arr) {
		return L::flattenTo(999999, $arr);
	};

	$flattenTo = function ($depth, $arr) {
		if ($depth <= 0) return $arr;
		return L::reduce( function ($memo, $item) {
			if (is_array($item)) return array_merge($memo, L::flattenTo($depth - 1, $item));
			$memo[] = $item;
			return $memo;
		}, $arr, array());
	};

	$unique = function ($arr) {
		return L::reduce( function ($memo, $item) {
			if (in_array($item, $memo)) return $memo;
			$memo[] = $item;
			return $memo;
		}, $arr, array());
	};

	$sort = function ($arr) use ($ascSort) {
		return L::sortBy($ascSort, $arr);
	};

	$sortBy = function ($fn, $arr) {
		$len = count($arr);
		if ($len <= 1) return $arr;
		$pivot = $arr[0];
		$left = array(); $right = array();
		$i = 0;
		while (++$i < $len) {
			$item = $arr[$i];
			$comparison = $fn($pivot, $item);
			if ($comparison >= 0) $right[] = $item;
			else $left[] = $item;
		}
		return array_merge(L::sortBy($fn, $left), array($pivot), L::sortBy($fn, $right));
	};


	// Defining utilities.

	L::$fns = array(
		'compose'      => $autoCurryTo(1, $compose),
		'sequence'     => $autoCurryTo(1, $sequence),
		'call'         => $autoCurryTo(2, $call),
		'callOn'       => $autoCurryTo(2, $callOn),
		'apply'        => $autoCurry($apply),
		'applyOn'      => $autoCurryTo(2, $flip($apply)),
		'autoCurry'    => $autoCurry($autoCurry),
		'autoCurryTo'  => $autoCurry($autoCurryTo),
		'partial'      => $autoCurryTo(2, $partial),
		'partialRight' => $autoCurryTo(2, $partialRight),
		'flip'         => $autoCurry($flip),
		'flipTo'       => $autoCurry($flipTo),
		'arity'        => $autoCurry($arity),
		'skip'         => $autoCurry($skip),
		'take'         => $autoCurry($take),
		
		'map'          => $autoCurry($map),
		'mapOn'        => $autoCurryTo(2, $flip($map)),
		'reduce'       => $autoCurry($reduce),
		'reduceOn'     => $autoCurryTo(2, $reduceOn),
		'filter'       => $autoCurry($filter),
		'filterOn'     => $autoCurryTo(2, $flip($filter)),
		'find'         => $autoCurry($find),
		'findOn'       => $autoCurryTo(2, $flip($find)),
		'findKey'      => $autoCurry($findKey),
		'findKeyOn'    => $autoCurryTo(2, $flip($findKey)),
		'each'         => $autoCurry($each),
		'eachOn'       => $autoCurryTo(2, $flip($each)),
		
		'prop'         => $autoCurry($prop),
		'propOn'       => $autoCurryTo(2, $flip($prop)),
		'keys'         => $autoCurry($keys),
		
		'equals'       => $autoCurry($equals),

		'flatten'      => $autoCurry($flatten),
		'flattenTo'    => $autoCurry($flattenTo),
		'unique'       => $autoCurry($unique),
		'sort'         => $autoCurry($sort),
		'sortBy'       => $autoCurry($sortBy),
	);

});
