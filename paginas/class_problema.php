<?
/*
Nome do Script : CLASS_USUARIO.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Versгo         : 1.0
Parвmetros     : Nenhum.
Descriзгo      : Script contendo a validaзгo de usuбrio.
*/
class problema
{
	function addPro($p_s_tipSigla, $p_s_proDesc)
	{
		$p_s_query = "INSERT INTO problemas (pro_tipsigla, pro_desc) 
		              VALUES ('$p_s_tipSigla', '$p_s_proDesc')";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	function alterPro($p_s_proCod, $p_s_proDesc)
	{
		$p_s_query = "UPDATE problemas SET pro_desc = '$p_s_proDesc' 
		              WHERE pro_cod = '$p_s_proCod'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	function delPro($p_s_proCod)
	{
		$p_s_query = "DELETE FROM problemas WHERE pro_cod = '$p_s_proCod'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	//Pega os problemas especнficos
	function getEspProbs($p_s_proTip)
	{
		$p_s_query = "SELECT pro_cod, pro_desc
		              FROM problemas
						  WHERE pro_tipsigla = '$p_s_proTip'
						  ORDER BY pro_desc ASC";
		
		$p_ob_result = mysql_query($p_s_query);
		
		if(mysql_num_rows($p_ob_result))
			return $p_ob_result;
		else
			return false;
	}
	
	function getProbDesc($p_s_proCod)
	{
		$p_s_query = "SELECT pro_desc
		              FROM problemas
						  WHERE pro_cod = '$p_s_proCod'";
						  
		if($p_s_result = mysql_query($p_s_query))
		{
			$p_s_probDesc = mysql_result($p_s_result,0,'pro_desc');
			return $p_s_probDesc;
		}
		else
			return false;
	}
}
?>