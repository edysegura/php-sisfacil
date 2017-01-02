/*
Nome do Script : COMMON.JS
Autor(es)      : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data           : 22 de Setembro de 2004.
Versão         : 1.0
Parâmetros     : Nenhum.
Descrição      : Biblioteca de scripts comuns.
*/

//----------------------------------------------------------------------------------------------------------

/*
Função          : goPrinc
Autor           : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data de início  : 22 de Setembro de 2004.
Data de término : 22 de Setembro de 2004.
Atualização     :
Descrição       : Desabilita a borda de focus dos links e dos botões.
Parametros      : Nenhum.
Retorno         : Nenhum.
*/
function goPrinc(sid)
{
	document.location = 'pgn_principal.php?sid='+sid;
}

//----------------------------------------------------------------------------------------------------------

/*
Função          : noFocus
Autor           : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data de início  : 22 de Setembro de 2004.
Data de término : 22 de Setembro de 2004.
Atualização     :
Descrição       : Desabilita a borda de focus dos links e dos botões.
Parametros      : Nenhum.
Retorno         : Nenhum.
*/
function noFocus()
{
	if(document.getElementById)
	{
		var v_ob_links  = document.getElementsByTagName('a');
		var v_ob_inputs = document.getElementsByTagName('input');
		var v_i_nLinks  = parseInt(v_ob_links.length);
		var v_i_nInputs = parseInt(v_ob_inputs.length);
	
		for(i=0; i<v_i_nLinks; i++)
			v_ob_links[i].onfocus = new Function("if(this.blur)this.blur();");
			
		for(i=0; i<v_i_nInputs; i++)
		{
			if(v_ob_inputs[i].type=='button' || v_ob_inputs[i].type=='submit' || 
				v_ob_inputs[i].type=='reset' || v_ob_inputs[i].type=='image')
				v_ob_inputs[i].onfocus = new Function("if(this.blur)this.blur();");
		}
	}
}

//----------------------------------------------------------------------------------------------------------

/*
Função          : isEmpty
Autor           : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data de início  : 23 de Setembro de 2004.
Data de término : 23 de Setembro de 2004.
Atualização     :
Descrição       : Funcão de uso geral para ver se um valor de entrada foi realmente inserido.
Parametros      : Nenhum.
Retorno         : Nenhum.
*/
function isEmpty(p_s_input)
{
	if(p_s_input == null || p_s_input == "")
	{
		return true;
	}
	return false; 
}

//----------------------------------------------------------------------------------------------------------

/*
Função          : isBlank
Autor           : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data de início  : 27 de Setembro de 2004.
Data de término : 27 de Setembro de 2004.
Atualização     :
Descrição       : Funcão de uso geral para ver se o valor de entrada é um monte de espaços.
Parametros      : Nenhum.
Retorno         : Nenhum.
*/
function isBlank(p_s_input)
{ 
	for(i=0; i<p_s_input.length;i++)
	{ 
		var v_s_char = p_s_input.charAt(i);
		if((v_s_char!=" ") && (v_s_char!="\t") && (v_s_char!="\n"))
		{ 
			return false;
		} 
		return true;
	} 
}

//----------------------------------------------------------------------------------------------------------

/*
Função          : isPosNumber
Autor           : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data de início  : 24 de Setembro de 2004.
Data de término : 24 de Setembro de 2004.
Atualização     :
Descrição       : Funcão verefica se o que está sendo informado é um número inteiro positivo.
Parametros      : p_o_evt.
Retorno         : true ou false.
*/
function isPosNumber(p_ob_evt)
{
	p_ob_evt = (p_ob_evt) ? p_ob_evt : window.event; //verifica se há algum evento no p_ob_evt.
	var v_s_charCode = (p_ob_evt.which) ? p_ob_evt.which : p_ob_evt.keyCode; //pega o código do caractere.
	var v_ob_msgSts = document.getElementById('msgStatus');
	var v_s_msg = "Este campo aceita somente números inteiros.";
	
	if(v_s_charCode > 31 && (v_s_charCode < 48 || v_s_charCode >57))
	{
		if(v_ob_msgSts)
			v_ob_msgSts.innerHTML = v_s_msg;
		else
			window.status = v_s_msg;
		return false;
	}
	
	if(v_ob_msgSts)
		v_ob_msgSts.innerHTML = '&nbsp;';
	else
		window.status = "";

	return true;
}

//----------------------------------------------------------------------------------------------------------

/*
Função          : isPosInteger
Autor           : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data de início  : 24 de Setembro de 2004.
Data de término : 24 de Setembro de 2004.
Atualização     :
Descrição       : Funcão de uso geral para ver se uma entrada numérica suspeita é um inteiro positivo.
Parametros      : p_s_inputVal.
Retorno         : true ou false.
*/
function clearMsgSts(v_s_cmpValue)
{
	var v_ob_msgStatus = document.getElementById('msgStatus');
	if(!isEmpty(v_s_cmpValue))
		v_ob_msgStatus.innerHTML = '&nbsp;';
}

//----------------------------------------------------------------------------------------------------------

/*
Função          : isPosInteger
Autor           : Ed. David Segura (wdedy@uol.com.br, edysegura@gmail.com).
Data de início  : 24 de Setembro de 2004.
Data de término : 24 de Setembro de 2004.
Atualização     :
Descrição       : Funcão de uso geral para ver se uma entrada numérica suspeita é um inteiro positivo.
Parametros      : p_s_inputVal.
Retorno         : true ou false.
*/
function exbOcu(p_ob_obj, p_ob_link, p_s_txtLnk)
{
	var v_ob_obj  = document.getElementById(p_ob_obj);
	var v_ob_link = document.getElementById(p_ob_link);
	
	//alert([v_ob_obj.tagName, v_ob_link.id, p_s_txtLnk].join("\n"));
	
	if(v_ob_obj.style.display == 'none')
	{
		v_ob_obj.style.display = '';
		v_ob_link.innerHTML = 'Ocultar '+ p_s_txtLnk;
	}
	else
	{
		v_ob_obj.style.display = 'none';
		v_ob_link.innerHTML = 'Exibir '+ p_s_txtLnk;
	}

}

//----------------------------------------------------------------------------------------------------------