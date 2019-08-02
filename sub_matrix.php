<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<body>
<pre>
<?php
	//echo "hello";
	$user_id=$_SESSION['var7'];
	$my_file = fopen("./results/".$user_id."_subs.txt","r")or die("Couldn't open $new_pdb");
	echo fread($my_file,filesize("./results/".$user_id."_subs.txt"));
	fclose($my_file);
	
	//$content = file_get_contents ("./results/1468333592_subs.txt_subs.txt");
	//header ("Content-Disposition: attachment; filename=1468333592_subs.txt");
    //echo $content;
?>
</pre>
</body>
</html>
