<?php
	session_start();
	//DONT FORGET TO
	//add username and password for amylpred2
?>
<!DOCTYPE html>
<html>
<head>
<title>ANTISOMA</title>
<meta name="author" content="knastou">
<link rel="shortcut icon" href="style/favicon.png" />
<link rel="stylesheet" type="text/css" href="./style/style_code.css">
</head>

<body bgcolor="#0d47a1">
	
	
	<table class="header">
  	<tr>
    	<td rowspan="2"><img src="./style/logo_soma.jpg" height="120" align="center"></td>
    	<th><h1>Reduction of the Aggregation Propensity of Monoclonal Antibodies</h1></th>
  	</tr>
  	<tr>
    	<td>
			<table class="nav" width="100%" >
			<tbody>
			<tr class="nav_cell">
					<td class="nav_cell" width="25%" align="center">
   					<a class="navbar" href="index.html" target="_blank">Home</a></td>
   
					<td class="nav_cell" width="25%" align="center">
        			<a class="navbar" href="submit.php" target="_blank">Submission</a></td>

					<td class="nav_cell" width="25%" align="center">
					<a class="navbar" href="manual.html" target="_blank">Manual</a></td>
		
					<td class="nav_cell" width="25%" align="center">
       				<a class="navbar" href="contact.html" target="_blank">Contact</a></td>
       
			</tr>
			</tbody>
			</table>
	  </td>
  	</tr>
	</table>
	<br>
	<!-- END OF HEADER-->
	<script>
 
		function myImvisibility() 
			{
			document.getElementById("myObj1").style.display = "none";
			}
		
//		function myVisibility() 
//			{
//			document.getElementById("myObj2").style.visibility = "visible";
//			}

</script>
<?php
$user_id=time();
?>
	<!-- BEGGINING OF DESCRIPTION-->
	<div class="Description" style="width:100%>
		<div class="Code" style="width:80%;margin: 0 auto">

		<div id="myObj1" style="position:inline">
			<p><u>Do not refresh this page, as it may take more than 20 minutes</u>
			<?php
			echo "Your user id is <strong><em>$user_id</em></strong>. <br><i>Please refer to the <a href='manual.html' target='_blank'>manual</a> to see how to retrieve a text file with your results after the job is finished</i></p>";
			?>
			<!--<div class="loader"></div>-->
			<img src="wait4.gif" alt="wt" height="100" width="100">
		</div>

<!--		<div id="myObj2" style="visibility:hidden;position:absolute">
		<img src="complete.png" alt="cm">
		</div> -->

<!--		<h4><strong> -->
		<?php
//			echo "Your query has been submitted. Please do not refresh this page because the process will restart!";
			ob_flush(); 
			flush();
			sleep(1);
		?>
<!--		</strong></h4>  -->
		<?php
                   /*~~~~~~~~~~~~~~functions needed~~~~~~~~~~~~~~~~~*/
//header('Content-Type: text/plain');

