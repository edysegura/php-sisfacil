<?
/*
Nome do Script : LOGIN.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Versão         : 1.0
Parâmetros     : Nenhum.
Descrição      : Script contendo a validação de usuário.
*/
require('vrf_session.php');
include('cfg_config.php');
require('class_conecta.php');
require('class_ocorrencia.php');
require('class_problema.php');
require('class_usuario.php');
require('class_departamento.php');
require('class_andamento.php');



//conexão com MySQL
$v_ob_conMysql = new conect_mysql($_SERVER['SERVER_NAME']);
$v_ob_conMysql->conect();

//objeto ocorrencia
$v_ob_oco = new ocorrencia;

//pega o id da sessão
$sid = session_id();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $c_s_titulo; ?></title>

<!-- Folhas de estilo para padronização -->
<link href="../css/sisfacil.css" rel="stylesheet" type="text/css" />

<!-- Folhas de estilo para padronização dos links -->
<link href="../css/links.css" rel="stylesheet" type="text/css" />

<!-- Biblioteca comum do javascript -->
<script type="text/javascript" src="../js/common.js"></script>

<style type="text/css">
<!--  
fieldset
{
	margin-bottom: 5px;
}

fieldset table
{
	margin-top: 5px;
	font-size: 10px;
}

th
{
	text-align: left;
	text-indent: 2px;
}

