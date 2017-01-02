<?
/*
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 12 de Outubro de 2004.
Vers�o         : 1.0
Par�metros     : Nenhum.
Descri��o      : P�gina inicial do sistema.
*/

include('cfg_config.php');
require('class_conecta.php');
require('class_usuario.php');

$v_s_funcLogin = $_POST['cmpUser'];
$v_s_funcsenha = md5($_POST['cmpSenha']);

$v_ob_conMysql = new conect_mysql($_SERVER['SERVER_NAME']);
$v_ob_conMysql->conect();

$v_ob_user = new user;

//Verifica se o usu�rio exite
$v_s_user  = $v_ob_user->validaUser($v_s_funcLogin, $v_s_funcsenha);

if($v_s_user)
{
	//Busca informa��es do usu�rio
	$v_ob_user->infoUser($v_s_funcLogin, $v_s_funcsenha);
	
	//inicia a sess�o
	session_start();
	$_SESSION['funcLogin']   = $v_ob_user->v_s_funcLogin;
	$_SESSION['funcNome']    = $v_ob_user->v_s_funcNome;
	$_SESSION['funcSenha']   = $v_ob_user->v_s_funcSenha;
	$_SESSION['funcCod']     = $v_ob_user->v_s_funcCod;
	$_SESSION['funcDepCod']  = $v_ob_user->v_s_funcDepCod;
	$_SESSION['isAdm']       = $v_ob_user->isAdm(); //Verifica se o usu�rio � uma administrador.
	
	//redireciona o usu�rio
	header("Location: pgn_principal.php?sid=".session_id());
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><? echo $c_s_titulo; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!-- Folhas de estilo para padroniza��o -->
<link href="../css/sisfacil.css" rel="stylesheet" type="text/css" />

<!-- Folhas de estilo para padroniza��o dos links -->
<link href="../css/links.css" rel="stylesheet" type="text/css" />

<!-- Bibliot�ca comun em javascript -->
<script type="text/javascript" src="../js/common.js"></script>

<style type="text/css">
<!--  
body
{
	background-image: none;
}

#btns
{
	text-align: right;
}

#btns input
{
	margin-right: 10px;
}

#desc
{
	padding: 3px;
	font-size: 10px;
	text-align: center;
}
-->
</style>

<!-- Fun��es da p�gina -->
<script type="text/javascript">
<!--
window.onload = function Construtor()
{
	noFocus(); //fun��o declarada dentro common.js
	document.forms[0].elements[0].focus();
}

function validaForm()
{
	var v_ob_msgStatus = document.getElementById('msgStatus');
	
	if(isEmpty(document.frmLogin.cmpUser.value) || isBlank(document.frmLogin.cmpUser.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo usu�rio � obrigat�rio';
		document.frmLogin.cmpUser.focus();
		return false;
	}
	
	if(isEmpty(document.frmLogin.cmpSenha.value) || isBlank(document.frmLogin.cmpSenha.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo senha � obrigat�rio';
		document.frmLogin.cmpSenha.focus();
		return false;
	}
	
	if(document.frmLogin.cmpSenha.value.length < 4) 
	{
		v_ob_msgStatus.innerHTML = 'Campo senha deve conter entre 4 e 8 caracteres.';
		document.frmLogin.cmpSenha.focus();
		return false;
	}
	return true;
}
-->
</script>

</head>
<body>

<div align="center">
	<!-- Divis�o do login -->
	<div id="login">
		<form action="<? echo $PHP_SELF; ?>" method="post" name="frmLogin" onsubmit="return validaForm()">
			<table width="300" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				 <th colspan="2">
				 	<h1><? echo $c_s_titulo; ?></h1>
				 </th>
			  </tr>
			  <tr>
				 <td>&nbsp;</td>
				 <td>&nbsp;</td>
			  </tr>
			  <tr>
				 <td class="tdcampos">
					<label for="cmpUser" accesskey="u">Us<span>u</span>&aacute;rio:</label>
				 </td>
				 <td><input name="cmpUser" type="text" class="cmp" id="cmpUser" value="wdedy" onblur="clearMsgSts(this.value)" maxlength="10" /></td>
			  </tr>
			  <tr>
				 <td class="tdcampos">
					<label for="cmpSenha" accesskey="e">S<span>e</span>nha:</label>
				 </td>
				 <td><input name="cmpSenha" type="password" class="cmp" id="cmpSenha" value="wdedy" onblur="clearMsgSts(this.value)" maxlength="8" /></td>
			  </tr>
			  <tr>
			    <td colspan="2">&nbsp;</td>
		     </tr>
			  <tr>
				 <td colspan="2">
				 	<div id="btns">
						<input type="submit" value="Entrar" />
					</div>
				 </td>
			  </tr>
			  <tr>
			    <td colspan="2"><p id="desc">Sistema multi-usu&aacute;rio e multi-plataforma para cadastro, acompanhamento, controle e consulta de ocorr&ecirc;ncias.</p></td>
		     </tr>
			  <tr>
			    <td colspan="2">
				 	<div id="msgStatus">
					<? 
						if(sizeof($_POST))
							echo "Sua senha n�o confere, ou voc� n�o � um usu�rio cadastrado.";
						else
							echo "&nbsp;";
					?>
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
}
?>