<?

    if(isset($_POST['veiculos_selecionados']) && $_POST['veiculos_selecionados'] != '')
    {
        include_once('../libs/classes/PreVenda.class.php');
        $classPreVenda = new PreVenda();

        $_SESSION['total_pagamento'] =0;
        $total_pagamento = 0;

        $veic_cod = $_POST['veiculos_selecionados'];

        $preVendas = $classPreVenda->getPrevendas($_SESSION["ss_empresa_conectada"],$_POST['veiculos_selecionados']);
        $preVenda = $preVendas[0];


	    echo "<div id='debugador' style='display:none'>".print_r($preVenda,true)."</div>";


        $data_venda =explode('-',$preVenda['data_venda']);
        $data_venda = $data_venda[2].'/'.$data_venda['1'].'/'.$data_venda[0];
        $posEstoque = $preVenda['posicao_estoque'];
        $vendedor = $preVenda['vendedor'];
        $modelo = $preVenda['marc_nome'].' '.$preVenda['modelo'].' - '.$preVenda['veic_placa'];

        $pess_nome = $preVenda['pess_nome'];
        $clie_cod = $preVenda['clie_cod'];
        $preco_venda = $preVenda['preco_venda'];
        $marc_cod = $preVenda['marc_cod'];
        $core_cod = $preVenda['core_cod'];
        $obs_canal = $preVenda['obs_canal'];
        $observacao_venda = $preVenda['observacao_venda'];
        $valor_transferencia = $preVenda['valor_transferencia'];
        $id_canal = $preVenda['id_canal'];
        $clientedocumento_cod = $preVenda['clientedocumento_cod'];
        $loginAdm = $preVenda['loginAdm'];
        $senhaAdm = $preVenda['senhaAdm'];


        $_SESSION['pagamentos'] = $preVenda['pagamentos'];
        foreach ($_SESSION['pagamentos'] as $key => $pag) {

            $pag['valor'] = number_format($pag['valor'],2,'.','');
            if ($pag['tipo'] == "TRO") {
                $total_pagamento = $total_pagamento - $pag['valor'];
            } else {
                $total_pagamento = $total_pagamento + $pag['valor'];
            }
        }

        $_SESSION['total_pagamento'] = $total_pagamento;

    }
    else
    {   
        $marc_cod = "";
        $posEstoque = 1;
        $preco_venda = 0;
        $_SESSION['total_pagamento'] = "0";

        if ($_SESSION['pagamentos']) {
            foreach ($_SESSION['pagamentos'] as $key => $pag) {

                if ($pag['tipo'] == "TRO") {
                    $total_pagamento = $total_pagamento - $pag['valor'];
                } else {
                    $total_pagamento = $total_pagamento + $pag['valor'];
                }
            }
            $_SESSION['total_pagamento'] = $total_pagamento;
        }


        $cliente = "";
        $data_venda = date("d/m/Y");

        if (isset($_POST["clie_cod"]) && $_POST["clie_cod"] != "") {
            $cliente = $_POST["clie_cod"];
            $data_venda = $_POST["data_venda"];
        }

        if (isset($_POST["acao"]) && $_POST["acao"] == "alterar") {
            $cliente = $_SESSION["ss_estoque_cliecod"];
            $data_venda = $_SESSION["ss_estoque_datavenda"];
            $vendedor = $_SESSION["ss_estoque_vendedor"];
            $_SESSION["acao"] = "saida_06.php";
        }

        if ($cliente != "") {
            conectar();

            $sql = "SELECT p.pess_nome, c.clie_cpf_cnpj, p.pess_tipo, p.pess_cod FROM clientes c INNER JOIN pessoas p on (c.pess_cod = p.pess_cod) WHERE c.clie_cod = $cliente AND c.reve_cod = " . $_SESSION["ss_empresa_conectada"] . "";
            $result1 = query($sql);
        }
        $pess_nome = result($result1, 0, "pess_nome"); 
    }

    $preco_venda = strstr($preco_venda,',') ? str_replace(',','.',str_replace('.','',$preco_venda)) : $preco_venda;

