<?php
	ob_start();
	session_start();
?>
<!DOCTYPE html>
<html>

<head>
<title>ANTISOMA</title>
<meta name="author" content="knastou">
<link rel="shortcut icon" href="style/favicon.png" />
	<meta charset='UTF-8'>
	<link rel="stylesheet" type="text/css" href="style/style_modeller.css">

</head>

<body bgcolor="#0d47a1">
	
	<!-- FIRST div for header-->
	<div class="mainsection">
	
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
   					<a class="navbar" href="index.html">Home</a></td>
   
					<td class="nav_cell" width="25%" align="center">
        			<a class="navbar" href="submit.php">Submission</a></td>

					<td class="nav_cell" width="25%" align="center">
					<a class="navbar" href="manual.html">Manual</a></td>
		
					<td class="nav_cell" width="25%" align="center">
       				<a class="navbar" href="contact.html">Contact</a></td>
       
			</tr>
			</tbody>
			</table>
	  </td>
  	</tr>
	</table>
</div>
	<br>
	<!-- END OF HEADER-->
	
	<!-- BEGGINING OF DESCRIPTION-->
	

	
	<?php	
	error_reporting(0);
	function pdb_to_fasta($name,$chain)
	{
		$myfile= fopen($name, "r") or die("Unable to open file 1!");
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
		$new_pdb= fopen("newpdb.pdb", "a+") or die("Unable to open file!");
		while(! feof($myfile))
		{	
			$a=fgets($myfile);//. "<br />";
			if ((preg_match("/^ATOM/",$a)) && (substr($a,21,1)==$chain)) 	# look for lines that start with ATOM
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
	$light_id=$_SESSION['var1'];
	$heavy_id=$_SESSION['var2'];
	$telikos_l=$_SESSION['var3'];
	$telikos_h=$_SESSION['var4'];
	$new_fasta_light=$_SESSION['var5'];
	$new_fasta_heavy=$_SESSION['var6'];
	$user_id=$_SESSION['var7'];	
	$total_old=$_SESSION['var8'];
	$sum_l=$_SESSION['var9'];
	$sum_h=$_SESSION['var10'];

	$up_limit_l=$_SESSION['array_name5'];
	$down_limit_l=$_SESSION['array_name6'];
	
	$sum_final=$_SESSION['sum'];
	
	$up_limit_h=$_SESSION['array_name7'];
	$down_limit_h=$_SESSION['array_name8'];
	$new_up_limit_l=$_SESSION['array_name1'];
	$new_down_limit_l=$_SESSION['array_name2'];
	$new_up_limit_h=$_SESSION['array_name3'];
	$new_down_limit_h=$_SESSION['array_name4'];
	$pos_replace_l=$_SESSION['array_nameposl'];
	$pos_replace_h=$_SESSION['array_nameposh'];
	
	$length=strlen($telikos_h)+1;
	
	$start_h1=$_SESSION['var_sh1'];
	$finish_h1=$_SESSION['var_fh1'];
	$start_h2=$_SESSION['var_sh2'];
	$finish_h2=$_SESSION['var_fh2'];
	$start_h3=$_SESSION['var_sh3'];
	$finish_h3=$_SESSION['var_fh3'];

	$start_l1=$_SESSION['var_sl1'];
	$finish_l1=$_SESSION['var_fl1'];
	$start_l2=$_SESSION['var_sl2'];
	$finish_l2=$_SESSION['var_fl2'];
	$start_l3=$_SESSION['var_sl3'];
	$finish_l3=$_SESSION['var_fl3'];
	$sum_meion_l=$_SESSION['sum_l'];
	$sum_meion_h=$_SESSION['sum_h'];

		$modeller_heavy=pdb_to_fasta("./results/$user_id.pdb",$heavy_id);
		//exidades($modeller_heavy);
		$modeller_light=pdb_to_fasta("./results/$user_id.pdb",$light_id);
		//exidades($modeller_light);

		$length_modeller_heavy=strlen($modeller_heavy);
		$length_modeller_light=strlen($modeller_light);
		$length_telikos_h=strlen($telikos_h);
		$length_telikos_l=strlen($telikos_l);

		$difference_heavy=$length_telikos_h-$length_modeller_heavy;
		$difference_light=$length_telikos_l-$length_modeller_light;

		//Check for differences in the allignment between my changed SEQ file and the file from pdb

		if ($difference_heavy>0)
		{
			for ($i=0; $i<$difference_heavy; $i++)
			{
				$modeller_heavy=$modeller_heavy."-";
			}
		}
		if ($difference_light>0)
		{
			for ($i=0; $i<$difference_light; $i++)
			{
				$modeller_light=$modeller_light."-";
			}
		}
		//create the alignment file alignment.alli
		//$file_ali= fopen("newpdb.pdb","r")or die("Couldn't open $filename"); //άνοιγμα αρχείου
		
		$lineforrecognition= fgets(fopen("newpdb.pdb","r"));
		$chain_name=substr($lineforrecognition,21,1);
		//echo $chain_name;
		//if ($chain_name=$heavy_id)
		//echo "!!!!!!!!!!!!!!!!!!!!!!!!!$chain_name----$heavy_id--------$light_id<br><br>"; 
		if (strcmp($chain_name, $heavy_id)==0)
		{
			//echo $heavy_id;
			//echo "proti einai h heavy";
			$file_ali= fopen("alignment.ali","w")or die("Couldn't open $filename"); //άνοιγμα αρχείου
			$title_heavy=">P1;newpdb\n";
			fwrite($file_ali,$title_heavy);
			fwrite($file_ali,"structureX:newpdb:FIRST:".$heavy_id.":LAST:".$light_id."::::\n");   ///!!!!!!!!!!!PROSOXIIIII DNE EXEI GINEI EISAGOGI TON ALISIDON!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			fwrite($file_ali,$modeller_heavy);
			fwrite($file_ali,"/\n");
			fwrite($file_ali,$modeller_light);
			fwrite($file_ali,"\n*");
			fwrite($file_ali,"\n\n");
			fwrite($file_ali,">P1;target\n");
			fwrite($file_ali,"sequence:target::::::::\n");
			fwrite($file_ali,$new_fasta_heavy);
			fwrite($file_ali,"/\n");
			fwrite($file_ali,$new_fasta_light);
			fwrite($file_ali,"\n*");
			fclose ($file_ali);
		}
//elseif ($chain_name=$light_id)
		if (strcmp($chain_name, $light_id)==0)
		{
			$file_ali= fopen("alignment.ali","w")or die("Couldn't open $filename"); //άνοιγμα αρχείου
			$title_heavy=">P1;newpdb\n";
			fwrite($file_ali,$title_heavy);
			fwrite($file_ali,"structureX:newpdb:FIRST:".$light_id.":LAST:".$heavy_id."::::\n");   ///!!!!!!!!!!!PROSOXIIIII DNE EXEI GINEI EISAGOGI TON ALISIDON!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			fwrite($file_ali,$modeller_light);
			fwrite($file_ali,"/\n");
			fwrite($file_ali,$modeller_heavy);
			fwrite($file_ali,"\n*");
			fwrite($file_ali,"\n\n");
			fwrite($file_ali,">P1;target\n");
			fwrite($file_ali,"sequence:target::::::::\n");
			fwrite($file_ali,$new_fasta_light);
			fwrite($file_ali,"/\n");
			fwrite($file_ali,$new_fasta_heavy);
			fwrite($file_ali,"\n*");
			fclose ($file_ali);
		}
	

		//create the python script buildmodel.py
		$file_python= fopen("buildmodel.py","w")or die("Couldn't open $filename"); //άνοιγμα αρχείου
		fwrite($file_python,"from modeller import *
from modeller.automodel import *    # Load the automodel class

log.verbose()
env = environ()
#env.io.hetatm = True
# directories for input atom files

a = automodel(env, alnfile = 'alignment.ali',
              		knowns = ('newpdb'), sequence = 'target')
a.starting_model= 1
a.ending_model  = 1
#a.md_level=refine.fast
a.make()");
		fclose($file_python);
		//$path="buildmodel.py";
		system("mod9.19 buildmodel.py");

		foreach (glob("*.pdb") as $filename)
		{
			if (substr($filename,0,6) == "target")	
			{
				$my_new_file=$filename;
			}
		}
		rename ($my_new_file,"./results/".$user_id."new_model.pdb");
		//$new_pdb = fopen("new_model.pdb","r")or die("Couldn't open $new_pdb");
		rename ("newpdb.pdb","./results/".$user_id."old_model.pdb");
		unlink('newpdb.pdb');
		system ("mkdssp -i ./results/".$user_id."new_model.pdb -o ./results/".$user_id."new_model.dssp");
	$file_dssp_new = fopen("./results/".$user_id.".dssp","r")or die("Couldn't open 3!!!!");
	$acc_L_new=array();
	$acc_H_new=array();
	while(! feof($file_dssp_new))
	{
		$a=fgets($file_dssp_new). "<br />"; //ανα γραμμή το κείμενο αποθηκεύεται στην $a
		if (preg_match("/^\s+\d+\s+\d+\s".$light_id."\s+/",$a)) 
		{
			$b_L_new[]=substr($a,35,3);
			$pos_L_new[]=substr($a,7,3)-1;
		}
		if (preg_match("/^\s+\d+\s+\d+\s".$heavy_id."\s+/",$a))
		{
			$b_H_new[]=substr($a,35,3);
			$pos_H_new[]=substr($a,7,3)-1;
		}
	
	}
	/*
	$acc_L_=array_combine($pos_L_new,$b_L_new);
	$acc_H=array_combine($pos_H_new,$b_H_new);
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
	//$sum=$sum_light+$sum_heavy;*/
	fclose($file_dssp_new);
//-------------------After substitutions-----------------

//------Light-------

	$new_sum_l=0;
	$new_l=0;
	for ($i=0; $i<count($new_up_limit_l); $i++)
	{
		//echo $b_L[$i]."ghfgkjfdjvnsdjnkjdbvsdhvbsdhvbsdbsvbsdvbsvjbskdjbvskvdbskjbsdk";
		for ($j=$new_up_limit_l[$i]; $j<=$new_down_limit_l[$i]; $j++)
		{
			//echo $b_L[$i]."ghfgkjfdjvnsdjnkjdbvsdhvbsdhvbsdbsvbsdvbsvjbskdjbvskvdbskjbsdk";
			if ($b_L_new[$j-1]>20)
			{
				$new_l=trim($b_L_new[$j-1]);
				$new_sum_l=$new_sum_l+$new_l;
				//echo $new_sum_l;
			}
		}
		
	}
//------Heavy--------

	$new_sum_h=0;
	$new_h=0;
	for ($m=0; $m<count($new_up_limit_h); $m++)
	{
		for ($j=$new_up_limit_h[$m]; $j<=$new_down_limit_h[$m]; $j++)
		{
			if ($b_H_new[$j-1]>20)
			{
				$new_h=trim($b_H_new[$j-1]);
				$new_sum_h=$new_sum_h+$new_h;
			}
		}
	}
//Edw kanonika afairoutan ta CDRs apo to sunoliko ogko alla efoson den douleue swsta ta kratame stous upologismous
//	$new_sum_h=$new_sum_h-$sum_meion_h; 
//	$new_sum_l=$new_sum_l-$sum_meion_l;
$total_new=$new_sum_h+$new_sum_l;
//--------------------------------------------------------Jmol----------------------------------
for ($i=0; $i<count($up_limit_h); $i++)
	{
		$num1=$up_limit_h[$i]-1;
		$num2=$down_limit_h[$i]-1;
		$arps_h.="select ".$num1."-".$num2.":H; color red; ";
	}
	for ($i=0; $i<count($new_up_limit_h); $i++)
	{
		$num3=$new_up_limit_h[$i]-1;
		$num4=$new_down_limit_h[$i]-1;
		$new_arps_h.="select ".$num3."-".$num4.":A; color red; ";
	}
	for ($i=0; $i<count($up_limit_l); $i++)
	{
		$num1=$up_limit_l[$i]-1;
		$num2=$down_limit_l[$i]-1;
		$arps_l.="select ".$num1."-".$num2.":L; color red; ";
	}
	for ($i=0; $i<count($new_up_limit_l); $i++)
	{
		$num3=$new_up_limit_l[$i]-1+$length;
		$num4=$new_down_limit_l[$i]-1+$length;
		$new_arps_l.="select ".$num3."-".$num4.":B; color red; ";
	}
	$arps=$arps_h.$arps_l;
	$new_arps=$new_arps_h.$new_arps_l;
	for ($i=0; $i<count($pos_replace_l); $i++)
	{
		$num=$pos_replace_l[$i]+$length;
		$replace_l.="select $num:B; color [x00FF00]; ";
	}
	for ($i=0; $i<count($pos_replace_h); $i++)
	{
		$num=$pos_replace_h[$i];
		$replace_h.="select $num:A; color [x00FF00]; ";
	}
	$replace=$replace_l.$replace_h;
	$script="script: \"load ./results/".$user_id."old_model.pdb; spacefill on; select :".$heavy_id."; color blue; select :".$light_id."; color [x909090]; ".$arps."select ".$start_h1."-".$finish_h1.":H; color yellow; select ".$start_h2."-".$finish_h2.":H; color yellow; select ".$start_h3."-".$finish_h3.":H; color yellow; select ".$start_l1."-".$finish_l1.":L; color yellow; select ".$start_l2."-".$finish_l2.":L; color yellow; select ".$start_l3."-".$finish_l3.":L; color yellow;\",";
	//echo "$script<br><br><br>";
	$new_finish_l1=$finish_l1+$length;
	$new_finish_l2=$finish_l2+$length;
	$new_finish_l3=$finish_l3+$length;

	$new_start_l1=$start_l1+$length;
	$new_start_l2=$start_l2+$length;
	$new_start_l3=$start_l3+$length;
	$new_script="script: \"load ./results/".$user_id."new_model.pdb; spacefill on; select :A; color blue; select :B; color [x909090]; ".$new_arps."select ".$start_h1."-".$finish_h1.":A; color yellow; select ".$start_h2."-".$finish_h2.":A; color yellow; select ".$start_h3."-".$finish_h3.":A; color yellow; select ".$new_start_l1."-".$new_finish_l1.":B; color yellow; select ".$new_start_l2."-".$new_finish_l2.":B; color yellow; select ".$new_start_l3."-".$new_finish_l3.":B; color yellow; $replace\",";
	//echo $new_script;
	?>
	<div class="Description">
		<h3><p><b><u>Visualisation of the Fab fragment of the monoclonal antibody</u><b><p></h3>
		
					
		<ul align="center" style="list-style-type: none;">
		<li><span style="color: blue">Blue</span>: Heavy chain of the monoclonal antibody</li> 
		<li><span style="color: gray">Gray</span>: Light chain of the monoclonal antibody</li>
		<li><span style="color: red">Red</span>: "Aggregation-prone" regions (APRs) (predicted by AMYLPRED2)</li>
		<li><span style="color: yellow">Yellow</span>: Complementarity determining regions (CDRs)</li>
		<li><span style="color: green">Green</span>: Aminoacid substitution</li>
	</ul>
	<br><br>
	<?php echo "<span style='margin:10px;' >Please refer to the final results file to see the regions that are colored in the models below: <a href=results/".$user_id."final_results.txt target='_blank'>Results</a>"; ?>
	<script type="text/javascript" src="./jsmol/JSmol.min.js"></script>

<script type="text/javascript">

// last update 2/18/2014 2:10:06 PM

var jmolApplet0; // set up in HTML table, below

// logic is set by indicating order of USE -- default is HTML5 for this test page, though

var s = document.location.search;

// Developers: The _debugCode flag is checked in j2s/core/core.z.js, 
// and, if TRUE, skips loading the core methods, forcing those
// to be read from their individual directories. Set this
// true if you want to do some code debugging by inserting
// System.out.println, document.title, or alert commands
// anywhere in the Java or Jmol code.

Jmol._debugCode = (s.indexOf("debugcode") >= 0);

jmol_isReady = function(applet) {
//	document.title = (applet._id + " - Jmol " + ___JmolVersion)
	Jmol._getElement(applet, "appletdiv").style.border="1px solid black"
}		

var Info = {
	width: 500,
	height: 400,
	debug: false,
	color: "0xFFFFFF",
	//addSelectionOptions: true,
	use: "HTML5",   // JAVA HTML5 WEBGL are all options
	j2sPath: "./jsmol/j2s", // this needs to point to where the j2s directory is.
	jarPath: "./jsmol/java",// this needs to point to where the java directory is.
	jarFile: "./jsmol/JmolAppletSigned.jar",
	isSigned: true,
	<?php
	echo "$script";
	?>
	serverURL: "http://chemapps.stolaf.edu/jmol/jsmol/php/jsmol.php",
	readyFunction: jmol_isReady,
	disableJ2SLoadMonitor: true,
  disableInitialConsole: true,
  allowJavaScript: true
	//defaultModel: "$dopamine",
	//console: "none", // default will be jmolApplet0_infodiv, but you can designate another div here or "none"
}


$(document).ready(function() {
  $("#appdiv").html(Jmol.getAppletHtml("jmolApplet0", Info))
})
var lastPrompt=0;
</script>
<!----neoooooooooooooooooooooooooooooooooo sccrippttttttttttttttttttttttttttttttttttttttttttttt--------------------------------------->
<script type="text/javascript">

// last update 2/18/2014 2:10:06 PM

var jmolApplet1; // set up in HTML table, below

// logic is set by indicating order of USE -- default is HTML5 for this test page, though

var s = document.location.search;

// Developers: The _debugCode flag is checked in j2s/core/core.z.js, 
// and, if TRUE, skips loading the core methods, forcing those
// to be read from their individual directories. Set this
// true if you want to do some code debugging by inserting
// System.out.println, document.title, or alert commands
// anywhere in the Java or Jmol code.

Jmol._debugCode = (s.indexOf("debugcode") >= 0);

jmol_isReady = function(applet) {
	//document.title = (applet._id + " - Jmol " + ___JmolVersion)
	Jmol._getElement(applet, "appletdiv").style.border="1px solid black"
}		

var Info1 = {
	width: 500,
	height: 400,
	debug: false,
	color: "0xFFFFFF",
	//addSelectionOptions: true,
	use: "HTML5",   // JAVA HTML5 WEBGL are all options
	j2sPath: "./jsmol/j2s", // this needs to point to where the j2s directory is.
	jarPath: "./jsmol/java",// this needs to point to where the java directory is.
	jarFile: "./jsmol/JmolAppletSigned.jar",
	isSigned: true,
	<?php
	echo "$new_script";
	?>
	serverURL: "http://chemapps.stolaf.edu/jmol/jsmol/php/jsmol.php",
	readyFunction: jmol_isReady,
	disableJ2SLoadMonitor: true,
  disableInitialConsole: true,
  allowJavaScript: true,
  spinRateX: 0.2,
    spinRateY: 0.5,
    spinFPS: 20,
    spin:true,
    debug: false
	//defaultModel: "$dopamine",
	//console: "none", // default will be jmolApplet0_infodiv, but you can designate another div here or "none"
}


$(document).ready(function() {
  $("#appdiv1").html(Jmol.getAppletHtml("jmolApplet1", Info1))
})
var lastPrompt=0;
</script>

<?php
/*
echo "<a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet0, 'load ./results/".$user_id."old_model.pdb; spacefill on; select :H; color blue; select :L; color [x909090]; ".$arps."select ".$start_h1."-".$finish_h1.":H; color yellow; select ".$start_h2."-".$finish_h2.":H; color yellow; select ".$start_h3."-".$finish_h3.":H; color yellow; select ".$start_l1."-".$finish_l1.":L; color yellow; select ".$start_l2."-".$finish_l2.":L; color yellow; select ".$start_l3."-".$finish_l3.":L; color yellow; moveto 1 left; background black;delay 0.1;background white')\">Refresh old model</a>";
echo"&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet1, 'load ./results/".$user_id."new_model.pdb; spacefill on; select :A; color blue; select :B; color [x909090]; ".$new_arps."select ".$start_h1."-".$finish_h1.":A; color yellow; select ".$start_h2."-".$finish_h2.":A; color yellow; select ".$start_h3."-".$finish_h3.":A; color yellow; select ".$new_start_l1."-".$new_finish_l1.":B; color yellow; select ".$new_start_l2."-".$new_finish_l2.":B; color yellow; select ".$new_start_l3."-".$new_finish_l3.":B; color yellow; ".$replace." moveto 1 left;background black;delay 0.1;background white')\">Refresh new model</a>";
echo "<br><br>";
echo "<a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet0, 'load ./results/".$user_id."old_model.pdb; spacefill on; select :H; color blue; select :L; color [x909090]; ".$arps."select ".$start_h1."-".$finish_h1.":H; color yellow; select ".$start_h2."-".$finish_h2.":H; color yellow; select ".$start_h3."-".$finish_h3.":H; color yellow; select ".$start_l1."-".$finish_l1.":L; color yellow; select ".$start_l2."-".$finish_l2.":L; color yellow; select ".$start_l3."-".$finish_l3.":L; color yellow; spin on')\">Spin on old model</a>";
echo"&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet1, 'load ./results/".$user_id."new_model.pdb; spacefill on; select :A; color blue; select :B; color [x909090]; ".$new_arps."select ".$start_h1."-".$finish_h1.":A; color yellow; select ".$start_h2."-".$finish_h2.":A; color yellow; select ".$start_h3."-".$finish_h3.":A; color yellow; select ".$new_start_l1."-".$new_finish_l1.":B; color yellow; select ".$new_start_l2."-".$new_finish_l2.":B; color yellow; select ".$new_start_l3."-".$new_finish_l3.":B; color yellow; ".$replace." Spin on')\">Spin on new model</a>";
echo "<br><br>";
echo "<a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet0, 'load ./results/".$user_id."old_model.pdb; spacefill on; select :H; color blue; select :L; color [x909090]; ".$arps."select ".$start_h1."-".$finish_h1.":H; color yellow; select ".$start_h2."-".$finish_h2.":H; color yellow; select ".$start_h3."-".$finish_h3.":H; color yellow; select ".$start_l1."-".$finish_l1.":L; color yellow; select ".$start_l2."-".$finish_l2.":L; color yellow; select ".$start_l3."-".$finish_l3.":L; color yellow; spin off')\">Spin off old model</a>";
echo"&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
echo "<a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet1, 'load ./results/".$user_id."new_model.pdb; spacefill on; select :A; color blue; select :B; color [x909090]; ".$new_arps."select ".$start_h1."-".$finish_h1.":A; color yellow; select ".$start_h2."-".$finish_h2.":A; color yellow; select ".$start_h3."-".$finish_h3.":A; color yellow; select ".$new_start_l1."-".$new_finish_l1.":B; color yellow; select ".$new_start_l2."-".$new_finish_l2.":B; color yellow; select ".$new_start_l3."-".$new_finish_l3.":B; color yellow; ".$replace." Spin off')\">Spin off new model</a>";
*/

echo "<table class=table3 align=center>";
 echo "<tr>";
   echo "<th align=center><i>Structure before substitutions</i></td>";
   echo "<th align=center><i>Structure after substitutions</i></td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td><div id=\"appdiv\"></div></td>";
   echo "<td><div id=\"appdiv1\"></div></td>";
   echo "</tr>";
   echo "<tr>";
   echo "<th><i>Surface of APRs before substitutions</i></th>";
   echo "<th><i>Surface of APRs after substitutions</i></th>";
   echo "</tr>";
   echo "<tr>";
   echo "<td align=center><b>Light chain</b>:$sum_l <span>&#8491;</span><sup>2</sup>\t<b>Heavy chain</b>:$sum_h <span>&#8491;</span><sup>2</sup>\t<b>TOTAL</b>: $total_old <span>&#8491;</span><sup>2</sup></td>";
   echo "<td align=center><b>Light chain</b>:$new_sum_l <span>&#8491;</span><sup>2</sup>\t<b>Heavy chain</b>:$new_sum_h <span>&#8491;</span><sup>2</sup>\t<b>TOTAL</b>: $total_new <span>&#8491;</span><sup>2</sup></td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td> <a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet0, 'load ./results/".$user_id."old_model.pdb; spacefill on; select :H; color blue; select :L; color [x909090]; ".$arps."select ".$start_h1."-".$finish_h1.":H; color yellow; select ".$start_h2."-".$finish_h2.":H; color yellow; select ".$start_h3."-".$finish_h3.":H; color yellow; select ".$start_l1."-".$finish_l1.":L; color yellow; select ".$start_l2."-".$finish_l2.":L; color yellow; select ".$start_l3."-".$finish_l3.":L; color yellow; moveto 1 left; background black;delay 0.1;background white')\">Refresh</a>";
   echo "&nbsp&nbsp <a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet0, 'load ./results/".$user_id."old_model.pdb; spacefill on; select :H; color blue; select :L; color [x909090]; ".$arps."select ".$start_h1."-".$finish_h1.":H; color yellow; select ".$start_h2."-".$finish_h2.":H; color yellow; select ".$start_h3."-".$finish_h3.":H; color yellow; select ".$start_l1."-".$finish_l1.":L; color yellow; select ".$start_l2."-".$finish_l2.":L; color yellow; select ".$start_l3."-".$finish_l3.":L; color yellow; spin on')\">Spin on</a>";
   echo "&nbsp&nbsp <a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet0, 'load ./results/".$user_id."old_model.pdb; spacefill on; select :H; color blue; select :L; color [x909090]; ".$arps."select ".$start_h1."-".$finish_h1.":H; color yellow; select ".$start_h2."-".$finish_h2.":H; color yellow; select ".$start_h3."-".$finish_h3.":H; color yellow; select ".$start_l1."-".$finish_l1.":L; color yellow; select ".$start_l2."-".$finish_l2.":L; color yellow; select ".$start_l3."-".$finish_l3.":L; color yellow; spin off')\">Spin off</a>";
   echo "</td>";
   echo "<td> <a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet1, 'load ./results/".$user_id."new_model.pdb; spacefill on; select :A; color blue; select :B; color [x909090]; ".$new_arps."select ".$start_h1."-".$finish_h1.":A; color yellow; select ".$start_h2."-".$finish_h2.":A; color yellow; select ".$start_h3."-".$finish_h3.":A; color yellow; select ".$new_start_l1."-".$new_finish_l1.":B; color yellow; select ".$new_start_l2."-".$new_finish_l2.":B; color yellow; select ".$new_start_l3."-".$new_finish_l3.":B; color yellow; ".$replace." moveto 1 left;background black;delay 0.1;background white')\">Refresh</a>";
   echo "&nbsp&nbsp <a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet1, 'load ./results/".$user_id."new_model.pdb; spacefill on; select :A; color blue; select :B; color [x909090]; ".$new_arps."select ".$start_h1."-".$finish_h1.":A; color yellow; select ".$start_h2."-".$finish_h2.":A; color yellow; select ".$start_h3."-".$finish_h3.":A; color yellow; select ".$new_start_l1."-".$new_finish_l1.":B; color yellow; select ".$new_start_l2."-".$new_finish_l2.":B; color yellow; select ".$new_start_l3."-".$new_finish_l3.":B; color yellow; ".$replace." Spin on')\">Spin on</a>";
   echo "&nbsp&nbsp <a class=\"click-me\" href=\"javascript:Jmol.script(jmolApplet1, 'load ./results/".$user_id."new_model.pdb; spacefill on; select :A; color blue; select :B; color [x909090]; ".$new_arps."select ".$start_h1."-".$finish_h1.":A; color yellow; select ".$start_h2."-".$finish_h2.":A; color yellow; select ".$start_h3."-".$finish_h3.":A; color yellow; select ".$new_start_l1."-".$new_finish_l1.":B; color yellow; select ".$new_start_l2."-".$new_finish_l2.":B; color yellow; select ".$new_start_l3."-".$new_finish_l3.":B; color yellow; ".$replace." Spin off')\">Spin off</a>";
   echo"</td>";
   echo "</tr>"; 
   echo "</table>";
/*
echo "<br>";
echo "<table class=table1 align=center>";spacefill on; select :H; color blue; select :L; color [x909090]; ".$arps."select ".$start_h1."-".$finish_h1.":H; color yellow; select ".$start_h2."-".$finish_h2.":H; color yellow; select ".$start_h3."-".$finish_h3.":H; color yellow; select ".$start_l1."-".$finish_l1.":L; color yellow; select ".$start_l2."-".$finish_l2.":L; color yellow; select ".$start_l3."-".$finish_l3.":L; color yellow;
echo "<tr>";
echo "<th><i>Surface of APRs before substitutions jfdjiogdfiognfdgnfkjds</i></th>";
echo "</tr>";
echo "<tr><td><b>Light chain</b>:$sum_l <span>&#8491;</span><sup>2</sup> \t<b>Heavy chain</b>:$sum_h <span>&#8491;</span><sup>2</sup>\t<b>TOTAL</b>: $total_old <span>&#8491;</span><sup>2</sup>";
echo "</td></td></table>";

echo "<br>";
echo "<table class=table1 align=center>";
echo "<tr>";
echo "<th><i>Surface of APRs  after substitutions</i></th>";
echo "</tr>";
echo "<tr><td><b>Light chain</b>:$new_sum_l <span>&#8491;</span><sup>2</sup>\t<b>Heavy chain</b>:$new_sum_h <span>&#8491;</span><sup>2</sup>\t<b>TOTAL</b>: $total_new <span>&#8491;</span><sup>2</sup>";
echo "</td></td></table>";*/

?>
<br><br>


<?php
echo "<span style='margin:10px;' >Please refer to the manual, to see how to download images of the models above<br><br>";
echo "<span style='margin:10px;' ><a class=\"click-me\" href=\"results/".$user_id."new_model.pdb\" target=\"_blank\">Download PDB file with the new model</a><br><br><br>";	
echo "<span style='margin:10px;' ><a class=\"click-me\" href=\"results/".$user_id.".tar.gz\" target=\"_blank\">Download compressed file with all your results</a>";	
?>
<br><br>
	<p><strong>JSmol</strong> <i>(Hanson, et al. (2013), Israel Journal of 
							Chemistry, 53(3-4): 207–216)</i></p>

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
<?php
system ("tar -czvf ./results/".$user_id.".tar.gz results/".$user_id."* > results/".$user_id.".tardirs");
session_write_close();
ob_end_flush();
?>
