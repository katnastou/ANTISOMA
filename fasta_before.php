<?php
	session_start();
?>
<html>
	<head>
<style type="text/css">
	.old_fasta
	{
		font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;
	}
	.Footer
</style>
	</head>
<div class="old_fasta">
<?php
	function exidades($seq)
	{
		for($i=0; $i<strlen($seq); $i+=60) //εκτύπωση σε 60δες
		{
			echo $newline=substr($seq,$i,60);
			echo "<br>";
		}
	}

	$telikos_l=$_SESSION['var3'];
	$telikos_h=$_SESSION['var4'];
	//$fasta_file = fopen("fasta_file.pdb","w")or die("Couldn't open $new_pdb"); 
    echo ">light chain|before subtitutions<br>";
	exidades($telikos_l);
	echo "<br><br>";
	echo ">heavy chain|before substitutions<br>";
	exidades($telikos_h);
?>
	</div>
</html>
	