?>
<script type="text/javascript" src="../../js/jquery.form.js"></script>
<script type="text/javascript">

    function carregaMarca(id_tpve)
    {
        try{
            if(id_tpve!="")
            {
                carregaModelo(-1);
                var oHTTPRequest = createXMLHTTP();
                oHTTPRequest.open("post", "../ajax/ajax_marcas.php", true);
                oHTTPRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                oHTTPRequest.onreadystatechange=function() {
                    if (oHTTPRequest.readyState==4){
                        document.getElementById("div_marca").innerHTML = URLDecode(oHTTPRequest.responseText);
                    }
                }
                oHTTPRequest.send("id_tpve=" + id_tpve);
            }
        }catch(e){alert(e);}
    }

    function carregaModelo(id_marca,id_tpve)
    {
    try{
        if(id_marca!="")
        {
            var oHTTPRequest = createXMLHTTP();
            var campos = {
                mode_cod: document.getElementById("mode_cod")
              };
            oHTTPRequest.open("post", "../ajax/ajax_modelos.php", true);
            oHTTPRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            oHTTPRequest.onreadystatechange=function() {
                if (oHTTPRequest.readyState < 4) {
                    //campos.mode_cod.disabled = true;
                    $('#mode_cod').html = "<option value=''>carregando.......</option>";
                 } else if (oHTTPRequest.readyState==4){
                    document.getElementById("div_modelo").innerHTML = URLDecode(oHTTPRequest.responseText);
                }
            }
            oHTTPRequest.send("id_marca=" + id_marca + "&id_tpve=" + id_tpve);
        }
    }catch(e){alert(e);}

    }


    jQuery.fn.outerHTML = function() {
        return jQuery('<div />').append(this.eq(0).clone()).html();
    };

    function replaceAll(string, token, newtoken) {
        while (string.indexOf(token) != -1) {
            string = string.replace(token, newtoken);
        }
        return string;
    }  



    var arrayFormasPagamento = <?=json_encode($_SESSION['pagamentos']);?>

    $(document).ready(function() {
		$( "#cliente_doc_nome" ).autocomplete({
                    serviceUrl:'../ajax/clientes.buscar.php',
                    minChars:2,
                    zIndex: 9999,
                    width:450,
                    deferRequestBy: 300, //miliseconds
                    noCache: true, //default is false, set to true to disable caching
                    onSelect: function(value, data){
                        if(data.id!='' && data.id > 0) {
                            $('#cliente_doc_cod').val(data.id);
                        } else if(data.id == 0){
                            $('#cliente_doc_cod').val('');
                            $("#cliente_doc_nome").val('');
                            return false;
                        }
                    }
            });

            $('.forma_pagamento_td').each(function(){
                    $(this).css('display','none');
            });

            $('#incluirFormaPagamento').click(function(){
                    var forma = $('#forma_pagamento').val();
                    //alert(forma);
                   // alert($('#'+forma).html());
                    $('#formularioPagamento').append(
                        $('#'+forma).html()
                    );
			$(document).ready(function(){
				$(this).append('<link rel="stylesheet" type="text/css" href="../css/autocomplete.css" /><script type="text/javascript" src="../js/jquery.autocomplete-min.js" />');
				$(this).append('<script type="text/javascript" src="../js/jquery.form.js" />');
			});
			$( "#cliente_doc_nome" ).autocomplete({
				                    serviceUrl:'../ajax/clientes.buscar.php',
			                    minChars:2,
			                    zIndex: 9999,
			                    width:450,
			                    deferRequestBy: 300, //miliseconds
			                    noCache: true, //default is false, set to true to disable caching
			                    onSelect: function(value, data){
			                        if(data.id!='' && data.id > 0) {
			                            $('#cliente_doc_cod').val(data.id);
			                        } else if(data.id == 0){
			                            $('#cliente_doc_cod').val('');
			                            $("#cliente_doc_nome").val('');
			                            return false;
			                        }
			                    }
			            });


            });

            $('#cancelarPagamento').live('click',function(){
                    $(this).parents('tbody:eq(0)').parents('tbody:eq(0)').remove();

            });

            $('#inserirPagamento').live('click',function(){

                    var options = {
                        success:       showResponse ,
                        url:       '../../ajax/adicionaPagamentoSession.php?valor_venda='+$('#preco_venda').val(),
                        type:      'post'
                    };

                    var form = $(this).parents('form:eq(0)');

                    var funcaoValidacao = $(form).attr('name');

                    //  alert(funcaoValidacao);

                    switch(funcaoValidacao )
                    {
                        case "dinheiro":
                            var validado = dinheiro($(form));
                            break;
                        case "cheque":
                            var validado = cheque(form);
                            break;
                        case "financiamento":
                            var validado = financiamento(form);
                            break;
                        case "veiculo":
                            var validado = veiculo(form);
                            break;
                        case "consorcio":
                            var validado = consorcio(form);
                            break;
                        case "promissoria":
                            var validado = promissoria(form);
                            break;
                        case "credito":
                            var validado = credito(form);
                            break;
                        case "debito":
                            var validado = debito(form);
                            break;
                        case "troco":
                            var validado = troco(form);
                            break;
                        case "ted":
                            var validado = ted(form);
                            break;
                        case "duplicata":
                            var validado = duplicata(form);
                            break;
                        case "boleto":
                            var validado = boleto(form);
                            break;
                        case "desconto":
                            var validado = desconto(form);
                            break;    
                    }

                    if(validado){
                        var valorForm = $(form).find('input[name="valor"]');

                        /*
                        if(funcaoValidacao == 'troco')    {
                        $('#total_pagamento').val(Number($('#total_pagamento').val()) - Number($(valorForm).val().replace(',','.')));
                        } else {
                        $('#total_pagamento').val(Number($('#total_pagamento').val()) + Number($(valorForm).val().replace(',','.')));
                        }
                        */

                        $(this).parents('form:eq(0)').ajaxSubmit(options);
                        $(this).parents('tbody:eq(0)').parents('tbody:eq(0)').remove();

                    }

                    return false;
            });

            $('a[id="excluirPagamento"]').live('click',function(){

                    var link = $(this);
                    var tipo_pagamento = $(this).attr('class');

                    $.post("../../ajax/adicionaPagamentoSession.php",
                        { id:$(this).attr('rel'), acao:"remover" },
                        function(data){
                            var valor = Number($(link).next().html().replace(',','.'));

                            if(tipo_pagamento == 'TRO'){
                                $('#total_pagamento').val(Number($('#total_pagamento').val()) + valor);
                            } else {
                                $('#total_pagamento').val(Number($('#total_pagamento').val()) - valor);
                            }

                            var preco_venda = Number($('#preco_venda').val().replace(',','.')) - Number($('#total_pagamento').val().replace(',','.'));

                            $('#valor_receber').html(float2moeda(preco_venda,2));

                            $('#pagamentos_selecionados').html(data);
                    });

                    return false;
            });

            $('a[id="editarPagamento"]').live('click',function(){

                    $("#formularioPagamento").html('');
                    var link = $(this);
                    var tipoPagamento =$(this).attr('tipoPagamento');
                    var idForma =$(this).attr('rel');
                    var input = "";

                    $.ajax({
                            type : 'POST',
                            url : '/ajax/ajax_modelos_multi.php',
                            dataType : 'html',
                            data: {
                                id_marca:arrayFormasPagamento[idForma].marca, campo:'modelo'
                            },
                            success : function(data){

                                $('#tempFormaPagamento').html($('#'+tipoPagamento).html());

                                var htmlTemp = $('#tempFormaPagamento').html();
                                var htmlModelo = $('#tempFormaPagamento select[name=\'modelo\']').outerHTML();
                                try{
                                    data = decodeURIComponent(data)    
                                }
                                catch(e){
                                    data = data;  
                                }

                                data = replaceAll(data, '+', ' ')
                                data = replaceAll(data, '%28', '(')
                                data = replaceAll(data, '%29', ')')
                                data = replaceAll(data, '%2F', '/')
                                data = replaceAll(data, '%DA', 'Ú')

                                if(arrayFormasPagamento[idForma].tipo == 'VEI'){
                                    htmlTemp = htmlTemp.replace(htmlModelo,data);
                                    $('#tempFormaPagamento').html(htmlTemp);
                                }
                                var $inputs = $('#tempFormaPagamento :input');
                                $inputs.each(function() {
                                        input = this;
                                        $.each(arrayFormasPagamento[idForma], function(i, item) {
                                                if(i == input.name){
                                                    htmlTemp = $('#tempFormaPagamento').html();
                                                    htmlModelo = $('#tempFormaPagamento input[name=\''+input.name+'\']').outerHTML();
                                                    var htmlModeloReplace = htmlModelo;

                                                    htmlModeloReplace = htmlModeloReplace.replace(/value="(([\s\S]|\n)*?)"/img, "");
                                                    htmlModeloReplace = htmlModeloReplace.replace("value",'');

                                                    htmlModeloReplace = htmlModeloReplace.replace("name",'value="'+item+'" name');

                                                    htmlTemp = htmlTemp.replace(htmlModelo,htmlModeloReplace);                                             
                                                    $('#tempFormaPagamento').html(htmlTemp);
                                                }
                                        });
                                });

                                $inputs = $('#tempFormaPagamento select');
                                $inputs.each(function() {
                                        input = this;
                                        $.each(arrayFormasPagamento[idForma], function(i, item) {
                                                if(i == input.name){

                                                    $(input).find('option').each(function() {
                                                            if(String(this.value) == String(item))
                                                                {
                                                                var htmlInput = $(input).html();

                                                                var htmlOp = $(this).outerHTML();
                                                                var htmlOpReplace = $(this).outerHTML();

                                                                htmlOpReplace = htmlOpReplace.replace("value",'selected="selected" value');
                                                                htmlInput = htmlInput.replace(htmlOp,htmlOpReplace);

                                                                $(input).html(htmlInput);
                                                            }
                                                    });
                                                }
                                        });
                                });

                                $("#tempFormaPagamento").find('form').append('<input type="hidden" name="edicaoForma" value="'+idForma+'" />');
                                $("#formularioPagamento").html($("#tempFormaPagamento").html());
                                $("#tempFormaPagamento").html('');

                            }
                    });                                       

                    return false;
            });

            $('#preco_venda').blur(function(){
                    var valor = $(this).val().replace(',','.') - $('#total_pagamento').val();
                    $('#valor_receber').html(float2moeda(valor,2));
                    //$('#preco_venda').val(MascaraMoeda(this,'',',',event));
            });

    });



    function dinheiro(form){

        if($(form).find('#valor').val()=="" || $(form).find('#valor').val()=="0,00")
            {
            alert("Campo obrigatório!");
            $(form).find('#valor').focus();
            return(false);
        }

        return true;
    }

    function cheque(form){

        var ok = true;

        $.each($(form).find('input'),function(index, value)
            {
                if($(this).attr('name')!="fina_descricao" && $(this).attr('name')!="cons_descricao")
                    {
                    if($(this).val()=="")
                        {
                        alert("Campo obrigatório!");
                        $(this).focus();
                        ok = false;
                        return(false);
                    }

                }

                if($(this).attr('name')=='vencimento' && $(this).val().length!=10){
                    alert("Favor informar uma data válida!");
                    $(this).focus();
                    ok = false;
                    return false;
                }
        });

        if(ok){
            return true;
        }
    }

    function financiamento(form){

        var ok = true;

        $.each($(form).find('input,select'),function(index, value)
            {
                if($(this).attr('name')!="fina_descricao" &&
                    $(this).attr('name')!="cons_descricao" &&
                    $(this).attr('name')!="vlr_financiado_tac" &&
                    $(this).attr('name')!="vlr_financiado_retorno" &&
                    $(this).attr('name')!="vlr_financiado_plus")
                    {
                    if($(this).val()=="" || $(this).val()=="0,00")
                        {
                        alert("Campo obrigatório!");
                        $(this).focus();
                        ok = false;
                        return false;
                    }

                }
        });

        if(ok){
            return true;
        }
    }

    function veiculo(form){

        var ok = true;

        $.each($(form).find('input,select:not(.non-required)'),function(index, value)
            {
               if(!$(value).hasClass('non-required'))
               {
                    if($(this).val()=="")
                        {
                        alert("Campo obrigatório!");
                        $(this).focus();
                        ok = false;
                        return false;
                    }
                }
               
        });

        if(ok){
            return true;
        }
    }

    function consorcio(form){

        var ok = true;

        $.each($(form).find('input,select'),function(index, value)
            {
                if($(this).val()=="")
                    {
                    alert("Campo obrigatório!");
                    $(this).focus();
                    ok = false;
                    return false;
                }
        });

        if(ok){
            return true;
        }
    }

    function desconto(form){

        var ok = true;

        $.each($(form).find('input,select'),function(index, value)
            {
                if($(this).val()=="")
                    {
                    alert("Campo obrigatório!");
                    $(this).focus();
                    ok = false;
                    return false;
                }
        });

        if(ok){
            return true;
        }
    }

    function promissoria(form){

        var ok = true;

        $.each($(form).find('input,select'),function(index, value)
            {
                if($(this).val()=="")
                    {
                    alert("Campo obrigatório!");
                    $(this).focus();
                    ok = false;
                    return false;
                }

                if($(this).attr('name')=='vencimento' && $(this).val().length!=10){
                    alert("Favor informar uma data válida!");
                    $(this).focus();
                    ok = false;
                    return false;
                }
        });

        if(ok){
            return true;
        }
    }

    function duplicata(form){

        var ok = true;

        $.each($(form).find('input,select'),function(index, value)
            {
                if($(this).val()=="")
                    {
                    alert("Campo obrigatório!");
                    $(this).focus();
                    ok = false;
                    return false;
                }

                if($(this).attr('name')=='vencimento' && $(this).val().length!=10){
                    alert("Favor informar uma data válida!");
                    $(this).focus();
                    ok = false;
                    return false;
                }
        });

        if(ok){
            return true;
        }
    }
    
    function boleto(form){

        var ok = true;

        $.each($(form).find('input,select'),function(index, value)
            {
                if($(this).val()=="")
                    {
                    alert("Campo obrigatório!");
                    $(this).focus();
                    ok = false;
                    return false;
                }

                if($(this).attr('name')=='vencimento' && $(this).val().length!=10){
                    alert("Favor informar uma data válida para o boleto!");
                    $(this).focus();
                    ok = false;
                    return false;
                }
        });

        if(ok){
            return true;
        }
    }
    
    function credito(form){

        var ok = true;

        $.each($(form).find('input,select'),function(index, value)
            {
                if($(this).val()=="")
                    {
                    alert("Campo obrigatório!");
                    $(this).focus();
                    ok = false;
                    return false;
                }

                if($(this).attr('name')=='vencimento' && $(this).val().length!=10){
                    alert("Favor informar uma data válida!");
                    $(this).focus();
                    ok = false;
                    return false;
                }
        });

        if(ok){
            return true;
        }
    }

    function debito(form){

        var ok = true;

        $.each($(form).find('input,select'),function(index, value)
            {
                if($(this).val()=="")
                    {
                    alert("Campo obrigatório!");
                    $(this).focus();
                    ok = false;
                    return false;
                }

                if($(this).attr('name')=='vencimento' && $(this).val().length!=10){
                    alert("Favor informar uma data válida!");
                    $(this).focus();
                    ok = false;
                    return false;
                }

        });

        if(ok){
            return true;
        }
    }


    function troco(form){

        var ok = true;

        $.each($(form).find('input,select'),function(index, value)
            {
                if($(this).val()=="")
                    {
                    alert("Campo obrigatório!");
                    $(this).focus();
                    ok = false;
                    return false;
                }

                if($(this).attr('name')=='vencimento' && $(this).val().length!=10){
                    alert("Favor informar uma data válida!");
                    $(this).focus();
                    ok = false;
                    return false;
                }
        });

        if(ok){
            return true;
        }
    }

    function ted(form){

        var ok = true;

        $.each($(form).find('input,select'),function(index, value)
            {
                if($(this).val()=="")
                    {
                    alert("Campo obrigatório!");
                    $(this).focus();
                    ok = false;
                    return false;
                }
                if($(this).attr('name')=='vencimento' && $(this).val().length!=10){
                    alert("Favor informar uma data válida!");
                    $(this).focus();
                    ok = false;
                    return false;
                }
        });

        if(ok){
            return true;
        }
    }
    
    function calculaValorTotalPromissoria(){

        var quantidade = parseInt($('#promissoria_numero').val());
        var valor_unitario = $('#valor_unitario').val().replace(",", ".");
        var total = quantidade * valor_unitario;
        total = total.toFixed(2);
        $('#valor').attr('value', total);
        
    }
    
    function calculaValorTotalDuplicata(){

        var quantidade = parseInt($('#duplicata_numero').val());
        var valor_unitario = $('#valor_unitario').val().replace(",", ".");
        var total = quantidade * valor_unitario;
        total = total.toFixed(2);
        $('#valor').attr('value', total);
        
    }


    function showResponse(responseText, statusText, xhr, $form)  {
        retorno = responseText.split('||');
        $('#pagamentos_selecionados').html(retorno[0]);
        $('#total_pagamento').val(retorno[1]);
        $('#valor_receber').html(retorno[2]);

        $.get('/ajax/ajax_pagamentos_json.php', function(data) {
                arrayFormasPagamento = JSON.parse(data);
            }, "json");
    }

