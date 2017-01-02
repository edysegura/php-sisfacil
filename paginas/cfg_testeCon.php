<?
/*
Nome do Script : LOGIN.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Versão         : 1.0
Parâmetros     : Nenhum.
Descrição      : Script contendo a validação de usuário.
*/

require('cfg_config.php');
require('class_conecta.php');

$conMysql = new conect_mysql($_SERVER['SERVER_NAME']);
$conMysql->conect();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $c_s_titulo; ?></title>

<style type="text/css">
<!--  
th
{
	text-align: left;
}
-->
</style>

</head>

<body>

<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th scope="col">Nome</th>
    <th scope="col">Login</th>
    <th scope="col">e-mail</th>
  </tr>
  <?
  	$p_s_query   = "SELECT * FROM funcionarios";
	$p_ob_result = mysql_query($p_s_query);
  	while($rows = mysql_fetch_array($p_ob_result))
	{
  ?>
  <tr>
    <td><? echo $rows['func_nome']; ?></td>
    <td><? echo $rows['func_login']; ?></td>
    <td><? echo $rows['func_email']; ?></td>
  </tr>
  <?
  	}
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
