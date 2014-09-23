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

L::$fns = array(
	'autoCurry' => $autoCurry,

	'autoCurryTo' => $autoCurryTo,

	'map' => $autoCurry( function ($fn, $obj) {
		return array_map($fn, $obj);
	}),

	'filter' => $autoCurry( function ($fn, $obj) {
		return array_filter($obj, $fn);
	}),
);
