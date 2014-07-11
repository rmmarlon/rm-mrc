function visualizaSenha(){
	if($('#visSenha').is(':checked')){ 
		document.getElementById('senha').type = 'text';
	} else{ 
		document.getElementById('senha').type = 'password'; 
	}
}
// JavaScript Document
// JavaScript Document
$(document).ready(function(){
	$(".phone").setMask("phone");
	$(".cpf").setMask("cpf");
	$(".anoSemestre").setMask("anoSemestre");
	$(".cnpj").setMask("cnpj");
	$(".planoconta").setMask("planoconta");
	$(".date").setMask("date");
	$(".cep").setMask("cep");
	$(".time").setMask("time");
	$(".cc").setMask("cc");
	$(".integer").setMask("integer");
	$(".decimal").setMask("decimal");
	$(".percentual").setMask("percentual");
	$(".signed-decimal").setMask("signed-decimal");
	//$(".cpf").css("width", "8em");
	$(".date").css("width", "6.15em");
	$(".phone").css("width", "100px");
	$(".time").css("width", "40px");
	$(".anoSemestre").css("width", "50px");
	$(".decimal").css("width", "80px");
	$(".percentual").css("width", "40px");
	$("input:disabled + span").css("color", "#F00");
	$("tbody > tr:even").css("background-color","#FFF");

	$('.date').live("focus", function(){
		$("div").remove(".calendario");
		dataCSR = new Date();
		var dataPadraoCalendario = $(this).val() == '' ? dataCSR.getDate()+'/'+(dataCSR.getMonth()+1)+'/'+dataCSR.getFullYear() : $(this).val();
		$(this).calendario({ 
			target:'#'+$(this).attr("id"),
			top:0,
			left:80,
			minDate:$(this).attr("minDate"),//Padrão: d/m/Y
			maxDate:$(this).attr("maxDate"),
			dateDefault:dataPadraoCalendario
		});
	});
	
	$(".date").keydown(function(e) {
		if($(".calendario").is(":visible")){
			$("div").remove(".calendario");
		}
	});
	/*BALAO NOVO*/
	/*BALÃO*/
    //Tooltips
	$(".tip_trigger").hover(function(){
		tip = $(this).find('.tip');
		tip.show(); //Show tooltip
	}, function() {
		tip.hide(); //Hide tooltip		  
	}).mousemove(function(e) {
		/* ANTIGOvar mousex = e.pageX + 20; //Get X coodrinates*/
		var mousex = $(this).offset().left;//Get X coodrinates
		/*ANTIGO var mousey = e.pageY + 20; //Get Y coordinates*/
		var mousey = $(this).offset().top + $(this).height() + 2; //Get Y coordinates
		var tipWidth = tip.width(); //Find width of tooltip
		var tipHeight = tip.height(); //Find height of tooltip
		//Distance of element from the right edge of viewport
		var tipVisX = $(window).width() - (mousex + tipWidth);
		//Distance of element from the bottom of viewport
		var tipVisY = $(window).height() - (mousey + tipHeight);

		if ( tipVisX < 20 ) { //If tooltip exceeds the X coordinate of viewport
			mousex = (mousex + $(this).height()+(tipWidth - mousex + $(this).height())) - tipWidth;
		} if ( tipVisY < 20 ) { //If tooltip exceeds the Y coordinate of viewport
			mousey = $(this).offset().top - (($(this).height()*2) + 6);
		} 
		tip.css({  top: mousey, left: mousex });
	});
	/*FIM BALAO NOVO*/
});
	//FUNÇAO DO BALAO
	function showToolTip(e,text){
		if(document.all)e = event;
		
		var obj = document.getElementById('bubble_tooltip');
		var obj2 = document.getElementById('bubble_tooltip_content');
		obj2.innerHTML = text;
		obj.style.display = 'block';
		var st = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
		if(navigator.userAgent.toLowerCase().indexOf('safari')>=0)st=0; 
		var leftPos = e.clientX - 100;
		if(leftPos<0)leftPos = 0;
		obj.style.left = leftPos + 'px';
		obj.style.top = e.clientY - obj.offsetHeight - 1 + st + 'px';
	}	
	
	function hideToolTip()
	{
		document.getElementById('bubble_tooltip').style.display = 'none';
		
	}
	// FIM DA FUNCAO DO BALAO
function AbrirAjax(){
	var xmlhttp;

	try{
		//Para o internet explorer 7 ou menor
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e){
		try{
			//IE 8
			xmlhttp = getXMLHTTP();
		}
		catch(e){
			try{
				xmlhttp = new XMLHttpRequest();
			} catch(e){
				alert("Seu navegador não tem recursos de Ajax");
				xmlhttp = null;
			}
		}
	}
	return xmlhttp;
}