$(document).ready(function() {
	$('#table-pagamento').css('display', '');
});


</script>
<!-- fim box -->

<table cellpadding="3" class="form" style='display:none' id='table-pagamento'>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr bgcolor="#eeeeee">
    <td height="25" colspan=2 bgcolor="#eeeeee"><strong>Dados Saída</strong></td>
  </tr>
  <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td class="text">Data da Venda:</td>
    <td ><input type="text" id="data_venda" name="data_venda" value="<?= $data_venda ?>" size="10" class="campodataOnblur" onBlur="javascript: this.className='campodataOnblur';" onFocus="javascript: this.className='campodataOnfocus';">
      
      <!--  <a href="" onclick="cal.select(document.forms['f1'].data_venda,'anchor1','dd/MM/yyyy'); return false;" name="anchor1" id="anchor1"><img src="../i/ic_calendario.png" width="16" height="18" border="0" align="top"></a> --> 
      <img src="../i/ic_calendario.png" width="16" height="18" border="0" align="top" onclick="javascript:return showCalendar('data_venda', 'dd/mm/y');" style="cursor:pointer;"></td>
  </tr>
  <tr>
    <td class="text"><span class="obrigatorio">*</span> Posição no Estoque:</td>
    <td><select onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur" name="posicao_estoque" id="posicao_estoque">
        <option <?=$posEstoque == 1? 'selected="selected"':''?> value="1">1</option>
        <option <?=$posEstoque == 2? 'selected="selected"':''?> value="2">2</option>
        <option <?=$posEstoque == 3? 'selected="selected"':''?> value="3">3</option>
        <option <?=$posEstoque == 4? 'selected="selected"':''?> value="4">4</option>
        <option <?=$posEstoque == 5? 'selected="selected"':''?> value="5">5</option>
        <option <?=$posEstoque == 6? 'selected="selected"':''?> value="6">6</option>
        <option <?=$posEstoque == 7? 'selected="selected"':''?> value="7">7</option>
        <option <?=$posEstoque == 8? 'selected="selected"':''?> value="8">8</option>
        <option <?=$posEstoque == 9? 'selected="selected"':''?> value="9">9</option>
        <option <?=$posEstoque == 10? 'selected="selected"':''?> value="10">10</option>
      </select>
      <span class="barNav"><a href="#"><img border="0" align="top" width="17" height="19" src="../i/bt_info.gif"><span>Neste Campo é posivel determinar a posição do Veiculo no Estoque ou em outra Loja do grupo. A regra pode ser montada conforme necessidade do Cliente.</span></a></span></td>
  </tr>
  <tr>
    <td class="text"><span class="obrigatorio">*</span> Vendedor:</td>
    <td ><select name="vendedor" id="vendedor" class="selectOnblur" onBlur="javascript: this.className='selectOnblur';" onFocus="javascript: this.className='selectOnfocus';">
        <option value="">-- Selecione o vendedor --</option>
        <?
                    //busca vendedores
                    $sql = "SELECT f.func_cod, p.pess_nome FROM funcionarios f INNER JOIN pessoas p on (f.pess_cod = p.pess_cod) WHERE f.reve_cod = " . $_SESSION["ss_empresa_conectada"] . " AND func_tipo='t' AND func_status = 't' ORDER BY p.pess_nome";
                    $result2 = query($sql);
                    for ($i = 0; $i < num_rows($result2); $i++) {
                    ?>
        <option <? if ($vendedor == result($result2, $i, "func_cod")) {
                                echo "selected";
                        } ?> value="<?= result($result2, $i, "func_cod") ?>">
        <?= result($result2, $i, "pess_nome") ?>
        </option>
        <?
                    }
                ?>
      </select>
      <? if ($_SESSION["ss_usuario_grupo"] != 80) {
                ?>
      <a href="javascript:popup('../popup/funcionarios.php', 'faq', 800, 650);" name="cadastrar_funcionarios"><img src="../i/ic_pesquisa.png" align="top" border="0"></a>
      <? } ?></td>
  </tr>
  <tr>
    <td class="text"><span class="obrigatorio">*</span> Veículo:</td>
    <td ><input type="text" autocomplete="off" id="modelo" value="<?= $modelo ?>" name="modelo" size="47" maxlength="150" class="campoOnblur" onBlur="javascript: this.className='campoOnblur';" onFocus="javascript: this.className='campoOnfocus';" />
      <input type="hidden" name="veic_cod" id="veic_cod" value="<?= $veic_cod ?>" /></td>
  </tr>
  <tr>
    <td></td>
    <td class="text text-danger">Digite o modelo ou a placa para localizar o veiculo.</td>
  </tr>
  <tr>
    <td class="text">Cliente:</td>
    <td><input type="text" autocomplete="off" value="<?= $pess_nome; ?>" name="clie_nome" id="clie_nome" size="47" maxlength="150" class="campoOnblur" onBlur="javascript: this.className='campoOnblur';" onFocus="javascript: this.className='campoOnfocus';">
      <input type="hidden" name="clie_cod" id="clie_cod" value="<?= $clie_cod ?>" /></td>
  </tr>
  <tr>
    <td></td>
    <td class="text text-danger">Digite no mínimo 3 caracteres para localizar o cliente (nome ou cpf).</td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr bgcolor="#eeeeee">
    <td height="25" colspan="2" bgcolor="#eeeeee"><strong>Valor da venda e forma de pagamento</strong></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td class="text">Valor da venda:</td>
    <td>R$&nbsp;<input type="text" name="preco_venda" id="preco_venda" value="<?= number_format($preco_venda, 2, ",", "") ?>" maxlength="30" class="campo2Onblur floatval" onBlur="javascript: this.className='campo2Onblur';" onFocus="javascript: this.className='campo2Onfocus';" onKeyPress="javascript: return MascaraMoeda(this,'',',',event)" >
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      A Receber: <span id="valor_receber" class="text-danger">R$
      <?= number_format(($_SESSION['total_pagamento']) ? ($preco_venda - $_SESSION['total_pagamento']) : "00.000,00", '2') ?>
      </span></td>
    <input type="hidden" name="total_pagamento" id="total_pagamento" value="<?= $_SESSION['total_pagamento'] ?>">
    <input type="hidden" name="valor_minimo" id="valor_minimo" value="">
  </tr>
  <tr>
    <td class="text">Forma de Pagamento:</td>
    <td class="resultadolink"><select id="forma_pagamento" name="forma_pagamento" class="selectOnblur" onBlur="javascript: this.className='selectOnblur';" onFocus="javascript: this.className='selectOnfocus';">
        <option value="">-- Selecione a forma de pagamento --</option>
        <option value="BOL">Boleto bancário</option>
        <option value="CAR">Cartão de Crédito</option>
        <option value="DEB">Cartão de Débito</option>
        <option value="CHE">Cheque</option>
        <option value="CON">Consórcio</option>
        <option value="DES">Desconto</option>
        <option value="DIN">Dinheiro</option>
        <option value="DUP">Duplicata</option>
        <option value="FIN">Financiamento</option>
        <option value="PRO">Promissória</option>
        <option value="TED">TED/DOC/Transferência Bancária</option>
        <option value="TRO">Troco na Troca</option>
        <option value="VEI">Veículo na Troca</option>
      </select>
      <a href="javascript:;" id="incluirFormaPagamento">Incluir</a></td>
  </tr>
  <tr>
    <td colspan="2"><table class="formtxt" id="formularioPagamento" cellspacing="0" cellpadding="1">
      </table></td>
  </tr>
  <tr>
    <td><table class="forma_pagamento_td form" id="DIN">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Dinheiro</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="dinheiro" method="post">
              <input type="hidden" name="tipo" value="DIN">
              <table class="formtxt">
                <tr>
                  <td class="text">Valor:</td>
                  <td><input type="text" value="0,00" onfocus="javascript: this.className='campo2onfocus';" onblur="javascript: this.className='campo2onblur';" class="campo2onblur floatval" maxlength="15" name="valor" id="valor"  onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                  <td class="formdivh"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                    <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>

      <table class="forma_pagamento_td form" id="DES">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Desconto</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="desconto" method="post">
              <input type="hidden" name="tipo" value="DES">
              <table class="formtxt">
                <tr>
                  <td class="text">Valor:</td>
                  <td><input type="text" value="0,00" onfocus="javascript: this.className='campo2onfocus';" onblur="javascript: this.className='campo2onblur';" class="campo2onblur floatval" maxlength="15" name="valor" id="valor"  onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                  <td class="formdivh"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                    <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>
      
      <table class="forma_pagamento_td form" id="TED">
        <tr class="headerPagamento">
          <td class="text">&nbsp;<strong>TED/DOC/Transferência Bancária</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="ted" method="post">
              <input type="hidden" name="tipo" value="TED">
              <table class="formtxt">
                <tr>
                  <td class="text">Valor:</td>
                  <td><input type="text" value="0,00" onfocus="javascript: this.className='campo2onfocus';" onblur="javascript: this.className='campo2onblur';" class="campo2onblur floatval" maxlength="15" name="valor" id="valor" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="text"> Vencimento</td>
                  <td><input type="text" value="" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur" maxlength="10" name="vencimento" id="ted_vencimento">
                    <img border="0" align="top" width="16" height="18" style="cursor: pointer;" onclick="javascript:return showCalendar('ted_vencimento', 'dd/mm/y');" src="../i/ic_calendario.png"></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                  <td class="formdivh"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                    <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>
      <table class="forma_pagamento_td form" id="CAR">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Cartão de Crédito</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="credito" method="post">
              <input type="hidden" name="tipo" value="CAR">
              <table cellspacing="2" cellpadding="2" border="0" class="formtxt">
                <tbody>
                  <tr>
                    <td width="150">Vencto.</td>
                    <td width="150">Valor</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input type="text" value="" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur" maxlength="10" name="vencimento" id="cartao_data_parcela">
                      <img border="0" align="top" width="16" height="18" style="cursor: pointer;" onclick="javascript:return showCalendar('cartao_data_parcela', 'dd/mm/y');" src="../i/ic_calendario.png"></td>
                    <td><input type="text" value="0,00" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur"  onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));" maxlength="10" name="valor" id="valor"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="formdivh" colspan="2"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                      <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                  </tr>
                </tbody>
              </table>
            </form></td>
        </tr>
      </table>
      <table class="forma_pagamento_td form" id="DEB">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Cartão de Débito</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="debito" method="post">
              <input type="hidden" name="tipo" value="DEB">
              <table cellspacing="2" cellpadding="2" border="0" class="formtxt">
                <tbody>
                  <tr>
                    <td width="150">Vencto.</td>
                    <td width="150">Valor</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input type="text" value="" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur" maxlength="10" name="vencimento" id="cartao_data_parcela">
                      <img border="0" align="top" width="16" height="18" style="cursor: pointer;" onclick="javascript:return showCalendar('cartao_data_parcela', 'dd/mm/y');" src="../i/ic_calendario.png"></td>
                    <td><input type="text" value="0,00" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur"  onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));" maxlength="10" name="valor" id="valor"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="formdivh" colspan="2"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                      <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                  </tr>
                </tbody>
              </table>
            </form></td>
        </tr>
      </table>
      <table class="forma_pagamento_td form" id="CHE">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Cheque</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="cheque" method="post">
              <input type="hidden" name="tipo" value="CHE">
              <table cellspacing="2" cellpadding="2" border="0" width="100%" class="formtxt">
                <tbody>
                  <tr>
                    <td colspan="2">Banco</td>
                    <td colspan="2">Agência</td>
                  </tr>
                  <tr>
                    <td colspan="2"><input type="text" onfocus="javascript: this.className='campoOnfocus';" onblur="javascript: this.className='campoOnblur';" class="campoOnblur" maxlength="150" size="47" value="" name="nome_banco" id="nome_banco" autocomplete="off">
                      <input type="hidden" value="" id="cheque_banco" name="cheque_banco">
                    <td colspan="2"><input type="text" value="" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur" onkeypress="javascript: return FloatValidate(this.value, false, event);" maxlength="4" name="cheque_agencia"></td>
                  </tr>
                  <tr>
                    <td class="text-danger" colspan="4">Digite no mínimo 3 caracteres para localizar o Banco.</td>
                  </tr>
                  <tr>
                    <td width="18%">No. Cheque</td>
                    <td width="28%">Vencto.</td>
                    <td width="24%">Valor</td>
                    <td width="24%">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input type="text" value="" onfocus="javascript: this.className='campo2Onfocus';" onblur="javascript: this.className='campo2Onblur';" class="campo2Onblur" onkeypress="javascript: return FloatValidate(this.value, false, event);" maxlength="10" name="cheque_numero" /></td>
                    <td><input type="text" value="" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur" maxlength="10" id="cheque_data" name="vencimento" />
                      <img src="../i/ic_calendario.png" alt="" width="16" height="18" style="cursor: pointer;" onclick="javascript:return showCalendar('cheque_data', 'dd/mm/y');" border="0" align="top" /></td>
                    <td><input type="text" value="0,00" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur floatval" maxlength="15" name="valor" id="valor" onkeypress="javascript: return(MascaraMoeda(this,'',',',event));" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"></td>
                  </tr>
                  <script type="text/javascript" language="javascript">
														$(document).ready(function() {
																$("#nome_banco").autocomplete({
																		serviceUrl:'../ajax/bancos.buscar.php',
																		minChars:2, 
																		zIndex: 9999,
																		width:450,
																		deferRequestBy: 300, //miliseconds
																		noCache: true, //default is false, set to true to disable caching
																		onSelect: function(value, data){
																				$('#cheque_banco').val(data.id);
																		}
																});
														});
												</script>
                  <tr>
                    <td class="formdivh" colspan="3"><br>
                      <input type="button" id="inserirPagamento" class="btn" value="gravar">
                      <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                  </tr>
                </tbody>
              </table>
            </form></td>
        </tr>
      </table>
      <table class="forma_pagamento_td form" id="PRO">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Promissória</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="promissoria" method="post">
              <input type="hidden" name="tipo" value="PRO">
              <table cellspacing="2" cellpadding="2" border="0" width="100%" class="formtxt">
                <tbody>
                  <tr>
                    <td>Quantidade</td>
                    <td>Primeiro vencimento</td>
                    <td>Frequencia</td>
                    <td>Valor unitario</td>
                    <td>Valor Total</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><select name="promissoria_numero" id="promissoria_numero" class="selectOnblur" onBlur="javascript: this.className='selectOnblur';" onFocus="javascript: this.className='selectOnfocus';">
                        <? for($i=1;$i<=60;$i++){ ?>
                        <option value="<?=$i?>">
                        <?=$i?>
                        </option>
                        <? } ?>
                      </select></td>
                    <td><input type="text" value="" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur" maxlength="10" name="vencimento" id="promissoria_data">
                      <img border="0" align="top" width="16" height="18" style="cursor: pointer;" onclick="javascript:return showCalendar('promissoria_data', 'dd/mm/y');" src="../i/ic_calendario.png"></td>
                    <td><select name="promissoria_frequencia" class="selectOnblur" onBlur="javascript: this.className='selectOnblur';" onFocus="javascript: this.className='selectOnfocus';">
                        <option value="10">10 dias</option>
                        <option value="15">15 dias</option>
                        <option value="20">20 dias</option>
                        <option value="30" selected>30 dias</option>
                        <option value="45">45 dias</option>
                        <option value="60">60 dias</option>
                      </select></td>
                    <td><input type="text" value="0,00" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur'; " class="campodataonblur floatval" maxlength="15" name="valor_unitario" id="valor_unitario" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));" onKeyUp="javascript: calculaValorTotalPromissoria();"></td>
                    <td><input type="text" readonly="readonly" value="0,00" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur'; " class="campodataonblur floatval" maxlength="15" name="valor" id="valor" onChange="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="formdivh" colspan="5"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                      <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                  </tr>
                </tbody>
              </table>
            </form></td>
        </tr>
      </table>
      <table class="forma_pagamento_td form" id="DUP">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Duplicata</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="duplicata" method="post">
              <input type="hidden" name="tipo" value="DUP">
              <table cellspacing="2" cellpadding="2" border="0" width="100%" class="formtxt">
                <tbody>
                  <tr>
                    <td>Quantidade</td>
                    <td>Primeiro vencimento</td>
                    <td>Frequencia</td>
                    <td>Valor unitario</td>
                    <td>Valor Total</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><select name="duplicata_numero" id="duplicata_numero" class="selectOnblur" onBlur="javascript: this.className='selectOnblur';" onFocus="javascript: this.className='selectOnfocus';">
                        <? for($i=1;$i<=60;$i++){ ?>
                        <option value="<?=$i?>">
                        <?=$i?>
                        </option>
                        <? } ?>
                      </select></td>
                    <td><input type="text" value="" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur" maxlength="10" name="vencimento" id="duplicata_data">
                      <img border="0" align="top" width="16" height="18" style="cursor: pointer;" onclick="javascript:return showCalendar('duplicata_data', 'dd/mm/y');" src="../i/ic_calendario.png"></td>
                    <td><select name="duplicata_frequencia" class="selectOnblur" onBlur="javascript: this.className='selectOnblur';" onFocus="javascript: this.className='selectOnfocus';">
                        <option value="10">10 dias</option>
                        <option value="15">15 dias</option>
                        <option value="20">20 dias</option>
                        <option value="30" selected>30 dias</option>
                        <option value="45">45 dias</option>
                        <option value="60">60 dias</option>
                      </select></td>
                    <td><input type="text" value="0,00" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur'; " class="campodataonblur floatval" maxlength="15" name="valor_unitario" id="valor_unitario" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));" onKeyUp="javascript: calculaValorTotalDuplicata();"></td>
                    <td><input type="text" value="0,00" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur'; " class="campodataonblur floatval" maxlength="15" name="valor" id="valor" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="formdivh" colspan="2"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                      <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                  </tr>
                </tbody>
              </table>
            </form></td>
        </tr>
      </table>
      <table class="forma_pagamento_td form" id="VEI">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Veículo</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="veiculo" method="post">
              <input type="hidden" name="tipo" value="VEI">
              <table cellspacing="2" cellpadding="2" border="0" width="100%" class="formtxt">
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Status:</td>
                  <td><select onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur" name="veic_status">
                      <option value="">----Selecione----</option>
                      <option value="1">NOVO</option>
                      <option value="2">USADO</option>
                    </select></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Tipo:</td>
                  <td><select onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur" name="veic_tipo">
                      <option value="">----Selecione----</option>
                      <option value="1">PRÓPRIO</option>
                      <option value="2">CONSIGNADO</option>
                    </select></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Espécie:</td>
                  <td><select onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur" name="tpve_cod" onchange="javascript:carregaMarca(this.value);">
                      <option value="">----Selecione----</option>
                      <?
                                    $sql = "SELECT tpve_cod, tpve_nome FROM tpveiculos WHERE tpve_status = 't' ORDER BY tpve_nome";
                                    $result_m = query($sql);


                                    for ($i = 0; $i < num_rows($result_m); $i++) {
                                    ?>
                      <option <? if (isset($tpve_cod) && ($tpve_cod == result($result_m, $i, "tpve_cod"))) {
                                                echo "selected";
                                        } ?> value="<?= result($result_m, $i, "tpve_cod") ?>">
                      <?= result($result_m, $i, "tpve_nome") ?>
                      </option>
                      <?
                                    }
                                ?>
                    </select></td>
                </tr>
                <tr>

                  <td class="text"><span class="obrigatorio">*</span>Marca:</td>
                  <td>
             <div id="div_marca" style="display:inline;">
                  <select onchange="javascript: carrega_modelo(this.value, 'modelo');" onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur" name="marca">
                      <option value="">----Selecione----</option>
                      <?
                                    //carregando array
                                    if ($marc_cod == "") {
                                        $marc_cod = 0;
                                    }


                                    //    $sql = "SELECT marc_cod, marc_nome FROM marcas WHERE marc_status = 't' ORDER BY marc_nome";
                                    //    $ = query($sql);

                                    $sql = "SELECT distinct m.marc_cod,m.marc_nome,m.importancia FROM marcas m JOIN marca_vs_tipo mt on (m.marc_cod=mt.marc_cod) WHERE m.marc_status = 't' and m.importancia = 1 ORDER BY m.importancia DESC, m.marc_nome";
                                    $rsMarca = query($sql);

                                    echo "<optgroup>";
                                    for ($i = 0; $i < num_rows($rsMarca); $i++) {
                                        $sel = "";
					if ( $preVenda['preVenda'] != true )
					{
	                                        if ($marc_cod == result($rsMarca, $i, "marc_cod")) 
						{
	                                            $sel = " selected=\"selectedado\" ";
	                                        }
					}

                                        echo "<option value=\"" . result($rsMarca, $i, "marc_cod") . "\" $sel>" . result($rsMarca, $i, "marc_nome") . "</option>";
                                    }
                                    echo "</optgroup><optgroup label=\"------------------\">";


                                    $sql = "SELECT distinct m.marc_cod,m.marc_nome,m.importancia FROM marcas m JOIN marca_vs_tipo mt on (m.marc_cod=mt.marc_cod) WHERE m.marc_status = 't' and m.importancia = 0 ORDER BY m.importancia DESC, m.marc_nome";
                                    $rsMarca = query($sql);

                                    echo "<optgroup>";
                                    for ($i = 0; $i < num_rows($rsMarca); $i++) {
                                        $sel = "";
                                        if ($marc_cod == result($rsMarca, $i, "marc_cod")) {
                                            $sel = " selected=\"selected\" ";
                                        }

                                        echo "<option value=\"" . result($rsMarca, $i, "marc_cod") . "\" $sel>" . result($rsMarca, $i, "marc_nome") . "</option>";
                                    }
                                    echo "</optgroup>";
                                ?>
                    </select>
            </div>
                    </td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Modelo:</td>
                  <td><div id="div_modelo">
                      <select onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur" name="modelo">
                        <option value="">----Selecione----</option>
                      </select>
                    </div></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Ano Fabricação:</td>
                  <td><input type="text" onkeypress="javascript: return FloatValidate(this.value, false, event);" onblur="javascript: this.className = 'campodataonblur';" onfocus="javascript: this.className = 'campodataonfocus';" maxlength="4" class="campodataonblur" value="" name="anofabricacao"></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Ano Modelo:</td>
                  <td><input type="text" onkeypress="javascript: return FloatValidate(this.value, false, event);" onblur="javascript: this.className = 'campodataonblur';" onfocus="javascript: this.className = 'campodataonfocus';" maxlength="4" class="campodataonblur" value="" name="anomodelo"></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Cor:</td>
                  <td><select onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur" name="core_cod">
                      <option value="">----Selecione----</option>
                      <?
                                    $sql = "SELECT core_cod, core_nome FROM cores WHERE core_status = 't' ORDER BY core_nome";
                                    $result_m = query($sql);


                                    for ($i = 0; $i < num_rows($result_m); $i++) {
                                    ?>
                      <option <? if ($core_cod == result($result_m, $i, "core_cod")) {
                                                echo "selected";
                                        } ?> value="<?= result($result_m, $i, "core_cod") ?>">
                      <?= result($result_m, $i, "core_nome") ?>
                      </option>
                      <?
                                    }
                                ?>
                    </select></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Combustível:</td>
                  <td><select onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur" name="comb_cod">
                      <option value="">----Selecione----</option>
                      <?
                                    $sql = "SELECT comb_cod, comb_nome FROM combustiveis WHERE comb_status = 't' ORDER BY comb_nome";
                                    $result_m = query($sql);


                                    for ($i = 0; $i < num_rows($result_m); $i++) {
                                    ?>
                      <option <? if (isset($comb_cod) && ($comb_cod == result($result_m, $i, "comb_cod"))) {
                                                echo "selected";
                                        } ?> value="<?= result($result_m, $i, "comb_cod") ?>">
                      <?= result($result_m, $i, "comb_nome") ?>
                      </option>
                      <?
                                    }
                                ?>
                    </select></td>
                </tr>
                <td class="text">Cambio:</td>
                <td>
                    <select name="camb_cod" class="selectOnblur">
                        <option value="">-- selecione --</option>
                        <?php
                        $sql = "SELECT * FROM cambio ";
                        $rs  = query($sql);
                        if(num_rows($rs) > 0){
                            while ($linha = pg_fetch_assoc($rs)){
                                if($linha['camb_cod'] == $camb_cod){
                                    $sel = " selected";
                                } else {
                                    $sel = "";
                                }
                                echo '<option value="'.$linha['camb_cod'].'" '.$sel.'>'.$linha['camb_nome'].'</option>';
                            }
                        }
                        ?>
                    </select>
                </td>
                </tr>
                <tr>
                    <td class="text">Quantidade de Portas:</td>
                    <td>
                        <select name="veic_qtdportas" class="selectOnblur">
                            <option value="">-- selecione --</option>
                            <option value="2" <?php if($veic_qtdportas==2): echo 'selected'; endif; ?>>2</option>
                            <option value="3" <?php if($veic_qtdportas==3): echo 'selected'; endif; ?>>3</option>
                            <option value="4" <?php if($veic_qtdportas==4): echo 'selected'; endif; ?>>4</option>
                            <option value="6" <?php if($veic_qtdportas==6): echo 'selected'; endif; ?>>6</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text">Quantidade de Passageiros:</td>
                    <td><input type="text" name="qtdpassageiros" id="qtdpassageiros" size="20" value="<?=$qtdpassageiros?>" alt="999" maxlength="10" class="campo3Onblur" onBlur="javascript: this.className='campo3Onblur';" onKeyPress="javascript: return FloatValidate(this.value, false, event);" onFocus="javascript: this.className='campo3Onfocus';"></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Placa:</td>
                  <td><input type="text" maxlength="7" value="" onblur="javascript: this.className = 'campo2onblur';" onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur" name="placa"></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Renavam:</td>
                  <td><input type="text" onfocus="javascript: this.className='campo3Onfocus';" onblur="javascript: this.className='campo3Onblur';" class="campo3Onblur" maxlength="30" size="20" value="" name="renavam"></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Km:</td>
                  <td><input type="text" onfocus="javascript: this.className='campo3Onfocus';" onblur="javascript: this.className='campo3Onblur';" class="campo3Onblur" maxlength="10" value="" size="20" name="veic_km"></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Chassi:</td>
                  <td><input type="text" onfocus="javascript: this.className='campo2Onfocus';" onblur="javascript: this.className='campo2Onblur';" class="campo2Onblur" maxlength="17" size="30" value="" name="chassi"></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Valor:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campo2onblur'; calculaValorLiquido();" onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="0,00" name="valor_compra" id="valor_compra" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="text">Valor quitação:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campo2onblur'; calculaValorLiquido();" onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="0,00" name="veic_valorquitacao" id="veic_valorquitacao" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="text">Valor debitos:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campo2onblur'; calculaValorLiquido();" onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="0,00" name="veic_valordebitos" id="veic_valordebitos" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="text">Valor Líquido:</td>
                  <td><input type="text" readonly="readonly" onblur="javascript: this.className = 'campo2onblur'; " onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="0,00" name="valor" id="valor" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span>Doc. em nome de:</td>
                  <td colspan="2"><input type="text" autocomplete="off" value="" name="cliente_doc_nome" id="cliente_doc_nome" size="47" maxlength="150" class="campoOnblur" onBlur="javascript: this.className='campoOnblur';" onFocus="javascript: this.className='campoOnfocus';">
                    <input type="hidden" name="cliente_doc_cod" id="cliente_doc_cod" value="" /></td>
                </tr>
                <tr>
                  <td></td>
                  <td class="text-danger">Digite no mínimo 3 caracteres para localizar o cliente (nome ou cpf).</td>
                </tr>
                 <tr>
                    <td class="text">Intermedi&aacute;rio:</td>
                    <td colspan=3><input type="text" name="veic_intermediario" id="veic_intermediario" size="47"  maxlength="150" class="campoOnblur non-required" onBlur="javascript: this.className='campoOnblur';" onFocus="javascript: this.className='campoOnfocus';"></td>
                </tr>
                <tr>
                <tr>
                	<td>&nbsp;</td>
                  <td class="formdivh"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                    <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>
      <table class="forma_pagamento_td form" id="FIN">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Financiamento</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="financiamento" method="post">
              <input type="hidden" name="tipo" value="FIN">
              <table cellspacing="2" cellpadding="2" border="0" width="100%" class="formtxt">
                <tr>
                  <td class="text"><span class="obrigatorio">*</span> Financeira:</td>
                  <td><select name="financeira" onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur">
                      <option value="">-- SELECIONE A FINANCEIRA --</option>
                      <?php
                                    $sql = "SELECT p.pess_nome FROM financeiras f 
                                    INNER JOIN pessoas p on (f.pess_cod = p.pess_cod) 
                                    ORDER BY p.pess_nome";
                                    $resFin = query($sql);
                                    //var_dump($resFin, num_rows($resFin));
                                    for ($i = 0; $i < num_rows($resFin); $i++) {
                                        $financeira = result($resFin, $i, "pess_nome");
                                        echo "<option name=\"".trim ($financeira)."\" value=\"".trim ($financeira)."\">" . $financeira . "</option>";
                                    }
                                ?>
                    </select></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span> No. de parcelas:</td>
                  <td><select onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur" name="fina_parcelas">
                      <option value="">----Selecione----</option>
                      <?php for ($i = 1; $i <= 72; $i++): ?>
                      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                      <?php endfor; ?>
                    </select></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span> Valor das parcelas:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campo2onblur';" onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="" name="valor_parcelas"  id="valor_parcelas" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="text">Descrição:</td>
                  <td><textarea onblur="javascript: this.className = 'textareaOnblur';" onfocus="javascript: this.className = 'textareaOnfocus';" class="textareaOnblur" rows="5" cols="40" name="fina_descricao"></textarea></td>
                </tr>
                <tr>
                  <td class="text"><span class="obrigatorio">*</span> Valor financiado:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campo2onblur'; " onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="0,00" name="valor" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="text">Valor do Retorno:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campo2onblur';" onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="0,00" name="vlr_financiado_retorno" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="text">Valor TAC:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campo2onblur';" onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="0,00" name="vlr_financiado_tac" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="text">Valor PLUS:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campo2onblur';" onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="0,00" name="vlr_financiado_plus" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                  <td class="formdivh"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                    <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>
      <table class="forma_pagamento_td form" id="CON">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Consórcio</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="consorcio" method="post">
              <input type="hidden" name="tipo" value="CON">
              <table cellspacing="2" cellpadding="2" border="0" width="100%" class="formtxt">
                <tr>
                  <td class="text">Nome do consórcio:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campoOnblur';" onfocus="javascript: this.className = 'campoOnfocus';" class="campoOnblur" value="" name="cons_nome"></td>
                </tr>
                <tr>
                  <td class="text">Descrição:</td>
                  <td><textarea onblur="javascript: this.className = 'textareaOnblur';" onfocus="javascript: this.className = 'textareaOnfocus';" class="textareaOnblur" rows="5" cols="40" name="cons_descricao"></textarea></td>
                </tr>
                <tr>
                  <td class="text">Valor consórcio:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campo2onblur'; " onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="" name="valor" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="formdivh">&nbsp;</td>
                  <td class="formdivh"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                    <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>
     
      <table class="forma_pagamento_td form" id="TRO">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Troco na troca</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="troco" method="post">
              <input type="hidden" name="tipo" value="TRO">
              <table cellspacing="2" cellpadding="2" border="0" width="100%" class="formtxt">
                <tr>
                  <td class="text">Valor devolução:</td>
                  <td><input type="text" onblur="javascript: this.className = 'campo2onblur';" onfocus="javascript: this.className = 'campo2onfocus';" class="campo2onblur floatval" maxlength="15" value="" name="valor"  id="valor"  onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                </tr>
                <tr>
                  <td class="text">Vencimento:</td>
                  <td><input type="text" value="" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur" maxlength="10" name="vencimento" id="promissoria_data">
                    
                    <!-- <a href="" onclick="cal.select(document.forms['f1'].promissoria_data1,'anchor1','dd/MM/yyyy'); return false;" name="anchor1" id="anchor1"><img src="../i/ic_calendario.png" width="16" height="18" border="0" align="top"></a> --> 
                    <img border="0" align="top" width="16" height="18" style="cursor: pointer;" onclick="javascript:return showCalendar('promissoria_data', 'dd/mm/y');" src="../i/ic_calendario.png"></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                  <td class="formdivh"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                    <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>
      <table class="forma_pagamento_td form" id="BOL">
        <tr class="headerPagamento">
          <td>&nbsp;<strong>Boleto bancário</strong></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2"><form name="boleto" method="post">
              <input type="hidden" name="tipo" value="BOL">
              <table cellspacing="2" cellpadding="2" border="0" width="100%" class="formtxt">
                <tbody>
                  <tr>
                    <td>Codigo boleto</td>
                    <td>Data vencimento</td>
                    <td>Valor</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input type="text" value="" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur'; " class="campodataonblur floatval" maxlength="15" name="boleto_numero" id="valor" ></td>
                    <td><input type="text" value="" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur';" class="campodataonblur" maxlength="10" name="vencimento" id="boleto_data">
                      <img border="0" align="top" width="16" height="18" style="cursor: pointer;" onclick="javascript:return showCalendar('boleto_data', 'dd/mm/y');" src="../i/ic_calendario.png"></td>
                    <td><input type="text" value="0,00" onfocus="javascript: this.className='campodataonfocus';" onblur="javascript: this.className='campodataonblur'; " class="campodataonblur floatval" maxlength="15" name="valor" id="valor" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="formdivh" colspan="5"><input type="button" id="inserirPagamento" class="btn" value="gravar">
                      <input type="button" id="cancelarPagamento"  class="btn"   value="cancelar"></td>
                  </tr>
                </tbody>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="10" class="text" colspan="2"><table id="pagamentos_selecionados" class="formtxt">
        <?
                $_SESSION['total_pagamento'] = "0";

                if ($_SESSION['pagamentos']) {

                    if(!isset($return['msg']))
                        $return['msg'] = "";

                    $return['msg'] .= "<tr class='headerPagamento'><td>Pagamento</td><td>Valor</td><td>Vencimento</td><td>Ação</td></tr>";
                    
                    foreach ($_SESSION['pagamentos'] as $key => $pag) {
                        unset($tipo);
                        switch ($pag['tipo']) {

                            case "DIN":
                                $tipo = "Dinheiro";
                                break;
                             case "DES":
                                $tipo = "Desconto";
                                break;    
                            case "CHE":
                                $tipo = "Cheque";
                                break;
                            case "FIN":
                                $tipo = "Financiamento";
                                break;
                            case "VEI":
                                $tipo = "Veículo na Troca";
                                break;
                            case "CON":
                                $tipo = "Consórcio";
                                break;
                            case "PRO":
                                $tipo = "Promissória";
                                break;
                            case "CAR":
                                $tipo = "Cartão de Crédito";
                                break;
                            case "DEB":
                                $tipo = "Cartão de Débito";
                                break;
                            case "TRO":
                                $tipo = "Troco na Troca";
                                break;
                            case "TED":
                                $tipo = "TED/DOC/Transferência";
                                break;
                            case "DUP":
                                $tipo = "Duplicata";
                                break;
                            case "BOL":
                                $tipo = "Boleto bancário";
                                break;
                        }
                        
                        $pag['valor'] = strstr($pag['valor'],',') ? str_replace(',','.',str_replace('.','',$pag['valor'])) : $pag['valor'];
                        
                        $return['msg'] .= "<tr><td>" . $tipo . "</td><td>". number_format($pag['valor'], 2, ',','') . "</td><td>" . $pag['vencimento'] . "</td><td class='resultadolink'>
                        <a id='editarPagamento' href='' rel='$key' tipoPagamento='{$pag['tipo']}'>editar</a>
                        <a id='excluirPagamento' href='' rel='$key'>excluir</a>
                        <span class='valor' style='display:none'>" . $pag['valor'] . "</span></td></tr>";
                        if ($pag['tipo'] == "TRO") {
                            $total_pagamento = $total_pagamento - $pag['valor'];
                        } else {
                            $total_pagamento = $total_pagamento + $pag['valor'];
                        }
                    }

                    $_SESSION['total_pagamento'] = $total_pagamento;
                }

                echo $return['msg'];
            ?>
      </table></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr bgcolor="#eeeeee" style="border:1px solid gren;width:500px">
    <td height="25" colspan="2" bgcolor="#eeeeee"><strong>Origem do cliente</strong></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td class="text"><span class="obrigatorio">*</span> Canal da Venda:</td>
    <td><select name="id_canal" id="id_canal" class="selectOnblur" onBlur="javascript: this.className='selectOnblur';" onFocus="javascript: this.className='selectOnfocus';">
        <option value="0">------------------------------------</option>
        <?
                $rs = query("select id_canal, canal_nome from canal_comunicacao where reve_cod='" . $_SESSION["ss_empresa_conectada"] . "' AND canal_status=true order by canal_nome");
                if (!isset($_SESSION["ss_estoque_id_canal"]) && !isset($id_canal)) {
                    $id_canal = 0;
                }


                for ($i = 0; $i < num_rows($rs); $i++) {

                    $selec = "";

                    if ($id_canal != "") {
                        if ($id_canal == result($rs, $i, "id_canal")) {
                            $selec = "selected";
                        }
                    }
                ?>
        <option <?= $selec ?> value="<?= result($rs, $i, "id_canal") ?>">
        <?= result($rs, $i, "canal_nome") ?>
        </option>
        <?
                }
            ?>
      </select></td>
  </tr>
  <tr>
    <td class="text">Informação Adicional:</td>
    <td ><input type="text" class="campoonblur" maxlength="50" name="obs_canal" id="obs_canal" value="<?= $obs_canal ?>" onfocus="javascript: this.className='campoonfocus';" onblur="javascript: this.className='campoonblur';"></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr bgcolor="#eeeeee">
    <td colspan="2" bgcolor="#eeeeee"><strong>Dados da transferencia</strong></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td class="text">Situa&ccedil;&atilde;o:</td>
    <td ><label>
        <input type="radio" name="status_situacao" id="status_situacao1" value="1" OnClick="javascript: pago_aberto();" />
        Pago
      </label>
      <label>
        <input type="radio" name="status_situacao" id="status_situacao2" value="2" checked="checked" OnClick="javascript: pago_aberto();" />
        Aberto
      </label>
      <label>
        <input type="radio" name="status_situacao" id="status_situacao3" value="3" OnClick="javascript: cortesia();" />
        Cortesia
      </label></td>
  </tr>
  <tr id="valor_pago_linha">
    <td class="text">Valor Pago:</td>
    <td ><input type="text" name="valor_pg_clien" id="valor_pg_clien" value="<?= $valor_pg_clien ?>" maxlength="15" class="campo2onblur floatval" onfocus="javascript: this.className = 'campo2onfocus';" onblur="javascript: this.className='campo2onblur'; if(this.value == '')this.value = '0,00';" onKeyPress="javascript: return(MascaraMoeda(this,'',',',event));"></td>
  </tr>
  <tr id="data_pagamento_linha">
    <td class="text">Data de Pagamento:</td>
    <td><input type="text" name="dt_pg_clien" id="dt_pg_clien"  value="<?= $dt_pg_clien ?>" size="10" class="campodataOnblur" onBlur="javascript: this.className='campodataOnblur';" onFocus="javascript: this.className='campodataOnfocus';">
      <img src="../i/ic_calendario.png" width="16" height="18" border="0" align="top" onclick="javascript:return showCalendar('dt_pg_clien', 'dd/mm/y');" style="cursor:pointer;"></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr bgcolor="#eeeeee">
    <td height="25" colspan="2" bgcolor="#eeeeee"><strong>Outras informações</strong></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td class="text">Observações de Saída:</td>
    <td colspan=2><textarea name="observacao_venda" id="observacao_venda" rows="5" class="textarea3Onblur" onfocus="this.className='textarea3Onfocus'" onblur="this.className='textarea3Onblur'"><?= $observacao_venda; ?>
