<?
/*
Nome do Script : LOGIN.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Vers�o         : 1.0
Par�metros     : Nenhum.
Descri��o      : Script contendo a valida��o de usu�rio.
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $c_s_titulo; ?></title>

<!-- Folhas de estilos para a padroniza��o -->
<link href="../css/sisfacil.css" rel="stylesheet" type="text/css" />
<!-- Folhas de estilos para a padroniza��o dos links -->
<link href="../css/links.css" rel="stylesheet" type="text/css" />
<!-- Bibliot�ca de scripts comuns -->
<script type="text/javascript" src="../js/common.js"></script>
<!-- Scripts locais -->
<script type="text/javascript">
<!--  
window.onload = function Construtor()
{
	noFocus(); //fun��o declarada dentro common.js
}
-->
</script>

</head>
<body>

<div align="center">
	<!-- Divis�o do login -->
	<div id="login">
		<form action="<? echo $PHP_SELF; ?>" method="post" name="frmLogin">
			<table width="300" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				 <th colspan="2">
					<? echo $c_s_titulo; ?>
				 </th>
			  </tr>
			  <tr>
				 <td>&nbsp;</td>
				 <td>&nbsp;</td>
			  </tr>
			  <tr>
				 <td>
					<label for="cmpUser" accesskey="u">Us<span>u</span>&aacute;rio:&nbsp;</label>
				 </td>
				 <td><input name="cmpUser" type="text" class="cmp" id="cmpUser" value="<? if(!empty($v_s_funcLogin)) echo $v_s_funcLogin; ?>" maxlength="10" /></td>
			  </tr>
			  <tr>
				 <td>
					<label for="cmpSenha" accesskey="e">S<span>e</span>nha:&nbsp;</label>
				 </td>
				 <td><input name="cmpSenha" type="password" class="cmp" id="cmpSenha" value="" maxlength="8" /></td>
			  </tr>
			  <tr>
				 <td colspan="2"><? echo "Nome do servidor: ".$_SERVER['SERVER_NAME']; ?></td>
			  </tr>
			  <tr>
				 <td>&nbsp;</td>
				 <td>
					<input name="" type="submit" value="Entrar" />
					<input name="" type="reset" value="Limpar" />
				 </td>
			  </tr>
			  <tr>
				 <td colspan="2">
				 	<div id="msgStatus">
						<? echo "Sua senha n�o confere, ou voc� n�o � um usu�rio cadastrado."; ?>
					</div>
				 </td>
			  </tr>
			</table>
		</form>
	</div>
</div>
<!-- FIM -->
</body>
</html>
<?
}
?>