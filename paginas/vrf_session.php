<?
//inicializa a sess�o
session_start();

//se n�o tiver vari�veis registradas
//retorna para a tela de login
if(!isset($_SESSION['funcLogin']) && !isset($_SESSION['funcSenha']))
   header("Location: index.php");
?>
