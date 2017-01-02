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
require('class_andamento.php');

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

<!-- Bibliotéca de scripts comum -->
<script type="text/javascript" src="../js/common.js"></script>

<!-- Scripts locais -->
<script type="text/javascript">
<!--
window.onload = function Construtor()
{
	noFocus(); //função declarada dentro common.js
}

function validaForm()
{
	var v_ob_msgStatus = document.getElementById('msgStatus');
	v_ob_msgStatus.innerHTML = '&nbsp;';
	
	if(isEmpty(document.frmStatus.cmpStsSigla.value) || isBlank(document.frmStatus.cmpStsSigla.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo sigla é obrigatório.';
		document.frmStatus.cmpStsSigla.focus();
		return false;
	}
	
	if(document.frmStatus.cmpStsSigla.value.length < 3)
	{
		v_ob_msgStatus.innerHTML = 'Campo sigla deve ter 3 caracteres.';
		document.frmStatus.cmpStsSigla.focus();
		return false;
	}
	
	if(isEmpty(document.frmStatus.cmpStsDesc.value) || isBlank(document.frmStatus.cmpStsDesc.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo descrição é obrigatório.';
		document.frmStatus.cmpStsDesc.focus();
		return false;
	}
	return true;
}
-->
</script>

</head>
<body>

<div align="center">
	<!-- Divisão dos status -->
	<div id="status">
		<form action="<? echo $PHP_SELF; ?>" method="post" name="frmStatus" id="frmStatus" onsubmit="return validaForm()">
			<table width="400" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				 <th colspan="2"><h1>Inclusão de status</h1></th>
			  </tr>
			  <tr>
			    <td width="72">&nbsp;</td>
			    <td width="322">&nbsp;</td>
		     </tr>
			  <tr>
				 <td class="tdcampos"><label for="cmpStsSigla" accesskey="g">Si<span>g</span>la:</label></td>
				 <td><input name="cmpStsSigla" type="text" class="cmpFrmSis" id="cmpStsSigla" onblur="clearMsgSts(this.value)" maxlength="3" />
				   ex.: <acronym title="Em andamento">ANA</acronym>, <acronym title="Aguardando atendimento">AGA</acronym>, <acronym title="Encerrada">ENC</acronym></td>
			  </tr>
			  <tr>
			    <td class="tdcampos"><label for="cmpStsDesc" accesskey="e">D<span>e</span>scri&ccedil;&atilde;o:</label></td>
			    <td><input name="cmpStsDesc" type="text" class="cmp" onblur="clearMsgSts(this.value)" id="cmpStsDesc" /></td>
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
			    <td colspan="2">
				 	<div id="msgStatus">
						&nbsp;
					</div>
				 </td>
		     </tr>
			</table>
	  </form>
	</div>
</div>

</body>
</html>
<?
//verefica se existe algum dado no post
if(sizeof($_POST))
{
	$p_s_stsSigla = $_POST['cmpStsSigla'];
	$p_s_stsDesc  = $_POST['cmpStsDesc'];
	
	$v_ob_sis = new andamento;
	
	$v_p_msg = '';
	
	if($v_ob_sis->addSts($p_s_stsSigla, $p_s_stsDesc))
	{
		$v_p_msg = "Status incluido com sucesso. \\nDeseja incluir outro?";
	}
	else
	{
		$v_p_msg = "Status não pode ser incluido. Esta sigla/descrição já existe.\\nTentar novamente?";
		echo "
			<script type='text/javascript'>
				document.frmStatus.cmpStsSigla.value = '$p_s_stsSigla';
				document.frmStatus.cmpStsSigla.select();
				document.frmStatus.cmpStsDesc.value  = '$p_s_stsDesc';
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