function login($url,$data){ //μέθοδος για να κανεις Login σε sites
	set_time_limit(0);
    $fp = fopen("cookie.txt", "w");
    fclose($fp);
    $login = curl_init();
    curl_setopt($login, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_setopt($login, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($login, CURLOPT_TIMEOUT, 40000);
    curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($login, CURLOPT_URL, $url);
    curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($login, CURLOPT_POST, TRUE);
    curl_setopt($login, CURLOPT_POSTFIELDS, $data);
    ob_start();
    return curl_exec ($login);
    ob_end_clean();
    curl_close ($login);
    unset($login);    
}  
 function grab_page($site){ //μέθοδος για να βλέπεις συγκεκριμένη σελίδα του site μάλλον δεν θα χρειαστεί
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 40);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($ch, CURLOPT_URL, $site);
    ob_start();
    return curl_exec ($ch);
    ob_end_clean();
    curl_close ($ch);
} 
function pdb_to_fasta($name,$chain)
{
		$myfile= fopen($name, "r") or die("Unable to open file!");
		$hash1 = array(   //hash για μετατροπή αμινοξέων απο 3 γράμματα σε 1
		"ALA" => "A", #Alanine         
		"ARG" => "R", #Arginine     
		"ASN" => "N", #Asparagine 
		"ASP" => "D", #Aspartic acid
		"CYS" => "C", #Cysteine 
		"GLU" => "E", #Glutamic acid
		"GLN" => "Q", #Glutaminea
		"GLY" => "G", #Glycine
		"HIS" => "H", #Histidine
		"ILE" => "I", #Isoleucine
		"LEU" => "L", #Leucine 
		"LYS" => "K", #Lysine
		"MET" => "M", #Methionine
		"PHE" => "F", #Phenylalanine
		"PRO" => "P", #Proline
		"SER" => "S", #Serine
		"THR" => "T", #Threonine
		"TRP" => "W", #Tryptophan
		"TYR" => "Y", #Tyrosine
		"VAL" => "V");#Valine
		$oldresno=-1;	# ATOMS belong to existing residue?
		$chain_array=array();
		$new_pdb= fopen("newpdb.pdb", "w+") or die("Unable to open file!");
		while(! feof($myfile))
		{	
			$a=fgets($myfile);//. "<br />";
			if (preg_match("/^ATOM/",$a))// && (substr($a,0,20)=$chain)) 	# look for lines that start with ATOM
			{
				fwrite($new_pdb,$a);
				$residue=$hash1[substr($a,17,3)];
				$resno=substr($a,23,3);
				$lin2=substr($a,21,1);
				if (($resno>$oldresno)&& ($lin2==$chain))
				{
					$diafora=$resno-$oldresno;
					if ($diafora>1)
					{
						for ($i=1; $i<$diafora; $i++)
						{
							array_push($chain_array,"-");
						}
					}
					array_push($chain_array,$residue);
				}
				$oldresno=$resno;
			}
			if (preg_match("/^TER/",$a))	
			{
				$oldresno=-1;
			}	
		}
		fclose ($myfile);
		
		$SEQUENCE_test=implode("",$chain_array);
		$SEQUENCE=substr($SEQUENCE_test,1,strlen($SEQUENCE_test)-1);
		return $SEQUENCE;
}
	function exidades($filename,$seq)
	{
		for($i=0; $i<strlen($seq); $i+=60) //εκτύπωση σε 60δες
		{
			$newline=substr($seq,$i,60);
			fwrite($filename,$newline);
			fwrite($filename,"\n");
			/*
			echo $newline=substr($seq,$i,60); //an einai mono gia echo den 8elei $filename h function
			echo "<br>";
			*/
		}
	}
function penidades($seq)
{
		for($i=0; $i<strlen($seq); $i+=50) //εκτύπωση σε 60δες
		{
			echo $newline=substr($seq,$i,50);
			echo "<br>";
		}
}
function amyl($fasta,$user_id)
{
	login("http://aias.biol.uoa.gr/AMYLPRED2/login.php","email=add_username_here&password=add_password_here"); //login to amylpred2
	$myfile_mid = fopen("./results/mid.txt", "w") or die("Unable to open file!");
	$txt_mid = login("http://aias.biol.uoa.gr/cgi-bin/AMYLPRED2/amylpred2.pl","seq_name=myseq&seq_data=".$fasta."&method=AGGRESCAN&method=AMYLPATTERN&method=NETCSSP&method=PAFIG&method=SECSTR&method=APD&method=TANGO&method=BSC&method=WALTZ&method=CONFENERGY"); //μετατρέπω την ενδιάμεση σελίδα σε txt file
	fwrite($myfile_mid, $txt_mid);//το αποθηκε΄θω σε αρχείο
    fclose($myfile_mid);
	$filename_mid="./results/mid.txt";
    $file_mid1 = fopen($filename_mid,"r")or die("Couldn't open $filename 1");
	while(! feof($file_mid1))
    {
		$a=fgets($file_mid1). "<br />"; //ανα γραμμή το κείμενο αποθηκεύεται στην $a
		$aa[]=$a;		//πίνακας που αποτελείται κάθε θέση του απο τις γραμμες του κειμένου
	}
	fclose ($file_mid1);
	$job_id=preg_grep("/Job ID:\s+(\d+)/", $aa); // ψάχνω τον κωδικό ID που μου χρειάζεται για να κάνω redirect στη σελίδα των αποτελεσμάτων
	foreach($job_id as $x => $x_value) //εκπύπωση των values του πίνακα μου
	{
		str_replace("/\s+/","/\s/",$x_value); //αντικάθιστώ τα πολλά κενά με ένα σε κάθε γραμμή του πίνακα
		$pina=explode (" ",$x_value);
		
	}
	$pre_ID=$pina[3];
	$id=substr($pre_ID,0,13);//ΙD που χρειάζομαι
	grab_page("http://aias.biol.uoa.gr/AMYLPRED2/tmp/".$id.".html"); // ανακατεύθυνση στη σελίδα των αποτελεσμάτων
	grab_page("http://aias.biol.uoa.gr/AMYLPRED2/tmp/".$id.".txt");

	
	$myfile_amylresult = fopen("./results/amylresult_$user_id.txt", "w") or die("Unable to open file!");
	$txt_amylresult = grab_page("http://aias.biol.uoa.gr/AMYLPRED2/tmp/".$id.".txt");
	fwrite($myfile_amylresult, $txt_amylresult);//το αποθηκε΄θω σε αρχείο
    fclose($myfile_amylresult);
	$filename_amylresult="results/amylresult_".$user_id.".txt";
    $file_amylresult1 = fopen($filename_amylresult,"r")or die("Couldn't open $filename 2");
	while(! feof($file_amylresult1))
    {
		$a=fgets($file_amylresult1); //ανα γραμμή το κείμενο αποθηκεύεται στην $a
		if (preg_match("/^\s+>--->\sCONSENSUS\d: .+/",$a))
		{
			//echo "!!!!!!!!!!!!!!!!!$a!!!!!!!!!!!!!!<br>";
			//$trimed=rtrim($a);
			//echo "$trimed";
			$arithmoi=substr($a,25,strlen($a));
			$line=preg_replace('/\s+/','', $arithmoi);
			$line_without_comma=str_replace(",","-",$line);
			$diastimata = explode("-", $line_without_comma);
			return $diastimata;
		}
	}
}
function print_intervals(array $array_up,array $array_down,$sequence,$name) //typwnei pinakes me ta kataloipa se APRs
	{
		echo "<tr><th> Region </th><th>  Start-End  </th><th>  Residues  </th></tr>";
		//echo "<br>";
		for ($i=0; $i<count($array_up); $i++)
		{
			$k=$i+1;
			echo ("<tr><td>$k</td>");
			echo "<td>$array_up[$i]-$array_down[$i]</td>";
			$seq= substr($sequence,$array_up[$i]-1,$array_down[$i]-$array_up[$i]+1);
			echo "<td>$seq</td></tr>";
			//echo "<br>";
		}
		echo "</table>";
	}

//----------------------  ΑΡΧΗ ΚΩΔΙΚΑ  --------------------
error_reporting(0); // kleinei ola ta warnings
//$pdb_id=$_POST["fileToUpload"];
//echo $pdb_id;
echo "<script type=\"text/javascript\">";
echo "myImvisibility();";
echo "</script>";


$help_h=0;
$help_l=0;


$fasta_id=$user_id;

$ile=$_SESSION['ile'];
$phe=$_SESSION['phe'];
$val=$_SESSION['val'];
$leu=$_SESSION['leu'];
$tyr=$_SESSION['tyr'];
$met=$_SESSION['met'];
$cys=$_SESSION['cys'];
$try=$_SESSION['try'];
$ala=$_SESSION['ala'];
$the=$_SESSION['the'];
$ser=$_SESSION['ser'];
$gln=$_SESSION['gln'];
$arg=$_SESSION['arg'];
$asn=$_SESSION['asn'];
$glu=$_SESSION['glu'];
$pro=$_SESSION['pro'];
$hys=$_SESSION['hys'];
$lys=$_SESSION['lys'];
$gly=$_SESSION['gly'];
$asp=$_SESSION['asp'];
			
$pdb_id1=$_POST["name"];
$pdb_id=strtoupper($pdb_id1);
$light_id1=$_POST["light"];
$light_id=strtoupper($light_id1);
$heavy_id1=$_POST["heavy"];
$heavy_id=strtoupper($heavy_id1);
$ph=$_POST["ph"];
$ionstr=$_POST["ionstr"];
if (preg_match('/[A-Z]/', $light_id))
{
    $donut=1;
}
else
{
	exit("<br><br>Error: Light chain name is incorrect");
}

if (preg_match('/[A-Z]/', $heavy_id))
{
    $ice_cream=1;
}
else
{
	exit("<br><br>Error: Heavy chain name is incorrect");
}

if ($ph<=14 && $ph>=0)
{
    $donut=1;
}
else
{
	exit("<br><br>Error: wrong pH");
}
if (is_numeric($ionstr))
{
    $donut=1;
}
else
{
	exit("<br><br>Error: Ionic Strength is not a number");
}

$file_sub= fopen("results/".$user_id."_subs.txt", "w") or die("Unable to open substitution table!");
fwrite($file_sub,"Before\t\t\t\t\t\tAfter\nSubstitutions\t\t\t\t\tSubstitutions

\tI\t\t\t->\t\t\t$ile
\tF\t\t\t->\t\t\t$phe
\tV\t\t\t->\t\t\t$val
\tL\t\t\t->\t\t\t$leu
\tY\t\t\t->\t\t\t$tyr
\tM\t\t\t->\t\t\t$met
\tC\t\t\t->\t\t\t$cys
\tW\t\t\t->\t\t\t$try
\tA\t\t\t->\t\t\t$ala
\tT\t\t\t->\t\t\t$the
\tS\t\t\t->\t\t\t$ser
\tQ\t\t\t->\t\t\t$gln
\tR\t\t\t->\t\t\t$arg
\tN\t\t\t->\t\t\t$asn
\tE\t\t\t->\t\t\t$glu
\tP\t\t\t->\t\t\t$pro
\tH\t\t\t->\t\t\t$hys
\tK\t\t\t->\t\t\t$lys
\tD\t\t\t->\t\t\t$asp
\tG\t\t\t->\t\t\t$gly");
fclose($file_sub);

$my_pdb_file=grab_page("http://files.rcsb.org/view/".$pdb_id.".pdb");

//echo $my_pdb_file;
//echo grab_page("http://files.rcsb.org/view/4X7S.pdb");
//echo $my_pdb_file;
//echo grabe("http://linuxg.net/how-to-install-curl-7-36-0-on-ubuntu-linux-mint-pinguy-os-and-elementary-os-systems/");

//header("Location:http://www.rcsb.org/pdb/explore/explore.do?structureId=2OSL");
//echo "<br>$pdb_id1<br><br>";
//$pdb_id2=substr($pdb_id1,2,strlen($pdb_id1));
//$pdb_id=(string)$pdb_id2;
//echo strlen($pdb_id);
//$my_pdb_file=fopen("$pdb_id", "r") or die("Unable to open file!");
//echo $my_pdb_file;

$myfile= fopen("./results/$user_id.pdb", "w") or die("Unable to open file!");
fclose($myfile); 
$filepath1="results/".$user_id.".pdb";
$myfile= fopen($filepath1, "w") or die("Unable to open file 5!");

fwrite($myfile,$my_pdb_file); 

fclose($myfile); 
#chmod($myfile,777);
$hash1 = array(   //hash για μετατροπή αμινοξέων απο 3 γράμματα σε 1
"ALA" => "A", #Alanine         
"ARG" => "R", #Arginine     
"ASN" => "N", #Asparagine 
"ASP" => "D", #Aspartic acid
"CYS" => "C", #Cysteine 
"GLU" => "E", #Glutamic acid
"GLN" => "Q", #Glutamine
"GLY" => "G", #Glycine
"HIS" => "H", #Histidine
"ILE" => "I", #Isoleucine
"LEU" => "L", #Leucine 
"LYS" => "K", #Lysine
"MET" => "M", #Methionine
"PHE" => "F", #Phenylalanine
"PRO" => "P", #Proline
"SER" => "S", #Serine
"THR" => "T", #Threonine
"TRP" => "W", #Tryptophan
"TYR" => "Y", #Tyrosine
"VAL" => "V");#Valine
$filename="results/".$user_id.".pdb";
//echo $filename."\n";

$file1 = fopen($filename,"r")or die("Couldn't open $filename 3"); //άνοιγμα αρχείου
if (filesize($filename) == 260){
    exit("<br><br><br>This isn't a VALID pdb code please try again!");
}
//chmod($file1,0777);
//print "---------- CDRS IN MONOCLONIC ANTIBODIES ----------";
//echo "<br><br>";
//echo "<br><br>";

while(! feof($file1))
  {
	$a=fgets($file1). "<br />"; //ανα γραμμή το κείμενο αποθηκεύεται στην $a
	//echo $a;
	
	if (preg_match("/^SEQRES\s*\d+\s*".$heavy_id."\s+\d+(\S+)/",$a))
	{
		$i++;
	}
	else
	{
		$help_h++;
		
	}
	if (preg_match("/^SEQRES\s*\d+\s*".$light_id."\s+\d+(\S+)/",$a))
	{
		$i++;
	}
	else
	{
		$help_l++;
		
	}
	$hd++;
	
	
	$aa[]=$a;				    //πίνακας που αποτελείται κάθε θέση του απο τις γραμμες του κειμένου
  }

if ($help_h == $hd)
	{
		exit ("Wrong heavy chain id, Please insert the right one");
	}
 if ($help_l == $hd)
	{
		exit ("Wrong light chain id, Please insert the right one");
	}
fclose ($file1);



//--------------------------ΕΛΑΦΡΙΑ ΑΛΥΣΙΔΑ-------------------------------------


$pinakas=preg_grep("/^SEQRES\s*\d+\s*".$light_id."\s+\d+(\S+)/", $aa); //ψάχνω στον πίνακα τις γραμμές SEQRES
//print_r ($pinakas);
foreach($pinakas as $x => $x_value) //εκπύπωση των values του πίνακα μου
{
	 $leksi=substr($x_value,19,51);
	 $string = preg_replace('/\s+/', '', $leksi);
	 for ($k=0; $k<strlen($string); $k=$k+3)
	 {
		 $seq=$hash1[substr($string,$k,3)];
		 $light_array[]=$seq;
	 }
	 $telikos_l=implode("",$light_array);
}
$telikos_l=implode("",$light_array); //τελική αμινοξική ακολουθία



//------------------------------ΒΑΡΙΑ ΑΛΥΣΙΔΑ----------------------------------


$pinakas1=preg_grep("/^SEQRES\s*\d+\s*".$heavy_id."\s+\d+(\S+)/", $aa);
foreach($pinakas1 as $x => $x_value)
{
	 $leksi1=substr($x_value,19,51);
	 $string1 = preg_replace('/\s+/', '', $leksi1);
	 for ($k=0; $k<strlen($string1); $k=$k+3)
	 {
		 $seq1=$hash1[substr($string1,$k,3)];
		 $heavy_array[]=$seq1;
	 }
	 $telikos_h=implode("",$heavy_array);
}
$telikos_h=implode("",$heavy_array);



//------------------------------Θέσεις CDRS------------------------------------
//echo "<br>";
//echo "<h2>CDRs regions</h2>";
$length_heavy_array=count($heavy_array);
$length_light_array=count($light_array);
	
	//----------------------------------------KABAT FOR LIGHT--------------------------------------
	
	//--------------------------L1-------------------------
	for ($i=15; $i<30; $i++)
	{
		if ($light_array[$i]=="C")
		{
			$start_l1=$i+1;
		}
		else {
			$start_l1=24; //estw oti einai to 24 an den isxuoun oi sun8hkes
		}
	}
	for ($i=25; $i<47; $i++)
	{
		if ((($light_array[$i]=="W")&&($light_array[$i+1]=="Y")&&($light_array[$i+2]=="Q"))
		 ||(($light_array[$i]=="W")&&($light_array[$i+1]=="F")&&($light_array[$i+2]=="Q"))
	     ||(($light_array[$i]=="W")&&($light_array[$i+1]=="Y")&&($light_array[$i+2]=="L"))
		 ||(($light_array[$i]=="W")&&($light_array[$i+1]=="L")&&($light_array[$i+2]=="Q")))
		 {
			$finish_l1=$i-1; 
		 }
		 else {
			$finish_l1=34; //estw oti einai to 34 an den isxuoun oi sun8hkes
		 }
	}
	
	//--------------------------L2-------------------------
	for ($k=$finish_l1+12; $k<$finish_l1+19;  $k++)
	{
		if ((($light_array[$k-2]=="I")&&($light_array[$k-1]=="Y"))
		 ||(($light_array[$k-2]=="V")&&($light_array[$k-1]=="Y"))
	     ||(($light_array[$k-2]=="I")&&($light_array[$k-1]=="K"))
		 ||(($light_array[$k-2]=="I")&&($light_array[$k-1]=="F")))
		 {
			 $start_l2=$k;
		 }
		 else {
			$start_l2=50; //estw oti einai to 50 an den isxuoun oi sun8hkes
		 }
	}
	$finish_l2=$start_l2+6;
	
	//--------------------------L3-------------------------
	for ($k=$finish_l2+30; $k<$finish_l2+35;  $k++)
	{
		if ($light_array[$k]=="C")
		{
			$start_l3=$k+1;
		}
		else {
			$start_l3=89; //estw oti einai to 89 an den isxuoun oi sun8hkes
		}
	}
	for ($k=$start_l3+5; $k<$start_l3+20;  $k++)
	{
		if ((($light_array[$k+1]=="F")&&($light_array[$k+2]=="G")&&($light_array[$k+4]=="G")))
		{
			$finish_l3=$k;
		}
		else {
			$finish_l3=97; //estw oti einai to 97 an den isxuoun oi sun8hkes
		}
	}
	
	//--------------------------H1-------------------------
	for ($i=18; $i<29; $i++)
	{
		if ($heavy_array[$i-5]=="C")
		{
			$start_h1=$i-1;
			//echo $start_h1;
		}
		else {
			$start_h1=31; //estw oti einai to 31 an den isxuoun oi sun8hkes
		}
	}
	for ($k=$start_h1+6; $k<$start_h1+15;  $k++)
	{
		if ((($heavy_array[$k+1]=="W")&&($heavy_array[$k+2]=="V"))
		 ||(($heavy_array[$k+1]=="W")&&($heavy_array[$k+2]=="I"))
	     ||(($heavy_array[$k+1]=="I")&&($heavy_array[$k+2]=="A")))
		 {
			 $finish_h1=$k;
		 }
		 else {
			 $finish_h1=35; //estw oti einai to 35 an den isxuoun oi sun8hkes
		 }
	}
	
	//--------------------------H2-------------------------
	$start_h2=$finish_h1+15;
	for ($k=$start_h2+12; $k<$start_h2+22;  $k++)
	{
		if((($heavy_array[$k+1]=="Y")||($heavy_array[$k+1]=="R")||($heavy_array[$k+1]=="G")||($heavy_array[$k+1]=="K"))
			&&(($heavy_array[$k+2]=="L")||($heavy_array[$k+2]=="K")||($heavy_array[$k+2]=="I")||($heavy_array[$k+2]=="V")||($heavy_array[$k+2]=="F")||($heavy_array[$k+2]=="T")||($heavy_array[$k+2]=="A"))
			&&(($heavy_array[$k+3]=="T")||($heavy_array[$k+3]=="S")||($heavy_array[$k+3]=="I")||($heavy_array[$k+3]=="A")))
			{
				$finish_h2=$k;
			}
		else {
			 $finish_h2=65; //estw oti einai to 65 an den isxuoun oi sun8hkes
		}
	}
	
	
	//--------------------------H3-------------------------
	
	for ($k=$finish_h2+29; $k<$finish_h2+36;  $k++)
	{
		if ($heavy_array[$k-3]=="C")
		{
			$start_h3=$k;
		}
		else {
			$start_h3=95; //estw oti einai to 95 an den isxuoun oi sun8hkes
		}
	}
	for ($k=$start_h3+2; $k<$start_h3+26;  $k++)
	{
		if ($heavy_array[$k+1]=="W" && $heavy_array[$k+2]=="G" && $heavy_array[$k+4]=="G")
		{
			$finish_h3=$k;
		}
		else {
			 $finish_h3=102; //estw oti einai to 102 an den isxuoun oi sun8hkes
		}
	}
	$length_l1=-($start_l1-$finish_l1);
	$length_l2=-($start_l2-$finish_l2);
	$length_l3=-($start_l3-$finish_l3);
	$length_h1=-($start_h1-$finish_h1);
	$length_h2=-($start_h2-$finish_h2);
	$length_h3=-($start_h3-$finish_h3);
	
	//echo "----------CDRs light chain---------";
	$akolouthia_l1= substr($telikos_l,$start_l1,$length_l1+1);
	$akolouthia_l2= substr($telikos_l,$start_l2,$length_l2+1);
	$akolouthia_l3= substr($telikos_l,$start_l3,$length_l3+1);
	$akolouthia_h1= substr($telikos_h,$start_h1,$length_h1+1);
	$akolouthia_h2= substr($telikos_h,$start_h2,$length_h2+1);
	$akolouthia_h3= substr($telikos_h,$start_h3,$length_h3+1);
	
	//echo "L1=".$akolouthia_l1."<br>L2=".$akolouthia_l2."<br>L3=".$akolouthia_l3;
	

	//-------------------ARXIZEI AMYLPRED-----------------
	
	
	$intervals_l=amyl($telikos_l,$user_id."light"); 
	foreach($intervals_l as $x => $x_value)
		{
			if ($x%2==0)
			{
//				echo $x."\n".$x_value."\n";
				$up_limit_l[]=$x_value;
			}
			else
			{
//				echo $x."\n".$x_value."\n";
				$down_limit_l[]=$x_value;
			}
		}
	

	
	$intervals_h=amyl($telikos_h,$user_id."heavy"); 
	foreach($intervals_h as $x => $x_value)
		{
			if ($x%2==0)
			{
				$up_limit_h[]=$x_value;
			}
			else
			{
				$down_limit_h[]=$x_value;
			}
		}
	
    
	////----------------------- ARXIZEI DSSP ---------------------


	system ("./dssp-2.0.4-linux-i386 -i results/$user_id.pdb -o results/$user_id.dssp");

	//system ("mkdssp -i ./results/1463489669.pdb -o ./results/results.dssp");

$dssppath="/srv/www/htdocs/ANTISOMA/results/".$user_id.".dssp";	
$file_dssp = fopen($dssppath,"r")or die("Couldn't open $filename 4!!!!!!!!!!!!!!");
	$acc_L=array();
	$acc_H=array();
	while(! feof($file_dssp))
	{
		$a=fgets($file_dssp). "<br />"; //ανα γραμμή το κείμενο αποθηκεύεται στην $a
		if (preg_match("/^\s+\d+\s+\d+\s".$light_id."\s+/",$a)) 
		{
			$b_L[]=substr($a,35,3);
			$pos_L[]=substr($a,7,3)-1;
		}
		if (preg_match("/^\s+\d+\s+\d+\s".$heavy_id."\s+/",$a))
		{
			$b_H[]=substr($a,35,3);
			$pos_H[]=substr($a,7,3)-1;
		}
	
	}
	$acc_L=array_combine($pos_L,$b_L);
	$acc_H=array_combine($pos_H,$b_H);
	foreach($acc_L as $x => $x_value)
		{
			if ($x_value>20)
			{
				//$sum_light=$sum_light+$x_value;
				$theseis_acc_light[]=$x; //οι θεσεις των αμινοξικων καταλοίπων που είναι προσβασιμες στον διαλύτη
			}
		}
	foreach($acc_H as $y => $y_value)
		{
			if ($y_value>20)
			{
				//$sum_heavy=$sum_heavy+$y_value;
				$theseis_acc_heavy[]=$y; //οι θεσεις των αμινοξικων καταλοίπων που είναι προσβασιμες στον διαλύτη
			}
		}
	//$sum=$sum_light+$sum_heavy;
	fclose($file_dssp);
	
	///------------------------EYRESH A^2 TON CDRS PRIN APO ANTIKATASTASEIS
	$light_array_cdr=$light_array;
	$heavy_array_cdr=$heavy_array;
	//print_r($light_array_cdr);
	//keep only aggregation prone regions
	for($k=1; $k<count($up_limit_h); $k++)
	{
		for ($i=($down_limit_h[$k-1]+1); $i<$up_limit_h[$k]; $i++)
		{
			unset($heavy_array_cdr[$i-1]);
		}	
	}
	for ($i=0; $i<$up_limit_h[0]; $i++)
	{
	
		unset($heavy_array_cdr[$i-1]);
	}
	$z=end($down_limit_h);
	for ($k=$z+1; $k<=$length_heavy_array; $k++)
	{
		unset($heavy_array_cdr[$k-1]);
	}
	//keep only cdrs
for ($i=0; $i<=$start_h1-1; $i++)
{
	foreach($heavy_array_cdr as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($heavy_array_cdr[$i]);
		}
	}	
}
for ($i=$finish_h1+1; $i<=$start_h2-1; $i++)
{
	foreach($heavy_array_cdr as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($heavy_array_cdr[$i]);
		}
	}	
}
for ($i=$finish_h2+1; $i<=$start_h3-1; $i++)
{
	foreach($heavy_array_cdr as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($heavy_array_cdr[$i]);
		}
	}	
}
for ($i=$finish_h3+1; $i<=$length_light_array; $i++)
{
	foreach($heavy_array_cdr as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($heavy_array_cdr[$i]);
		}
	}	
}
//find which are accesible to the solvent
$sum_meion_h=0;
foreach($acc_H as $x => $x_value)
	{
		if (array_key_exists($x_value, $heavy_array_cdr))
		{
			//array_push($pos_replace_h,$x_value);
			$sum_meion_h+=$x_value;
		}
	}
