<?
/*
Nome do Script : CLASS_USUARIO.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Versуo         : 1.0
Parтmetros     : Nenhum.
Descriчуo      : Script contendo a validaчуo de usuсrio.
*/
class sistemas
{
	function addSis($p_s_sisSigla, $p_s_sisDesc)
	{
		//converte a sigla para maiusculo
		$p_s_sisSigla = strtoupper($p_s_sisSigla);
		
		$p_s_query = "INSERT INTO sistemas (sis_sigla, sis_desc) VALUES 
		              ('$p_s_sisSigla', '$p_s_sisDesc')";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	function alterSis($p_s_sisSigla, $p_s_sisDesc)
	{
		$p_s_query = "UPDATE sistemas SET sis_sigla = '$p_s_sisSigla', sis_desc = '$p_s_sisDesc' 
		              WHERE sis_sigla = '$p_s_sisSigla'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	//deleta o sistema selecionado
	function delSis($p_s_sisSigla)
	{
		$p_s_query = "DELETE FROM sistemas WHERE sis_sigla = '$p_s_sisSigla'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	//retorna todos os sistemas cadastrados
	function getSis()
	{
		$p_s_query = "SELECT * FROM sistemas ORDER BY sis_desc ASC";
		
		if($p_s_result = mysql_query($p_s_query))
			return $p_s_result;
		else
			return false;
	}
	
	function getSisDesc($p_s_sisSigla)
	{
		$p_s_query = "SELECT sis_desc FROM sistemas
		              WHERE sis_sigla = '$p_s_sisSigla'";
		
		if($p_s_result = mysql_query($p_s_query))
			return mysql_result($p_s_result,0,'sis_desc');
		else
			return false;
	}
}
?>