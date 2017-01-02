<?
/*
Nome do Script : LOGIN.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Vers�o         : 1.0
Par�metros     : Nenhum.
Descri��o      : Script contendo a valida��o de usu�rio.
*/

//inicializa a sess�o
session_start();

//destr�i as vari�veis
unset($_SESSION['funcLogin']);
unset($_SESSION['funcNome']);
unset($_SESSION['funcSenha']);
unset($_SESSION['funcCod']);
unset($_SESSION['funcDepCod']);
unset($_SESSION['isAdm']);

//Libera todas as vari�veis de sess�o
session_unset();
//destrui��o da sess�o.
session_destroy();
//redireciona para a tela de login
header("Location: index.php");
?>