//print_r($sum_meion_h);

//-----------------------------------------------------------------------------------------------------------------------------------------
for($k=1; $k<count($up_limit_l); $k++)
	{
		for ($i=($down_limit_l[$k-1]+1); $i<$up_limit_l[$k]; $i++)
		{
			unset($light_array_cdr[$i-1]);
		}	
	}
	for ($i=0; $i<$up_limit_l[0]; $i++)
	{
	
		unset($light_array_cdr[$i-1]);
	}
	$z=end($down_limit_l);
	for ($k=$z+1; $k<=$length_light_array; $k++)
	{
		unset($light_array_cdr[$k-1]);
	}
	//keep only cdrs
for ($i=0; $i<=$start_l1-1; $i++)
{
	foreach($light_array_cdr as $x => $x_value)
	{
		if ($x==$i)
		{
//			print $i."\n".$light_array_cdr[$i]."\n";
			unset($light_array_cdr[$i]);
		}
	}	
}
for ($i=$finish_l1+1; $i<=$start_l2-1; $i++)
{
	foreach($light_array_cdr as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($light_array_cdr[$i]);
		}
	}	
}
for ($i=$finish_l2+1; $i<=$start_l3-1; $i++)
{
	foreach($light_array_cdr as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($light_array_cdr[$i]);
		}
	}	
}
for ($i=$finish_l3+1; $i<=$length_light_array; $i++)
{
	foreach($light_array_cdr as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($light_array_cdr[$i]);
		}
	}	
}
//print_r($light_array_cdr);
//find which are accesible to the solvent
$sum_meion_l=0;
//print_r($acc_L);

