<?
/*
Nome do Script : CLASS_USUARIO.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Versуo         : 1.0
Parтmetros     : Nenhum.
Descriчуo      : Script contendo a validaчуo de usuсrio.
*/
class andamento
{
	function addSts($p_s_stsSigla, $p_s_stsDesc)
	{
		//converte a sigla para maiusculo
		$p_s_stsSigla = strtoupper($p_s_stsSigla);
		
		$p_s_query = "INSERT INTO andamento(anda_sigla, anda_desc) VALUES 
		              ('$p_s_stsSigla', '$p_s_stsDesc')";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	function alterSts($p_s_stsSigla, $p_s_stsDesc)
	{
		$p_s_query = "UPDATE andamento SET anda_sigla = '$p_s_stsSigla', anda_desc = '$p_s_stsDesc' 
		              WHERE anda_sigla = '$p_s_stsSigla'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	//deleta o sistema selecionado
	function delSts($p_s_stsSigla)
	{
		$p_s_query = "DELETE FROM andamento WHERE anda_sigla = '$p_s_stsSigla'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	//retorna todos os sistemas cadastrados
	function getSts()
	{
		$p_s_query = "SELECT * FROM andamento ORDER BY anda_desc ASC";
		
		if($p_s_result = mysql_query($p_s_query))
			return $p_s_result;
		else
			return false;
	}
	
	function getDescSts($p_s_andaSigla)
	{
		$p_s_query = "SELECT anda_desc 
		              FROM andamento
						  WHERE anda_sigla = '$p_s_andaSigla'";
		
		if($p_s_result = mysql_query($p_s_query))
		{
			$p_s_andaDesc = mysql_result($p_s_result,0,'anda_desc');
			return $p_s_andaDesc;
		}
		else
			return false;
	}
	
	function getCodDescSts($p_s_andaSigla)
	{
		$p_s_query = "SELECT anda_cod, anda_desc 
		              FROM andamento
						  WHERE anda_sigla = '$p_s_andaSigla'";
		
		if($p_s_result = mysql_query($p_s_query))
		{
			return $p_s_result;
		}
		else
			return false;
	}

}
?>