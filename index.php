<?php
/**
 * 
 * Redirecionador
 * @author Edy Segura, infoedy@gmail.com
 *  
 */

$sFileName = 'paginas/index.php';

if(file_exists($sFileName)) {
	header("Location: paginas/index.php");
	exit;
}
else {
	require('paginas/cfg_config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
<head>
<title><?php echo $c_s_titulo; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<!-- Folhas de estilo para padronização -->
<link href="css/sisfacil.css" rel="stylesheet" type="text/css" title="Padrão" />

</head>
<body>

<div align="center">
	<!-- Divisão do header -->
	<div id="header">
		&nbsp;
	</div>
	
	<!-- Divisão do corpo -->
	<div id="corpo">
		<p>Estamos em manutenção</p>
	</div>

  	<!-- Divisão do corpo -->
	<div id="footer">
		<?php echo $c_s_footer; ?>
	</div>
</div>

</body>
</html>
<?php } ?>