foreach($acc_L as $x => $x_value)
	{
		if (array_key_exists($x_value, $light_array_cdr))
		{
			//array_push($pos_replace_h,$x_value);
			$sum_meion_l+=$x_value;
			//print_r("$x_value");
		}
	}
//print_r("!!!!!!!!$sum_meion_l!!!!!");
$sum_final=$sum_meion_h+$sum_meion_l;
	
	////----------------------- ΕΥΡΕΣΗ ΚΑΤΑΛΟΙΠΩΝ ΠΡΟΣ ΑΝΤΙΚΑΤΆΣΤΑΣΗ-------------------

//--------------Heavy chain on amylpred----------------

for($k=1; $k<count($up_limit_h); $k++)
{ //prints residues after first APR and between all following APRs
	for ($i=($down_limit_h[$k-1]+1); $i<$up_limit_h[$k]; $i++)
	{
		 //$sum_light=$sum_light+$b_L[$i-1];
		 //echo $sum_light;
		 //echo $b_H[$i];
	//echo "<br>";
		 unset($heavy_array[$i-1]);
	}	
}
//prints residues before first APR
for ($i=0; $i<$up_limit_h[0]; $i++)
{

	unset($heavy_array[$i-1]);

}
//prints last residues after APRs
$z=end($down_limit_h);
for ($k=$z+1; $k<=$length_heavy_array; $k++)
{

	unset($heavy_array[$k-1]);
}
/*for ($i=0;$i<=224;$i++){
		foreach($heavy_array as $x => $x_value)
	{
		if ($x==$i)
		{
	print $heavy_array[$i]."\n";
		}
}
}
*/
//-------------delete CDRS----------------
//print $start_h2;
//print "\n";
//print $finish_h2;
//print "\n";

for ($i=$start_h1; $i<=$finish_h1; $i++)
{
	foreach($heavy_array as $x => $x_value)
	{
		if ($x==$i)
		{
//			print $heavy_array[$i]."\n";
			unset($heavy_array[$i]);
		}
	}	
}
for ($i=$start_h2-1; $i<=$finish_h2+1; $i++)
{
	foreach($heavy_array as $x => $x_value)
	{
		if ($x==$i)
		{
			print $heavy_array[$i]."\n";
			unset($heavy_array[$i]);
		}
	}	
}
for ($i=$start_h3-1; $i<=$finish_h3+1; $i++)
{
	foreach($heavy_array as $x => $x_value)
	{
		if ($x==$i)
		{
//			print $heavy_array[$i]."\n";
			unset($heavy_array[$i]);
		}
	}	
}
//------------delete framework residues---------
// Delete 26-29
for ($i=25; $i<=28; $i++)
{
	foreach($heavy_array as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($heavy_array[$i]);
		}
	}	
}
//Delete 71
foreach($heavy_array as $x => $x_value)
{
	if ($x==70)
	{
		unset($heavy_array[$x]);
	}
}