</textarea></td>
  </tr>
  <input type="hidden" name="clientedocumento_cod" id="clientedocumento_cod" value="<?=$clientedocumento_cod?>" />
  <!--<tr>
    <td class="text">Valor Transferência:</td>
    <td>R$&nbsp;<input type="text" name="valor_transferencia" id="valor_transferencia" value="<?= number_format($valor_transferencia, 2, ",", "") ?>" maxlength="30" class="campo2Onblur floatval" onblur="javascript:if(this.value == '')this.value = '0,00';">
</tr>-->
  <tr id="loginAdmLinha" style="display:none;">
    <td colspan="2" align="center"><div style="border:1px solid #000; padding:5px; margin:5px">
        Login: <input type="text" name="loginAdm" id="loginAdm" class="campo2Onblur" onBlur="javascript: this.className='campo2Onblur';" onFocus="javascript: this.className='campo2Onfocus';" value="<?=$loginAdm?>">
        Senha: <input type="password" name="senhaAdm" id="senhaAdm" class="campo2Onblur" onBlur="javascript: this.className='campo2Onblur';" onFocus="javascript: this.className='campo2Onfocus';" value="<?=$senhaAdm?>">
      </div></td>
  </tr>
  <tr>
    <td height="10" colspan="2" class="text"></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td align=""><input type="button" id="btGravar" onclick="javascript: return Validar();" value="Salvar" class="btngravar" name="button"></td>
  </tr>
  <tr>
    <td height="20" colspan="2" class="text"></td>
  </tr>
