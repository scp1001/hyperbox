<?php

die('Unit tests are just special case of Formal Verification.');

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

#$finish= '( inputSigned && deadlineCorrect && !gameFinished ) || ( dataSize == 9 ) ';
$finish= 'side && safe && humanTravel && objectTravel';
//$finish= 'human == wolf == goat == cabbage == true';
#$finish= 'win';

//Important for correct variable parsing


function expansion($finish){
	global $new, $level;
	
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
	$finish=str_replace('!', ' ! ', $finish);
	

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
		
		$tline=str_replace(" ", '', $line);
		$tline=str_replace("\r", '', $line);
		$tline=str_replace("\n", '', $line);
		$tline=str_replace("\t", '', $line);
		
		if ($tline == '' || strpos(" $line", '#') ){
			continue;
		}

		
		if (!strpos(" $line", 'let') && !strpos(" $line", 'match') && !strpos(" $line", '=>') && !strpos(" $line", '{') && !strpos(" $line", '}') ){
			$endpoints[] = " $line ";
		}
			
		
	}
	
	//print_r($endpoints);
	$finish1=$finish;
	$finish2=$endpoints[0];
	
	$finish=$finish1;
	$finish2=$finish2;

	
	$finish=$finish2;
	
	
	//die();
	

	
	
	

	
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
			
			
			$new[$v]=$level. '_' . $str;
			//print " after $finish<br/><br/>";
			//$finish=str_replace("#$v#", " $str", $finish);


		}
	}
	
	return $finish;

}


print "Start сonditions: $finish <br/><br/>";

$depth=15;



