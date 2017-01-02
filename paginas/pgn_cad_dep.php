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
require('class_departamento.php');

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
	
	if(isEmpty(document.frmDep.cmpDepNome.value) || isBlank(document.frmDep.cmpDepNome.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo nome é obrigatório.';
		document.frmDep.cmpDepNome.focus();
		document.frmDep.cmpDepNome.select();
		return false;
	}
	
	if(isEmpty(document.frmDep.cmpDepSala.value) || isBlank(document.frmDep.cmpDepSala.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo sala é obrigatório.';
		document.frmDep.cmpDepSala.focus();
		return false;
	}

	if(isEmpty(document.frmDep.cmpDepRamal.value) || isBlank(document.frmDep.cmpDepRamal.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo ramal é obrigatório.';
		document.frmDep.cmpDepRamal.focus();
		return false;
	}

	return true;
}
-->
</script>

</head>
<body>

<div align="center">
	<!-- Divisão dos funcionários -->
	<div id="funcionario">
		<form action="<? echo $PHP_SELF; ?>" method="post" name="frmDep" id="frmDep" onsubmit="return validaForm()">
			<table width="400" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				 <th colspan="2"><h1>Inclusão de departamentos</h1></th>
			  </tr>
			  <tr>
			    <td width="51">&nbsp;</td>
			    <td width="343">&nbsp;</td>
		     </tr>
			  <tr>
				 <td class="tdcampos"><label for="cmpDepNome" accesskey="o">N<span>o</span>me:</label></td>
				 <td><input name="cmpDepNome" type="text" class="cmp" onblur="clearMsgSts(this.value)" id="cmpDepNome" /></td>
			  </tr>
			  <tr>
				 <td class="tdcampos"><label for="cmpDepAndar" accesskey="n">A<span>n</span>dar:</label></td>
				 <td><input name="cmpDepAndar" type="text" class="cmpFrmDep" id="cmpDepAndar" onkeypress="return isPosNumber(event)" maxlength="4" /></td>
			  </tr>
			  <tr>
				 <td class="tdcampos"><label for="cmpDepSala" accesskey="a">S<span>a</span>la:</label></td>
				 <td><input name="cmpDepSala" type="text" class="cmpFrmDep" onblur="clearMsgSts(this.value)" id="cmpDepSala" onkeypress="return isPosNumber(event)" maxlength="4" /></td>
			  </tr>
			  <tr>
				 <td class="tdcampos"><label for="cmpDepRamal" accesskey="r"><span>R</span>amal:</label></td>
				 <td><input name="cmpDepRamal" type="text" class="cmpFrmDep" onblur="clearMsgSts(this.value)" id="cmpDepRamal" onkeypress="return isPosNumber(event)" maxlength="4" /></td>
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
if(sizeof($_POST))
{
	$p_s_depNome   = $_POST['cmpDepNome'];
	$p_s_depAndar  = $_POST['cmpDepAndar'];
	$p_s_depSala   = $_POST['cmpDepSala'];
	$p_s_depRamal  = $_POST['cmpDepRamal'];
	
	$v_ob_dep = new departamento;
	
	$v_p_msg = '';
	$v_s_script = '';
	
	if($v_ob_dep->addDep($p_s_depNome, $p_s_depAndar, $p_s_depSala, $p_s_depRamal))
	{
		$v_p_msg = "Departamento incluido com sucesso. \\nDeseja incluir outro?";
	}
	else
	{
		$v_p_msg = "Departamento $p_s_depNome já existe.\\nTentar novamente?";
		echo "
			<script type='text/javascript'>
				document.frmDep.cmpDepNome.value  = '$p_s_depNome';
				document.frmDep.cmpDepNome.select();
				document.frmDep.cmpDepAndar.value = '$p_s_depAndar';
				document.frmDep.cmpDepSala.value  = '$p_s_depSala';
				document.frmDep.cmpDepRamal.value = '$p_s_depRamal';
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