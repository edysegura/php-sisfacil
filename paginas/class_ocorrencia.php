<?
/*
Nome do Script : CLASS_USUARIO.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Versуo         : 1.0
Parтmetros     : Nenhum.
Descriчуo      : Script contendo a validaчуo de usuсrio.
*/
class ocorrencia
{
	function addOco($p_s_funcCod, $p_s_funcDepCod, $p_s_sisSigla, $p_s_andaSigla, $p_s_proTipSigla, 
	                $p_s_proCod, $p_s_tipSigla, $p_s_ocoDesc, $p_s_ocoDtAbertura)
	{
		//alterando o padrуo da data
		list($v_s_dia, $v_s_mes, $v_s_ano) = explode("/",$p_s_ocoDtAbertura);
		$p_s_ocoDtAbertura = "$v_s_ano-$v_s_mes-$v_s_dia";
		
		$p_s_query = "INSERT INTO ocorrencias (oco_funccod, oco_funcdepcod, oco_sissigla, oco_andasigla, 
		                                       oco_protipsigla, oco_procod, oco_tipsigla, oco_desc, oco_dtabertura)
		                             VALUES ('$p_s_funcCod', '$p_s_funcDepCod', '$p_s_sisSigla', '$p_s_andaSigla', 
											          '$p_s_proTipSigla', '$p_s_proCod', '$p_s_tipSigla', '$p_s_ocoDesc', '$p_s_ocoDtAbertura')";
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	function alterOco($p_s_ocoCod, $p_s_andaSigla, $p_s_ocoDesc)
	{
		$p_s_query = "UPDATE ocorrencias SET oco_andasigla = '$p_s_andaSigla', oco_desc = '$p_s_ocoDesc' 
						  WHERE oco_cod = '$p_s_ocoCod'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	function delOco($p_s_ocoCod)
	{
		$p_s_query = "DELETE FROM ocorrencias WHERE oco_cod = '$p_s_ocoCod'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	function getOcos()
	{
		$p_s_query = "SELECT * FROM ocorrencias 
		              WHERE oco_andasigla = 'AGA' OR
								  oco_andasigla = 'ANA' OR
								  oco_andasigla = 'EST'";
		
		if($p_ob_result = mysql_query($p_s_query))
			return $p_ob_result;
		else
			return false;
	}
	
	function getOco($p_s_ocoCod)
	{
		$p_s_query = "SELECT * FROM ocorrencias 
		              WHERE oco_cod = '$p_s_ocoCod'";
		
		if($p_ob_result = mysql_query($p_s_query))
			return $p_ob_result;
		else
			return false;
	}

	
	function getUserOco($p_s_funcCod)
	{
		$p_s_query = "SELECT * FROM ocorrencias 
		              WHERE oco_funccod = '$p_s_funcCod' AND
						        oco_andasigla = 'AGA' OR
								  oco_andasigla = 'ANA' OR
								  oco_andasigla = 'EST'";
		
		if($p_ob_result = mysql_query($p_s_query))
			return $p_ob_result;
		else
			return false;
	}
	
	function getUserConOco($p_s_ocoCod, $p_s_funcCod)
	{
		$p_s_query = "SELECT * FROM ocorrencias 
		              WHERE oco_cod = '$p_s_ocoCod' AND
						        oco_funccod = '$p_s_funcCod'";
								  
		if($p_ob_result = mysql_query($p_s_query))
			return $p_ob_result;
		else
			return false;

	}
	
	function getUserConOcoCods($p_s_funcCod)
	{
		$p_s_query = "SELECT oco_cod FROM ocorrencias 
		              WHERE oco_funccod = '$p_s_funcCod'";
								  
		if($p_ob_result = mysql_query($p_s_query))
			return $p_ob_result;
		else
			return false;

	}

}
?>