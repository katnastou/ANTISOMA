<!DOCTYPE html>
<?php
	session_start();
?>
<html>
<head>
<title>ANTISOMA</title>
<meta name="author" content="knastou">
<link rel="shortcut icon" href="style/favicon.png" />
<link rel="stylesheet" type="text/css" href="./style/style_me.css">
</head>

<body bgcolor="#0d47a1">
	
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

<script>
 
//		function myImvisibility() 
//			{
//			document.getElementById("myObj1").style.visibility = "hidden";
//			}
		
		function myVisibility() 
			{
			document.getElementById("myObj1").style.display = "block";
			}
		function myVisibility2() 
			{
			document.getElementById("myObj2").style.display = "block";
			}
</script>

	<br>
	<!-- BEGGINING OF DESCRIPTION-->
	<div class="Description">
			<!-- BEGGINING OF pdb FROM SITE-->	
			<form action="fetch.php" method="post" enctype="multipart/form-data">
			<div id="container">
				<div id="first"><h4>Insert a PDB ID</h4></div>
				<div id="second2"><input type="text" name="name" maxlength="4" placeholder="e.g. 2OSL"></div>
				<div id="first"><h4>Light chain ID*</h4></div>
				<div id="second"><input type="text" name="light" maxlength="1" placeholder="e.g. L"></div>
				<div id="first"><h4>Heavy chain ID*</h4></div>
				<div id="second"><input type="text" name="heavy" maxlength="1" placeholder="e.g. H"></div>
				<div id="first"><h4>pH</h4></div>
				<div id="fourth"><input type="text" name="ph" maxlength="4" value="6.0"></div>
				<div id="first"><h4>Ionic Strength</h4></div>
				<div id="fourth"><input type="text" name="ionstr" maxlength="5" value="0.05"></div>
				<div id="third"><input type="submit" value="Submit" name="submit" onclick="myVisibility()"></div>
			</div>
			</form>
			
			<div id="header"><span style="color:#0d47a1"> <b>OR</b> <i>upload your own pdb file </i> </span></div>
			<br>
			<form action="upload.php" method="post" enctype="multipart/form-data">
			<div id="container">
				<div id="first"><h4>Select .pdb file</h4></div>
				<div id="second2">
				<label for="file-upload" class="custom-file-upload">Upload pdb file</label>
				<input id="file-upload" type="file" name="uploaded">
				<!--<input type="file" name="uploaded" size="60">-->
				</div>
				<div id="first"><h4>Light chain ID*</h4></div>
				<div id="second"><input type="text" name="light" maxlength="1" placeholder="e.g. L"></div>
				<div id="first"><h4>Heavy chain ID*</h4></div>
				<div id="second"><input type="text" name="heavy" maxlength="1" placeholder="e.g. H"></div>
				<div id="first"><h4>pH</h4></div>
				<div id="fourth"><input type="text" name="ph" maxlength="4" value="6.0"></div>
				<div id="first"><h4>Ionic Strength</h4></div>
				<div id="fourth"><input type="text" name="ionstr" maxlength="5" value="0.05"></div>
				<div id="third"><input type="submit" value="Submit" name="submit" onclick="myVisibility()"></div>
			</div>
			</form>

