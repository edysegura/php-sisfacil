<?
/*
Nome do Script : CFG_CONFIG.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 12 de Outubro de 2004.
Versão         : 1.0
Parâmetros     : Nenhum.
Descrição      : Arquivo contendo variaveis globais.
*/

//require('vrf_session.php');
include('cfg_config.php');
require('class_conecta.php');
require('class_usuario.php');

//conexão com o mysql
$v_ob_conMysql = new conect_mysql($_SERVER['SERVER_NAME']);
$v_ob_conMysql->conect();

//pegando todos os usuários cadastrados no sistema
$v_ob_func = new user;

$v_ob_result = $v_ob_func->getUsers($_GET['depCod']);
//$v_ob_result = $v_ob_func->getUsers('3');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $c_s_titulo; ?></title>
<link href="../css/sisfacil.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="func">
<select name="cmpFunc" class="cmpBox" id="cmpFunc" onchange="clearMsgSts(this.value)">
	<option selected="selected">Funcionarios</option>
	<?
		while($rows = mysql_fetch_array($v_ob_result))
		{
			$v_s_funcCod  = $rows['func_cod'];
			$v_s_funcNome = $rows['func_nome'];
			echo "<option value='$v_s_funcCod'>$v_s_funcNome</option>";
		}
	?>
</select>
<a href="pgn_cad_func.php" title="Adicionar novo usuário"
 onclick="return confirm('Deseja ir para o cadastro de usuário?\nTodos os dados informados serão perdidos.')">
	<img src="../imagens/btn_mais.gif" alt="Cadastro de usuário" name="btn_mais" width="15" height="15" id="btn_mais" />
</a>
</div>

<?
	$v_s_scriptExec = '';
	
	if($v_ob_result)
	{
		$v_s_scriptExec = "top.document.getElementById('tdFunc').innerHTML = document.getElementById('func').innerHTML;
		                   top.document.getElementById('trFunc').style.display = '';";
	}
	else
	{
		$v_s_scriptExec = "top.document.getElementById('trFunc').style.display = 'none';
		                   alert('Nenhum funcionário foi encontrado para este departamento.');";
	}

	echo "
			<script type='text/javascript'>
			<!--  
				$v_s_scriptExec
			-->
			</script>
		  ";
?>
</body>
</html>