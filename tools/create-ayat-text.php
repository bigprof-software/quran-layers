<?php

	include('autoloader.php');

	if(!isset($argv[1]) || !isset($argv[2]))
		die(
			"Usage: php create-ayat-text.php source-file path\n" .
			"Example:\n" .
			"php create-ayat-text.php quran-text.txt text\n"
		);

	$sourceFile = $argv[1];
	$path = $argv[2];

	$file = __DIR__ . '/../resources/' . $sourceFile;
	$ayat = @file($file);
	if(!$ayat) die("Source file '{$file}' not found");

	$ayatResolved = [];

	foreach ($ayat as $aya) {
		list($index, $text) = explode(':', $aya);
		list($ayaNum, $sura) = explode('/', $index);
		
		$ayatResolved[intval($sura)][intval($ayaNum)] = trim($text);
	}

	echo "Please wait while extracting ayat from source file '{$file}'\n";

	AyatMap::forEachAya(function($suraNum, $ayaNum) use ($ayatResolved, $path) {
		$text = $ayatResolved[$suraNum][$ayaNum];
		$ayaPath = sprintf(__DIR__ . '/../api/%03d/%03d', $suraNum, $ayaNum);

		echo "Writing to {$ayaPath}/{$path}: ";

		if(@mkdir("{$ayaPath}/{$path}") || is_dir("{$ayaPath}/{$path}")) {
			file_put_contents("{$ayaPath}/{$path}/index.html", $text);
			echo "OK\n";
		} else {
			echo "FAILED!\n";
		}

		if($path == 'text')
			@file_put_contents("{$ayaPath}/index.html", $text);
	});

	echo "Done. Ayat extracted to /{sura}/{aya}/{$path}\n";
