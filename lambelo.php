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


	// Iteration.

	$map = function ($fn, $obj) {
		return array_map($fn, $obj);
	};

	$reduce = function ($fn, $obj, $initial = null) {
		if (is_null($initial)) return array_reduce($obj, $fn);
		return array_reduce($obj, $fn, $initial);
	};

	$reduceOn = function ($obj, $fn, $initial = null) {
		if (is_null($initial)) return array_reduce($obj, $fn);
		return array_reduce($obj, $fn, $initial);
	};

	$filter = function ($fn, $obj) {
		return array_filter($obj, $fn);
	};

	$each = function ($fn, $obj) {
		foreach ($obj as $key => $value) {
			$fn($value, $key, $obj);
		}
		return $obj;
	};


	// Extraction.

	$prop = function ($prop, $obj) {
		return $obj[$prop];
	};

	$keys = function ($obj) {
		return array_keys($obj);
	};


	// Comparison.

	$equals = function ($a, $b) {
		return $a === $b;
	};


	// Convenience.

	$flatten = function ($obj) {
		return L::flattenTo(999999, $obj);
	};

	$flattenTo = function ($depth, $obj) {
		if ($depth <= 0) return $obj;
		return L::reduce( function ($memo, $item) {
			if (is_array($item)) return array_merge($memo, L::flattenTo($depth - 1, $item));
			$memo[] = $item;
			return $memo;
		}, $obj, array());
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
		'compose'     => $autoCurryTo(1, $compose),
		'sequence'    => $autoCurryTo(1, $sequence),
		'call'        => $autoCurryTo(2, $call),
		'callOn'      => $autoCurryTo(2, $flipTo(2, $call)),
		'apply'       => $autoCurry($apply),
		'applyOn'     => $autoCurryTo(2, $flip($apply)),
		'autoCurry'   => $autoCurry,
		'autoCurryTo' => $autoCurryTo,
		'flip'        => $autoCurry($flip),
		'flipTo'      => $autoCurry($flipTo),
		'arity'       => $autoCurry($arity),
		
		'map'         => $autoCurry($map),
		'mapOn'       => $autoCurryTo(2, $flip($map)),
		'reduce'      => $autoCurry($reduce),
		'reduceOn'    => $autoCurryTo(2, $reduceOn),
		'filter'      => $autoCurry($filter),
		'filterOn'    => $autoCurryTo(2, $flip($filter)),
		'each'        => $autoCurry($each),
		'eachOn'      => $autoCurryTo(2, $flip($each)),
		
		'prop'        => $autoCurry($prop),
		'keys'        => $autoCurry($keys),
		
		'equals'      => $autoCurry($equals),
		
		'flatten'     => $autoCurry($flatten),
		'flattenTo'   => $autoCurry($flattenTo),
		'unique'      => $autoCurry($unique),
		'sort'        => $autoCurry($sort),
		'sortBy'      => $autoCurry($sortBy),
	);

});