function number_format( number, decimals, dec_point, thousands_sep ) {
    
	var n = number, prec = decimals;
	 n = !isFinite(+n) ? 0 : +n;
	 prec = !isFinite(+prec) ? 0 : Math.abs(prec);
	 var sep = (typeof thousands_sep == "undefined") ? ',' : thousands_sep;
	 var dec = (typeof dec_point == "undefined") ? '.' : dec_point;
 
	 var s = (prec > 0) ? n.toFixed(prec) : Math.round(n).toFixed(prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
 
	 var abs = Math.abs(n).toFixed(prec);
	 var _, i;
 
	 if (abs >= 1000) {
		  _ = abs.split(/\D/);
		  i = _[0].length % 3 || 3;
 
		  _[0] = s.slice(0,i + (n < 0)) +
				  _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
 
		  s = _.join(dec);
	 } else {
		  s = s.replace('.', dec);
	 }
 
	 return s;
}

function retiraMascara(valorOriginal){
	 var valor = new String(valorOriginal);
	 
	 valor = valor.replace(/\./g, '');
	 valor = valor.replace(/\,/g, '.');
	 
	 return valor;
}

function corrigeValor(valorOriginal){
	 var valor = new String(valorOriginal);
	 
	 valor = valor.replace(/\./g, '');
	 valor = valor.replace(/\,/g, '.');
	 
	 return valor;
}
function subtrairData(dataInicial,dataFinal) {
    var d1=new Date(dataInicial.substr(6,4), dataInicial.substr(3,2)-1, dataInicial.substr(0,2));
    var d2=new Date(dataFinal.substr(6,4), dataFinal.substr(3,2)-1, dataFinal.substr(0,2));
    return Math.ceil((d2.getTime()-d1.getTime())/1000/60/60/24);
}
function comparaData(dataInicial, dataFinal){
	var retorno = true;
	
	if (dataInicial == '' || dataFinal == ''){
		retorno = false;
	}
	
	if (retorno){
		var nova_data1 = parseInt(dataInicial.split("/")[2].toString() + dataInicial.split("/")[1].toString() + dataInicial.split("/")[0].toString());
		var nova_data2 = parseInt(dataFinal.split("/")[2].toString() + dataFinal.split("/")[1].toString() + dataFinal.split("/")[0].toString());

		if (nova_data2 < nova_data1){
		  retorno = false;
		} 
	}
	
	return retorno;
}
function comparaHora(horaInicial, horaFinal){
	var retorno = true;
	
	if (horaInicial.length < 5 || horaFinal < 5){
		retorno = false;
	}
	
	if (retorno){
		var hInicial = parseInt(horaInicial.substr(0,2));
		var hFinal = parseInt(horaFinal.substr(0,2));
		
		var mInicial = parseInt(horaInicial.substr(3,2));
		var mFinal = parseInt(horaFinal.substr(3,2));
		
		if(hInicial > hFinal){
			retorno = false;
		} else if(hInicial == hFinal
				 && mInicial > mFinal){
			retorno = false;
		}
	}
	
	return retorno;
}
function roundNumber(num, dec) {
	var result = Math.ceil(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}
$(document).ready(function() {
	/*$(document).mousedown( function(e) {
		if(e.button == 2){
			var baseName = window.location.pathname.substring(window.location.pathname.lastIndexOf("/")+1) || "index.html";
			alert("Favor não utilizar o botão direito! \n SUPORTE - PAGINA: " + baseName);
		}
	});*/
	
	$('a[name=modal]').click(function(e) {
		e.preventDefault();
		
		var id = $(this).attr('href');
		var maskHeight = '100%';
		var maskWidth = '100%';
		$("body").append('<div id="mask"></div>');
		$('#mask').css({'width':maskWidth,'height':maskHeight});

		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();

		//$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		$(id).slideDown();
		$(id).animate({'top':'15%'});
	
	});
	
	$('.window .close').live("click",function (e) {
		e.preventDefault();
		var id = $('a[name=modal]').attr('href');
		$(id).slideUp(500, function(){
			$('div#mask').remove();
			$('.window').hide();
			$(id).css({'top':'0%'});
		});
	});
	$('a[name=modalB]').click(function(e) {
		e.preventDefault();
		
		var id = $(this).attr('href');
		var maskHeight = '100%';
		var maskWidth = '100%';
		$("body").append('<div id="maskB"></div>');
		$('#maskB').css({'width':maskWidth,'height':maskHeight});

		$('#maskB').fadeIn(1000);	
		$('#maskB').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();

		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		$(id).fadeIn(2000); 
	
	});
	
	$('.windowB .closeB').click(function (e) {
		e.preventDefault();
		$('#maskB').remove();
		$('.windowB').hide();
	});
});