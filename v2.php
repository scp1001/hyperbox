<?php
require_once('functions.php');

function si($str,$insertstr,$pos)
		{
			$str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
			return $str;
		}  
	


	
	
	$str= " humanTravel && newWolf==wolf && newGoat==goat && newCabbage==cabbage ";
	$str= " nc < nd || nb > na ";
	$str= " nc <= nd || nb >= na ";
	$nv=op($str, '||', 'Or', 1);
	
	print "\n\n$nv";
	




die();

