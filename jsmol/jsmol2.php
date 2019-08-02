<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>JSmol -- Jmol/HTML5 Demo</title>
<?php
	$up_limit_h=array("53", "82", "97", "121", "151", "192", "206");
	$down_limit_h=array("48","78","91","104","149","186","198");
	$up_limit_l=array("23", "57", "81", "91", "122", "143");
	$down_limit_l=array("19","50","75","88","118","133"); //prosoxi -1 einai to sosto kataloipo
	$new_up_limit_h=array("53", "82", "109", "151");
	$new_down_limit_h=array("48","78","107","149");
	$new_up_limit_l=array("25","142");
	$new_down_limit_l=array("19","136");
	$start_h1=27;
	$finish_h1=37;
	$start_h2=52;
	$finish_h2=67;
	$start_h3=98;
	$finish_h3=103;
	
	$start_l1=23;
	$finish_l1=38;
	$start_l2=54;
	$finish_l2=60;
	$start_l3=93;
	$finish_l3=101;
	//Light
	for ($i=0; $i<count($up_limit_h); $i++)
	{
		$num1=$up_limit_h[$i]-1;
		$num2=$down_limit_h[$i]-1;
		$arps_h.="select ".$num2."-".$num1.":H; color red; ";
	}
	for ($i=0; $i<count($up_limit_l); $i++)
	{
		$num1=$up_limit_l[$i]-1;
		$num2=$down_limit_l[$i]-1;
		$arps_l.="select ".$num2."-".$num1.":L; color red; ";
	}
	$arps=$arps_h.$arps_l;
	$script="script: \"load data/anevike.pdb; spacefill on; select :H; color blue; select :L; color [x909090]; ".$arps."select ".$start_h1."-".$finish_h1.":H; color yellow; select ".$start_h2."-".$finish_h2.":H; color yellow; select ".$start_h3."-".$finish_h3.":H; color yellow; select ".$start_l1."-".$finish_l1.":L; color yellow; select ".$start_l2."-".$finish_l2.":L; color yellow; select ".$start_l3."-".$finish_l3.":L; color yellow;\",";
	//echo $script;
	?>
<script type="text/javascript" src="JSmol.min.js"></script>

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
	document.title = (applet._id + " - Jmol " + ___JmolVersion)
	Jmol._getElement(applet, "appletdiv").style.border="1px solid black"
}		

var Info = {
	width: 500,
	height: 400,
	debug: false,
	color: "0xFFFFFF",
	addSelectionOptions: true,
	use: "HTML5",   // JAVA HTML5 WEBGL are all options
	j2sPath: "./j2s", // this needs to point to where the j2s directory is.
	jarPath: "./java",// this needs to point to where the java directory is.
	jarFile: "JmolAppletSigned.jar",
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
</head>
<body>
<div id="appdiv"></div>

</body>
</html>
