<!DOCTYPE HTML>
<HTML XMLNS="http://www.w3.org/1999/xhtml" xml:lang="es-ES" lang="es-ES">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<TITLE>Online Shop PHP status</TITLE>
</HEAD>
<BODY style="font-family:Verdana,Tahoma,Arial,Sans-Serif; font-size:10pt; background:#ffffff">
<DIV align="center">
<H1 style="color:navy;">LOCALHOST</H1>

<hr style="display: block; position: relative; padding: 0; margin: 8px auto; height: 0; width: 400px; max-height: 0; font-size: 1px; line-height: 0; clear: both; border: none; border-top: 1px solid #aaaaaa; border-bottom: 1px solid #ffffff;">

<p>Ruta a la carpeta del sitio: 
<b><?php
  echo $_SERVER["DOCUMENT_ROOT"]
  
?></b></p>

<hr style="display: block; position: relative; padding: 0; margin: 8px auto; height: 0; width: 400px; max-height: 0; font-size: 1px; line-height: 0; clear: both; border: none; border-top: 1px solid #aaaaaa; border-bottom: 1px solid #ffffff;">

<p>Elementos de la variable global  <b>$_SERVER</b>:

<BR><BR>

<?php 
$indicesServer = array('PHP_SELF', 
'GATEWAY_INTERFACE', 
'SERVER_ADDR', 
'SERVER_NAME', 
'SERVER_SOFTWARE', 
'SERVER_PROTOCOL', 
'REQUEST_METHOD', 
'DOCUMENT_ROOT', 
'HTTP_ACCEPT_LANGUAGE', 
'HTTP_CONNECTION', 
'HTTP_HOST', 
'HTTP_USER_AGENT', 
'SCRIPT_FILENAME', 
'SERVER_ADMIN', 
'SERVER_PORT', 
'SCRIPT_NAME', 
'REQUEST_URI') ; 

echo '<table width="640px" cellpadding="10" style="font-size:12px; border: solid 2px grey;">' ; 
foreach ($indicesServer as $arg) { 
    if (isset($_SERVER[$arg])) { 
        echo '<tr><td style="border: solid 1px grey;">'.$arg.'</td><td style="border: solid 1px grey;">' . $_SERVER[$arg] . '</td></tr>' ; 
    } 
    else { 
        echo '<tr><td style="border: solid 1px grey;">'.$arg.'</td><td style="border: solid 1px grey;">-</td></tr>' ; 
    } 
} 
echo '</table>' ; 



?>



</p>	
</DIV>

</BODY>
</HTML>