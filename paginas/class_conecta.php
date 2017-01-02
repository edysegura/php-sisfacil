<?
/*
Nome do Script : CFG_CONECTA.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Verso         : 1.0
Parmetros     : Nenhum.
Descrio      : Arquivo contendo a classe para conexo.
*/

class conect_mysql
{
	var $p_s_host;
	var $p_s_user;
	var $p_s_pass;
	var $p_s_database;
	
	/* Construtor da classe conect_mysql */
	function conect_mysql($p_s_server)
	{
		//converte tudo para minusculo.
		$p_s_server = strtolower($p_s_server);
		
		//testa se est no servidor local ou na web.
		if($p_s_server) //== 'localhost')//'sol')
		{
			$this->p_s_host = 'mysql.webengineers.com.br';
			$this->p_s_user = 'sisfacil';
			$this->p_s_pass = 'sisf4cil';
			$this->p_s_database = 'sisfacil';
		}
		else
		{
			$this->p_s_host = 'mysql.webengineers.com.br';
			$this->p_s_user = 'sisfacil';
			$this->p_s_pass = 'sisf4cil';
			$this->p_s_database = 'sisfacil';
		}
	}
	
	/* Mtodo para conexo com o mysql */
	function conect()
	{
		$p_ob_link = mysql_connect($this->p_s_host, $this->p_s_user, $this->p_s_pass)
		or die ('No foi possvel conectar: ' . mysql_error());
		
		mysql_select_db($this->p_s_database, $p_ob_link)
		or die ('No foi possvel usar este banco: ' . mysql_error());
	}
}
?>