<!--			<table class="table23">
			
				<tr>
					<td style="width:100px">
	  				<b><h4>Insert a PDB ID</h4></td>
					<td style="width:100px"><form action="fetch.php" method="post" enctype="multipart/form-data">
						<input type="text" name="name" maxlength="4" placeholder="e.g. 2OSL"></td>
						<td style="width:100px"><b><h4>Light chain ID*</h4></td> 
						<td style="width:150px"><input type="text" name="light" maxlength="1" placeholder="e.g. L"></td>
						<td style="width:100px"><b><h4>Heavy chain ID*</h4></td> 					
						<td style="width:150px"><input type="text" name="heavy" maxlength="1" placeholder="e.g. H"></td>
						<td><input type="submit" value="Submit" name="submit" onclick="myVisibility()"></td>
				</tr>
						<div id="myObj2" style="visibility:hidden" >						
				<tr>
						<td style="width:100px"><b><h4>pH*</h4></td> 					
						<td style="width:150px"><input type="text" name="ph" maxlength="1" value="6.0"></td>
						<td style="width:100px"><b><h4>Ionic Strength*</h4></td> 					
						<td style="width:150px"><input type="text" name="ionstr" maxlength="1" value="0.05"></td>
						</tr>
						</div>
					</form>
		
			<tr>
			<th colspan="4">
			<p><span style="color:#0d47a1"> <b>OR</b> <i>upload your own pdb file </i> </span></p></th>
			</tr>
-->
		<!-- BEGGINING OF pdb FROM FOLDER-->
<!--		<tr>
		<td style="width:100px">
			<form action="upload.php" method="post" enctype="multipart/form-data">
				<b><h4>Select .pdb file</h4></b></td>
				<div>
				  <label for="files" class="btn">Select File</label>
				  <input id="uploaded" name="uploaded" style="visibility:hidden;" type="file">
				</div>-->
    			<!--<td style="position: relative"><input type="file" name="uploaded"></td>-->
<!--    		<td style="width:100px">
    			<b><h4>Light chain ID*</h4></td> </b>
				<td style="width:150px"><input type="text" name="light" maxlength="1" placeholder="e.g. L"></td>
			<td style="width:100px">
				<b><h4>Heavy chain ID*</h4></td> </b>						
				<td style="width:150px"><input type="text" name="heavy" maxlength="1" placeholder="e.g. H"></td>
			<td>
				<input type="submit" value="Submit" name="submit onclick="myVisibility()">
			</form>
			</td>
		</tr>
		</table>
-->
		<br>
		<div id="myObj1" style="display: none;" >
			<p><u>Please do not refresh this page if you are not automatically redirected.<br>
			Your job may take more than 20 minutes</u></p>

			<!--<div class="loader"></div>-->
			<img src="wait4.gif" alt="wt" height="100" width="100">
		</div>
		
		<br>
		*Please  insert a chain identifier  as defined in the pdb file.  <a href="pdb_example.html" target="_blank">Example</a>
		
		<br><br>
		<!-------------SUBSTITUTION MATRIX---------------->
		<hr><h3>Advanced options:Change the substitutions matrix</h3>
		<script type="text/javascript"><!--
/* Script by: www.jtricks.com
 * Version: 20090221
 * Latest version:
 * www.jtricks.com/javascript/blocks/showinghiding.html
 */
function showPageElement(what)
{
    var obj = typeof what == 'object'
        ? what : document.getElementById(what);

    obj.style.display = 'inline-block';
    return false;
}

function hidePageElement(what)
{
    var obj = typeof what == 'object'
        ? what : document.getElementById(what);

    obj.style.display = 'none';
    return false;
}

function togglePageElementVisibility(what)
{
    var obj = typeof what == 'object'
        ? what : document.getElementById(what);

    if (obj.style.display == 'none')
        obj.style.display = 'inline-block';
    else
        obj.style.display = 'none';
    return false;
}

//--></script>

<button id="extended"
    onclick="showPageElement('div1')">
        Show Advanced Options
</button>

<button id="extended"
    onclick="hidePageElement(document.getElementById('div1'))">
        Hide Advanced Options
