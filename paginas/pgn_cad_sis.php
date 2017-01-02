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
require('class_sistemas.php');

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
	
	if(isEmpty(document.frmSis.cmpSisSigla.value) || isBlank(document.frmSis.cmpSisSigla.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo sigla é obrigatório.';
		document.frmSis.cmpSisSigla.focus();
		return false;
	}
	
	if(document.frmSis.cmpSisSigla.value.length < 3)
	{
		v_ob_msgStatus.innerHTML = 'Campo sigla deve ter 3 caracteres.';
		document.frmSis.cmpSisSigla.focus();
		document.frmSis.cmpSisSigla.select();
		return false;
	}
	
	if(isEmpty(document.frmSis.cmpSisDesc.value) || isBlank(document.frmSis.cmpSisDesc.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo descrição é obrigatório.';
		document.frmSis.cmpSisDesc.focus();
		return false;
	}
	return true;
}
-->
</script>

</head>
<body>

<div align="center">
	<!-- Divisão dos sistema -->
	<div id="sistema">
		<form action="<? echo $PHP_SELF; ?>" method="post" name="frmSis" id="frmSis" onsubmit="return validaForm()">
			<table width="400" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				 <th colspan="2"><h1>Inclusão de sistemas</h1></th>
			  </tr>
			  <tr>
			    <td width="72">&nbsp;</td>
			    <td width="322">&nbsp;</td>
		     </tr>
			  <tr>
				 <td class="tdcampos"><label for="cmpSisSigla" accesskey="g">Si<span>g</span>la:</label></td>
				 <td><input name="cmpSisSigla" type="text" class="cmpFrmSis" onblur="clearMsgSts(this.value)" id="cmpSisSigla" maxlength="3" />
				   ex.: <acronym title="Windows 95, 98">W9X</acronym>, <acronym title="Macintosh">MAC</acronym>, <acronym title="Linux">LNX</acronym></td>
			  </tr>
			  <tr>
			    <td class="tdcampos"><label for="cmpSisDesc" accesskey="e">D<span>e</span>scri&ccedil;&atilde;o:</label></td>
			    <td><input name="cmpSisDesc" type="text" class="cmp" onblur="clearMsgSts(this.value)" id="cmpSisDesc" /></td>
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
				 </div></td>
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
//verefica se existe algum dado no post
if(sizeof($_POST))
{
	$p_s_sisSigla = $_POST['cmpSisSigla'];
	$p_s_sisDesc  = $_POST['cmpSisDesc'];
	
	$v_ob_sis = new sistemas;
	
	$v_p_msg = '';
	$v_s_script = '';
	
	if($v_ob_sis->addSis($p_s_sisSigla, $p_s_sisDesc))
	{
		$v_p_msg = "Sistema incluido com sucesso. \\nDeseja incluir outro?";
	}
	else
	{
		$v_p_msg = "Sistema não pode ser incluido. Sigla/Descrição já existem.\\nTentar novamente?";
		echo "
			<script type='text/javascript'>
				document.frmSis.cmpSisSigla.value = '$p_s_sisSigla';
				document.frmSis.cmpSisSigla.select();
				document.frmSis.cmpSisDesc.value  = '$p_s_sisDesc';
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