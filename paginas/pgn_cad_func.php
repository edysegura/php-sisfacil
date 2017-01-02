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
require('class_usuario.php');
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

<!-- Bibliotéca de scripts comuns -->
<script type="text/javascript" src="../js/common.js"></script>

<!-- Definição de estilo local -->
<style type="text/css">
<!--  
#fieldDep, #fieldUser
{
	margin-left: 15px;
	width: 350px;
	text-align: left;
}

#fieldDep, select
{
	margin-top: 5px;
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

function abilitar(v_s_valor)
{
	v_ob_btnSubmit = document.getElementById('btnSubmit');
	
	if(v_s_valor)
		v_ob_btnSubmit.disabled = false;
	else
		v_ob_btnSubmit.disabled = true;
	
}

function checkCmp(v_ob_cmp)
{
	v_ob_msgSts = document.getElementById('msgStatus');
	
	if(isEmpty(v_ob_cmp.value))
	{
		if(typeof(v_ob_timerID) != 'undefined')
			clearTimeout(v_ob_timerID);
			
		v_ob_msgSts.innerHTML = 'Primeiro escolha o departamento.';
		v_ob_timerID = setTimeout("v_ob_msgSts.innerHTML = '&nbsp;'",3000);
		return true;
	}
	else
		return false;
}

function validaForm()
{
	var v_ob_msgStatus = document.getElementById('msgStatus');
	v_ob_msgStatus.innerHTML = '&nbsp;';
	
	if(isEmpty(document.frmFunc.cmpFuncNome.value) || isBlank(document.frmFunc.cmpFuncNome.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo nome é obrigatório.';
		document.frmFunc.cmpFuncNome.focus();
		return false;
	}
	
	if(isEmpty(document.frmFunc.cmpFuncLogin.value) || isBlank(document.frmFunc.cmpFuncLogin.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo login é obrigatório.';
		document.frmFunc.cmpFuncLogin.focus();
		return false;
	}

	if(isEmpty(document.frmFunc.cmpFuncSenha.value) || isBlank(document.frmFunc.cmpFuncSenha.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo senha é obrigatório.';
		document.frmFunc.cmpFuncSenha.focus();
		return false;
	}
	
	if(isEmpty(document.frmFunc.cmpFuncConfSenha.value) || isBlank(document.frmFunc.cmpFuncConfSenha.value))
	{
		v_ob_msgStatus.innerHTML = 'Campo confirmação de senha é obrigatório.';
		document.frmFunc.cmpFuncConfSenha.focus();
		return false;
	}

	if(document.frmFunc.cmpFuncSenha.value.length < 4 || document.frmFunc.cmpFuncSenha.value.length > 8)
	{
		v_ob_msgStatus.innerHTML = 'Campo senha deve conter entre 4 e 8 caracteres.';
		document.frmFunc.cmpFuncSenha.focus();
		document.frmFunc.cmpFuncSenha.select();
		return false;
	}
	
	if(document.frmFunc.cmpFuncSenha.value != document.frmFunc.cmpFuncConfSenha.value)
	{
		v_ob_msgStatus.innerHTML = 'Confirmação de senha inválida.';
		document.frmFunc.cmpFuncSenha.value='';
		document.frmFunc.cmpFuncConfSenha.value='';
		document.frmFunc.cmpFuncSenha.focus();
		return false;
	}
	
	if(!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.frmFunc.cmpFuncEmail.value)))
	{
		v_ob_msgStatus.innerHTML = 'E-mail inválido.';
		document.frmFunc.cmpFuncEmail.focus();
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
		<form action="<? echo $PHP_SELF; ?>" method="post" name="frmFunc" id="frmFunc" onsubmit="return validaForm()">
			<table width="400" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				 <th>Inclusão de usuários</th>
			  </tr>
			  <tr>
				 <td>
				 	<fieldset id="fieldDep">
						<legend><label for="cmpDep" accesskey="e">D<span>e</span>partamento:</label></legend>
				 		<select name="cmpDep" class="cmpBox" id="cmpDep" onchange="abilitar(this.value)">
							<option selected="selected" value="">Departamentos</option>
							<?
								$v_ob_dep = new departamento;
								$p_s_result = $v_ob_dep->getDeps();
								
								while($rows = mysql_fetch_array($p_s_result))
								{
									$v_s_depCod  = $rows['dep_cod'];
									$v_s_depNome = $rows['dep_nome'];
									
									if($v_s_depCod == $_POST['cmpDep'])
										echo "<option value='$v_s_depCod' selected='selected'>$v_s_depNome</option>";
									else
										echo "<option value='$v_s_depCod'>$v_s_depNome</option>";
								}
							?>
					  </select>
					  <a href="pgn_cad_dep.php" title="Adicionar novo departamento"
					   onclick="return confirm('Deseja ir para o cadastro de departamento?\nTodos os dados informados serão perdidos.')">
					  		<img src="../imagens/btn_mais.gif" alt="Cadastro de departamento" name="btn_mais" width="15" height="15" id="btn_mais" />
					  </a>
					</fieldset>
				 </td>
			  </tr>
			  <tr>
			    <td>
				 	<fieldset id="fieldUser">
						<legend>Usuário:</legend>
						<label for="cmpFuncNome" accesskey="n"><span>N</span>ome:</label><br />
						<input name="cmpFuncNome" type="text" class="cmp" onblur="clearMsgSts(this.value)" id="cmpFuncNome" onfocus="if(checkCmp(this.form.cmpDep)) this.blur()" /><br />
						
						<label for="cmpFuncLogin" accesskey="o">L<span>o</span>gin:</label><br />
						<input name="cmpFuncLogin" type="text" class="cmp" onblur="clearMsgSts(this.value)" id="cmpFuncLogin" onfocus="if(checkCmp(this.form.cmpDep)) this.blur()" /><br />
						
						<label for="cmpFuncSenha" accesskey="s"><span>S</span>enha:</label><br />
						<input name="cmpFuncSenha" type="password" class="cmp" onblur="clearMsgSts(this.value)" id="cmpFuncSenha" onfocus="if(checkCmp(this.form.cmpDep)) this.blur()" /><br />
						
						<label for="cmpFuncConfSenha" accesskey="m">Confir<span>m</span>ar senha:</label><br />
						<input name="cmpFuncConfSenha" type="password" class="cmp" onblur="clearMsgSts(this.value)" id="cmpFuncConfSenha" onfocus="if(checkCmp(this.form.cmpDep)) this.blur()" /><br />
						
						<label for="cmpFuncEmail" accesskey="a">E-m<span>a</span>il:</label><br />
						<input name="cmpFuncEmail" type="text" class="cmp" onblur="clearMsgSts(this.value)" id="cmpFuncEmail" onfocus="if(checkCmp(this.form.cmpDep)) this.blur()" /><br />
						
						<label>Data de Inclus&atilde;o:</label>
						<? echo date("d/m/Y"); ?><input name="cmpFuncDtInc" type="hidden" id="cmpFuncDtInc" value="<? echo date("d/m/Y"); ?>" />
					</fieldset>
				 </td>
		     </tr>
			  <tr>
			    <td>&nbsp;</td>
		     </tr>
			  <tr>
			    <td>
				 	<div id="btns">
						<input type="submit" id="btnSubmit" value="OK" <? if(!sizeof($_POST)) echo 'disabled="disabled"'; ?> />&nbsp;
						<input type="button" value="Cancelar" onclick="goPrinc('<? echo session_id(); ?>')" />
					</div>
				 </td>
		     </tr>
			  <tr>
			    <td>
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
	$p_s_funcDepCod = $_POST['cmpDep'];
	$p_s_funcNome   = $_POST['cmpFuncNome'];
	$p_s_funcLogin  = $_POST['cmpFuncLogin'];
	$p_s_funcSenha  = $_POST['cmpFuncSenha'];
	$p_s_funcEmail  = $_POST['cmpFuncEmail'];
	$p_s_funcDtInc  = $_POST['cmpFuncDtInc'];
	
	$v_ob_func = new user;

	$v_p_msg = '';
	
	if($v_ob_func->addUser($p_s_funcDepCod, $p_s_funcNome, $p_s_funcLogin, $p_s_funcSenha, $p_s_funcEmail, $p_s_funcDtInc))
	{
		$v_p_msg = "Usuário incluido com sucesso. \\nDeseja incluir outro?";
		echo "
			<script type='text/javascript'>
				document.frmFunc.cmpDep.selectedIndex = 0;
			</script>
		";
	}
	else
	{
		$v_p_msg = "Usuário não pode ser incluido. Login: $p_s_funcLogin já existe.\\nTentar novamente?";
		echo "
			<script type='text/javascript'>
				document.frmFunc.cmpFuncNome.value  = '$p_s_funcNome';
				document.frmFunc.cmpFuncLogin.value = '$p_s_funcLogin';
				document.frmFunc.cmpFuncLogin.select();
				document.frmFunc.cmpFuncEmail.value = '$p_s_funcEmail';
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