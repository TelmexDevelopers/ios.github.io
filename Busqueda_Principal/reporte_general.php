<?php
//Exportar datos de php a Excel
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reportes.xls");
header("../../../adodb/adodb.inc.php");
header("../../../adodb/adodb-pager.inc.php");
?>
<HTML LANG="es">
<TITLE>::. Exportacion de Datos .::</TITLE>
</head>
<body>

<?php
$link = @mysql_connect("10.94.130.36", "ios_new", "provi");
mysql_select_db("ios_new", $link);


// maximo por pagina
$limit = 100;

// pagina pedida
//	var datos = 'q='+combo1+'&r='+combo2+'&s='+combo3+'&t='+texto+'&pag='+page;
			
	$id_DD=$_GET["id_DD"];
	$idcat_edo_servicio=$_GET["idcat_edo_servicio"];
	$id_Area_Responsable=$_GET["id_Area_Responsable"];
	$id_Fase_IOS=$_GET["id_Fase_IOS"];
	$id_Entidad=$_GET["id_Entidad"];
	$id_Fase_SISA=$_GET["id_Fase_SISA"];
	$idcat_con_OT=$_GET["idcat_con_OT"];
	$Subgerentes=$_GET["Subgerentes"];
	$Supervisores=$_GET["Supervisores"];
	$referencia=$_GET["referencia"];
	$cm=$_GET["cm"];
	$area_cm=$_GET["area_cm"];
	$direccion=$_GET["direccion"];
	//$Supervisores_Analisis=$_GET["Supervisores_Analisis"];
	//$ipe_analisis=$_GET["ipe_analisis"];
	//$punta =  $_GET["punta"];

	$campos="";
	$cont = 0;
// si hace seleccion del cualquier opcion del combo nos traera la consulta elegida por el combo usando where
if 
(
	$_GET["id_DD"] != "" ||
	$_GET["idcat_edo_servicio"] != "" ||
	$_GET["id_Area_Responsable"] != "" ||
	$_GET["id_Fase_IOS"] != "" ||
	$_GET["id_Entidad"] != "" ||
	$_GET["id_Fase_SISA"] != "" ||
	$_GET["idcat_con_OT"] != ""|| 
	$_GET["Subgerentes"] != ""||
	$_GET["Supervisores"] != ""||
	$_GET["Supervisores_Analisis"] != ""||
	$_GET["ipe_analisis"] != ""||
	$_GET["cm"] != ""||
	$_GET["area_cm"] != ""||
	$_GET["direccion"] != ""||
	//$_GET["punta"] != ""||
	$_GET["referencia"] != ""
	
	)
{
	$campos.="WHERE ";
	
	
}
if ($_GET["id_DD"] != "" || $_GET["id_DD"] == "*")
{
	
	$campos.="dir_division = '".$_GET["id_DD"]."'  ";
	$cont++;
}

if ($_GET["idcat_edo_servicio"] != "" || $_GET["idcat_edo_servicio"] == "*")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" edo_serv = '".$_GET["idcat_edo_servicio"]."'  ";
	$cont++;
}
if ($_GET["id_Area_Responsable"] != "" || $_GET["id_Area_Responsable"] == "*")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" id_Area_Responsable = '".$_GET["id_Area_Responsable"]."'  ";
	$cont++;
}
if ($_GET["id_Fase_IOS"] != "" || $_GET["id_Fase_IOS"] == "*")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" id_Fase_IOS = '".$_GET["id_Fase_IOS"]."'  ";
	$cont++;
}
if ($_GET["id_Entidad"] != "" || $_GET["id_Entidad"] == "*")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" coordinacion_abrev = '".$_GET["id_Entidad"]."'  ";
	$cont++;
}
if ($_GET["id_Fase_SISA"] != "" || $_GET["id_Fase_SISA"] == "*")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" fase_serv = '".$_GET["id_Fase_SISA"]."'  ";
	$cont++;
}
if ($_GET["idcat_con_OT"] != "" || $_GET["idcat_con_OT"] == "*")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" int_con_OT = '".$_GET["idcat_con_OT"]."'  ";
	$cont++;
}
if ($_GET["Subgerentes"] != "" || $_GET["Subgerentes"] == "*")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" id_Usuario_Subgerente = '".$_GET["Subgerentes"]."'  ";
	$cont++;
}
if ($_GET["Supervisores"] != "" || $_GET["Supervisores"] == "*")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" id_Usuario_Supervisor = '".$_GET["Supervisores"]."'  ";
	$cont++;
}

if ($_GET["cm"] != "" || $_GET["cm"] == "*")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" siglas = '".$_GET["cm"]."'  ";
	$cont++;
}

