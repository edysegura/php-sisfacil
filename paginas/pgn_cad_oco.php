<?
/*
Nome do Script : CFG_CONFIG.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 12 de Outubro de 2004.
Versão         : 1.0
Parâmetros     : Nenhum.
Descrição      : Arquivo contendo variaveis globais.
*/
require('vrf_session.php');
include('cfg_config.php');
require('class_conecta.php');
//require('class_usuario.php');
require('class_departamento.php');
require('class_sistemas.php');
require('class_ocorrencia.php');

//conexão com o mysql
$v_ob_conMysql = new conect_mysql($_SERVER['SERVER_NAME']);
$v_ob_conMysql->conect();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $c_s_titulo; ?></title>

<!-- Folhas de estilo para a padronização -->
<link href="../css/sisfacil.css" rel="stylesheet" type="text/css" />

<!-- Folhas de estilo para a padronização dos links -->
<link href="../css/links.css" rel="stylesheet" type="text/css" />

<!-- Bibliotéca de scripts comuns -->
<script type="text/javascript" src="../js/common.js"></script>

<style type="text/css">
<!--  
fieldset
{
	position: absolute;
}

#ocorrencia
{
	position: relative;
	width: 508px;
	height: 430px;
}

#ocorrencia #divtitle
{
	font-weight: bold;
}

#operador
{
	top: 25px;
	left: 9px;
	width: 476px; 
}

#problema, #lstProblemas
{
	top: 67px;
	height: 57px;
}

#problema
{
	width: 219px;
	left: 9px;
}

#lstProblemas
{
	width: 236px; 
	left: 249px;
}

#sistemas
{
	top: 146px;
	width: 200px; 
	height: 53px;
	left: 253px;
}

#oco
{
	top: 138px;
	width: 476px;
	height: 205px;
	left: 9px;
}

#btns
{
	position: absolute;
	top: 384px;
	left: 9px;
	height: 40px;
	width: 490px;
}

