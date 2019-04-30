<?php
die();
//code prereplace with */-+ spaces and dedouble spaces

function xcut($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


//echo $parsed; // (result = dog)



//print 'ok';


$finish= 'win || timeout && s.amount >= 10000000 && s.fee <= 1000000';
$finish= 'win';

//Important for correct variable parsing



function expansion($finish){
	
	$finish=trim($finish);
	$finish = " $finish ";
	$finish=str_replace("\r\n", "", $finish);
	$finish=str_replace("\n", "", $finish);
	
		//Our goal is extracting variables, so we just clean string from another data
	$finish=str_replace('(', ' ( ', $finish);
	$finish=str_replace(')', ' ) ', $finish);
	$finish=str_replace('==', ' == ', $finish);
	$finish=str_replace('||', ' || ', $finish);
	$finish=str_replace('&&', ' && ', $finish);
	$finish=str_replace('>', ' > ', $finish);
	$finish=str_replace('<', ' < ', $finish);
	$finish=str_replace('-', ' - ', $finish);
	$finish=str_replace('+', ' + ', $finish);
	$finish=str_replace('*', ' * ', $finish);
	$finish=str_replace('/', ' / ', $finish);
	$finish=str_replace('%', ' % ', $finish);
	

	//Remove multiple spaces and tabs
	for ($i=0; $i<50; $i++){
		$finish = str_replace("\t", ' ', $finish);
		$finish = str_replace('  ', ' ', $finish);
	}
	

		

	
	
	//Remove multiple spaces and tabs
	for ($i=0; $i<50; $i++){
		$finish = str_replace("\t", ' ', $finish);
		$finish = str_replace('  ', ' ', $finish);
	}
	

	$data=explode(' ', $finish);


	//print_r($data);


	foreach ($data AS $k=>$v){
		if (ctype_alpha($v[0]) AND $v != ''){
			$vrs[]=trim($v);
		}
	}


	//print "vrs: <br/>";

	$vrs=array_unique($vrs);

	//print_r($vrs);
	
	

	





	$code=file_get_contents('code.txt');
	

	
	//also fix to garanty that variables are separated with spaces
	/*
	$code=str_replace('-', ' - ', $code);
	$code=str_replace('+', ' + ', $code);
	$code=str_replace('*', ' * ', $code);
	$code=str_replace('/', ' / ', $code);
	$code=str_replace('%', ' % ', $code);
	*/

	for ($i=0; $i<300; $i++){
		$code = str_replace("\t", ' ', $code);
		$code = str_replace('  ', ' ', $code);
	}

	//important fix for better parsing initialization of variables
	$code=str_replace(' =', '=', $code);
	
	


	$pos=strpos($code, $finish);


	//print "<br/> pos $pos <br/>";


	$list=file('code.txt');

	$c=count($list);


	for ($i=0; $i<$c; $i++){
		$line=trim($list[$i]);
		if ($line == $finish){
			$num=$i;
			//print "Yes! $line $finish";
		}
	}

	
	//print_r($vrs);
	foreach ($vrs as $k=>$v){
		//print "<br/> vrs let $v= ";
		$p=strpos("   $code", "let $v=");
		
		//print "p $p!";
		
		if ($p != 0){
			$str=xcut($code, "let $v=", "\n");
			
			$str=trim($str);
			
			//print " Variable $v : $p, $str \n";
			//We need to replace only variables, separated with spaces

			//print "v $v; prefinish $finish<br/>";
			
			$finish=str_replace("\r\n", "", $finish);
			$finish=str_replace("\n", "", $finish);
			
			//we dont want to go on lowest level now
			if (!strpos(" $str", "extract") OR 1 != 1){
				$finish=str_replace(" $v ", " $str ", $finish);
			}
			//print " after $finish<br/><br/>";
			//$finish=str_replace("#$v#", " $str", $finish);


		}
	}
	
	return $finish;

}


print "Start сonditions: $finish <br/><br/>";

$depth=15;



for ($i=0; $i<$depth; $i++){

	
	$l1= strlen($finish) . " ";
	
	$finish=expansion($finish);
	
	$l2= strlen($finish);
	

	
	print "\n<br/>l1 $l1, l2 $l2";
	
	if ($l1 >= $l2){
		print "<br/>Expansion completed on depth $i!";
		break;
	}
	
	print "$finish<br/><br/>";
}


/*

$finish=explode(' ', $finish);

foreach ($finish as $k=>$v){
	print "$k : $v <br/>";
}

*/

$data=explode(' ', $finish);


	//print_r($data);


	foreach ($data AS $k=>$v){
		if (ctype_alpha($v[0]) AND $v != ''){
			$vrs[]=trim($v);
		}
	}


	//print "vrs: <br/>";

	$vrs=array_unique($vrs);
	
	print_r($vrs);
	
	$python='';
	
	foreach ($vrs as $k=>$v){
		$python .= "$v = Int('$v')\n";
	}


print $python;