//-------------light chain on amylpred---------

for($k=1; $k<count($up_limit_l); $k++)
{
	for ($i=($down_limit_l[$k-1]+1); $i<$up_limit_l[$k]; $i++)
	{
		 unset($light_array[$i-1]);
	}	
}
for ($i=0; $i<$up_limit_l[0]; $i++)
{
	unset($light_array[$i-1]);
}
$z=end($down_limit_l);
for ($k=$z+1; $k<=$length_light_array; $k++)
{
	unset($light_array[$k-1]);
}

//-------------delete CDRS------------------
for ($i=$start_l1-1; $i<=$finish_l1+1; $i++)
{
	foreach($light_array as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($light_array[$i]);
		}
	}	
}
for ($i=$start_l2-1; $i<=$finish_l2+1; $i++)
{
	foreach($light_array as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($light_array[$i]);
		}
	}	
}
for ($i=$start_l3-1; $i<=$finish_l3+1; $i++)
{
	foreach($light_array as $x => $x_value)
	{
		if ($x==$i)
		{
			unset($light_array[$i]);
		}
	}	
}

//-----find which are acc in dssp

//~~~~HEAVY DSSP~~~~~

$pos_replace_h_med=array();
foreach($theseis_acc_heavy as $x => $x_value)
	{
		if (array_key_exists($x_value, $heavy_array))
		//if (isset($x_value, $heavy_array))
		{
			array_push($pos_replace_h_med,$x_value);
		}
	}

//~~~~LIGHT DSSP~~~~~

$pos_replace_l_med=array();
foreach($theseis_acc_light as $x => $x_value)
	{
		if (array_key_exists($x_value, $light_array))
		{
			array_push($pos_replace_l_med,$x_value);
		}
	}

	
//~~~~~~~~~FOLDX~~~~~~~~~// Find which residues increase stability and only replace those

// Find positions to check
$hash2 = array(   
		"I" => $ile, #Isoleucine         
		"F" => $phe, #Phenylalanine 
		"V" => $val, #Valine
		"L" => $leu, #Leucine 
		"Y" => $tyr, #Tyrosine
		"M" => $met, #Methionine
		"C" => $cys, #Cysteine
		"W" => $try, #Tryptophan
		"A" => $ala, #Alanine
		"T" => $the, #Threonine Glycine
		"S" => $ser, #Histidine
		"Q" => $gln, #Isoleucine
		"R" => $arg, #Leucine 
		"N" => $asn, #Lysine
		"E" => $glu, #
		"P" => $pro, #Proline
		"H" => $hys, #Histidine
		"K" => $lys, #Lysine
		"G" => $gly); #Glycine

		
//		//elegxos
//		$positions = 'LL11N,SL12N';
		
		//swsto uncomment later
$positions = '';

for ($i=0; $i<count($pos_replace_l_med); $i++)
{	$aminoacid_l=substr($telikos_l,$pos_replace_l_med[$i],1);
 	$pointer_l=$pos_replace_l_med[$i]+1;
	$positions.=$aminoacid_l.$light_id.$pointer_l.$hash2[$aminoacid_l].",";
}
for ($i=0; $i<count($pos_replace_h_med); $i++)
{	$aminoacid_h=substr($telikos_h,$pos_replace_h_med[$i],1);
 	$pointer_h=$pos_replace_h_med[$i]+1;
	$positions.=$aminoacid_h.$heavy_id.$pointer_h.$hash2[$aminoacid_h].",";
}
//remove last comma
   $positions = substr($positions, 0, -1);
//echo("<br><br><br>$positions<br><br><br>");



//copy pdb file to run foldx
system("cp ./results/$user_id.pdb ./");
sleep(1);

// Run FoldX for residues in $pos_replace_h_med && $pos_replace_l_med
$pdbfilename=$user_id.".pdb";	
$pdbdir="./results";
$outputdir="./results/foldxoutput_".$user_id.".txt";
//system("foldx -f config.cfg");
shell_exec ("./foldx --command=PositionScan --pdb=$pdbfilename --positions=$positions --ionStrength=$ionstr --pH=$ph --output-dir=$pdbdir > $outputdir");
sleep(1);
//echo "./foldx --command=PositionScan --pdb=$pdbfilename --positions=$positions --output-dir=$pdbdir > $outputdir";
//remove pdb file after foldx run
system("mv *.pdb results");
system("mv energies* results");
system("mv foldxoutput* results");

//Read file created from FoldX and keep only residues in positions with positive values in ddg
$foldxfilepath="./results/PS_".$user_id."_scanning_output.txt";	
$file_foldx = fopen($foldxfilepath,"r")or die("Couldn't open $foldxfilepath 6!!!!!!!!!!!!!!"); 
////
	$stable_L=array();
	$stable_H=array();
	while(! feof($file_foldx))
	{
		$a=fgets($file_foldx). "<br />"; //ανα γραμμή το κείμενο αποθηκεύεται στην $a
		if (preg_match("/^\w{3}".$light_id."(\d+)\w\t(.*)/",$a, $matches)) 
		{
			$ddg_L[]=$matches[2]; 
			$posi_L[]=$matches[1]; 
//			echo ("<br><br>$matches[1]<br>$matches[2]<br><br>");
		}
		if (preg_match("/^\w{3}".$heavy_id."(\d+)\w\t(.*)/",$a, $matches)) 
		{
			$ddg_H[]=$matches[2];   /////////
			$posi_H[]=$matches[1];   ////////
		}
	
	}
	$stable_L=array_combine($posi_L,$ddg_L); //////
	$stable_H=array_combine($posi_H,$ddg_H); //////
//	print_r($stable_H);
//	echo("<br><br>");
	foreach($stable_L as $x => $x_value)
		{
			if ($x_value>0)
			{
				//$sum_light=$sum_light+$x_value;
				$theseis_stable_light[]=$x; //aa positions that stabilize the molecule
			}
		}

	foreach($stable_H as $y => $y_value)
		{
			if ($y_value>0)
			{
				//$sum_heavy=$sum_heavy+$y_value;
				$theseis_stable_heavy[]=$y; //aa positions that stabilize the molecule
			}
		}
//		print_r($theseis_stable_heavy);
//	echo("<br><br>");
	//$sum=$sum_light+$sum_heavy;
	fclose($file_foldx);

//push those in pos_replace_h && $pos_replace_l
$pos_replace_h=array();
foreach($theseis_stable_heavy as $x => $x_value)
	{
		if (array_key_exists($x_value, $heavy_array))
		//if (isset($x_value, $heavy_array))
		{
			array_push($pos_replace_h,$x_value);
		}
	}

$pos_replace_l=array();
foreach($theseis_stable_light as $x => $x_value)
	{
		if (array_key_exists($x_value, $light_array))
		{
			array_push($pos_replace_l,$x_value);
		}
	}



echo("<br><br><br> <i><b>Your id is:$user_id</b> &nbsp&nbspYou can retrieve your results using this ID. <u>Please refer to the <a href='manual.html' target='_blank'>manual</a>.</u> Results are deleted after 2 weeks</i><br><br>");
//----------------------------TEST---------------------------