if ($_GET["area_cm"] != "" || $_GET["area_cm"] == "*")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" area = '".$_GET["area_cm"]."'  ";
	$cont++;
}



if ($_GET["referencia"] != "")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" referencia = '$referencia'";
	$cont++;
}
if ($_GET["direccion"] != "")
{
	if($cont>0)
	{
		$campos.=" AND";	
	}
	$campos.=" direccion = '$direccion'";
	$cont++;
}


$pag = (int) $_GET["pag"];
if ($pag < 1)
{
   $pag = 1;
}
$offset = ($pag-1) * $limit;
//echo $pag;

$sql = "SELECT SQL_CALC_FOUND_ROWS 
	referencia,
	ser_n,
	fase_serv,
	Tipo_de_proyecto,
	edo_serv,
	str_Fase_IOS,
	str_Area_responsable,
	ipe_analisis,
	ipe_documentacion,
	ipe_wifa,
	clas_1,
	clas_2,
	due_date,
	usuario,
	usuario_pta,
	direccion,
	SUBGERENTE_RESPONSABLE,
	SUPERVISOR,
	Familia,
	ancho_banda,
	tipo_art,
	fecha_estado,
	dt_Fecha_Fase_IOS,
	Programa,
	Grupo_dil_servicio,
	coordinacion_abrev,
	dir_division,
	ipe_entrega,
	int_Documentado,
	id_Medio_Acceso,
	area,
	siglas,
	cto_mantto,
	sector,
	direccion



 FROM vw_ios_reg ".$campos." LIMIT $offset, $limit";
//echo $sql;
$sqlTotal = "SELECT FOUND_ROWS() as total";

$rs = mysql_query($sql);
$rsTotal = mysql_query($sqlTotal);

$rowTotal = mysql_fetch_assoc($rsTotal);
// Total de registros sin limit
$total = $rowTotal["total"];
/* FROM tb_seguimiento_servicios ";
$result=mysql_query($sql,$IdConexion);*/

?>
<table border="1">
<tr>
<td>referencia</td>

<td>referencia</td>
<td>ser_n</td>
<td>fase_serv</td>
<td>Tipo_de_proyecto</td>
<td>edo_serv</td>
<td>str_Fase_IOS</td>
<td>str_Area_responsable</td>
<td>ipe_analisis</td>
<td>ipe_documentacion</td>
<td>ipe_wifa</td>
<td>clas_1</td>
<td>clas_2</td>
<td>due_date</td>
<td>usuario</td>
<td>usuario_pta</td>
<td>direccion</td>
<td>SUBGERENTE_RESPONSABLE</td>
<td>SUPERVISOR</td>
<td>Familia</td>
<td>ancho_banda</td>
<td>tipo_art</td>
<td>fecha_estado</td>
<td>dt_Fecha_Fase_IOS</td>
<td>Programa</td>
<td>Grupo_dil_servicio</td>
<td>coordinacion_abrev</td>
<td>dir_division</td>
<td>ipe_entrega</td>
<td>int_Documentado</td>
<td>id_Medio_Acceso</td>
<td>area</td>
<td>siglas</td>
<td>cto_mantto</td>
<td>sector</td>
<td>direccion</td>

 
</TR>


<?php

while($row = mysql_fetch_assoc($rs)) {
printf("<tr>
<td>&nbsp;%s</td>
<td>&nbsp;%s&nbsp;</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
<td>&nbsp;%s</td>
</tr>", 

	$row["referencia"],
	$row["ser_n"],
	$row["fase_serv"],
	$row["Tipo_de_proyecto"],
	$row["edo_serv"],
	$row["str_Fase_IOS"],
	$row["str_Area_responsable"],
	$row["ipe_analisis"],
	$row["ipe_documentacion"],
	$row["ipe_wifa"],
	$row["clas_1"],
	$row["clas_2"],
	$row["due_date"],
	$row["usuario"],
	$row["usuario_pta"],
	$row["direccion"],
	$row["SUBGERENTE_RESPONSABLE"],
	$row["SUPERVISOR"],
	$row["Familia"],
	$row["ancho_banda"],
	$row["tipo_art"],
	$row["fecha_estado"],
	$row["dt_Fecha_Fase_IOS"],
	$row["Programa"],
	$row["Grupo_dil_servicio"],
	$row["coordinacion_abrev"],
	$row["dir_division"],
	$row["ipe_entrega"],
	$row["int_Documentado"],
	$row["id_Medio_Acceso"],
	$row["area"],
	$row["siglas"],
	$row["cto_mantto"],
	$row["sector"],
	$row["direccion"]);

}
mysql_free_result($rs);
mysql_close($link);  //Cierras la Conexión
?>
</table>
</body>
</html>



