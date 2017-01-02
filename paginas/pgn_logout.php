<?
/*
Nome do Script : LOGIN.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 13 de Outubro de 2004.
Versгo         : 1.0
Parвmetros     : Nenhum.
Descriзгo      : Script contendo a validaзгo de usuбrio.
*/

//inicializa a sessгo
session_start();

//destrуi as variбveis
unset($_SESSION['funcLogin']);
unset($_SESSION['funcNome']);
unset($_SESSION['funcSenha']);
unset($_SESSION['funcCod']);
unset($_SESSION['funcDepCod']);
unset($_SESSION['isAdm']);

//Libera todas as variбveis de sessгo
session_unset();
//destruiзгo da sessгo.
session_destroy();
//redireciona para a tela de login
header("Location: index.php");
?>