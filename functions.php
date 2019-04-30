<?php
function xcut1($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function spaces1($it){
	$it=str_replace('(', ' ( ', $it);
	$it=str_replace(')', ' ) ', $it);
	$it=str_replace('==', ' == ', $it);
	$it=str_replace('||', ' || ', $it);
	$it=str_replace('&&', ' && ', $it);
	$it=str_replace('>', ' > ', $it);
	$it=str_replace('<', ' < ', $it);
	$it=str_replace('>=', ' >= ', $it);
	$it=str_replace('<=', ' <= ', $it);
	$it=str_replace('-', ' - ', $it);
	$it=str_replace('+', ' + ', $it);
	$it=str_replace('*', ' * ', $it);
	$it=str_replace('/', ' / ', $it);
	$it=str_replace('%', ' % ', $it);
	$it=str_replace('!', ' ! ', $it);
	$it=str_replace('=', ' = ', $it);
	$it=str_replace(',', ' , ', $it);
	$it=str_replace('{', ' { ', $it);
	$it=str_replace('}', ' } ', $it);
	
	$it=str_replace('=  =', '==', $it);
	$it=str_replace('= =', '==', $it);
	$it=str_replace('!  =', '!=', $it);
	$it=str_replace('! =', '!=', $it);
	$it=str_replace("<  =", "<=", $it);
	$it=str_replace("< =", "<=", $it);
	$it=str_replace("=  >", "=>", $it);
	$it=str_replace("= >", "=>", $it);
	
	$it=str_replace('let', 'let ', $it);
	return $it;
}

function no_double_spaces1($it){
	for ($h=0; $h<20; $h++){
		$it=str_replace('  ', ' ', $it);
	}
	for ($h=0; $h<20; $h++){
		$it=str_replace("\n\n", "\n", $it);
	}
	return $it;
}

function standartize_code($data){
	$data=str_replace("\r\n", "\n", $data);
	$data=str_replace("\t", "", $data);

	$data=no_double_spaces1($data);
	$data=str_replace(' ', '', $data);

	$data=spaces1($data);
	$data=no_double_spaces1($data);

	return $data;
}


#Gives correct names to variables which equal extracted value. It need for compiler
function standartize_variables_names($data){
	


$codelines=explode("\n", $data);
$codec=count($codelines);

for ($i=0; $i<$codec; $i++){
	$codelines[$i]= " " . $codelines[$i] . " ";
	$ab=$codelines[$i];
	$cv=xcut1($ab,'let ', ' =');
	if (strlen($cv) == 0){
		$cv=xcut1($ab,'let ', ' =');
	}
	$cv=trim($cv);
	
	//print "i $i, cv $cv \n";
	

	
	
	$p1=strpos($ab, "extract");
	$p2=strpos($ab, 'data ,');
	file_put_contents('cv.txt', "p1 $p1 !!\n", FILE_APPEND);
	if ($p1 && !$p2){
		$cdl=substr($ab, $p1);
		$nvr=xcut1($cdl,'"','" )');
		//$codelines[$i]= " let " . $nvr. "= " .$codelines[$i];
		//$codelines=str_replace(" $cv ", " $nvr ", $codelines);
		$replace1[]=$cv;
		$replace2[]=$nvr;
		file_put_contents('cv.txt', "dfalse !$cv! !$nvr!<br/>\n", FILE_APPEND);
	}
	
	if ($p1 && $p2){
		$cdl=substr($ab, $p1);
		$nvr=xcut1($cdl,'"','" )');
		$nvr = "new" . ucfirst($nvr);
		//$codelines[$i]= " let " . $nvr. "= " .$codelines[$i];
		//$codelines=str_replace(" $cv ", " $nvr ", $codelines);
		$replace1[]=$cv;
		$replace2[]=$nvr;
		//print "cv !$cv!, nvr !$nvr!";
		file_put_contents('cv.txt', "dtrue !$cv! !$nvr!<br/>\n", FILE_APPEND);
	}
	
}
	$data=implode("\n", $codelines);


	$c=count($replace1);

	for ($i=0; $i<$c; $i++){
		$data=str_replace(" $replace1[$i] ", " $replace2[$i] ", $data);
	}
	
	$data=no_double_spaces1($data);

	return $data;
}






#It need for compiler, because he dont like start variables names in finish definition
function expand_finish($tmpcode){

	
$list=explode("\n", $tmpcode);

//print_r($codelines);

	$c=count($list);
	
	//print_r($list);


	for ($i=0; $i<$c; $i++){
		
		$line=trim($list[$i]);
		if ($line == '' || strpos(" $line", '#') ){
			continue;
		}

		
		if (!strpos(" $line", 'let') && !strpos(" $line", 'match') && !strpos(" $line", '=>') && !strpos(" $line", '{') && !strpos(" $line", '}') ){
			$eendpoints[] = " $line ";
			//print "found!";
		}
			
		
	}
	
	//print_r($endpoints);
	//print "endp";
	$ff1=trim($eendpoints[1]);
	
	//print_r($eendpoints);
	
	//Fixing bug with final condition, where start variables cant be in finish
	
	$ff2= "let fState = $ff1\n fState";

//file_put_contents('cv.txt', "$ff1\n$ff2", FILE_APPEND);



$clt=xcut1("$tmpcode", "TransferTransaction", "}");
$cst=substr_count(" $clt" , "let");

//print "cst $cst, f1 $f1, f2 $f2";

if ($cst == 0){
	//print "f1 $f1, f2 $f2";
	$tmpcode=str_replace($ff1, $ff2, $tmpcode);
}



return $tmpcode;
}

	
	function op($it, $operand, $newOperand, $dbg=0){
		
		if ($_GET['dbg'] == 10)
		print "start: $it \n\n";
		
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
		
		$it=str_replace('* ', '*', $it);
		$it=str_replace(' *', '*', $it);
		$it=str_replace('/ ', '/', $it);
		$it=str_replace(' /', '/', $it);
		$it=str_replace('% ', '%', $it);
		$it=str_replace(' %', '%', $it);
		
		$it=str_replace('< ', '<', $it);
		$it=str_replace(' <', '<', $it);
		$it=str_replace('> ', '>', $it);
		$it=str_replace(' >', '>', $it);
		
		$it=str_replace('<= ', '<=', $it);
		$it=str_replace(' <=', '<=', $it);
		$it=str_replace('>= ', '>=', $it);
		$it=str_replace(' >=', '>=', $it);
		
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
		
		if ($_GET['dbg'] == 10)
		print "finish: $new_str \n\n";
	
		return $new_str;
	}


