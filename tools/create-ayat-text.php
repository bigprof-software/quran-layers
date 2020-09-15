<?php

	/* Usage: php create-ayat-text.php source-file path */
	
	include('autoloader.php');

	$sourceFile = isset($argv[1]) ? $argv[1] : 'quran-text.txt';
	$path = isset($argv[2]) ? $argv[2] : 'text';

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

	foreach ($ayatResolved as $sura => $ayat)
		foreach ($ayat as $ayaNum => $text) {
			$ayaPath = sprintf(__DIR__ . '/../%03d/%03d', $sura, $ayaNum);

			echo "Writing to {$ayaPath}/{$path}: ";

			if(@mkdir("{$ayaPath}/{$path}") || is_dir("{$ayaPath}/{$path}")) {
				file_put_contents("{$ayaPath}/{$path}/index.html", $text);
				echo "OK\n";
			} else {
				echo "FAILED!\n";
			}

			if($path == 'text')
				@file_put_contents("{$ayaPath}/index.html", $text);
		}

	echo "Done. Ayat extracted to /{sura}/{aya}/{$path}\n";
