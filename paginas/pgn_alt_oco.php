<?
/*
Nome do Script : PGN_ALT_OCO.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com), Leonardo Rocha.
Data           : 13 de Outubro de 2004.
Versão         : 1.0
Parâmetros     : Nenhum.
Descrição      : Script para a alteração da ocorrência.
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
//Construtor da página
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

<fieldset id="fieldOcoUser" style="display: inherit;">
	<form action="<? echo $PHP_SELF; ?>" method="post" name="frmConOco">
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
				if($rows['oco_cod'] == $_POST['cmpOcoCod'])
					echo "<option value='{$rows[oco_cod]}' selected='selected'>{$rows[oco_cod]}</option>";
				else
					echo "<option value='{$rows[oco_cod]}'>{$rows[oco_cod]}</option>";
			}
		?>
  </select>
	<input type="submit" value="Consultar" class="padraoBtn" />
<?
	}
	else
		echo "Você não tem nenhuma ocorrência cadastrada.";

	if(sizeof($_POST))
	{
		$v_ob_prob = new problema;
		$v_ob_sis  = new sistemas;
		$v_ob_sts  = new andamento;
		$v_ob_dep  = new departamento;
		
		if($p_ob_result = $v_ob_oco->getUserConOco($_POST['cmpOcoCod'], $_SESSION['funcCod']))
		{
			if(mysql_num_rows($p_ob_result))
			{
				echo "<br /><br />";
?>
				
				<span class='top'>Problema:</span><br />
				<span class='bottom'><? echo $v_ob_prob->getProbDesc(mysql_result($p_ob_result,0,'oco_procod')); ?></span><br /><br />
				
				<span class='top'>Sistema:</span><br />
				<span class='bottom'>
				<? 
					echo $v_ob_sis->getSisDesc(mysql_result($p_ob_result,0,'oco_sissigla')); 
				?>
				</span><br /><br />
				
				<span class='top'>Status:</span><br />
				<span class='bottom'>
					<select name="cmpTipSts" id="cmpTipSts" class="cmpBox" onchange="clearMsgSts(this.value)">
						<option value="<? echo mysql_result($p_ob_result,0,'oco_andasigla'); ?>" selected="selected">
							<? echo $v_ob_sts->getDescSts(mysql_result($p_ob_result,0,'oco_andasigla')); ?>
						</option>
						<option value="CNL">Cancelada</option>
					</select>
				<?
					}
				?>
				</span><br /><br />
				
				<span class='top'>Data de abertura:</span><br />
				<span class='bottom'><? echo date("d/m/Y",strtotime(mysql_result($p_ob_result,0,'oco_dtabertura'))); ?></span><br /><br />
				
				<span class='top'>Descrição:</span><br />
				<span class='bottom'>
				<? 
					$p_s_ocoDesc = mysql_result($p_ob_result,0,'oco_desc');
					echo "
						<textarea id='cmpOcoDesc' name='cmpOcoDesc' class='longTxt'>$p_s_ocoDesc</textarea>
					";
				?>
				</span><br /><br />
				
				<span class='top'>Solução:</span><br />
				<span class='bottom'>
				<? 
					$p_s_ocoSolucao = mysql_result($p_ob_result,0,'oco_solucao');
					if(!empty($p_s_ocoSolucao))
						echo $p_s_ocoSolucao;
					else
						echo "Não defenido";
				?>
				</span><br /><br />
				<input type="hidden" id="cmpOcoCod" value="<? echo $_POST['cmpOcoCod']; ?>" />
				<input type="hidden" id="cmpOcoAlter" value="1" />
				<div id="btns">
					<input type="submit" value="Alterar" />
					&nbsp;
					<input type="button" value="Cancelar" onclick="goPrinc('<? echo session_id(); ?>')" />
				</div>
<?
			}
		}
?>
</form>
</fieldset>
<?
	if($_POST['cmpOcoAlter'])
	{
		$p_s_ocoCod  = $_POST['cmpOcoCod'];
		$p_s_sigSts  = $_POST['cmpTipSts'];
		$p_s_ocoDesc = $_POST['cmpOcoDesc'];
		
		if($v_ob_oco->alterOco($p_s_ocoCod, $p_s_sigSts, $p_s_ocoDesc))
		{
			echo "
				<script type='text/javascript'>
					alert('Alteração feita com sucesso.');
					document.location.reload();
				</script>
			";
		}
		else
		{
			echo "
				<script type='text/javascript'>
					alert('Não foi possível fazer a alteração.');
				</script>
			";
		}
	}
?>
</body>
</html>