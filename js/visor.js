function visor(file) {
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("vista").innerHTML=xmlhttp.responseText;	
		}
	}
	xmlhttp.open("GET","visor.php?file="+file,true);
	xmlhttp.send();
}