td
{
	text-indent: 2px;
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
-->
</script>

</head>
<body>

<fieldset id="fieldUser">
	<legend>Usuário:</legend>
	<? 
		echo "<span>{$_SESSION['funcLogin']}</span> | 
	         <span>{$_SESSION['funcNome']}</span> | ";
		
		if($_SESSION['isAdm'])
			echo '<a href="#" id="lnkAdm" onclick="exbOcu(\'fieldAdm\', this.id, \'menu administrador\'); return false">Exibir menu administrador</a> | ';
	?>
	<a href="#" id="lnkOco" onclick="exbOcu('fieldOco', this.id, 'menu ocorrência'); return false;">Exibir menu ocorrência</a>
	 | 
	<a href="#" id="lnkOcoUser" onclick="exbOcu('fieldOcoUser', this.id, 'ocorrência(s) pendente(s)'); return false;">Exibir ocorrência(s) pendente(s)</a>
	 | 
	<a href="pgn_logout.php" onclick="return confirm('Deseja realmente sair?')">Sair</a>
</fieldset>

<?
	if($_SESSION['isAdm'])
	{
		echo "<fieldset id='fieldAdm' style='display: none;'><legend>Administrador:</legend>";
		echo "<a href='pgn_cad_func.php?sid=$sid'>Usuário</a> | ";
		echo "<a href='pgn_cad_sis.php?sid=$sid'>Sistema</a> | ";
		echo "<a href='pgn_cad_dep.php?sid=$sid'>Departamento</a> | ";
		echo "<a href='pgn_cad_pro.php?sid=$sid'>Problema</a> | ";
		echo "<a href='pgn_cad_adm.php?sid=$sid'>Administrador</a> | ";
		echo "<a href='pgn_cad_status.php?sid=$sid'>Status</a>";
		echo "</fieldset>";
	}
?>

<fieldset id="fieldOco" style="display: none;">
	<legend>Ocorrência:</legend>
	<a href="pgn_cad_oco.php?sid=<? echo $sid; ?>">Incluir</a> | 
	<a href="pgn_con_oco.php?sid=<? echo $sid; ?>">Consultar</a> | 
	<a href="pgn_alt_oco.php?sid=<? echo $sid; ?>">Alterar</a> | 
	<a href="#">Fechar</a>
</fieldset>

<fieldset id="fieldOcoUser" style="display: none;">
	<legend>Ocorrência(s) pendente(s) para <span><? echo $_SESSION['funcLogin']; ?></span>:</legend>
	<?
		$v_s_msg  = "Não foi encontrada nenhuma ocorrênca pendente.";
		
		if($p_ob_result = $v_ob_oco->getUserOco($_SESSION['funcCod']))
		{
			$v_i_numOco = mysql_num_rows($p_ob_result);
			
			if($v_i_numOco)
				echo "Foram encontrada(s)&nbsp;<b>$v_i_numOco</b>&nbsp;ocorrência pendente(s). <a href='#' id='lnkUserOco' onclick=\"exbOcu('tblOcoUser', this.id, 'ocorrência(s)')\"; return false;>Exibir ocorrência(s)</a>";
			else
				echo $v_s_msg;
		}
		else
			echo $v_s_msg;

		if($p_ob_result)
		{
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="2" id="tblOcoUser" style="display: none;">
		  <tr>
			 <th  scope="col">C&oacute;digo</th>
			 <th  scope="col">Problema</th>
			 <th  scope="col">Local</th>
			 <th  scope="col">Abertura</th>
			 <th  scope="col">Status</th>
			 <th  scope="col">Tempo</th>
		  </tr>
		  <?
			 $p_i_linha = -1;
			 while($rows = mysql_fetch_array($p_ob_result))
			 { $p_i_linha++;
		  ?>
		  <tr class="<? echo row_color($p_i_linha); ?>">
			 <td><a href="pgn_con_ocoprinc.php?ocoCod=<? echo $rows['oco_cod']; ?>&sid=<? echo session_id(); ?>"><? echo $rows['oco_cod']; ?></a></td>
			 <td>
				<? 
					$v_ob_prob = new problema;
					echo $v_ob_prob->getProbDesc($rows['oco_procod']);
				?>
			 </td>
			 <td>
				<?
					$v_ob_dep = new departamento;
					echo $v_ob_dep->getDep($rows['oco_funcdepcod']);
				?>
			 </td>
			 <td>
				<? 
					echo date("d/m/Y", strtotime($rows['oco_dtabertura']));
				?>
			 </td>
			 <td>
				<?
					$v_ob_sts = new andamento;
					echo $v_ob_sts->getDescSts($rows['oco_andasigla']);
				?>
			 </td>
			 <td>
				<?
					echo date_diff($rows['oco_dtabertura'], date("m/d/Y"));
				?>
			 </td>
		  </tr>
		  <?
			 }
		  ?>
		</table>
		<?
			}
		?>
</fieldset>

<?
if($_SESSION['isAdm'])
{
?>
<fieldset>
	<legend>Ocorrência(s) pendente(s):</legend>
<?
if($p_ob_result = $v_ob_oco->getOcos())
{
?>
<a href='#' id='lnkUserOcoAdm' onclick="exbOcu('tblOcoAdm', this.id, 'ocorrência(s)')"; return false;>Exibir ocorrência(s)</a>
<table width="100%" border="0" cellspacing="0" cellpadding="2" id="tblOcoAdm" style="display: none;">
  <tr>
    <th width="38" scope="col">C&oacute;digo</th>
    <th width="153" scope="col">Problema</th>
    <th width="59" scope="col">Operador</th>
    <th width="136" scope="col">Local</th>
    <th width="86" scope="col">Abertura</th>
    <th width="168" scope="col">Status</th>
    <th width="49" scope="col">Tempo</th>
    <th width="57" scope="col">Atender</th>
  </tr>
  <?
  	 $p_i_linha = -1;
	 while($rows = mysql_fetch_array($p_ob_result))
	 { $p_i_linha++;
  ?>
  <tr class="<? echo row_color($p_i_linha); ?>">
    <td><a href="pgn_con_ocoprinc.php?ocoCod=<? echo $rows['oco_cod']; ?>&sid=<? echo session_id(); ?>"><? echo $rows['oco_cod']; ?></a></td>
    <td>
		<? 
			$v_ob_prob = new problema;
			echo $v_ob_prob->getProbDesc($rows['oco_procod']);
		?>
	 </td>
    <td>
	   <? 
			$v_ob_func = new user;
			echo $v_ob_func->getLogin($rows['oco_funccod']);
		?>
	 </td>
    <td>
	 	<?
			$v_ob_dep = new departamento;
			echo $v_ob_dep->getDep($rows['oco_funcdepcod']);
		?>
	 </td>
    <td>
	   <? 
			echo date("d/m/Y", strtotime($rows['oco_dtabertura']));
		?>
	 </td>
    <td>
	 	<?
			$v_ob_sts = new andamento;
			echo $v_ob_sts->getDescSts($rows['oco_andasigla']);
		?>
	 </td>
    <td>
	 	<?
			echo date_diff($rows['oco_dtabertura'], date("m/d/Y"));
		?>
	 </td>
    <td><a href="pgn_atender_oco.php?ocoCod=<? echo $rows['oco_cod']; ?>&sid=<? echo session_id(); ?>" onclick="return false;">Sim</a></td>
  </tr>
  <?
  	 }
  ?>
</table>
<?
}
else
	echo "Não foi encontrada nenhuma ocorrênca pendente.";
?>
</fieldset>
<?
}
?>

</body>
</html>