<?
/*
Nome do Script : CFG_CONFIG.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 12 de Outubro de 2004.
Versão         : 1.0
Parâmetros     : Nenhum.
Descrição      : Arquivo contendo variaveis globais.
*/

//require('vrf_session.php');
include('cfg_config.php');
require('class_conecta.php');
require('class_problema.php');

//conexão com o mysql
$v_ob_conMysql = new conect_mysql($_SERVER['SERVER_NAME']);
$v_ob_conMysql->conect();

//pegando todos os usuários cadastrados no sistema
$v_ob_pro = new problema;

$v_ob_result = $v_ob_pro->getEspProbs($_GET['proTip']);
//$v_ob_result = $v_ob_pro->getEspProbs('SIS');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $c_s_titulo; ?></title>
<link href="../css/sisfacil.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="probs">
<select name="cmpProCod" class="cmpBox" onchange="clearMsgSts(this.value)" id="cmpProCod" style="margin-top: 10px;">
	<option selected="selected">Problemas <? echo $_GET['proTip']; ?></option>
	<?
		while($rows = mysql_fetch_array($v_ob_result))
		{
			$v_s_proCod  = $rows['pro_cod'];
			$v_s_proDesc = $rows['pro_desc'];
			echo "<option value='$v_s_proCod'>$v_s_proDesc</option>";
		}
	?>
</select>
</div>

<?
	$v_s_scriptExec = '';
	
	if($v_ob_result)
	{
		$v_s_scriptExec = "top.document.getElementById('lstProbs').innerHTML = document.getElementById('probs').innerHTML;";
	}

	echo "
			<script type='text/javascript'>
			<!--  
				$v_s_scriptExec
			-->
			</script>
		  ";
?>
</body>
</html>