</table>
<script language="JavaScript">
    function Verificar()
    {
        if(document.f1.clie_cod.value!="")
            {
            document.f1.action='saida_01.php';
            document.f1.submit();
        }
        else
            {
            alert("Pesquise o cliente!");
            document.f1.pesquisar.focus();
        }
    }

    function Validar()
    {
        var confirmar = true;
        var valor_minimo = $('#valor_minimo').val().replace(',','.');

        if(Number(valor_minimo) > Number('0') &&
            (Number($('#preco_venda').val().replace(',','.'))) < (Number(valor_minimo))){
            $('#loginAdmLinha').show();
            $('#loginAdm').focus()
            if($('#loginAdm').val() == '' || $('#senhaAdm').val() == ''){
                alert('Valor de venda está abaixo do valor mínimo, você deve entrar com a senha de administrador.');
                confirmar = false;
            }
            else
                {
                $.post("forms/ver_senha_admin.php",
                    {  
                        loginAdm: $('#loginAdm').val(),
                        senhaAdm: $('#senhaAdm').val()
                    },
                    function(data){
                        if(data!="1"){
                            alert(data);
                            confirmar = false;
                            $('#btGravar').show();
                            return(false);
                        }
                        else
                            {
                            restoValidacao(confirmar)
                        }
                });
            }
        }
        else
            restoValidacao(confirmar);
    }
    
    function cortesia(){
        $('#valor_pago_linha').hide();
        $('#data_pagamento_linha').hide();
    }
    function pago_aberto(){
        $('#valor_pago_linha').show();
        $('#data_pagamento_linha').show();
    }

    function restoValidacao(confirmar)
    {
        if((Number($('#total_pagamento').val())) != (Number($('#preco_venda').val().replace(',','.')))){
            alert('A soma de pagamentos está diferente do valor de venda.');
            confirmar = false;
        }

        if(confirmar == true){
            if($('#data_venda').val()=="")
                {
                alert("Informe a data de venda!");
                $('#data_venda').focus();
                return(false);
            }

            if($('#data_venda').val().length!=10)
                {
                alert("Informe a data de venda corretamente!");
                $('#data_venda').focus();
                return(false);
            }

            if($('#vendedor').val()=="")
                {
                alert("Selecione o vendedor!");
                $('#vendedor').focus();
                return(false);
            }
            if($('#veic_cod').val()=="")
                {
                alert("Pesquise o veículo!");
                $('#modelo').focus();
                return(false);
            }
            if($('#clie_cod').val()=="")
                {
                alert("Pesquise o cliente!");
                $('#clie_nome').focus();
                return(false);
            }
            if($('#preco_venda').val()=="" || $('#preco_venda').val()=="0,00")
                {
                alert("Digite o valor da venda!");
                $('#preco_venda').focus();
                return(false);
            }
//            alert($('input[name=status_situacao]:checked').val());
            if($('input[name=status_situacao]:checked').val()==1){
                if($('#valor_pg_clien').val()=="" || $('#valor_pg_clien').val()=="0,00")
                    {
                    alert("Digite o valor pago da transferencia!");
                    $('#valor_pg_clien').focus();
                    return(false);
                }
                if($('#dt_pg_clien').val().length!=10)
                    {
                    alert("Digite a data de pagamento!");
                    $('#dt_pg_clien').focus();
                    return(false);
                }
            }
            
            if($('#id_canal').val() == 0 )
                {
                alert("Selecione o canal da venda!");
                $('#id_canal').focus();
                return(false);
            }

            $('#btGravar').hide();

            if( $('#valor_transferencia').val() == '' )
                $('#valor_transferencia').val('0,00');

            $.post("forms/inse_saida_ajax.php",
                {  
                    preVenda:<?=(strstr($_SERVER['REQUEST_URI'],'pre-venda-01.php'))? 'true':'false'?>,
                    data_venda: $('#data_venda').val(),
                    vendedor: $('#vendedor').val(),
                    veic_cod: $('#veic_cod').val(),
                    clie_cod: $('#clie_cod').val(),
                    preco_venda: $('#preco_venda').val(),
                    obs_canal: $('#obs_canal').val(),
                    id_canal: $('#id_canal').val(),
                    status: $('input[name=status_situacao]:checked').val(),
                    valor_pg_clien: $('#valor_pg_clien').val(),
                    dt_pg_clien: $('#dt_pg_clien').val(),
                    observacao_venda: $('#observacao_venda').val(),
                    clientedocumento_cod: $('#clientedocumento_cod').val(),
                    valor_transferencia: $('#valor_transferencia').val(),
                    posicao_estoque: $('#posicao_estoque').val(),
                    loginAdm: $('#loginAdm').val(),
                    senhaAdm: $('#senhaAdm').val()
                },
                function(data){
                    if(data=="1"){
                        document.location.href = "saida_07.php?veic_cod=" + $('#veic_cod').val() + '&clie_cod=' + $('#clie_cod').val();
                    } else {
                        alert(data);
                        $('#btGravar').show();
                    }
            });
        }
    }

    function Recarregar()
    {
        document.f1.action = 'saida_01.php';
        document.f1.submit();
    }

    function carrega_modelo(id, mod)
    {
        if(id!="")
            {
            var oHTTPRequest = createXMLHTTP();
            oHTTPRequest.open("post", "../ajax/ajax_modelos_multi.php", true);
            oHTTPRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            oHTTPRequest.onreadystatechange=function() {
                if (oHTTPRequest.readyState==4){
                    div = "div_"+mod;
                    document.getElementById(div).innerHTML = URLDecode(oHTTPRequest.responseText);
                }
            }
            oHTTPRequest.send("id_marca=" + id + "&campo=" + mod);
        }
    }

    function calculaValorLiquido(){
        var total = 0;
        var compra = document.getElementById('valor_compra').value.replace(",",".");
        var quitacao = document.getElementById('veic_valorquitacao').value.replace(",",".");
        var debito = document.getElementById('veic_valordebitos').value.replace(",",".");

        //        alert("Q " + quitacao + " - D " + debito + " - C " + compra);

        if(quitacao == "" && debito == ""){
            total = compra;
        }
        if(quitacao != ""){
            if(compra == quitacao){
                if(debito != "" && debito > 0){
                    document.getElementById('valor').value = "-"+debito.replace(".",",");
                }else{
                    document.getElementById('valor').value = '0,00';
                }
                return true;
           }else{
                total = compra - quitacao ;
                total = total.toFixed(2)
            }
        }
        if(debito != ""){
            if(total == 0){
                total = compra - debito;
            }else{
                total = total - debito;
            }
            total = total.toFixed(2)
        }
        var valor_retorno =  total.replace(".",",");
        document.getElementById('valor').value = valor_retorno;
    }


