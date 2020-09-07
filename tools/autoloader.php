<?php

	spl_autoload_register(function($class) {
		$toolsDir = __DIR__;
		@include("{$toolsDir}/lib/{$class}.php");
	});
