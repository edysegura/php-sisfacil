<?
/*
Nome do Script : LOGIN.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Versão         : 1.0
Parâmetros     : Nenhum.
Descrição      : Script contendo a validação de usuário.
*/
require('vrf_session.php');
include('cfg_config.php');
require('class_conecta.php');
require('class_ocorrencia.php');
require('class_problema.php');
require('class_usuario.php');
require('class_departamento.php');
require('class_andamento.php');
require('class_sistemas.php');



//conexão com MySQL
$v_ob_conMysql = new conect_mysql($_SERVER['SERVER_NAME']);
$v_ob_conMysql->conect();

//objeto ocorrencia
$v_ob_oco = new ocorrencia;

//pega o id da sessão
$sid = session_id();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $c_s_titulo; ?></title>

<!-- Folhas de estilo para padronização -->
<link href="../css/sisfacil.css" rel="stylesheet" type="text/css" />

<!-- Folhas de estilo para padronização dos links -->
<link href="../css/links.css" rel="stylesheet" type="text/css" />

<!-- Biblioteca comum do javascript -->
<script type="text/javascript" src="../js/common.js"></script>

<style type="text/css">
<!--  
fieldset
{
	margin-bottom: 5px;
}

fieldset table
{
	margin-top: 5px;
	font-size: 10px;
}

th
{
	text-align: left;
	text-indent: 2px;
}

td
{
	text-indent: 2px;
}

span
{
	color: #000000;
}
-->
</style>

<!-- Scripts locais -->
<script type="text/javascript">
<!--
window.onload = function Construtor()
{
	noFocus(); //função declarada dentro common.js
}
-->
</script>

</head>
<body>

<fieldset id="fieldUser">
	<legend>Usuário:</legend>
	<? 
		echo "<a href='#' onclick='return false;'>{$_SESSION['funcLogin']}</a> | 
	         <a href='#' onclick='return false;'>{$_SESSION['funcNome']}</a> | ";
		
	?>
	<a href="#" onclick="goPrinc('<? echo $sid; ?>'); return false;">Menu principal</a>
	 | 
	<a href="pgn_logout.php" onclick="return confirm('Deseja realmente sair?')">Sair</a>
</fieldset>

<form action="<? echo $PHP_SELF; ?>" method="post" name="frmConOco">
<fieldset id="fieldOcoUser" style="display: inherit;">
	<legend>Ocorrência(s):</legend>
	<?
		$p_result = $v_ob_oco->getUserConOcoCods($_SESSION['funcCod']);
		
		if(mysql_num_rows($p_result))
		{
	?>
	<label for="cmpOcoCod" accesskey="d">Có<span>d</span>igo:</label><br />
	<select name="cmpOcoCod" class="cmpBox" id="cmpOcoCod" style="width: 50px;">
		<option value="" selected="selected"></option>
		<?
			while($rows = mysql_fetch_array($p_result))
			{
				echo "<option value='{$rows[oco_cod]}'>{$rows[oco_cod]}</option>";
			}
		?>
  </select>
	<input type="submit" value="Consultar" class="padraoBtn" /><br /><br />
	<?
		}
		else
			echo "Você não tem nenhuma ocorrência cadastrada.";
	?>
<?
	if(sizeof($_POST))
	{
		$v_ob_prob = new problema;
		$v_ob_sis  = new sistemas;
		$v_ob_sts  = new andamento;
		
		if($p_ob_result = $v_ob_oco->getUserConOco($_POST['cmpOcoCod'], $_SESSION['funcCod']))
		{
			if(mysql_num_rows($p_ob_result))
			{
				echo "<span class='top'>Código:</span> ";
				echo "<span class='bottom'>". $_POST['cmpOcoCod'] ."</span><br /><br />";
				
				echo "<span class='top'>Problema:</span><br />";
				echo "<span class='bottom'>". $v_ob_prob->getProbDesc(mysql_result($p_ob_result,0,'oco_procod')) ."</span><br /><br />";
				
				echo "<span class='top'>Sistema:</span><br />";
				echo "<span class='bottom'>". $v_ob_sis->getSisDesc(mysql_result($p_ob_result,0,'oco_sissigla')) ."</span><br /><br />";
				
				echo "<span class='top'>Status:</span><br />";
				echo "<span class='bottom'>". $v_ob_sts->getDescSts(mysql_result($p_ob_result,0,'oco_andasigla')) ."</span><br /><br />";
				
				echo "<span class='top'>Data de abertura:</span><br />";
				echo "<span class='bottom'>". date("d/m/Y",strtotime(mysql_result($p_ob_result,0,'oco_dtabertura'))) ."</span><br /><br />";
				
				echo "<span class='top'>Data de fechamento</span><br />";
				$v_dt_ocoDtFechamento = mysql_result($p_ob_result,0,'oco_dtfechamento');
				$v_s_resultFinal = $v_dt_ocoDtFechamento ? $v_dt_ocoDtFechamento : "Não definida";
				echo "<span class='bottom'>". $v_s_resultFinal ."</span><br /><br />";
					
				echo "<span class='top'>Descrição:</span><br />";
				echo "<span class='bottom'>". mysql_result($p_ob_result,0,'oco_desc') ."</span><br /><br />";
				
				echo "<span class='top'>Solução:</span><br />";
				$v_s_ocoSolucao = mysql_result($p_ob_result,0,'oco_solucao');
				if(!empty($v_s_ocoSolucao))
					echo "<span class='bottom'>". mysql_result($p_ob_result,0,'oco_solucao') ."</span><br /><br />";
				else
					echo "<span class='bottom'>Não defenido</span><br /><br />";
			}
		}
	}
?>
</fieldset>
</form>

</body>
</html>