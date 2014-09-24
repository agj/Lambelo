<?php

class L {

	static function __callStatic($name, $args) {
		$fn = self::$fns[$name];
		return call_user_func_array($fn, $args);
	}

	static $fns;
}

call_user_func( function () { // Creating a closure to prevent variable leakage.

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

	$ascSort = function ($left, $right) {
		if ($left === $right) return 0;
		if ($left > $right)   return -1;
		if ($left < $right)   return 1;
	};

	$map = function ($fn, $obj) {
		return array_map($fn, $obj);
	};

	$reduce = function ($fn, $obj, $initial = null) {
		if (is_null($initial)) return array_reduce($obj, $fn);
		return array_reduce($obj, $fn, $initial);
	};

	$filter = function ($fn, $obj) {
		return array_filter($obj, $fn);
	};

	$prop = function ($prop, $obj) {
		return $obj[$prop];
	};

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

	$sequence = function () {
		$fns = func_get_args();
		return function () use ($fns) {
			return L::reduce( function ($memo, $fn) {
				return $fn($memo);
			}, array_slice($fns, 1), call_user_func_array($fns[0], func_get_args()));
		};
	};

	$call =function ($fn) {
		$args = array_slice(func_get_args(), 1);
		return call_user_func_array($fn, $args);
	};

	$apply = function ($fn, $args) {
		return call_user_func_array($fn, $args);
	};

	$equals = function ($a, $b) {
		return $a === $b;
	};


	L::$fns = array(
		'autoCurry'   => $autoCurry,
		'autoCurryTo' => $autoCurryTo,
		'map'         => $autoCurry($map),
		'reduce'      => $autoCurry($reduce),
		'filter'      => $autoCurry($filter),
		'prop'        => $autoCurry($prop),
		'flatten'     => $autoCurry($flatten),
		'flattenTo'   => $autoCurry($flattenTo),
		'unique'      => $autoCurry($unique),
		'sort'        => $autoCurry($sort),
		'sortBy'      => $autoCurry($sortBy),
		'sequence'    => $autoCurryTo(1, $sequence),
		'call'        => $autoCurryTo(2, $call),
		'apply'       => $autoCurry($apply),
		'equals'      => $autoCurry($equals),
	);

});