#msgStatus
{
	position: absolute;
	top: 410px;
	left: 2px;
	height: 8px;
	width: 490px;
	background-color: transparent;
	text-align: left;
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

function atuLstPro(p_s_tipPro)
{
	var v_ob_getPro = document.getElementById('pgnGetPro');
	
	if(p_s_tipPro)
		v_ob_getPro.src = 'get_problema.php?proTip='+p_s_tipPro;
}

function validaForm()
{
	var v_ob_msgStatus = document.getElementById('msgStatus');
	v_ob_msgStatus.innerHTML = '&nbsp;';
	
	if((document.frmOco.tipPro[0].checked == false) && (document.frmOco.tipPro[1].checked == false))
	{
		v_ob_msgStatus.innerHTML = 'Campo área da ocorrência é obrigatório.';
		return false;
	}
	
	if(isEmpty(document.frmOco.cmpProCod.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo lista de problemas é obrigatório.';
		return false;
	}

	if(isEmpty(document.frmOco.cmpTipSis.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo sistema é obrigatório.';
		document.frmOco.cmpTipSis.focus();
		return false;
	}
	
	if(isEmpty(document.frmOco.cmpOcoDesc.value) || isBlank(document.frmOco.cmpOcoDesc.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo descrição é obrigatório.';
		document.frmOco.cmpOcoDesc.focus();
		return false;
	}

	return true;
}

function clearMsg()
{
	document.getElementById('msgStatus').innerHTML = '';
}
-->
</script>

</head>
<body>

<div align="center">
	<!-- Divisão dos ocorrencia -->
	<form action="<? echo $PHP_SELF; ?>" method="post" name="frmOco" id="frmOco" onsubmit="return validaForm()">
	<div id="ocorrencia">
		<div id="divtitle">Inclusão de ocorrência</div>
	
		<!-- fieldset operador -->
		<fieldset id="operador">
			<legend>Operador:</legend>
			<? 
				echo $_SESSION['funcLogin'] ." | ".$_SESSION['funcNome'] ." | ";
				
				$v_ob_dep = new departamento;
				if($v_ob_dep->getDep($_SESSION['funcDepCod'])) echo $v_ob_dep->getDep($_SESSION['funcDepCod']);
					else echo "Nenhum departamento foi encontrado.";
			?>
		</fieldset>
		
		<!-- fieldset problema -->
		<fieldset id="problema">
			<legend>Área da ocorrência:</legend>
			<input name="tipPro" type="radio" value="TEC" id="TEC" onclick="atuLstPro(this.value); clearMsg()" />
			<label for="TEC" accesskey="c">Té<span>c</span>nico/Hardware</label><br />
			<input name="tipPro" type="radio" value="SIS" id="SIS" onclick="atuLstPro(this.value); clearMsg()" />
			<label for="SIS" accesskey="d">A<span>d</span>ministrativo/Software</label>
		</fieldset>
		
		<!-- fieldset lstProblemas -->
		<fieldset id="lstProblemas">
			<legend><label for="cmpProCod" accesskey="l"><span>L</span>ista de problemas:</label></legend>
			<div id="lstProbs" style="background-color: transparent;">
			<select class="cmpBox" id="cmpProCod" style="margin-top: 10px;" disabled="disabled">
				<option selected="selected" value="">Problemas</option>
			</select>
			</div>
		</fieldset>

		<!-- fieldset ocorrencia -->
		<fieldset id="oco">
			<legend>Ocorrência:</legend>
			<label for="cmpTipSis" accesskey="i">S<span>i</span>stema:</label><br />
			<select name="cmpTipSis" id="cmpTipSis" class="cmpBox" onchange="clearMsgSts(this.value)">
			  <option value="" selected="selected">Sistemas</option>
			  <?
					$v_ob_sis = new sistemas;
					$p_ob_result = $v_ob_sis->getSis();
					
					while($rows = mysql_fetch_array($p_ob_result))
					{
						$v_s_sisSigla = $rows['sis_sigla'];
						$v_s_sisDesc  = $rows['sis_desc'];
						
						if($v_s_sisSigla == $_POST['cmpTipSis'])
							echo "<option value='$v_s_sisSigla' selected='selected'>$v_s_sisDesc</option>";
						else
							echo "<option value='$v_s_sisSigla'>$v_s_sisDesc</option>";
					}
				?>
			</select>
			<br /><br />
			<label>Data de Abertura:</label>
			<? echo date("d/m/Y"); ?>
			<input type="hidden" name="cmpOcoDtAbertura" value="<? echo date("d/m/Y"); ?>" /><br /><br />
			<label for="cmpOcoDesc" accesskey="s">De<span>s</span>crição:</label><br />
			<textarea name="cmpOcoDesc" wrap="PHYSICAL" id="cmpOcoDesc" class="longTxt" onblur="clearMsgSts(this.value)"></textarea>
		</fieldset>
		
		<div id="btns">
			<input name="cmpFuncCod" type="hidden" id="cmpFuncCod" value="<? echo $_SESSION['funcCod']; ?>" />
			<input name="cmpFuncDepCod" type="hidden" id="cmpFuncDepCod" value="<? echo $_SESSION['funcDepCod']; ?>" />
			<input name="cmpAndaSigla" type="hidden" id="cmpAndaSigla" value="AGA" />
			<input type="submit" value="OK" />&nbsp;
			<input type="button" value="Cancelar" onclick="goPrinc('<? echo session_id(); ?>')" />
		</div>
		<div id="msgStatus">
			&nbsp;
		</div>
	</div>
	</form>
</div>
<iframe src="" id="pgnGetPro" style="display: none;"></iframe>
<!-- FIM -->
</body>
</html>
<?
if(sizeof($_POST))
{
	$p_s_funcCod       = $_POST['cmpFuncCod'];
	$p_s_funcDepCod    = $_POST['cmpFuncDepCod'];
	$p_s_sisSigla      = $_POST['cmpTipSis'];
	$p_s_andaSigla     = $_POST['cmpAndaSigla'];
	$p_s_proTipSigla   = $_POST['tipPro'];
	$p_s_proCod        = $_POST['cmpProCod'];
	$p_s_tipSigla      = $_POST['tipPro'];
	$p_s_ocoDesc       = $_POST['cmpOcoDesc'];
	$p_s_ocoDtAbertura = $_POST['cmpOcoDtAbertura'];
	
	$v_ob_oco = new ocorrencia;

	$v_p_msg = '';
	
	if($v_ob_oco->addOco($p_s_funcCod, $p_s_funcDepCod, $p_s_sisSigla, $p_s_andaSigla, $p_s_proTipSigla, 
	                     $p_s_proCod, $p_s_tipSigla, $p_s_ocoDesc, $p_s_ocoDtAbertura))
	{
		$v_p_msg = "Ocorrência incluida com sucesso. \\nDeseja incluir outra?";
		echo "
			<script type='text/javascript'>
				document.frmOco.cmpTipSis.selectedIntex = 0;
			</script>
		";
	}
	else
	{
		$v_p_msg = "Ocorrência não pode ser incluida. \\nTentar novamente?";
		echo "
			<script type='text/javascript'>
				document.frmOco.cmpOcoDesc.value  = '$p_s_ocoDesc';
			</script>
		";
	}
	
	echo "
		<script type='text/javascript'>
			if(!confirm('$v_p_msg'))
				goPrinc('".session_id()."');
		</script>
	";
}
?>