</button>
<br><br><br>		
		
		<div id="div1">
		<form action="submit.php" method="post">
		<table class="sub_table" align="center">
			<tr>
				<th>Residues<br>before substitutions</th><th>Residues<br>after substitutions</th>
				<th>Residues<br>before substitutions</th><th>Residues<br>after substitutions</th>
			</tr>
			<tr>
				<td>I</td><td><select name="ile">
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="N">N</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
						 </td>
			
				<td>F</td><td><select name="phe">
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
						 </td>
			</tr>
			<tr>
				<td>V</td><td><select name="val">
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			
				<td>L</td><td><select name="leu">
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			</tr>
			<tr>
				<td>Y</td><td><select name="tyr">
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			
				<td>M</td><td><select name="met">
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="N">N</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			</tr>
			<tr>
				<td>W</td><td><select name="try">
								<option value="G">G</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="N">N</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			
				<td>A</td><td><select name="ala">
								<option value="S">S</option>
								<option value="G">G</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="N">N</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			</tr>
			<tr>
				<td>T</td><td><select name="the">
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			
				<td>S</td><td><select name="ser">
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			</tr>
			<tr>
				<td>Q</td><td><select name="gln">
								<option value="Q">Q</option>
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="R">R</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			
				<td>R</td><td><select name="arg">
								<option value="R">R</option>
								<option value="Q">Q</option>
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			</tr>
			<tr>
				<td>N</td><td><select name="asn">
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			
				<td>E</td><td><select name="glu">
								<option value="D">D</option>
								<option value="R">R</option>
								<option value="Q">Q</option>
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="I">I</option>
							 </select>
							</td>
			</tr>
			<tr>
				<td>P</td><td><select name="pro">
								<option value="P">P</option>
								<option value="G">G</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="N">N</option>
								<option value="E">E</option>
								<option value="H">H</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			
				<td>H</td><td><select name="hys">
								<option value="R">R</option>
								<option value="Q">Q</option>
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			</tr>
			<tr>
				<td>K</td><td><select name="lys">
								<option value="R">R</option>
								<option value="Q">Q</option>
								<option value="N">N</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="G">G</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			
				<td>G</td><td><select name="gly">
								<option value="G">G</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="C">C</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="N">N</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
			</tr>
			<tr>
				<td>C</td><td><select name="cys">
								<option value="C">C</option>
								<option value="G">G</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="N">N</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="K">K</option>
								<option value="D">D</option>
								<option value="I">I</option>
							 </select>
							</td>
				<td>D</td><td><select name="asp">
								<option value="D">D</option>
								<option value="C">C</option>
								<option value="G">G</option>
								<option value="A">A</option>
								<option value="F">F</option>
								<option value="V">V</option>
								<option value="L">L</option>
								<option value="Y">Y</option>
								<option value="M">M</option>
								<option value="W">W</option>
								<option value="T">T</option>
								<option value="S">S</option>
								<option value="Q">Q</option>
								<option value="R">R</option>
								<option value="N">N</option>
								<option value="E">E</option>
								<option value="P">P</option>
								<option value="H">H</option>
								<option value="K">K</option>
								<option value="I">I</option>
							 </select>
							</td>
			</tr>
		</table>
		<strong>
