<?
//inicializa a sessão
session_start();

//se não tiver variáveis registradas
//retorna para a tela de login
if(!isset($_SESSION['funcLogin']) && !isset($_SESSION['funcSenha']))
   header("Location: index.php");
?>