</script> 
<script>
    $(function() {
            $model_ac = $('#modelo').autocomplete({ 
                    serviceUrl:'../ajax/veiculos.buscar.php',
                    params: { situacao:'estoque', novo:'false' },
                    minChars:2, 
                    zIndex: 9999,
										width:450,
                    deferRequestBy: 300, //miliseconds
                    noCache: true, //default is false, set to true to disable caching
                    onSelect: function(value, data){
                        if(data.id!='' && data.id > 0) {
                            $('#veic_cod').val(data.id);
                            $('#veic_valorcompra').val(data.vlcompra);
                            //                            alert(data.pos_est);
                            var stringHtml = '';
                            for(var i=1;i<=10;i++){
                                if(i == data.pos_est){
                                    stringHtml = stringHtml + '<option value="'+data.pos_est+'" selected="selected">'+data.pos_est+'</option>';
                                }else{
                                    stringHtml = stringHtml + '<option value="'+i+'">'+i+'</option>';
                                }
                            }
                            $('#posicao_estoque').html(stringHtml);

                            $.get("../ajax/ajax_preco_veiculo.php", { veic_cod: data.id }, function(data){
                                    $('#preco_venda').val(data);
                                    $('#valor_receber').html(data);
                            });

                            $.get("../ajax/ajax_valorminimo_veiculo.php", { veic_cod: data.id }, function(data){
                                    $('#valor_minimo').val(data);
                            });

                        } else if(data.id == 0){
                            $('#veic_cod').val('');
                            $('#veic_valorcompra').val('');
                            $( "#modelo" ).val('');
                            return false;
                        }
                        $('#clie_nome').focus();    
                    }
            });

            $clie_ac = $( "#clie_nome" ).autocomplete({
                    serviceUrl:'../ajax/clientes.buscar.php',
                    minChars:2, 
                    zIndex: 9999,
                    width:450,
                    deferRequestBy: 300, //miliseconds
                    noCache: true, //default is false, set to true to disable caching
                    onSelect: function(value, data){
                        if(data.id!='' && data.id > 0) {
                            $('#clie_cod').val(data.id);
                        } else if(data.id == 0){
                            $('#clie_cod').val('');
                            $( "#clie_nome").val('');
                            return false;
                        }
                    }
            });

	/*
           $clie_doc_nome = $( "#cliente_doc_nome" ).autocomplete({
                    serviceUrl:'../ajax/clientes.buscar.php',
                    minChars:2,
                    zIndex: 9999,
                    width:450,
                    deferRequestBy: 300, //miliseconds
                    noCache: true, //default is false, set to true to disable caching
                    onSelect: function(value, data){
                        if(data.id!='' && data.id > 0) {
                            $('#cliente_doc_cod').val(data.id);
                        } else if(data.id == 0){
                            $('#cliente_doc_cod').val('');
                            $("#cliente_doc_nome").val('');
                            return false;
                        }
                    }
            });
	*/

		/*
		
            $('#cliente_doc_nome').live('keyup', function(){
                    $(this).autocomplete({
                            serviceUrl:'../ajax/clientes.buscar.php',
                            minChars:2, 
                            zIndex: 9999,
                            width:450,
                            deferRequestBy: 300, //miliseconds
                            noCache: true, //default is false, set to true to disable caching
                            onSelect: function(value, data){
                                $('.autocomplete').hide();
                                if(data.id!='' && data.id > 0) {
                                    $('#cliente_doc_cod').val(data.id);
                                } else if(data.id == 0){
                                    $('#cliente_doc_cod').val('');
                                    $("#cliente_doc_nome").val('');
                                    return false;
                                }
                            }
                    });

            });

		*/
            //            $('#clientedocumento_nome').autocomplete({
            //                    serviceUrl:'../ajax/clientes.buscar.php',
            //                    minChars:2, 
            //                    zIndex: 9999,
            //                    width:450,
            //                    deferRequestBy: 300, //miliseconds
            //                    noCache: true, //default is false, set to true to disable caching
            //                    onSelect: function(value, data){
            //                        if(data.id!='' && data.id > 0) {
            //                            $('#clientedocumento_cod').val(data.id);
            //                        } else if(data.id == 0){
            //                            $('#clientedocumento_cod').val('');
            //                            $( "#clientedocumento_nome" ).val('');
            //                            return false;
            //                        }
            //                    }
            //            });


    });
</script>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css" />
<script type="text/javascript" src="../js/jquery.autocomplete-min.js"></script>
<div style="display: none;">
  <div id="tempFormaPagamento" name="tempFormaPagamento">
  </div>
</div>
<?php
    error_reporting(0);
    ini_set("display_errors", 0);

?>
