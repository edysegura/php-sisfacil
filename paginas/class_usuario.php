<?
/*
Nome do Script : CLASS_USUARIO.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Versão         : 1.0
Parâmetros     : Nenhum.
Descrição      : Script contendo a validação de usuário.
*/
class user
{
	var $v_s_funcCod;     //Armazena o código do funcionário.
	var $v_s_funcDepCod;  //Armazena o código do departamento.
	var $v_s_funcNome;    //Armazena o nome do funcionário.
	var $v_s_funcLogin;   //Armazena o login do funcionário.
	var $v_s_funcSenha;   //Armazena a senha do funcionário.
	var $v_s_funcEmail;   //Armazena o email do funcionário.
	
	//Método para validar o usuáro
	function validaUser($p_s_user, $p_s_senha)
	{
		$p_s_query = "SELECT *
                    FROM funcionarios
				        WHERE func_login = '$p_s_user' AND
				        func_senha = '$p_s_senha'";
		
		$p_ob_result = mysql_query($p_s_query);
		
		if(mysql_num_rows($p_ob_result))
			return true;
		else
			return false;
	}
	
	//Obtem informações do usuário.
	function infoUser($p_s_user, $p_s_senha)
	{
		$p_s_query = "SELECT *
                    FROM funcionarios
				        WHERE func_login = '$p_s_user' AND
				        func_senha = '$p_s_senha'";
		
		$p_ob_result = mysql_query($p_s_query);
		
		$this->v_s_funcCod    = mysql_result($p_ob_result,0,'func_cod');
		$this->v_s_funcDepCod = mysql_result($p_ob_result,0,'func_depcod');
		$this->v_s_funcNome   = mysql_result($p_ob_result,0,'func_nome');
		$this->v_s_funcLogin  = mysql_result($p_ob_result,0,'func_login');
		$this->v_s_funcSenha  = mysql_result($p_ob_result,0,'func_senha');
		$this->v_s_funcEmail  = mysql_result($p_ob_result,0,'func_email');
	}
	
	//método q retorna todos os funcionário do departamento
	function getUsers($p_s_funcDepCod)
	{
		$p_s_query = "SELECT func_cod, CONCAT(func_nome,' - ',func_login) as func_nome
		              FROM funcionarios
						  WHERE func_depcod = '$p_s_funcDepCod'";
							
		$p_ob_result = mysql_query($p_s_query);
		
		if(mysql_num_rows($p_ob_result))
			return $p_ob_result;
		else
			return false;
	}
	
	function getLogin($p_s_funcCod)
	{
		$p_s_query = "SELECT func_login
		              FROM funcionarios
						  WHERE func_cod = '$p_s_funcCod'";
						  
		if($p_s_result = mysql_query($p_s_query))
		{
			$p_s_funcLogin = mysql_result($p_s_result,0,'func_login');
			return $p_s_funcLogin;
		}
		else
			return false;
	}
	
	function getNome($p_s_funcCod)
	{
		$p_s_query = "SELECT func_nome
		              FROM funcionarios
						  WHERE func_cod = '$p_s_funcCod'";
						  
		if($p_s_result = mysql_query($p_s_query))
		{
			$p_s_funcNome = mysql_result($p_s_result,0,'func_nome');
			return $p_s_funcNome;
		}
		else
			return false;
	}
	
	//Método para vereficar se o usuário é uma Administrador
	function isAdm()
	{
		$p_s_query = "SELECT 1 as VALOR
	                 FROM administradores
					     WHERE adm_funccod = '$this->v_s_funcCod'";
						  
		$p_ob_result = mysql_query($p_s_query);
		
		if(mysql_num_rows($p_ob_result))
			$v_s_isAdm = mysql_result($p_ob_result,0,'VALOR');
		else
			$v_s_isAdm = false;
		
		if($v_s_isAdm)
			return true;
		else
			return false;
	}
	
	//Método para adicionar um novo funcionário
	function addUser($p_s_funcDepCod, $p_s_funcNome, $p_s_funcLogin, $p_s_funcSenha, $p_s_funcEmail, $p_s_funcDtInc)
	{
		
		//Se o campo login e senha for vazio retorna false
		if(empty($p_s_funcLogin)||empty($p_s_funcSenha)) return false;
		
		//criptografia da senha do usuário
		$p_s_funcSenha = md5($p_s_funcSenha);
		
		//alterando o padrão da data
		list($v_s_dia, $v_s_mes, $v_s_ano) = explode("/",$p_s_funcDtInc);
		$p_s_funcDtInc = "$v_s_ano-$v_s_mes-$v_s_dia";
		
		$p_s_query = "INSERT INTO funcionarios (func_depcod, func_nome, func_login, func_senha, func_email, func_dtinc) VALUES 
		              ('$p_s_funcDepCod', '$p_s_funcNome', '$p_s_funcLogin', '$p_s_funcSenha', '$p_s_funcEmail', '$p_s_funcDtInc')";
						  
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	//Método para adicionar Administrador
	function addAdm($p_s_funcCod, $p_s_funcDepCod)
	{
		$p_s_query = "INSERT INTO administradores (adm_funccod, adm_funcdepcod) VALUES 
		              ('$p_s_funcCod', '$p_s_funcDepCod')";
						  
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	//Método para excluir o administrador selecionado
	function delAdm($p_s_admCod)
	{
		$p_s_query = "DELETE FROM administradores 
		              WHERE adm_cod = '$p_s_admCod'";
						  
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	//Método para atualizar dados do funcionário
	function alterUser($p_s_funcCod, $p_s_funcDepCod, $p_s_funcNome, $p_s_funcLogin, $p_s_funcSenha, $p_s_funcEmail)
	{
		$p_s_query = "UPDATE funcionarios SET func_depcod = '$p_s_funcDepCod', func_nome = '$p_s_funcNome', 
		              func_login = '$p_s_funcLogin', func_senha = '$p_s_funcSenha', func_email = '$p_s_funcEmail' 
						  WHERE func_cod = '$p_s_funcCod' AND func_depcod = '$p_s_funcDepCod'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
	
	//Método para excluir um funcionário existente
	function delUser($p_s_funcCod, $p_s_funcDepCod)
	{
		$p_s_query = "DELETE FROM funcionarios WHERE func_cod = '$p_s_funcCod' 
		              AND func_depcod = '$p_s_funcDepCod'";
		
		if(mysql_query($p_s_query))
			return true;
		else
			return false;
	}
}
?>