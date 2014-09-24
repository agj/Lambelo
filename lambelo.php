<?php

class L {

	static function __callStatic($name, $args) {
		$fn = self::$fns[$name];
		return call_user_func_array($fn, $args);
	}

	static $fns;
}

$autoCurry = function ($fn) use (&$autoCurryTo) {
	$ref = new ReflectionFunction($fn);
	$arity = $ref->getNumberOfRequiredParameters();
	return $autoCurryTo($arity, $fn);
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

$ascSort = function ($left, $right) {
	if ($left === $right) return 0;
	if ($left > $right)   return -1;
	if ($left < $right)   return 1;
};

L::$fns = array(
	'autoCurry' => $autoCurry,

	'autoCurryTo' => $autoCurryTo,

	'map' => $autoCurry( function ($fn, $obj) {
		return array_map($fn, $obj);
	}),

	'reduce' => $autoCurry( function ($fn, $obj, $initial = null) {
		if (is_null($initial)) return array_reduce($obj, $fn);
		return array_reduce($obj, $fn, $initial);
	}),

	'filter' => $autoCurry( function ($fn, $obj) {
		return array_filter($obj, $fn);
	}),

	'prop' => $autoCurry( function ($prop, $obj) {
		return $obj[$prop];
	}),

	'flatten' => $autoCurry( function ($obj) {
		return L::flattenTo(999999, $obj);
	}),

	'flattenTo' => $autoCurry( function ($depth, $obj) {
		if ($depth <= 0) return $obj;
		return L::reduce( function ($memo, $item) {
			if (is_array($item)) return array_merge($memo, L::flattenTo($depth - 1, $item));
			$memo[] = $item;
			return $memo;
		}, $obj, array());
	}),

	'unique' => $autoCurry( function ($arr) {
		return L::reduce( function ($memo, $item) {
			if (in_array($item, $memo)) return $memo;
			$memo[] = $item;
			return $memo;
		}, $arr, array());
	}),

	'sort' => $autoCurry( function ($arr) use ($ascSort) {
		return L::sortBy($ascSort, $arr);
	}),

	'sortBy' => $autoCurry( function ($fn, $arr) {
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
	}),
);