//echo "<a class=\"click-me\" href=\"final.php\" target=\"_blank\">Download the result file</a>";
echo "<h2>CDRs</h2>";
echo "<table class=table3 align=center><tr><th>  Light chain  </th><th>  Start-End  </th><th>  Residues  </th><th> Heavy chain</th><th>Start-End</th><th>Residues</th></tr>";
$cdr_start_l1=$start_l1+1;
$cdr_start_l2=$start_l2+1;
$cdr_start_l3=$start_l3+1;
$cdr_start_h1=$start_h1+1;
$cdr_start_h2=$start_h2+1;
$cdr_start_h3=$start_h3+1;
$cdr_finish_l1=$finish_l1+1;
$cdr_finish_l2=$finish_l2+1;
$cdr_finish_l3=$finish_l3+1;
$cdr_finish_h1=$finish_h1+1;
$cdr_finish_h2=$finish_h2+1;
$cdr_finish_h3=$finish_h3+1;
echo "<tr><td>L1</td><td>$cdr_start_l1-$cdr_finish_l1</td><td>$akolouthia_l1</td><td>H1</td><td>$cdr_start_h1-$cdr_finish_h1</td><td>$akolouthia_h1</td></tr>";
echo "<tr><td>L2</td><td>$cdr_start_l2-$cdr_finish_l2</td><td>$akolouthia_l2</td><td>H2</td><td>$cdr_start_h2-$cdr_finish_h2</td><td>$akolouthia_h2</td></tr>";
echo "<tr><td>L3</td><td>$cdr_start_l3-$cdr_finish_l3</td><td>$akolouthia_l3</td><td>H3</td><td>$cdr_start_h3-$cdr_finish_h3</td><td>$akolouthia_h3</td></tr></table>";
echo"<br>";
$results_file = fopen("./results/".$user_id."final_results.txt","w")or die("Couldn't open the results file");
fwrite($results_file,"Amino acids for replacement\n\nLIGHT CHAIN\t\t");
echo "<h2>Residues for replacement</h2>";
echo "<a href=sub_matrix.php target=_blank>See replacement matrix</a><br>";
echo "<table class=table1 align=center><tr><th>Light chain</th><tr><tr><td>";
for ($i=0; $i<count($pos_replace_l); $i++)
{	$aminoacid_l=substr($telikos_l,$pos_replace_l[$i],1);
 	$pointer_l=$pos_replace_l[$i]+1;
	echo "$pointer_l:$aminoacid_l  ";
	fwrite($results_file,"$pointer_l:$aminoacid_l  ");
}
fwrite($results_file,"\nHEAVY CHAIN\t\t");
echo "</td></tr></table><br>";
echo "<table class=table1 align=center><tr><th>Heavy chain</th><tr><tr><td>";
for ($i=0; $i<count($pos_replace_h); $i++)
{	$aminoacid_h=substr($telikos_h,$pos_replace_h[$i],1);
 	$pointer_h=$pos_replace_h[$i]+1;
	echo "$pointer_h:$aminoacid_h  ";
	fwrite($results_file,"$pointer_h:$aminoacid_h  ");
}
$_SESSION['array_nameposl']=$pos_replace_l;
$_SESSION['array_nameposh']=$pos_replace_h;
echo "</td></tr></table>";
echo "<i>*These residues are <strong>NON</strong> CDRs, accessible to the solvent and present in
\"aggregation-prone\" regions</i><br>";
fwrite($results_file,"\n*These amino acids are not on CDRs, they are accessible to the solvent and they are present in
\"aggregation-prone\" regions");
////---------------------------------- NEW FASTA FILES -----------------------------


$new_heavy_array=str_split($telikos_h);
$new_light_array=str_split($telikos_l);

//----------- NEW FASTA LIGHT -----------
$new_fasta_light='';
foreach ($pos_replace_l as $x => $x_value)
{
	$new_light_array[$x_value]=strtolower($hash2[$new_light_array[$x_value]]);
}
if(!$new_light_array){ //NEW!!!
	$new_fasta_light='';
}
else{
$new_fasta_light=implode($new_light_array);
}
//echo "<br>$new_fasta_light<br>";  //NEW TEST
//--------------------------------------------------------apoo doooo kai katooooooooooooooooooo----------------------------------------------
//----------- NEW FASTA HEAVY -----------
foreach ($pos_replace_h as $x => $x_value)
{
	$new_heavy_array[$x_value]=strtolower($hash2[$new_heavy_array[$x_value]]);
}
$new_fasta_heavy=implode($new_heavy_array);
fwrite($results_file,"\n\n--------------------------------------Sequences alignement---------------------------\n\nLIGHT CHAIN\n");
echo "<h2>Alignment of Sequences</h2><br>In lowercase letters there are residues that are going to be substituted<br><br>";
echo "<table class=table1 align=center>";
echo "<tr>";
echo "<th><i>Alignment for LIGHT chain before and after substitutions</i></th>";
echo "</tr>";
echo "<tr><td>";
//---------------------ali light chain-----------------------
$ali_l_old=array();
$ali_l_new=array();
for($i=0; $i<strlen($telikos_l); $i+=10) //εκτύπωση σε 60δες
		{
			$line1=substr($telikos_l,$i,10);
			$line2=substr($new_fasta_light,$i,10);
			array_push($ali_l_old,$line1);
			array_push($ali_l_new,$line2);
		}
	$length_l=count($ali_l_old);
	$ali_length=$length_l*10;
	//echo $length;
	
	for($i=0; $i<$length_l-1; $i+=6)
	{
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
		fwrite( $results_file, "            ");
		for($l=0; $l<=5; $l++)
		{
			$sum_ali_l=((($i+$l)*10)+10);
			$num=strlen((string) $sum_ali_l);
			if ($sum_ali_l>$ali_length-10)
			{
				break;
			}
			if ($num===3)
			{
				fwrite( $results_file, "       $sum_ali_l ");
				echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$sum_ali_l&nbsp";
			}
			if ($num===2)
			{
				fwrite( $results_file, "        $sum_ali_l ");
				echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$sum_ali_l&nbsp";
			}
		}
		echo "<br>";
		fwrite( $results_file, "\n");
		echo "seq_before&nbsp&nbsp";
		fwrite($results_file,"seq_before  ");
		for($j=0; $j<=5; $j++)
		{
			$sum=$i+$j;
			fwrite( $results_file, "$ali_l_old[$sum] ");
			echo "$ali_l_old[$sum] ";
		}
		echo "<br>";
		fwrite( $results_file, "\n");
		echo "seq_after&nbsp&nbsp&nbsp";
		fwrite($results_file,"seq_after   ");
		for($k=0; $k<=5; $k++)
		{
			$sum=$i+$k;
			echo "$ali_l_new[$sum] ";
			fwrite( $results_file, "$ali_l_new[$sum] ");
		}
		echo "<br><br>";
		fwrite( $results_file, "\n\n");
	}
echo "</td>";
echo "</tr></table><br><br>";

//---------------------ali light chain-----------------------
fwrite($results_file,"\n\nHEAVY CHAIN\n");
echo "<table class=table1 align=center>";
echo "<tr>";
echo "<th><i>Alignment for HEAVY chain before and after substitutions</i></th>";
echo "</tr>";
echo "<tr><td>";

$ali_h_old=array();
$ali_h_new=array();
for($i=0; $i<strlen($telikos_h); $i+=10) //εκτύπωση σε 60δες
		{
			$line1=substr($telikos_h,$i,10);
			$line2=substr($new_fasta_heavy,$i,10);
			array_push($ali_h_old,$line1);
			array_push($ali_h_new,$line2);
		}
	$length_h=count($ali_h_old);
	$ali_length=$length_h*10;
	//echo $length;
	
	for($i=0; $i<$length_h-1; $i+=6)
	{
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
		fwrite( $results_file, "            ");
		for($l=0; $l<=5; $l++)
		{
			$sum_ali_h=((($i+$l)*10)+10);
			$num=strlen((string) $sum_ali_h);
			if ($sum_ali_h>$ali_length-10)
			{
				break;
			}
			if ($num===3)
			{
				fwrite( $results_file, "       $sum_ali_h ");
				echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$sum_ali_h&nbsp";
			}
			if ($num===2)
			{
				fwrite( $results_file, "        $sum_ali_h ");
				echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$sum_ali_h&nbsp";
			}
		}
		echo "<br>";
		fwrite( $results_file, "\n");
		echo "seq_before&nbsp&nbsp";
		fwrite($results_file,"seq_before  ");
		for($j=0; $j<=5; $j++)
		{
			$sum=$i+$j;
			fwrite( $results_file, "$ali_h_old[$sum] ");
			echo "$ali_h_old[$sum] ";
		}
		echo "<br>";
		fwrite( $results_file, "\n");
		echo "seq_after&nbsp&nbsp&nbsp";
		fwrite($results_file,"seq_after   ");
		for($k=0; $k<=5; $k++)
		{
			$sum=$i+$k;
			echo "$ali_h_new[$sum] ";
			fwrite( $results_file, "$ali_h_new[$sum] ");
		}
		echo "<br><br>";
		fwrite( $results_file, "\n\n");
	}
echo "</td>";
echo "</tr></table><br><br>";

$new_fasta_heavy=strtoupper($new_fasta_heavy);
$new_fasta_light=strtoupper($new_fasta_light);


fwrite($results_file,"\n\n--------------------------------------------------CDRS------------------------------------------\n\n");
fwrite($results_file,"L1\t\t$cdr_start_l1-$cdr_finish_l1\t\t\t$akolouthia_l1\n");
fwrite($results_file,"L2\t\t$cdr_start_l2-$cdr_finish_l2\t\t\t$akolouthia_l2\n");
fwrite($results_file,"L3\t\t$cdr_start_l3-$cdr_finish_l3\t\t\t$akolouthia_l3\n\n");

