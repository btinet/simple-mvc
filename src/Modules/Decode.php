<?php

namespace simplemvc\ Modules;

class Decode {
	
	public function imap($input = false){
		
		// Unnötige Zeichen definieren
		$_replace = array('=?', '?= ', 'UTF-8', 'iso-8859-1', '?B?', '?Q?');
				
		// Prüfen, ob $input übergeben wurde
		if ($input){
			
			// Zeichenkodierung erkennen
			if (strpos($input, 'UTF')!== false) {
				$format = 'UTF';
			} elseif (strpos($input, 'iso')!== false) {
				$format = 'ISO';
			} else {
				$format = 'UTF';
			}			
			
			// Encoding erkennen
			if (strpos($input, '?B?')!== false) {
				$encoded = 'B';
			} elseif (strpos($input, '?Q?')!== false) {
				$encoded = 'Q';
			} else {
				$encoded = false;
			}
			
			// Unnötigte Zeichen entfernen
			$input = str_replace($_replace, '', $input);
			
			// Input dekodieren
			switch ($encoded){
				case 'B':
					$input = base64_decode($input);
					break;
					
				case 'Q':
					$input = substr(quoted_printable_decode($input),0,-1);
					$input = str_replace ('_',' ',$input);
					break;
					
				default:
					break;
			}
			
			// HTML Tags entfernen
			switch ($format){
				case 'UTF':
					$input = htmlentities($input, ENT_QUOTES | ENT_IGNORE, "UTF-8");
					break;
					
				case 'ISO':
					$input = htmlentities($input, ENT_QUOTES | ENT_IGNORE, "iso-8859-1");
					break;				
			}			
			
		}
		// Input zurückgeben
		return ($input)?$input:'-';
	}

}
?>