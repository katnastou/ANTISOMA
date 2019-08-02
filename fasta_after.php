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

	$new_fasta_light=$_SESSION['var5'];
	$new_fasta_heavy=$_SESSION['var6'];
	//$fasta_file = fopen("fasta_file.pdb","w")or die("Couldn't open $new_pdb"); 
    echo ">light chain|after subtitutions<br>";
	exidades($new_fasta_light);
	echo "<br><br>";
	echo ">heavy chain|after substitutions<br>";
	exidades($new_fasta_heavy);
?>
	</div>
</html>