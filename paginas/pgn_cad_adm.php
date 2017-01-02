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
require('class_usuario.php');

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
<!--  
window.onload = function Construtor()
{
	noFocus(); //função declarada dentro common.js
}

function atuCmp(p_s_depCod)
{
	var v_ob_trFunc = document.getElementById('trFunc');
	
	if(p_s_depCod)
	{
		var v_ob_pgn = document.getElementById('getUsers');
		v_ob_pgn.src = 'get_users.php?depCod='+p_s_depCod;
	}
	else
	{
		v_ob_trFunc.style.display = 'none';
	}
}

function validaForm()
{
	var v_ob_msgStatus = document.getElementById('msgStatus');
	v_ob_msgStatus.innerHTML = '&nbsp;';
	
	if(isEmpty(document.frmAdm.cmpDep.value))
	{
		v_ob_msgStatus.innerHTML = 'Escolha o departamento.';
		document.frmAdm.cmpDep.focus();
		return false;
	}
	
	if(isEmpty(document.frmAdm.cmpFunc.value))
	{
		v_ob_msgStatus.innerHTML = 'Escolha o funcionário.';
		document.frmAdm.cmpFunc.focus();
		return false;
	}
	return true;
}
-->
</script>

</head>
<body>

<div align="center">
	<!-- Divisão do problema -->
	<div id="problema">
		<form action="<? echo $PHP_SELF; ?>" method="post" name="frmAdm" id="frmAdm" onsubmit="return validaForm()">
			<table width="400" border="0" cellspacing="0" cellpadding="1">
			  <tr>
				 <th colspan="2">Inclusão de administradores</th>
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td>&nbsp;</td>
		     </tr>
			  <tr>
				 <td class="tdcampos" width="117"><label for="cmpDep" accesskey="p">De<span>p</span>artamento:</label></td>
				 <td width="277">
				 <select name="cmpDep" class="cmpBox" id="cmpDep" onchange="atuCmp(this.value); clearMsgSts(this.value)">
				   <option selected="selected" value="">Departamentos</option>
					<?
						$v_ob_dep = new departamento;
						$p_s_result = $v_ob_dep->getDeps();
						
						while($rows = mysql_fetch_array($p_s_result))
						{
							$v_s_depCod  = $rows['dep_cod'];
							$v_s_depNome = $rows['dep_nome'];
							echo "<option value='$v_s_depCod'>$v_s_depNome</option>";
						}
					?>
				 </select>
				 <a href="pgn_cad_dep.php" title="Adicionar novo departamento"
				  onclick="return confirm('Deseja ir para o cadastro de departamento?\nTodos os dados informados serão perdidos.')">
				 		<img src="../imagens/btn_mais.gif" alt="Cadastro de departamento" name="btn_mais" width="15" height="15" id="btn_mais" />
				 </a>
				 </td>
			  </tr>
			  <tr id="trFunc" style="display: none;">
				 <td class="tdcampos"><label for="cmpFunc" accesskey="u">F<span>u</span>ncion&aacute;rio:</label></td>
				 <td id="tdFunc">&nbsp;</td>
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

<iframe src="" name="getUsers" id="getUsers" style="display: none"></iframe>
<!-- FIM -->

</body>
</html>
<?
if(sizeof($_POST))
{
	$p_s_funcDepCod = $_POST['cmpDep'];
	$p_s_funcCod    = $_POST['cmpFunc'];
	
	$v_ob_func = new user;
	
	$v_p_msg = '';
	
	if($v_ob_func->addAdm($p_s_funcCod, $p_s_funcDepCod))
	{
		$v_p_msg = "Administrador incluido com sucesso. \\nDeseja incluir outro?";
	}
	else
	{
		$v_p_msg = "Administrador já existe. \\nDeseja incluir outro?";
	}
	
	echo "
		<script type='text/javascript'>
			if(!confirm('$v_p_msg'))
				goPrinc('".session_id()."');
		</script>
	";
}
?>