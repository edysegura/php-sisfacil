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
require('class_problema.php');

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

<!-- Scripts locais -->
<script type="text/javascript">
window.onload = function Construtor()
{
	noFocus(); //função declarada dentro common.js
}

function validaForm()
{
	var v_ob_msgStatus = document.getElementById('msgStatus');
	v_ob_msgStatus.innerHTML = '&nbsp;';
	
	if(isEmpty(document.frmPro.cmpTipPro.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo problema é obrigatório.';
		document.frmPro.cmpTipPro.focus();
		return false;
	}
	
	if(isEmpty(document.frmPro.cmpProDesc.value) || isBlank(document.frmPro.cmpProDesc.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo descrição é obrigatório.';
		document.frmPro.cmpProDesc.focus();
		return false;
	}

	return true;
}
</script>

</head>
<body>

<div align="center">
	<!-- Divisão do problema -->
	<div id="problema">
		<form action="<? echo $PHP_SELF; ?>" method="post" name="frmPro" id="frmPro" onsubmit="return validaForm()">
			<table width="400" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				 <th colspan="2">Inclusão de problemas</th>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
		     </tr>
			  <tr>
				 <td class="tdcampos" width="80"><label for="cmpTipPro" accesskey="r">P<span>r</span>oblema:</label></td>
				 <td width="314">
				 <select name="cmpTipPro" class="cmpBox" id="cmpTipPro" onblur="clearMsgSts(this.value)">
				   <option selected="selected" value="">Área da ocorrência</option>
					<option value="TEC" <? if($_POST['cmpTipPro'] == 'TEC') echo 'selected="selected"'; ?>>Hardware, Sistema operacional</option>
					<option value="SIS" <? if($_POST['cmpTipPro'] == 'SIS') echo 'selected="selected"'; ?>>Software, Sistemas administrativos</option>
				 </select>
				 </td>
			  </tr>
			  <tr>
				 <td class="tdcampos"><label for="cmpProDesc" accesskey="d"><span>D</span>escri&ccedil;&atilde;o:</label></td>
				 <td><input name="cmpProDesc" type="text" class="cmp" onblur="clearMsgSts(this.value)" id="cmpProDesc" /></td>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
		     </tr>
			  <tr>
			    <td colspan="2">
				 <div id="btns">
					 <input type="submit" value="OK" />
					 &nbsp;
					 <input type="button" value="Cancelar" onclick="goPrinc('<? echo session_id(); ?>')" />
				 </div>
				 </td>
		     </tr>
			  <tr>
			    <td colspan="2"><div id="msgStatus">&nbsp;</div></td>
		     </tr>
			</table>
		</form>
	</div>
</div>

</body>
</html>
<?
if(sizeof($_POST))
{
	$p_s_tipSigla = $_POST['cmpTipPro'];
	$p_s_proDesc  = $_POST['cmpProDesc'];
	
	$v_ob_pro = new problema;
	
	$v_p_msg = '';
	
	if($v_ob_pro->addPro($p_s_tipSigla, $p_s_proDesc))
	{
		$v_p_msg = "Problema incluido com sucesso. \\nDeseja incluir outro?";
		echo "
			<script type='text/javascript'>
				document.frmPro.cmpTipPro.selectedIndex = 0;
			</script>
		";
	}
	else
	{
		$v_p_msg = "Problema não pode ser incluido. \\nTentar novamente?";
		echo "
			<script type='text/javascript'>
				document.frmPro.cmpProDesc.value  = '$p_s_proDesc';
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