for ($i=0; $i<$depth; $i++){
	$level=$i;
	
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


print "<br/><br/>";



	
	foreach ($vrs as $k=>$v){
		$vp[]=strpos($finish, $v);		
	}

	//		
	
	//print_r($vp);

	
	for ($i=0; $i<100; $i++){
		$now=strpos($finish, '||', $now);
		if ($now === FALSE){
			break;
		}
		$op[]=$now;
	}


	//print_r($op);

	foreach($op as $k=>$v){
		
	}

	
	$c=count($new);
	
	$new=array_reverse($new);

	if ($_GET['dbg'] == 1)
	print_r($new);
	
	//Start from long vars because if we start with short, we can affect it twice
	
	function levels($str){
		$str=explode('_', $str);
		return $str[0];
	}
	
	$keys = array_map('levels', array_values($new));
	array_multisort($keys, SORT_DESC, $new);
	
	//Now it is sorted by levels and we can remove them
	foreach ($new as $k=>$v){
		
		$v=explode('_', $v);
		$v=$v[1];
		$new[$k]=$v;
		
		//print "v $v ;;;<br/>";
		//continue;
	}
	
	//print_r($new);	
	//die();
	
	function si($str,$insertstr,$pos)
		{
			$str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
			return $str;
		}  
	
	
	function op($it, $operand, $newOperand, $dbg=0){
		
		if ($dbg != 0)
		print "<br/>***<br/>";
		
		$it=trim($it);
		$it =" $it ";
		for ($q=0; $q<10; $q++){
			$it=str_replace('  ', ' ', $it);
		}
		//pelengation end for operand
		$it=str_replace('== ', '==', $it);
		$it=str_replace(' ==', '==', $it);
		$it=str_replace('!= ', '!=', $it);
		$it=str_replace(' !=', '!=', $it);
		$it=str_replace('- ', '-', $it);
		$it=str_replace(' -', '-', $it);
		$it=str_replace('+ ', '+', $it);
		$it=str_replace(' +', '+', $it);
		
		//if ($dbg != 0)
		//print " Debug mode ";
		
	//print "<br/><br/>$it<br/>";
	
		
		//$pos= strpos($it, "||", $pos+1);
	    $pos= strpos($it, "$operand");
		
		if ($pos === FALSE){
			return $it;
		}
		
		if ($dbg != 0)
		print "pos $pos; <br/>";
		
		$tmp1=substr($it, 0, $pos-1);
		$tmp2=substr($it, $pos + 2 + 1);   //operator length + 1
		
		if ($dbg != 0)
		print " tmp1 !$tmp1!, tmp2 !$tmp2!";
		$last_space= strrpos($tmp1, ' ');
		
		$first_var= substr($tmp1, $last_space);
		
		//print " last space $last_space ; fv $first_var ";
		
		$first_space= strpos($tmp2, ' ');
		$second_var= substr($tmp2, 0, $first_space);
		
		//print "second var $second_var";
		
		
		$tmp1=si($tmp1, $newOperand.'(', $last_space + 1);
		$tmp2=si($tmp2, ')', $first_space);
		$new_str=$tmp1.','.$tmp2;
		
		if ($dbg != 0)
		print "<br/>---<br/>";
		return $new_str;
	}
	
	function antispaces($it){
		$it=str_replace(' ( ', '(', $it);
		$it=str_replace(' ) ', ')', $it);
		$it=str_replace(' == ', '==', $it);
		$it=str_replace(' || ', '||', $it);
		$it=str_replace(' &&', '&&', $it);
		$it=str_replace(' > ', '>', $it);
		$it=str_replace(' < ', '<', $it);
		$it=str_replace(' - ', '-', $it);
		$it=str_replace(' + ', '+', $it);
		$it=str_replace(' * ', '*', $it);
		$it=str_replace(' / ', '/', $it);
		$it=str_replace(' % ', '%', $it);
		$it=str_replace(' ! ', '!', $it);
		$it=str_replace(' = ', '=', $it);
		return $it;
	}
	
	function state($it){
		$it=trim($it);
		$it= " $it ";
		
	$it=str_replace('(', ' ( ', $it);
	$it=str_replace(')', ' ) ', $it);
	$it=str_replace('==', ' == ', $it);
	$it=str_replace('||', ' || ', $it);
	$it=str_replace('&&', ' && ', $it);
	$it=str_replace('>', ' > ', $it);
	$it=str_replace('<', ' < ', $it);
	$it=str_replace('-', ' - ', $it);
	$it=str_replace('+', ' + ', $it);
	$it=str_replace('*', ' * ', $it);
	$it=str_replace('/', ' / ', $it);
	$it=str_replace('%', ' % ', $it);
	$it=str_replace('!', ' ! ', $it);
	$it=str_replace('=', ' = ', $it);
	$it=str_replace('= =', '==', $it);
	$it=str_replace(',', ' , ', $it);
		
		//return $it;
		global $new;
		foreach ($new as $k=>$v){
			
			
				
			if (strpos(" $k", 'new')){
				$it=str_replace("$k ", $k.'[i+1] ', $it);
				//$it=str_replace('new', '', $it);					
			}else{
				$it=str_replace("$k ", $k.'[i] ', $it);		
			}
		}
		return $it;
	}
	
	
	foreach ($new as $k=>$v){
		
		
		
		//print "v $v ;;;<br/>";
		//continue;
		
		if (strpos(" $v", 'extract')){
			continue;
		}
			
		
		$v=str_replace('==', ' == ', $v);
		$v=str_replace(' ==  ', ' == ', $v);
		$v=str_replace('  == ', ' == ', $v);
		$v=str_replace('+', ' + ', $v);
		$v=str_replace(' +  ', ' + ', $v);
		$v=str_replace('  + ', ' + ', $v);
		$v=str_replace('-', ' - ', $v);
		$v=str_replace(' -  ', ' - ', $v);
		$v=str_replace('  - ', ' - ', $v);
		
		
		$pos=0;
		
		$nv=$v;
		for ($q=0; $q<50; $q++){
			$nv=op($nv, '||', 'Or');
			$nv=op($nv, '&&', 'And');
		}
		
		$kk=$k;
		//$kk=state($k);
		$nv=state($nv);
		$nv=str_replace('new', '', $nv);
		$nv=str_replace('=  =', '==', $nv);
		$nv=str_replace('= =', '==', $nv);
		$nv=str_replace('!  =', '!=', $nv);
		$nv=str_replace('! =', '!=', $nv);
		
		
		$nv=str_replace(' Q', ' q', $nv);
		$nv=str_replace(' W', ' w', $nv);
		$nv=str_replace(' E', ' e', $nv);
		$nv=str_replace(' R', ' r', $nv);
		$nv=str_replace(' T', ' t', $nv);
		$nv=str_replace(' Y', ' y', $nv);
		$nv=str_replace(' U', ' u', $nv);
		$nv=str_replace(' I', ' i', $nv);
		$nv=str_replace(' O', ' o', $nv);
		$nv=str_replace(' P', ' p', $nv);
		$nv=str_replace(' A', ' a', $nv);
		$nv=str_replace(' S', ' s', $nv);
		$nv=str_replace(' D', ' d', $nv);
		$nv=str_replace(' F', ' f', $nv);
		$nv=str_replace(' G', ' g', $nv);
		$nv=str_replace(' H', ' h', $nv);
		$nv=str_replace(' J', ' j', $nv);
		$nv=str_replace(' K', ' k', $nv);
		$nv=str_replace(' L', ' l', $nv);
		$nv=str_replace(' Z', ' z', $nv);
		$nv=str_replace(' X', ' x', $nv);
		$nv=str_replace(' C', ' c', $nv);
		$nv=str_replace(' V', ' v', $nv);
		$nv=str_replace(' B', ' b', $nv);
		$nv=str_replace(' N', ' n', $nv);
		$nv=str_replace(' M', ' m', $nv);
		
		$nv=str_replace(' and ', ' And', $nv);
		$nv=str_replace(' or ', ' Or', $nv);
		
		
		
		/*
		if (strpos(" $k", 'new')){
			$kk=$k.'[i+1]';
		}else{
			$kk=$k.'[i]';
		}
		*/
		

		
		#print "before $k= $v<br/>---<br/>";
		print "$kk= [ $nv for i in range(Num-1) ]<br/>";
	}
	
	//$it= op("safeWithoutHuman || newGoat == newHuman ", '||');
	
	//print "it !$it! <br/>";
	
	//print op($it, '||');
	
	