<!--		<input id="saveChanges" type="submit" value="Press this button to save your changes in the substitution table" name="submit">   -->
		<button class="button" style="vertical-align:middle" type="submit" name="submit"><span>Press this button to save your changes in the substitution table </span></button>
		</strong>
		</form>
		<p><strong>*If you don't press SAVE your changes will be lost</strong></p>
		</div>
		
		


		
		<?php
			
			//-----------------------ISOLEUKINE----------------------
			if (isset($_POST["ile"]))
			{
				$ile=$_POST["ile"];
			}
			else
			{
				$ile="A";
			}
			//echo "I-->$ile <br> D-->$phe";
			//---------------------PHEINALANINE--------------------
			if (isset($_POST["phe"]))
			{
				$phe=$_POST["phe"];
			}
			else
			{
				$phe="N";
			}
			//echo "I-->$ile <br> F-->$phe";
			//---------------------VALINE---------------------
			if (isset($_POST["val"]))
			{
				$val=$_POST["val"];
			}
			else
			{
				$val="N";
			}
			//---------------------LEUCINE---------------------
			if (isset($_POST["leu"]))
			{
				$leu=$_POST["leu"];
			}
			else
			{
				$leu="N";
			}
			//---------------------TYROCINE---------------------
			if (isset($_POST["tyr"]))
			{
				$tyr=$_POST["tyr"];
			}
			else
			{
				$tyr="N";
			}
			//---------------------METHIONINE--------------------
			if (isset($_POST["met"]))
			{
				$met=$_POST["met"];
			}
			else
			{
				$met="A";
			}
			
			//---------------------CYSTEINE---------------------
			if (isset($_POST["cys"]))
			{
				$cys=$_POST["cys"];
			}
			else
			{
				$cys="C";
			}
			//---------------------TRYPTOPHANE---------------------
			if (isset($_POST["try"]))
			{
				$try=$_POST["try"];
			}
			else
			{
				$try="G";
			}
			//---------------------ALANINE---------------------
			if (isset($_POST["ala"]))
			{
				$ala=$_POST["ala"];
			}
			else
			{
				$ala="S";
			}
			//---------------------THREONINE----------------------
			if (isset($_POST["the"]))
			{
				$the=$_POST["the"];
			}
			else
			{
				$the="N";
			}
			//---------------------SERINE---------------------
			if (isset($_POST["ser"]))
			{
				$ser=$_POST["ser"];
			}
			else
			{
				$ser="N";
			}
			//---------------------GLUTAMINE---------------------
			if (isset($_POST["gln"]))
			{
				$gln=$_POST["gln"];
			}
			else
			{
				$gln="Q";
			}
			
			//---------------------ARGININE----------------------
			if (isset($_POST["arg"]))
			{
				$arg=$_POST["arg"];
			}
			else
			{
				$arg="R";
			}
			//---------------------ASPARAGINE----------------------
			if (isset($_POST["asn"]))
			{
				$asn=$_POST["asn"];
			}
			else
			{
				$asn="N";
			}
			//---------------------GLUTAMIC ACID----------------------
			if (isset($_POST["glu"]))
			{
				$glu=$_POST["glu"];
			}
			else
			{
				$glu="D";
			}
			
			//---------------------PROLINE----------------------
			if (isset($_POST["pro"]))
			{
				$pro=$_POST["pro"];
			}
			else
			{
				$pro="P";
			}
			
			//---------------------HYSTIDINE----------------------
			if (isset($_POST["hys"]))
			{
				$hys=$_POST["hys"];
			}
			else
			{
				$hys="R";
			}
			//---------------------LYSINE----------------------
			if (isset($_POST["lys"]))
			{
				$lys=$_POST["lys"];
			}
			else
			{
				$lys="R";
			}
			//---------------------GLYCINE---------------------
			if (isset($_POST["gly"]))
			{
				$gly=$_POST["gly"];
			}
			else
			{
				$gly="G";
			}
			//---------------------ASPARTIC ACID---------------------
			if (isset($_POST["asp"]))
			{
				$asp=$_POST["asp"];
			}
			else
			{
				$asp="D";
			}
			
			$_SESSION['ile']=$ile;
			$_SESSION['phe']=$phe;
			$_SESSION['val']=$val;
			$_SESSION['leu']=$leu;
			$_SESSION['tyr']=$tyr;
			$_SESSION['met']=$met;
			$_SESSION['cys']=$cys;
			$_SESSION['try']=$try;
			$_SESSION['ala']=$ala;
			$_SESSION['the']=$the;
			$_SESSION['ser']=$ser;
			$_SESSION['gln']=$gln;
			$_SESSION['arg']=$arg;
			$_SESSION['asn']=$asn;
			$_SESSION['glu']=$glu;
			$_SESSION['pro']=$pro;
			$_SESSION['hys']=$hys;
			$_SESSION['lys']=$lys;
			$_SESSION['gly']=$gly;
			$_SESSION['asp']=$asp;
		?>
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
	</body>
</html>
