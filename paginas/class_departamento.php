<?
/*
Nome do Script : CLASS_USUARIO.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Versуo         : 1.0
Parтmetros     : Nenhum.
Descriчуo      : Script contendo a validaчуo de usuсrio.
*/
class departamento
{
	function addDep($p_s_depNome, $p_s_depAndar, $p_s_depSala, $p_s_depRamal)
	{
		$p_s_query = "INSERT INTO departamentos (dep_nome, dep_andar, dep_sala, dep_ramal) 
		              VALUES ('$p_s_depNome', '$p_s_depAndar', '$p_s_depSala', '$p_s_depRamal')";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	function alterDep($p_s_depCod, $p_s_depNome, $p_s_depAndar, $p_s_depSala, $p_s_depRamal)
	{
		$p_s_query = "UPDATE departamentos SET dep_nome = '$p_s_depNome', dep_andar = '$p_s_depAndar', 
		              dep_sala = '$p_s_depSala', dep_ramal = '$p_s_depRamal' WHERE dep_cod = '$p_s_depCod'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	function delDep($p_s_depCod)
	{
		$p_s_query = "DELETE FROM departamentos WHERE dep_cod = '$p_s_depCod'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	function getDeps()
	{
		$p_s_query = "SELECT dep_cod, dep_nome
						  FROM departamentos";
		
		$p_s_result = mysql_query($p_s_query);

		if(mysql_num_rows($p_s_result))
			return $p_s_result;
		else
			return false;
	}
	
	function getDep($p_s_depCod)
	{
		$p_s_query = "SELECT dep_nome
		              FROM departamentos
						  WHERE dep_cod = '$p_s_depCod'";
						  
		if($p_s_result = mysql_query($p_s_query))
		{
			$v_s_depNome = mysql_result($p_s_result,0,'dep_nome');
			return $v_s_depNome;
		}
		else
			return false;
	}
}
?>