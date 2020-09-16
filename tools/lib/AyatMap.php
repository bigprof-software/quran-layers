<?php
	/**
	 * 
	 */
	class AyatMap {
		
		public static function suraAyatCount() {
			/*
			 This was obtained by running the following JS code in the console of the page
			 https://en.wikipedia.org/wiki/List_of_chapters_in_the_Quran
			 then pasting the clipboard contents

			 var ayatOfSura = {}, sura = 1;
			 $('table').eq(0).find('tr td:nth-child(5)').each(function() {
			 	ayatOfSura[sura] = $(this).text().trim().match(/^\d{1,3}/)[0];
			 	sura++;
			 });
			 copy(JSON.stringify(ayatOfSura));

			 */
			return json_decode('{"1":"7","2":"286","3":"200","4":"176","5":"120","6":"165","7":"206","8":"75","9":"129","10":"109","11":"123","12":"111","13":"43","14":"52","15":"99","16":"128","17":"111","18":"110","19":"98","20":"135","21":"112","22":"78","23":"118","24":"64","25":"77","26":"227","27":"93","28":"88","29":"69","30":"60","31":"34","32":"30","33":"73","34":"54","35":"45","36":"83","37":"182","38":"88","39":"75","40":"85","41":"54","42":"53","43":"89","44":"59","45":"37","46":"35","47":"38","48":"29","49":"18","50":"45","51":"60","52":"49","53":"62","54":"55","55":"78","56":"96","57":"29","58":"22","59":"24","60":"13","61":"14","62":"11","63":"11","64":"18","65":"12","66":"12","67":"30","68":"52","69":"52","70":"44","71":"28","72":"28","73":"20","74":"56","75":"40","76":"31","77":"50","78":"40","79":"46","80":"42","81":"29","82":"19","83":"36","84":"25","85":"22","86":"17","87":"19","88":"26","89":"30","90":"20","91":"15","92":"21","93":"11","94":"8","95":"8","96":"19","97":"5","98":"8","99":"8","100":"11","101":"11","102":"8","103":"3","104":"9","105":"5","106":"4","107":"7","108":"3","109":"6","110":"3","111":"5","112":"4","113":"5","114":"6"}', true);
		}

		public static function suraNames() {
			// TODO -- returns a map of suraNum => suraName (in Arabic)	
		}

		/**
		 * Iterate through ayat of each sura and execute the callback function provided, optionally mapping
		 * the return value to a 2D array of sura numbers => aya numbers and returning that array.
		 *
		 * @param      callable  $callback  The callback function, accepting suraNumber, ayaNumber 
		 * @param      bool      $return    If set to true, accepts a return value from the callback into a 2D array and returns it
		 */
		public static function forEachAya($callback, $return = false) {
			$suras = self::suraAyatCount();
			if($return) $map = [];

			foreach($suras as $suraNum => $ayatCount)
				for($ayaNum = 1; $ayaNum <= $ayatCount; $ayaNum++) {
					if(!$return) {
						$callback($suraNum, $ayaNum);
						continue;
					}

					$map[$suraNum][$ayaNum] = $callback($suraNum, $ayaNum);
				}

			if($return) return $map;
		}
	}