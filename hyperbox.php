<?php
require('functions.php');
header('Content-Type: text/html; charset=UTF-8');



$log=json_encode($_POST);
file_put_contents('jlog.txt', $log);





$pm=$_POST['message'];


if ($_GET['type'] == 2){
	$_POST['steps']= 1;
}



$pm= standartize_code($pm);

$pm=standartize_variables_names($pm);

$pm=expand_finish($pm);

$pm=str_replace(" = ", "= ", $pm);

file_put_contents('tmpcode.txt', $pm);





if ($_GET['dbg'] != '7')
file_put_contents('code.txt', $pm);

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
#$finish= 'side && safe && humanTravel && objectTravel';
//$finish= 'human == wolf == goat == cabbage == true';
#$finish= 'win';

//Important for correct variable parsing


function levels($str){
		$str=explode('_', $str);
		return $str[0];
	}

function expansion($finish, $part=0){
	global $new, $level;
	
	$finish=trim($finish);
	$finish = " $finish ";
	$finish=str_replace("\r\n", "", $finish);
	$finish=str_replace("\n", "", $finish);
	
		//Our goal is extracting variables, so we just clean string from another data
	$finish=str_replace('(', ' ( ', $finish);
	$finish=str_replace(')', ' ) ', $finish);
	$finish=str_replace('==', ' == ', $finish);
	$finish=str_replace('!=', ' != ', $finish);
	$finish=str_replace('||', ' || ', $finish);
	$finish=str_replace('&&', ' && ', $finish);
	$finish=str_replace('>', ' > ', $finish);
	$finish=str_replace('<', ' < ', $finish);
	$finish=str_replace('>=', ' >= ', $finish);
	$finish=str_replace('<=', ' <= ', $finish);
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
	$finish=$endpoints[$part];
	
	
	
	

	
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


function si($str,$insertstr,$pos)
		{
			$str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
			return $str;
		}  
	
	
	
	
	function spaces($it){
		return $it;
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
		
		$it=str_replace('=  =', '==', $it);
		$it=str_replace('= =', '==', $it);
		$it=str_replace('!  =', '!=', $it);
		$it=str_replace('! =', '!=', $it);
		
		
		return $it;
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
		$it=str_replace(', ', ',', $it);
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
	$it=str_replace('>=', ' >= ', $it);
	$it=str_replace('<=', ' <= ', $it);
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
	
	function translate($k, $v, $part=0){
		$v=str_replace('==', ' == ', $v);
		$v=str_replace(' ==  ', ' == ', $v);
		$v=str_replace('  == ', ' == ', $v);
		$v=str_replace('+', ' + ', $v);
		$v=str_replace(' +  ', ' + ', $v);
		$v=str_replace('  + ', ' + ', $v);
		$v=str_replace('-', ' - ', $v);
		$v=str_replace(' -  ', ' - ', $v);
		$v=str_replace('  - ', ' - ', $v);
		
		$v=str_replace('!=', ' != ', $v);
		$v=str_replace(' !=  ', ' != ', $v);
		$v=str_replace('  != ', ' != ', $v);
		
		$v=str_replace('*', ' * ', $v);
		$v=str_replace(' *  ', ' * ', $v);
		$v=str_replace('  * ', ' * ', $v);
		
		$v=str_replace('/', ' / ', $v);
		$v=str_replace(' /  ', ' / ', $v);
		$v=str_replace('  / ', ' / ', $v);
		
		$v=str_replace('%', ' % ', $v);
		$v=str_replace(' %  ', ' % ', $v);
		$v=str_replace('  % ', ' % ', $v);
		
		$v=str_replace('>', ' > ', $v);
		$v=str_replace(' >  ', ' > ', $v);
		$v=str_replace('  > ', ' > ', $v);
		
		$v=str_replace('<', ' < ', $v);
		$v=str_replace(' <  ', ' < ', $v);
		$v=str_replace('  < ', ' < ', $v);
		
		$v=str_replace('>=', ' >= ', $v);
		$v=str_replace(' >=  ', ' >= ', $v);
		$v=str_replace('  >= ', ' >= ', $v);
		
		$v=str_replace('<=', ' <= ', $v);
		$v=str_replace(' <=  ', ' <= ', $v);
		$v=str_replace('  <= ', ' <= ', $v);
		
		
		
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
		if ($part == 0){
			//file_put_contents('new.txt', "$kk: $nv" . "\n", FILE_APPEND);	
			return "$kk= [ $nv for i in range(Num-1) ]<br/>";
		}
		
		if ($part == 1){
			$nv=str_replace('[i]', '[Steps]', $nv);
			$nv=str_replace('[i+1]', '[Steps+1]', $nv);
			//file_put_contents('new.txt', "$kk: $nv" . "\n", FILE_APPEND);	
			return "$kk= $nv<br/>";
		}
		
	}

	
function convert($part){
global $new, $level, $stages;

if ($_GET['dbg'] == 1)
print "Start сonditions: $finish <br/><br/>";

$depth=15;



for ($i=0; $i<$depth; $i++){
	$level=$i;
	
	$l1= strlen($finish) . " ";
	
	$finish=expansion($finish,$part);
	
	$l2= strlen($finish);
	

	if ($_GET['dbg'] == 1)
	print "\n<br/>l1 $l1, l2 $l2";
	
	if ($l1 >= $l2){
		if ($_GET['dbg'] == 1)
		print "<br/>Expansion completed on depth $i!<br/>";
		break;
	}
	
	if ($_GET['dbg'] == 1)
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
	
	if ($_GET['dbg'] == 1)
	print_r($vrs);
	
	//$python='';
	
	foreach ($vrs as $k=>$v){
			//$python .= "$v = Int('$v')\n";
	}

if ($_GET['dbg'] == 1)
print $python;

if ($_GET['dbg'] == 1)
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
	
	
	
	$keys = array_map('levels', array_values($new));
	array_multisort($keys, SORT_DESC, $new);
	
	if ($_GET['dbg'] == 3){
		print "Multisorted";
		print_r($new);
	}
	
	//Now it is sorted by levels and we can remove them
	foreach ($new as $k=>$v){
		
		$v=explode('_', $v);
		$v=$v[1];
		$new[$k]=$v;
		
		//All variables
		//file_put_contents('new.txt', "$k: $v" . "\n", FILE_APPEND);	
		//print "v $v ;;;<br/>";
		//continue;
	}
	
	
	
	foreach ($new as $k=>$v){
		
		
		if ($_GET['dbg'] == 2){
			print "$k= $v ;;;<br/>";
			continue;
		}
		
		if (strpos(" $v", 'extract')){
			continue;
		}
		
		$dataStates .= translate($k, $v, $part);
	}
	
	if ($_GET['dbg'] == 1)
	print "<br/>---<br/>";
	if ($part == 0 || $part == 5){
		$data= translate('data', $finish, $part);
	}
	
	if ($part == 1){
		$data= translate('final', $finish, $part);
		$data=str_replace('[Steps]', '', $data);
	}
	#$data= str_replace('[i]', '', $data);
	#$data=str_replace('data=', '', $data); //for solver, data final
	#$data=str_replace('[', '', $data);
	#$data=str_replace(']', '', $data);
	#$data=str_replace('for i in range(Num-1)', '', $data);
	
	
	$dataFinal= $data;
	
	//$it= op("safeWithoutHuman || newGoat == newHuman ", '||');
	
	//print "it !$it! <br/>";
	
	//print op($it, '||');
	
	if ($part == 5){
		return $dataFinal;
	}
	
	return $dataStates . $dataFinal;
	#return $dataFinal;
	
}







$code=file_get_contents('code.txt');
$contract=explode('contract , "', $code);
$data=explode('data , "', $code);

//print_r($contract);
$cc=count($contract);

for ($i=1; $i<$cc; $i++){
	$t=explode('"', $contract[$i]);
	$vars[]= "$t[0] = [ Int('$t[0]_%i' % (i + 1)) for i in range(Num) ]";
	
	//For results sorting in the end of script
	$stages[$t[0]]=array();
}

if ($_GET['dbg'] == 1)
print "<br/>";

$cc=count($data);

$nothing="";


$vstart=explode(',', $_POST['startState']);

for ($i=1; $i<$cc; $i++){
	
	//Getting variables
	
	$val=0;
	
	if (isset($vstart[$i-1])){
		$val= (int)$vstart[$i-1];
	}
	
	$t=explode('"', $data[$i]);
	$start .= "$t[0][0] == $val, ";
	$vars[]= "$t[0] = [ Int('$t[0]_%i' % (i + 1)) for i in range(Num) ]";
	$nothing .= "$t[0][i] == $t[0][i+1], ";
}

$nothing=substr($nothing, 0, strlen($v)-2);
$nothing="nothing= [  And( $nothing )   for i in range(Num-1) ]";
$vars[]=$nothing;

$vars=array_unique($vars);


foreach ($vars as $k=>$v){
	$pvars .= "$v<br/>";
}

$start=substr($start, 0, strlen($start)-2);
$start="start= [ $start ]";

if ($_GET['dbg'] == 1)
print "<br/> $start<br/><br/>";

$dataCode= file_get_contents('http://2.59.42.98/hyperbox2.php');



$dd=explode("<br/>", $dataCode);
$cd=count($dd);



$dd[$cd-2]=str_replace("= [", "= [ Or(", $dd[$cd-2]);
$dd[$cd-2]=str_replace("for", ", nothing[i]) for", $dd[$cd-2]);

$dataCode=implode("<br/>", $dd);


//unset($new,$level);
//convert(1);


unset($new,$level);
$finishCode= convert(1);


#print $dataCode;
function linesprior($dataCode){
			
	$dCode=explode("<br/>", $dataCode);

	#print_r($dCode);

	$cc=count($dCode);

	$dCode2="";
	$dCode3="";

	for ($i=0; $i<$cc-1; $i++){
		$vname=explode('=', $dCode[$i]);
		$vname2= $vname[2];
		$vname= $vname[0];
		$vv= $dCode[$i];
		
		$p1=strpos("$dataCode", "$vname=");
		$p2=strpos("$dataCode", $vname);

		$dif= $p2-$p1;
		#print "vname $vname, p1 $p1, p2 $p2, dif $dif<br/>";
		
		
		
		if ($dif < 0){	
			$dCode[-$i]=$dCode[$i];
			$dCode[$i]='';
			#print "problem! $vv <br/><br/>";
			$dCode2 = $vv . "<br/>" . $dCode2;
		}else{
			$dCode2 .= $vv."<br/>";
		}
	}
	return $dCode2;

}

$dataFfsinal=convert(0);
unset($new,$level);
$dataFinal=convert(5);

#Sorting variables to solve depend
for($i=0; $i<50; $i++){
	$dataCode=linesprior($dataCode);
	$finishCode=linesprior($finishCode);
}

#Regular VM
if ($_GET['type'] == 2){
	$tdata=explode(',', $_POST['tdata']);
	$finishCode='';
	
	//file_put_contents('tdata.txt', json_encode($tdata));
	
	#Final will be user data input final, and transfer final restriction disabled.
	for ($i=1; $i<$cc; $i++){
		
		//Getting variables
		
		$val=0;
		
		if (isset($tdata[$i-1])){
			$val= (int)$tdata[$i-1];
		}
		
		$t=explode('"', $data[$i]);
		$finishCode.= "$t[0][1] == $val, ";
	}
	
	$finishCode=substr($finishCode, 0, strlen($finishCode) - 2);
	$finishCode= "final= [ $finishCode ]";
	
	#$finishCode='final=  And(1==1)';
}

//file_put_contents('tdata.txt', "\n" . $finishCode, FILE_APPEND);

if ($_GET['dbg'] == 1)
print "$pvars <br/>$dataCode<br/><br/>$dataFinal<br/><br/>$finishCode<br/><br/>";

$code=$pvars. "\n\n" .$start. "\n\n" .$dataCode. "\n\n" .$finishCode;
$code=str_replace("<br/>", "\n", $code);

$template=file_get_contents('template42.txt');
$inpsteps=(int)$_POST['steps'];
$inpsteps=min($inpsteps, 30);
$inpsteps=max($inpsteps, 1);
$usersteps="Steps=$inpsteps";

if ($_GET['dbg'] == 7)
$usersteps="Steps=7";

$template=str_replace('Steps=7', $usersteps, $template);
$template=str_replace('$code$', $code, $template);
file_put_contents('code.py', $template);
file_put_contents('/var/www/html/all/bin/python/code.py', $template);

if ($_GET['dbg'] == 1)
print "Current unix time:";

if ($_GET['dbg'] == 1)
print time();

function execute($command, $timeout = 5) {
    $handle = proc_open($command, [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']], $pipe);

    $startTime = microtime(true);

    /* Read the command output and kill it if the proccess surpassed the timeout */
    while(!feof($pipe[1])) {
        $read .= fread($pipe[1], 8192);
        if($startTime + $timeout < microtime(true)) break;
    }

    kill(proc_get_status($handle)['pid']);
    proc_close($handle);

    return $read;
}

/* The proc_terminate() function doesn't end proccess properly on Windows */
function kill($pid) {
    return strstr(PHP_OS, 'WIN') ? exec("taskkill /F /T /PID $pid") : exec("kill -9 $pid");
}

putenv('PATH=/var/www/html/all/bin');
$result= execute("/usr/bin/python /var/www/html/all/bin/python/code.py");
//print "$result";

$p=strpos($result, '[');


$result=substr($result, $p);

$result=str_replace('[', '', $result);
$result=str_replace(']', '', $result);
$result=str_replace('traversing model...', '', $result);
$result=str_replace(' ', '', $result);

$nresult=str_replace("\r", "", $result);
$nresult=str_replace("\n", "", $result);

if (strpos(" $nresult", "Totalsolutionnumber:0")){
	
	if ($_GET['type'] == 2){
		print '
	<div class="container-contact100-form-btn" style="background-color: #FFA07A; margin-top: 10px; margin-bottom: 10px; padding-top: 10px; padding-bottom: 10px;">
		Transaction forbidden by smart-contract.
	</div>'."\n";
	die();
	}
	
	print '<div class="container-contact100-form-btn" style="background-color: #E6E6FA; margin-top: 10px;  margin-bottom: 10px;">No solution exists. Transfer transactions will never be possible with this contract and start state on this or smaller depth.<br/> </div>'."\n";
	die();
}

if (!$p){
	print '<div class="container-contact100-form-btn" style="background-color: #E9967A; margin-top: 10px;  margin-bottom: 10px;">Analysis failed.
	Possible reasons: 1) Incorrect or incompatible code 2) Code algorithmic complexity 3)Hyperbox bug (it is 0.1 version)</div>'."\n";
	die();
}

$result=explode(",\n", $result);







$rc=count($result);

//print_r($result);





for ($i=0; $i<$rc; $i++){
	$dtx=$result[$i];
	$dtx=explode('_', $dtx);
	

	$dtx_step=xcut($result[$i], '_', '=');
	//print "dtx step $dtx_step, dtx $result[$i] \n";
	
	$vl=explode('=', $result[$i])[1];
	
	$stages[$dtx[0]][$dtx_step]=$vl;
}


foreach ($stages as $k=>$v){
	//print "k $k";
	ksort($stages[$k]);
}

$sc=count($stages[$k]);

//print "Output<br/>";

//print_r($stages);


//skip start
for ($i=2; $i<$sc+1; $i++){
	foreach ($stages as $k=>$v){
		$vstage[$i] .= "$k= ";
		$vstage[$i] .= $stages[$k][$i];
		$vstage[$i] .= ", ";
	}
}


$step_template='
<div class="container-contact100-form-btn" style="background-color: #00FF7F; margin-top: 10px; margin-bottom: 10px; padding-top: 10px; padding-bottom: 10px;">
	Data transaction: %text%
</div>'."\n";


foreach ($vstage as $k=>$v){
	#remove last comma
	$vstage[$k]=substr($v, 0, strlen($v)-2);
	
	#remove strange new lines
	$vstage[$k]=str_replace("\n\n", "", $vstage[$k]);
	$vsteps.=str_replace('%text%', $vstage[$k], $step_template);
}


if ($_GET['type'] == 2){
	if ( ($_POST['tdata'] != $_POST['startState']) ){
		print '
	<div class="container-contact100-form-btn" style="background-color: #E6E6FA; margin-top: 10px; margin-bottom: 10px; padding-top: 10px; padding-bottom: 10px;">
		Transaction granted. Initial state field updated.
	</div>'."\n";
	}
	
	if ( ($_POST['tdata'] == $_POST['startState']) ){
		print '
	<div class="container-contact100-form-btn" style="background-color: #E6E6FA; margin-top: 10px; margin-bottom: 10px; padding-top: 10px; padding-bottom: 10px;">
		Data fields equals contract state. 
	</div>'."\n";
	}

}else{
	print '
	<div class="container-contact100-form-btn" style="background-color: #E6E6FA; margin-top: 10px; margin-bottom: 10px; padding-top: 10px; padding-bottom: 10px;">
		Winning transaction chain found:
	</div>'."\n";
}

if ( ($_POST['tdata'] != $_POST['startState']) || $_GET['type'] == 1){
	print_r($vsteps);
}

if ($_GET['type'] != 2){
	print '
	<div class="container-contact100-form-btn" style="background-color: #00FF7F; margin-top: 10px; margin-bottom: 10px; padding-top: 10px; padding-bottom: 10px;">
		Transfer transaction
	</div>'."\n";
}







