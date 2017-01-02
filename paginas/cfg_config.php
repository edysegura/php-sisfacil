<?
/*
Nome do Script : CFG_CONFIG.PHP
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 12 de Outubro de 2004.
Verso         : 1.0
Parmetros     : Nenhum.
Descrio      : Arquivo contendo variaveis globais.
*/

$c_s_titulo = "FÁCIL! - Sistema de ocorrências";
$c_s_footer = "FÁCIL! - Sistema de ocorrências<br />FAITEC 2004";

function date_diff($p_s_data1, $p_s_data2)
{
        $v_i_segundos = strtotime($p_s_data2)-strtotime($p_s_data1);
        $v_i_dias = intval($v_i_segundos/86400); //86400 = quantidade de segundos em 1 dia.

        $v_s_dias = $v_i_dias." dias";
        return $v_s_dias;
}

function row_color($p_i_linha)
{
   $bgcolor1 = 'rowcolor1';
   $bgcolor2 = 'rowcolor2';

   if(($p_i_linha%2)==0)
      return $bgcolor1;
   else
      return $bgcolor2;
}
?>