fwrite($results_file,"H1\t\t$cdr_start_h1-$cdr_finish_h1\t\t\t$akolouthia_h1\n");
fwrite($results_file,"H2\t\t$cdr_start_h2-$cdr_finish_h2\t\t\t$akolouthia_h2\n");
fwrite($results_file,"H3\t\t$cdr_start_h3-$cdr_finish_h3\t\t\t$akolouthia_h3\n\n");

//echo "<table class=table3 align=center><tr><th>Name heavy chain</th><th>Start-End</th><th>Aminoacids</th></tr>";
//echo "<tr><td>H1</td><td>$start_h1-$finish_h1</td><td>$akolouthia_h1</td></tr>";
//echo "<tr><td>H2</td><td>$start_h2-$finish_h2</td><td>$akolouthia_h2</td></tr>";
//echo "<tr><td>H3</td><td>$start_h3-$finish_h3</td><td>$akolouthia_h3</td></tr></table>";
//echo"</tr>";


$_SESSION['var1']=$light_id;
$_SESSION['var2']=$heavy_id;
$_SESSION['var3']=$telikos_l;
$_SESSION['var4']=$telikos_h;
$_SESSION['var5']=$new_fasta_light;
$_SESSION['var6']=$new_fasta_heavy;
$_SESSION['var7']=$user_id;

//------------------------------------------Second run of amylpred 2----------------------------------

//echo "<h2>Amylpred 2 results after substitutions</h2>";
	$new_intervals_l=amyl($new_fasta_light,"newlight".$user_id); 
	foreach($new_intervals_l as $x => $x_value)
		{
			if ($x%2==0)
			{
				$new_up_limit_l[]=$x_value;
			}
			else
			{
				$new_down_limit_l[]=$x_value;
			}
		}
	
	
	
	$new_intervals_h=amyl($new_fasta_heavy,"newheavy".$user_id); 
	foreach($new_intervals_h as $x => $x_value)
		{
			if ($x%2==0)
			{
				$new_up_limit_h[]=$x_value;
			}
			else
			{
				$new_down_limit_h[]=$x_value;
			}
		}
	
	echo "<h2>AMYLPRED2 results for LIGHT chain before and after substitutions</h2>";

	echo"<table class=mytable align=center>";
	echo"<tr>";
	echo"<td><strong>Before substitutions</strong></td><td><strong>After substitutions</strong></td></tr><br>";
	echo"<tr>";
	echo"<td>";
	echo"<table class=table3 align=center>";
	if(!$up_limit_l){
		echo "<tr><td>No APRs found!</td></tr></table>";
	}
	else{
		print_intervals($up_limit_l,$down_limit_l,$telikos_l," Light");
	}
	echo "</td>";

	echo"<td>";
	echo"<table class=table3 align=center>";
	if(!$new_up_limit_l){
		echo "<tr><td>No APRs found!</td></tr></table>";
	} 
	else{
	print_intervals($new_up_limit_l,$new_down_limit_l,$new_fasta_light," Light");
	}
	//print_intervals($up_limit_h,$down_limit_h,$telikos_h," Heavy");
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<h2>AMYLPRED2 results for HEAVY chain before and after substitutions</h2>";
	echo"<table align=center>";
	echo"<tr>";
	echo"<td><strong>Before substitutions</strong></td><td><strong>After substitutions</strong></td></tr><br>";
	echo"<tr>";
	echo"<td>";
	echo"<table class=table3 align=center>";
	if(!$up_limit_h){
		echo "<tr><td>No APRs found!</td></tr></table>";
	} //NEW!!!
	else{
	print_intervals($up_limit_h,$down_limit_h,$telikos_h," Heavy");
	}
	//print_intervals($new_up_limit_l,$new_down_limit_l,$new_fasta_light," Light");
	echo"</td>";
	echo "<td>";
	echo"<table class=table3 align=center>";
	if(!$new_up_limit_h){
		echo "<tr><td>No APRs found!</td></tr></table>";
	} //NEW!!!
	else{
	print_intervals($new_up_limit_h,$new_down_limit_h,$new_fasta_heavy," Heavy");
	}
	echo "</td>";
	echo "</tr>";
	echo "</table><br>";
	echo "<i>*Remaining \"aggregation-prone\" regions are often located in CDRs</i><br>";
	$_SESSION['array_name1']=$new_up_limit_l;
	$_SESSION['array_name2']=$new_down_limit_l;
	$_SESSION['array_name3']=$new_up_limit_h;
	$_SESSION['array_name4']=$new_down_limit_h;
	$_SESSION['array_name5']=$up_limit_l;
	$_SESSION['array_name6']=$down_limit_l;
	$_SESSION['array_name7']=$up_limit_h;
	$_SESSION['array_name8']=$down_limit_h;
	
//---------------------------write my results file-----------------------------------------------------------------

	
	fwrite($results_file,"\n\n-------------------------------------Amylpred 2 results --------------------------------------\n\n");
	fwrite($results_file,"Light chain before substitutions\nRegion:\t\t\t\t\tStart-End\t\t\t\tAmino acids\n");
	for ($i=0; $i<count($up_limit_l); $i++)
		{
			$k=$i+1;
			fwrite($results_file,"$k\t\t\t\t\t");
			//echo ("<tr><td>$k</td>");
			$up=$up_limit_l[$i];
			$down=$down_limit_l[$i];
			fwrite($results_file,"$up-$down\t\t\t\t\t");
			//echo "<td>$array_up[$i]-$array_down[$i]</td>";
			$seq= substr($telikos_l,$up_limit_l[$i]-1,$down_limit_l[$i]-$up_limit_l[$i]+1);
			fwrite($results_file,"$seq");
			//echo "<td>$seq</td></tr>";
			//echo "<br>";
			fwrite($results_file,"\n\n");
		}
		
		fwrite($results_file,"\n\nLight chain after substitutions\nRegion:\t\t\t\t\tStart-End\t\t\t\tAmino acids\n");
		for ($i=0; $i<count($new_up_limit_l); $i++)
		{
			$k=$i+1;
			fwrite($results_file,"$k\t\t\t\t\t");
			//echo ("<tr><td>$k</td>");
			$up=$new_up_limit_l[$i];
			$down=$new_down_limit_l[$i];
			fwrite($results_file,"$up-$down\t\t\t\t\t");
			//echo "<td>$array_up[$i]-$array_down[$i]</td>";
			$seq= substr($new_fasta_light,$new_up_limit_l[$i]-1,$new_down_limit_l[$i]-$new_up_limit_l[$i]+1);
			fwrite($results_file,"$seq");
			//echo "<td>$seq</td></tr>";
			//echo "<br>";
			fwrite($results_file,"\n\n");
		}
		fwrite($results_file,"                                           -----------------                      ");
		
		fwrite($results_file,"\n\nHeavy chain before substitutions\nRegion:\t\t\t\t\tStart-End\t\t\t\tAmino acids\n");
		for ($i=0; $i<count($up_limit_h); $i++)
		{
			$k=$i+1;
			fwrite($results_file,"$k\t\t\t\t\t");
			//echo ("<tr><td>$k</td>");
			$up=$up_limit_h[$i];
			$down=$down_limit_h[$i];
			fwrite($results_file,"$up-$down\t\t\t\t\t");
			//echo "<td>$array_up[$i]-$array_down[$i]</td>";
			$seq= substr($telikos_h,$up_limit_h[$i]-1,$down_limit_h[$i]-$up_limit_h[$i]+1);
			fwrite($results_file,"$seq");
			//echo "<td>$seq</td></tr>";
			//echo "<br>";
			fwrite($results_file,"\n\n");
		}
		
		fwrite($results_file,"\n\nHeavy chain after substitutions\nRegion:\t\t\t\t\tStart-End\t\t\t\tAmino acids\n");
		for ($i=0; $i<count($new_up_limit_h); $i++)
		{
			$k=$i+1;
			fwrite($results_file,"$k\t\t\t\t\t");
			//echo ("<tr><td>$k</td>");
			$up=$new_up_limit_h[$i];
			$down=$new_down_limit_h[$i];
			fwrite($results_file,"$up-$down\t\t\t\t\t");
			//echo "<td>$array_up[$i]-$array_down[$i]</td>";
			$seq= substr($new_fasta_heavy,$new_up_limit_h[$i]-1,$new_down_limit_h[$i]-$new_up_limit_h[$i]+1);
			fwrite($results_file,"$seq");
			//echo "<td>$seq</td></tr>";
			//echo "<br>";
			fwrite($results_file,"\n\n");
		}
		fwrite($results_file,"\n\n------------------------------------------ END -----------------------------------------------------------");
	
	/*echo "<tr><th>Region $name</th><th>  Start-End  </th><th>  Aminoacids  </th></tr>";
		//echo "<br>";
		for ($i=0; $i<count($array_up); $i++)
		{
			$k=$i+1;
			echo ("<tr><td>$k</td>");
			echo "<td>$array_up[$i]-$array_down[$i]</td>";
			$seq= substr($sequence,$array_up[$i]-1,$array_down[$i]-$array_up[$i]+1);
			echo "<td>$seq</td></tr>";
			//echo "<br>";
		}
		echo "</table>";*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//print_r($heavy_array);
//----------------------------run again dssp in my new fasta file----------------------------
	/*system ("mkdssp -i newmodel.pdb -o new_model.dssp");
	$file_dssp_new = fopen("new_model.dssp","r")or die("Couldn't open $filename");
	$acc_L_new=array();
	$acc_H_new=array();
	while(! feof($file_dssp_new))
	{
		$a=fgets($file_dssp_new). "<br />"; //ανα γραμμή το κείμενο αποθηκεύεται στην $a
		if (preg_match("/^\s+\d+\s+\d+\sA\s+/",$a)) 
		{
			$b_L_new[]=substr($a,35,3);
			$pos_L_new[]=substr($a,7,3)-1;
		}
		if (preg_match("/^\s+\d+\s+\d+\sB\s+/",$a))
		{
			$b_H_new[]=substr($a,35,3);
			$pos_H_new[]=substr($a,7,3)-1;
		}
	
	}
	
	$acc_L_=array_combine($pos_L,$b_L);
	$acc_H=array_combine($pos_H,$b_H);
	foreach($acc_L as $x => $x_value)
		{
			if ($x_value>20)
			{
				//$sum_light=$sum_light+$x_value;
				$theseis_acc_light[]=$x; //οι θεσεις των αμινοξικων καταλοίπων που είναι προσβασιμες στον διαλύτη
			}
		}
	foreach($acc_H as $y => $y_value)
		{
			if ($y_value>20)
			{
				//$sum_heavy=$sum_heavy+$y_value;
				$theseis_acc_heavy[]=$y; //οι θεσεις των αμινοξικων καταλοίπων που είναι προσβασιμες στον διαλύτη
			}
		}
	//$sum=$sum_light+$sum_heavy;
	fclose($file_dssp_new); */ 
