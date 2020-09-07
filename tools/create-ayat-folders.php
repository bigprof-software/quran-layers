<?php
	
	include('autoloader.php');

	$ayat = AyatMap::SuraAyatCount();

	foreach ($ayat as $sura => $countAyat) {
		$suraFmt = sprintf('%03d', $sura);
		@mkdir(__DIR__ . "/../{$suraFmt}");

		for($aya = 1; $aya <= $countAyat; $aya++)
			@mkdir(__DIR__ . "/../{$suraFmt}/" . sprintf('%03d', $aya));
	}
