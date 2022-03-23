<?php
/// pasar la fecha por GET
error_reporting(-1);
error_reporting(0);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

$fecha = $_GET['fecha'];
$dollar = get_tc($fecha);
echo '<br><br>Fecha:  '.$fecha.'   ---> '.$dollar;
	
function get_tc($fecha){
$partes = explode("-",$fecha);	
  $dia1 = $partes[2] * 1;
  $mes1 = $partes[1] * 1;
  $ano1 = $partes[0];
  $dias = $dia1.'-'.$mes1.'-'.$ano1;
$fechax = $dia1.'-'.$mes1.'-'.$ano1;	
if($dia1 <=9)
{
$dia1 = '0'.$dia1;
}	

if($mes1 <=9)
{
$mes1 = '0'.$mes1;
}	

 $extra = $dia1.'%2F'.$mes1.'%2F'.$ano1.'&hfecha='.$dia1.'%2F'.$mes1.'%2F'.$ano1;

$buscar = 'http://www.dof.gob.mx/indicadores_detalle.php?cod_tipo_indicador=158&dfecha='.$extra;

$buscar = str_replace("amp;","",$buscar);
	
 $html = file_get_contents($buscar);
$start = stripos($html, 'class="Celda 1"');
  $end = stripos($html, '</tr>', $offset = $start);
$length = $end - $start;
$htmlSection = substr($html, $start, $length);	
	
$bus = 'olvido_clave.php';
$mystring = $htmlSection;
$findme   = $bus;
$pos = strpos($mystring, $findme);
if ($pos === false) {	
  $resultado = str_replace('class="Celda 1">','',$htmlSection); 
  $resultado = str_replace(' ','',$resultado);
  $resultado = trim($resultado);
  $resultado = str_replace($fechax,'',$resultado); 	
  $resultado = ltrim($resultado);
  $resultado = rtrim($resultado);	
  $resultado = str_replace('<tdwidth="52%"align="center"class="txt">','',$resultado);	
  $resultado = str_replace('<tdheight="17"width="48%"align="center"class="txt"style="padding:3px;">','',$resultado);
  $resultado = str_replace('"','',$resultado);
  $resultado = trim($resultado);
  /// $resultado = str_replace(' ','*',$resultado);	
//// print_r($resultado);	
 if($resultado !== "0")
{
/// echo '<br><br>Fecha:  '.$fecha.'   ---> '.$resultado;
}	 
else
{
$resultado = 0; 
}	
		
}
else
{
$htmlSection = '';
  $resultado = 0;
}	
$resultado = trim($resultado);	
$resultado = str_replace('</td>','',$resultado);
$resultado = ltrim($resultado,"");
 $fx = new DateTime($fecha); 
$izq = $fx->format('d-m-Y');		
$resultado = str_replace($izq,'',$resultado);	
//// $largo = strlen($resultado);	
//// $resultado .= "(".$izq."*".$largo.")";	
$resultado = htmlspecialchars($resultado);	
/// $resultado = addcslashes($resultado);		
return $resultado;	 	
}	
?>