//-----------------------------surface in cm^2------------------------------------------
//-------------------Before substitutions-----------------

//------Light-------

	$sum_l=0;
	$old_l=0;
	for ($i=0; $i<count($up_limit_l); $i++)
	{
		for ($j=$up_limit_l[$i]; $j<=$down_limit_l[$i]; $j++)
		{
			if ($b_L[$j-1]>20)
			{
				$old_l=trim($b_L[$j-1]);
				$sum_l=$sum_l+$old_l;
			}
		}
		
	}
//------Heavy--------

	$sum_h=0;
	$old_h=0;
	for ($m=0; $m<count($up_limit_h); $m++)
	{
		for ($j=$up_limit_h[$m]; $j<=$down_limit_h[$m]; $j++)
		{
			if ($b_H[$j-1]>20)
			{
				$old_h=trim($b_H[$j-1]);
				$sum_h=$sum_h+$old_h;
			}
		}
	}
	
	
	$old_fasta_file = fopen("./results/".$fasta_id."old_fasta_file.txt","w")or die("Couldn't open $old_fasta_file"); 
    //echo $fasta_id;
	fwrite($old_fasta_file,">light chain|before substitutions\n");
	exidades($old_fasta_file,$telikos_l);
	fwrite($old_fasta_file,"\n\n");
	fwrite($old_fasta_file,">heavy chain|before substitutions\n");
	exidades($old_fasta_file,$telikos_h);
	echo "<br><br><span style='margin:10px;' ><a href=\"results/".$fasta_id."old_fasta_file.txt\" target=\"_blank\">Download FASTA before substitutions</a>";	
	//echo $old_fasta_file;
	
	$new_fasta_file = fopen("./results/".$user_id."new_fasta_file.txt","w")or die("Couldn't open $new_fasta_file"); 
    fwrite($new_fasta_file,">light chain|after substitutions\n");
	exidades($new_fasta_file,$new_fasta_light);
	fwrite($new_fasta_file,"\n\n");
	fwrite($new_fasta_file,">heavy chain|after substitutions\n");
	exidades($new_fasta_file,$new_fasta_heavy);
	echo "<br><br><span style='margin:10px;' ><a href=\"results/".$user_id."new_fasta_file.txt\" target=\"_blank\">Download FASTA after substitutions</a>";	
	
	echo "<br><br><span style='margin:10px;' >You can download the results as a text file: <a href=results/".$user_id."final_results.txt target='_blank'> HERE</a>";

$total_old=$sum_h+$sum_l;
$_SESSION['var8']=$total_old-$sum_final;
$_SESSION['var9']=$sum_l-$sum_meion_l;
$_SESSION['var10']=$sum_h-$sum_meion_h;
$_SESSION['var_sh1']=$start_h1;
$_SESSION['var_fh1']=$finish_h1;
$_SESSION['var_sh2']=$start_h2;
$_SESSION['var_fh2']=$finish_h2;
$_SESSION['var_sh3']=$start_h3;
$_SESSION['var_fh3']=$finish_h3;

$_SESSION['var_sl1']=$start_l1;
$_SESSION['var_fl1']=$finish_l1;
$_SESSION['var_sl2']=$start_l2;
$_SESSION['var_fl2']=$finish_l2;
$_SESSION['var_sl3']=$start_l3;
$_SESSION['var_fl3']=$finish_l3;
$_SESSION['sum']=$sum_final;
$_SESSION['sum_l']=$sum_meion_l;
$_SESSION['sum_h']=$sum_meion_h;

?>
<br><br>
<script type="text/javascript">
function showPageElement(what)
{
    var obj = typeof what == 'object'
        ? what : document.getElementById(what);

    obj.style.display = 'block';
    return false;
}
//myImvisibility();
// myVisibility();
</script>
		<a class="click-me" style="cursor:pointer" id="show" onClick="setTimeout(function(){window.open('modeller.php', '_blank');}, 15000);showPageElement('div1')">Calculate a new model with Modeller</a>
		<div id="div1" style="display:none;text-align: center;">
		<br><img src="model.png" alt="cm">
		</div>

<br><br><span style='margin:10px;'>As an alternative to Modeller you can use a predictor to create a novel structure using the fasta files provided above <br><a href="https://sysimm.ifrec.osaka-u.ac.jp/kotaiab/" target='_blank'><strong>kotai</strong></a> <a href="https://www.ncbi.nlm.nih.gov/pubmed/25064566">Yamashita <em>et al.</em> 2014</a>
<br>OR<br><a href="http://opig.stats.ox.ac.uk/webapps/sabdab-sabpred/Modelling.php" target='_blank'><strong>ABodyBuilder</strong></a> <a href="https://www.ncbi.nlm.nih.gov/pubmed/27392298">Leem <em>et al.</em> 2016</a>
		
<!--
		<a class="click-me" href="fasta_before.php" target="_blank">Fasta file before substitutions</a>
		<a class="click-me" href="fasta_after.php" target="_blank">Fasta file after substitutions</a>
-->
		</div>
	
</div>

	<!-- END OF DESCRIPTION-->
	<br>
	
	<!-- BEGGINING OF FOOTER-->
	<div class="Footer">
		<img src="./style/athina.jpg" height="70" align="left">
			<div class="Linkers">
  				<tr>
    				<td class="small_cell">
    		    		<a target="_blank" class="navbar_foot" href ="http://www.uoa.gr/"><span style="color:#2F4F4F">National and Kapodistrian University of Athens</span></a>
    				</td>
				</tr><br> 
				<tr>
     				<td class="small_cell">
     		    		<a target="_blank" class="navbar_foot" href ="http://www.biol.uoa.gr/"><span style="color:#2F4F4F">Department of Biology</span></a>
     				</td>
				</tr>
					<br>
            	<tr>
     				<td class="small_cell"><a target="_blank" class="navbar_foot" href ="http://biophysics.biol.uoa.gr/">
     		    		<span style="color:#008080">Back to Lab Page</span></a>
     				</td>
     	    	</tr>	
		</div>
   </div>
   <!-- END OF FOOTER-->
	</body>

</html>

