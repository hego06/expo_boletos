<?php
$file	= $_GET['file'];
echo "<iframe id='visualizar' name='visualizar' 
		scrolling='auto' frameborder='2' style='width:90%'
		src='pdfs/$file' height='450'>
		</iframe>";
?>