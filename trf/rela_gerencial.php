<?
	session_start();
	$reve_cod = $_SESSION["ss_empresa_conectada"];
	$relatorio = $_POST["relatorio"];
        $relatorio_botao = $relatorio;
	if ($relatorio==1){
		if(empty($dre_modelo)) $dre_modelo='1'; //Sintético
		if(empty($dre_tipo)) $dre_tipo = "2"; // Mensal
		if ($dre_tipo == "2") {
			if(empty($dtmes)) $dtmes = date("m");
		}
		if(empty($dtano)) $dtano = date("Y");
		if(empty($pesq)) $pesq = "1";
	}
?>
<script language="JavaScript">
  	function recarregar()
  	{
		if(document.f.relatorio.value==1)
		{
			document.f.action = "dre_p.php";
		}
		if(document.f.relatorio.value==8)
		{
			document.f.action = "analitico_p.php";
		}
		document.f.submit();
  	}
	function verifica(f){
//            alert(f.relatorio.value);
  		if(f.relatorio.value == 1){
			var janela;
			var link_pop;
			if (f.dre_tipo.value == 1)
				link_pop = 'forms/pdf_dre_anual.php?dtano=' + f.dtano.value + '&modelo=' + f.dre_modelo.value;
			else
				link_pop = 'forms/pdf_dre_mensal.php?dtmes=' + f.dtmes.value + '&dtano=' + f.dtano.value + '&modelo=' + f.dre_modelo.value;
			alert(link_pop);

			janela = window.open(link_pop, 'dre', 'width=850, height=600, scrollbars=yes, resizable=yes');
			return(true);
		}
		else
			if(f.relatorio.value == 2 || f.relatorio.value == 9){
				if(f.relatorio.value==2)
					var link_pop = "forms/pdf_lista_gerencial_estoque.php?posicao_estoque=" + f.posicao_estoque.value + "&search_tipo=" + f.search_tipo.value + "&search_ordem=" + f.search_ordem.value;
				else
					var link_pop = "forms/pdf_lista_gerencial_estoque_com_documentacao.php?posicao_estoque=" + f.posicao_estoque.value + "&search_tipo=" + f.search_tipo.value;
				var janela;
				janela = window.open(link_pop, 'formulário', 'width=850, height=600, scrollbars=yes, resizable=yes');
			}
			else if( f.relatorio.value == 3)
			{
				if(f.dtini1.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtini1.focus();
				  return(false);
				}
				if(f.dtfim1.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtfim1.focus();
				  return(false);
				}

				var dia_ini = f.dtini1.value.substr(0,2);
				var mes_ini = f.dtini1.value.substr(3,2);
				var ano_ini = f.dtini1.value.substr(6,4);
				var dia_fim = f.dtfim1.value.substr(0,2);
				var mes_fim = f.dtfim1.value.substr(3,2);
				var ano_fim = f.dtfim1.value.substr(6,4);
				
				var vendedor = f.vendedor.value;
//                               
                                    var link_pop = "forms/pdf_lista_gerencial_venda.php?search_tipo=" + f.search_tipo.value + "&vendedor="+vendedor+"&posicao_estoque=" + f.posicao_estoque.value + "&dtini=" + ano_ini + "-" + mes_ini + "-" + dia_ini + "&dtfim=" + ano_fim + "-" + mes_fim + "-" + dia_fim;
                               
				var janela;
//                                alert(link_pop);
                                janela = window.open(link_pop, 'Relatório', 'width=850, height=600, scrollbars=yes, resizable=yes');
				return(true);

			}
            else if(f.relatorio.value == 11)
            {
                if(f.dtini1.value.length < 10){
                    alert("Por favor, complete o período corretamente !!!");
                    f.dtini1.focus();
                    return(false);
                }
                if(f.dtfim1.value.length < 10){
                    alert("Por favor, complete o período corretamente !!!");
                    f.dtfim1.focus();
                    return(false);
                }

                var dia_ini = f.dtini1.value.substr(0,2);
                var mes_ini = f.dtini1.value.substr(3,2);
                var ano_ini = f.dtini1.value.substr(6,4);
                var dia_fim = f.dtfim1.value.substr(0,2);
                var mes_fim = f.dtfim1.value.substr(3,2);
                var ano_fim = f.dtfim1.value.substr(6,4);

                var vendedor = f.vendedor.value;
//
                var link_pop = "forms/pdf_lista_gerencial_venda_imposto.php?search_tipo=" + f.search_tipo.value + "&vendedor="+vendedor+"&posicao_estoque=" + f.posicao_estoque.value + "&dtini=" + ano_ini + "-" + mes_ini + "-" + dia_ini + "&dtfim=" + ano_fim + "-" + mes_fim + "-" + dia_fim;

                var janela;
//                                alert(link_pop);
                janela = window.open(link_pop, 'Relatório', 'width=850, height=600, scrollbars=yes, resizable=yes');
                return(true);

            }
			else if(f.relatorio.value == 5)
			{
				if(f.dtini1.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtini1.focus();
				  return(false);
				}
				if(f.dtfim1.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtfim1.focus();
				  return(false);
				}

				var dia_ini = f.dtini1.value.substr(0,2);
				var mes_ini = f.dtini1.value.substr(3,2);
				var ano_ini = f.dtini1.value.substr(6,4);
				var dia_fim = f.dtfim1.value.substr(0,2);
				var mes_fim = f.dtfim1.value.substr(3,2);
				var ano_fim = f.dtfim1.value.substr(6,4);
				var vendedor = f.vendedor.value;
				var financeira = f.financeira.value;
                               
				var link_pop = "forms/pdf_lista_gerencial_retorno.php?posicao_estoque=" + f.posicao_estoque.value + "&id_vendedor="+vendedor+"&financeira="+financeira+"&dtini=" + ano_ini + "-" + mes_ini + "-" + dia_ini + "&dtfim=" + ano_fim + "-" + mes_fim + "-" + dia_fim;
				var janela;
				janela = window.open(link_pop, 'Relatório', 'width=850, height=600, scrollbars=yes, resizable=yes');
				return(true);

			}
			else if(f.relatorio.value == 6)
			{
				if(f.dtini1.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtini1.focus();
				  return(false);
				}
				if(f.dtfim1.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtfim1.focus();
				  return(false);
				}

				var dia_ini = f.dtini1.value.substr(0,2);
				var mes_ini = f.dtini1.value.substr(3,2);
				var ano_ini = f.dtini1.value.substr(6,4);
				var dia_fim = f.dtfim1.value.substr(0,2);
				var mes_fim = f.dtfim1.value.substr(3,2);
				var ano_fim = f.dtfim1.value.substr(6,4);
				var vendedor = f.vendedor.value;

				var link_pop = "forms/pdf_comissao_vendedor.php?posicao_estoque=" + f.posicao_estoque.value + "&id_vendedor="+vendedor+ "&dtini=" + ano_ini + "-" + mes_ini + "-" + dia_ini + "&dtfim=" + ano_fim + "-" + mes_fim + "-" + dia_fim;
				var janela;
				janela = window.open(link_pop, 'Relatório', 'width=850, height=600, scrollbars=yes, resizable=yes');
				return(true);

			}
			else if(f.relatorio.value == 7)
			{
				if(f.dtini1.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtini1.focus();
				  return(false);
				}
				if(f.dtfim1.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtfim1.focus();
				  return(false);
				}

				var dia_ini = f.dtini1.value.substr(0,2);
				var mes_ini = f.dtini1.value.substr(3,2);
				var ano_ini = f.dtini1.value.substr(6,4);
				var dia_fim = f.dtfim1.value.substr(0,2);
				var mes_fim = f.dtfim1.value.substr(3,2);
				var ano_fim = f.dtfim1.value.substr(6,4);
				
				var vendedor = f.vendedor.value;
                                
                                var link_pop = "forms/pdf_lista_gerencial_venda_comissao.php?search_tipo=" + f.search_tipo.value + "&vendedor="+vendedor+"&posicao_estoque=" + f.posicao_estoque.value + "&dtini=" + ano_ini + "-" + mes_ini + "-" + dia_ini + "&dtfim=" + ano_fim + "-" + mes_fim + "-" + dia_fim;
                            
				var janela;
				janela = window.open(link_pop, 'Relatório', 'width=850, height=600, scrollbars=yes, resizable=yes');
				return(true);

			}
			else if(f.relatorio.value == 4){
				if(f.dtini2.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtini2.focus();
				  return(false);
				}
				if(f.dtfim2.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtfim2.focus();
				  return(false);
				}

				if(f.dtini2.value.substr(3,2)==f.dtfim2.value.substr(3,2))
				{
					if(f.dtini2.value>f.dtfim2.value)
					{
						alert("Data Final maior que Data Inicial!");
						f.dtfim2.focus();
						return(false);
					}
					else
					{
						var dia_ini = f.dtini2.value.substr(0,2);
						var mes_ini = f.dtini2.value.substr(3,2);
						var ano_ini = f.dtini2.value.substr(6,4);
						var dia_fim = f.dtfim2.value.substr(0,2);
						var mes_fim = f.dtfim2.value.substr(3,2);
						var ano_fim = f.dtfim2.value.substr(6,4);

						var link_pop = "forms/pdf_lista_gerencial_canal.php?posicao_estoque=" + f.posicao_estoque.value + "&dtini=" + ano_ini + "-" + mes_ini + "-" + dia_ini + "&dtfim=" + ano_fim + "-" + mes_fim + "-" + dia_fim;
						var janela;
						janela = window.open(link_pop, 'Relatório', 'width=850, height=600, scrollbars=yes, resizable=yes');
						return(true);
					}
				}
			}
                        else if( f.relatorio.value == 10)
			{
				if(f.dtini1.value.length < 10){
				  alert("Por favor, complete o período corretamente !!!");
				  f.dtini1.focus();
				  return(false);
				}

				var dia_ini = f.dtini1.value.substr(0,2);
				var mes_ini = f.dtini1.value.substr(3,2);
				var ano_ini = f.dtini1.value.substr(6,4);
//                                alert("gerencial_fechamento.php?mes=" + mes_ini + "&ano=" + ano_ini);
//				  janela = window.open="gerencial_fechamento.php_self";
//                                document.location = "gerencial_fechamento.php";
//                                location.href="gerencial_fechamento.php?mes=" + mes_ini + "&ano=" + ano_ini;
                                
				var link_pop = "/relat/gerencial_fechamento.php?mes=" + mes_ini + "&ano=" + ano_ini;
//                                alert(link_pop);
                                document.location=link_pop;
//				var janela;
//				janela = window.open(link_pop, 'Relatório', 'width=800, height=600, scrollbars=yes, resizable=yes');
				return(false);

			}
  	}
        
    function geraXLS(){
        if(f.relatorio.value == 2){
            var link_pop = "forms/xls_lista_gerencial_estoque.php?posicao_estoque=" + f.posicao_estoque.value + "&search_tipo=" + f.search_tipo.value + "&search_ordem=" + f.search_ordem.value;
            var janela;
            janela = window.open(link_pop, 'formulário', 'width=850, height=600, scrollbars=yes, resizable=yes');
            return(true);
        }
        if(f.relatorio.value == 3){
            if(f.dtini1.value.length < 10){
                alert("Por favor, complete o período corretamente !!!");
                f.dtini1.focus();
                return(false);
            }
            if(f.dtfim1.value.length < 10){
                alert("Por favor, complete o período corretamente !!!");
                f.dtfim1.focus();
                return(false);
            }
            var dia_ini = f.dtini1.value.substr(0,2);
            var mes_ini = f.dtini1.value.substr(3,2);
            var ano_ini = f.dtini1.value.substr(6,4);
            var dia_fim = f.dtfim1.value.substr(0,2);
            var mes_fim = f.dtfim1.value.substr(3,2);
            var ano_fim = f.dtfim1.value.substr(6,4);
            var vendedor = f.vendedor.value;
            var link_pop = "forms/xls_lista_gerencial_venda.php?search_tipo=" + f.search_tipo.value + "&vendedor="+vendedor+"&posicao_estoque=" + f.posicao_estoque.value + "&dtini=" + ano_ini + "-" + mes_ini + "-" + dia_ini + "&dtfim=" + ano_fim + "-" + mes_fim + "-" + dia_fim;
            var janela;
            janela = window.open(link_pop, 'Relatório', 'width=850, height=600, scrollbars=yes, resizable=yes');
            return(true);
        }        
        if(f.relatorio.value == 7){
            if(f.dtini1.value.length < 10){
                alert("Por favor, complete o período corretamente !!!");
                f.dtini1.focus();
                return(false);
            }
            if(f.dtfim1.value.length < 10){
                alert("Por favor, complete o período corretamente !!!");
                f.dtfim1.focus();
                return(false);
            }
            var dia_ini = f.dtini1.value.substr(0,2);
            var mes_ini = f.dtini1.value.substr(3,2);
            var ano_ini = f.dtini1.value.substr(6,4);
            var dia_fim = f.dtfim1.value.substr(0,2);
            var mes_fim = f.dtfim1.value.substr(3,2);
            var ano_fim = f.dtfim1.value.substr(6,4);
            var vendedor = f.vendedor.value;
            var link_pop = "forms/xls_lista_gerencial_venda_comissao.php?search_tipo=" + f.search_tipo.value + "&vendedor="+vendedor+"&posicao_estoque=" + f.posicao_estoque.value + "&dtini=" + ano_ini + "-" + mes_ini + "-" + dia_ini + "&dtfim=" + ano_fim + "-" + mes_fim + "-" + dia_fim;
            var janela;
            janela = window.open(link_pop, 'Relatório', 'width=850, height=600, scrollbars=yes, resizable=yes');
            return(true);
        }
        if(f.relatorio.value == 9){
            var link_pop = "forms/xls_lista_gerencial_estoque_com_documentacao.php?posicao_estoque=" + f.posicao_estoque.value + "&search_tipo=" + f.search_tipo.value;
            var janela;
            janela = window.open(link_pop, 'formulário', 'width=850, height=600, scrollbars=yes, resizable=yes');
            return(true);
        }
    }
    

  	//Inseriodo por Claudio dia 29/06/2007

  			function Dia(Data_DDMMYYYY)
			{
			string_data = Data_DDMMYYYY.toString();
			posicao_barra = string_data.indexOf("/");
			if (posicao_barra!= -1)
			{
			dia = string_data.substring(0,posicao_barra);
			return dia;
			}
			else
			{
			return false;
			}
			}

			function Mes(Data_DDMMYYYY)
			{
			string_data = Data_DDMMYYYY.toString();
			posicao_barra = string_data.indexOf("/");
			if (posicao_barra!= -1)
			{
			dia = string_data.substring(0,posicao_barra);
			string_mes = string_data.substring(posicao_barra+1,string_data.length);
			posicao_barra = string_mes.indexOf("/");
			if (posicao_barra!= -1)
			{
			mes = string_mes.substring(0,posicao_barra);
			mes = Math.floor(mes);
			return mes;
			}
			else
			{
			return false;
			}

			}
			else
			{
			return false;
			}
			}

			function Ano(Data_DDMMYYYY)
			{
			string_data = Data_DDMMYYYY.toString();
			posicao_barra = string_data.indexOf("/");
			if (posicao_barra!= -1)
			{
			dia = string_data.substring(0,posicao_barra);
			string_mes = string_data.substring(posicao_barra+1,string_data.length);
			posicao_barra = string_mes.indexOf("/");
			if (posicao_barra!= -1)
			{
			mes = string_mes.substring(0,posicao_barra);
			mes = Math.floor(mes);
			ano = string_mes.substring(posicao_barra+1,string_mes.length);
			return ano;
			}
			else
			{
			return false;
			}

			}
			else
			{
			return false;
			}
			}

			function Calcula_Data(data_DDMMYYYY,dias,adicao){

			Var_Dia=Dia(data_DDMMYYYY);
			Var_Mes=Mes(data_DDMMYYYY);
			Var_Mes=Math.floor(Var_Mes)-1;
			Var_Ano=Ano(data_DDMMYYYY);

			var data = new Date(Var_Ano,Var_Mes,Var_Dia);

			if (adicao == true)
			{
			operacao = '+'
			var diferenca = data.getTime() + (dias * 1000 * 60 * 60 * 24);
			}
			else
			{
			operacao = '-'
			var diferenca = data.getTime() - (dias * 1000 * 60 * 60 * 24);
			}
			    var data=new Date(diferenca);
				dia = data.getDate();
				mes = data.getMonth() + 1;
				ano = data.getFullYear();
				dia = (dia < 10 ? "0"+dia : dia);
				mes = (mes < 10 ? "0"+mes : mes);
				diferenca = dia + "/" + mes + "/" + ano;

			return(diferenca);
			}

			function Calcula_Dias(data1_DDMMYYYY,data2_DDMMYYYY){

			Var_Dia1=Dia(data1_DDMMYYYY);
			Var_Mes1=Mes(data1_DDMMYYYY);
			Var_Mes1=Math.floor(Var_Mes1)-1;
			Var_Ano1=Ano(data1_DDMMYYYY);
			var data1 = new Date(Var_Ano1,Var_Mes1,Var_Dia1);

			Var_Dia2=Dia(data2_DDMMYYYY);
			Var_Mes2=Mes(data2_DDMMYYYY);
			Var_Mes2=Math.floor(Var_Mes2)-1;
			Var_Ano2=Ano(data2_DDMMYYYY);
			var data2 = new Date(Var_Ano2,Var_Mes2,Var_Dia2);

			var diferenca = data2.getTime() - data1.getTime();
			var diferenca = Math.floor(diferenca / (1000 * 60 * 60 * 24));
			return(diferenca);

			}

				function periodo(dias,campo){
				if(dias!="")
				{
				data = adicionarDias(new Date(),dias);
				dia = data.getDate();
				mes = data.getMonth() + 1;
				ano = data.getFullYear();
				dia = (dia < 10 ? "0"+dia : dia);
				mes = (mes < 10 ? "0"+mes : mes);
				datanova = dia + "/" + mes + "/" + ano;
				dthoje=datahoje();
				switch (campo) {
    				case 1:
						if(dias==15)
						{
						   f.dtfim1.value=dthoje;
						   f.dtini1.value=Calcula_Data(dthoje,15,false);
						}
						else if(dias==1)
					    {
						   f.dtfim1.value=dthoje;
						   f.dtini1.value=Calcula_Data(dthoje,0,false);
					    }
						else if(dias==30)
						 {
						   f.dtfim1.value=dthoje;
						   f.dtini1.value=primeirodia();
					    }

       				    break
       				case 2:
       					if(dias==15)
						{
						   f.dtfim2.value=dthoje;
						   f.dtini2.value=Calcula_Data(dthoje,15,false);
						}
						else if(dias==1)
					    {
						   f.dtfim2.value=dthoje;
						   f.dtini2.value=Calcula_Data(dthoje,0,false);
					    }
						else if(dias==30)
						 {
						   f.dtfim2.value=dthoje;
						   f.dtini2.value=primeirodia();
					    }
       					break
       			   case 3:
       					f.dtfim3.value=datanova;
       					f.dtini3.value=dthoje;
       					break
       			   case 4:
       					f.dtfim4.value=datanova;
       					f.dtini4.value=dthoje;
       					break
       			  case 5:
       				    f.dtfim5.value=datanova;
       					f.dtini5.value=dthoje;
       					break
       			  case 6:
       					f.dtfim6.value=datanova;
       					f.dtini6.value=dthoje;
       					break
       			  case 7:
       					f.dtfim7.value=datanova;
       					f.dtini7.value=dthoje;
       					break
       			  case 8:
       					f.dtfim8.value=datanova;
       					f.dtini8.value=dthoje;
       					break

    		     default:
       				break
				}
			   }
	       }
	       function datahoje(){

				data = new Date();
				dia = data.getDate();
				mes = data.getMonth() + 1;
				ano = data.getFullYear();
				dia = (dia < 10 ? "0"+dia : dia);
				mes = (mes < 10 ? "0"+mes : mes);
				dthoje = dia + "/" + mes + "/" + ano;
				return(dthoje);
	       }

		    function dataformatada(){

				data = new Date();
				dia = data.getDate();
				mes = data.getMonth() + 1;
				ano = data.getFullYear();
				dia = (dia < 10 ? "0"+dia : dia);
				mes = (mes < 10 ? "0"+mes : mes);
				dtformatada = dia + "/" + mes + "/" + ano;
				return(dtformatada);
	       }
		   	function primeirodia(){

				data = new Date();
				dia = 1;
				mes = data.getMonth() + 1;
				ano = data.getFullYear();
				dia = (dia < 10 ? "0"+dia : dia);
				mes = (mes < 10 ? "0"+mes : mes);
				dia1mes = dia + "/" + mes + "/" + ano;
				return(dia1mes);
	       }


			function adicionarDias(data, dias){
		    return new Date(data.getTime() + (dias * 24 * 60 * 60 * 1000));
		     }
</script>
<form method="POST" name="f" action="" onSubmit="javascript:return verifica(this);">
<table cellpadding="3" class="form">
<tr>
	<td>&nbsp;</td>
	<td colspan="5"><strong>Selecione o relat&oacute;rio desejado </strong></td>
	</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan="5"><select name="relatorio" class="selectOnblur" onfocus="javascript: this.className='selectOnfocus';" onblur="javascript: this.className='selectOnblur';" onchange="javascript:recarregar();">
	  <option value=""></option>
	  <? if(false && $_SESSION["ss_usuario_grupo"]!=121) { ?>
	  <option value="8" <? if ($relatorio == 8) echo " selected"; ?>>Relat&oacute;rio Gerencial Financeiro Agrupado </option>
	  <? } ?>
	  <option value="2" <? if ($relatorio == 2) echo " selected"; ?>>Lista Gerencial de Estoque</option>
	  <option value="9" <? if ($relatorio == 9) echo " selected"; ?>>Lista Gerencial de Estoque Com Documenta&ccedil;&atilde;o</option>
	  <option value="3" <? if ($relatorio == 3) echo " selected"; ?>>Lista Gerencial de Ve&iacute;culos Vendidos com Vendedor</option>
      <option value="11" <? if ($relatorio == 11) echo " selected"; ?>>Lista Gerencial de Ve&iacute;culos Vendidos com Vendedor(Imposto)</option>
	  <option value="7" <? if ($relatorio == 7) echo " selected"; ?>>Lista Gerencial de Ve&iacute;culos Vendidos com Comiss&atilde;o</option>
	  <option value="5" <? if ($relatorio == 5) echo " selected"; ?>>Relat&oacute;rio Retorno de Financiamento</option>
	  <option value="6" <? if ($relatorio == 6) echo " selected"; ?>>Relat&oacute;rio Comiss&atilde;o de Vendedores</option>
	  <option value="4" <? if ($relatorio == 4) echo " selected"; ?>>Relat&oacute;rio Canal de Venda</option>
	  <option value="10" <? if ($relatorio == 10) echo " selected"; ?>>Relat&oacute;rio de Fechamento</option>
	  </select>
	  <!--option value="1" <? if ($relatorio == 1) echo " selected"; ?>>DRE</option--></td>
	</tr>
<?
if ($relatorio == 1){//INI-if ($relatorio == 1)
?>

<tr>
	<td height="30" colspan="6" class="text"></td>
	</tr>
<tr>
	<td colspan="6">Complete abaixo os campos para a impressão do relatório:</td>
	</tr>
<tr>
	<td width="120" valign="bottom">Modelo: </td>
	<td width="755" valign="bottom">Tipo: </td>

<?
	if($dre_tipo == "2"){
?>	<td width="164" valign="bottom">Mês:</td>

<?
	}
?>

	<td width="110" valign="bottom">Ano:</td>
	<td colspan="2" valign="bottom">&nbsp;</td>
	</tr>
<tr>
	<td width="120" valign="top">
		<select name="dre_modelo" class="selectOnblur" onFocus="javascript: this.className='selectOnfocus';" onBlur="javascript: this.className='selectOnblur';" OnChange="javascript: recarregar();">
			<option value="1" <? if($dre_modelo == "1") echo "selected"; ?>>Sintético</option>
			<option value="2" <? if($dre_modelo == "2") echo "selected"; ?>>Analítico</option>
		</select>
	</td>
	<td width="755" valign="top">
		<select name="dre_tipo" class="selectOnblur" onFocus="javascript: this.className='selectOnfocus';" onBlur="javascript: this.className='selectOnblur';" OnChange="javascript: recarregar();">
			<option value="1" <? if($dre_tipo == "1") echo "selected"; ?>>Anual</option>
			<option value="2" <? if($dre_tipo == "2") echo "selected"; ?>>Mensal</option>
		</select>
	</td>

<?
	if($dre_tipo == "2"){
?>

	<td width="164" valign="top">
		<select name="dtmes" class="selectOnblur" onFocus="javascript: this.className='selectOnfocus';" onBlur="javascript: this.className='selectOnblur';">
			<option value=""></option>
			<option value="1">Janeiro</option>
			<option value="2">Fevereiro</option>
			<option value="3">Março</option>
			<option value="4">Abril</option>
			<option value="5">Maio</option>
			<option value="6">Junho</option>
			<option value="7">Julho</option>
			<option value="8">Agosto</option>
			<option value="9">Setembro</option>
			<option value="10">Outubro</option>
			<option value="11">Novembro</option>
			<option value="12">Dezembro</option>
		</select>
	</td>

<?
	}
?>

	<td width="110" valign="top"><input type="text" name="dtano" value="<?=$dtano?>" size="10" maxlength="4" class="campodataOnblur" onBlur="javascript: this.className='campodataOnblur';" onFocus="javascript: this.className='campodataOnfocus';"></td>
	<td width="133" valign="top"><input type="submit" name="gerar_dre" value="gerar resultado" class="botao"></td>
	<td width="272" valign="top"><input type="submit" name="imprimir_dre" value="imprimir" class="botao"></td>
</tr>

<?
}
if ( $relatorio == 3 || $relatorio == 5 || $relatorio == 6 || $relatorio == 7 || $relatorio == 11) {
?>
<tr>
	<td height="30" colspan="6" class="text"></td>
	</tr>
<tr>
	<td width="120" class="text">Período:</td>
	<td width="755" colspan="5">
		<select name="periodo1" class="selectOnblur" onFocus="javascript: this.className='selectOnfocus';" onClick="javascript: this.className='selectOnblur';periodo(f.periodo1.value,1);">
			<option value=""<? if ($periodo1 == "") echo " selected"; ?>></option>
			<option value="1"<? if ($periodo1 == 1) echo " selected"; ?>>Diário</option>
			<option value="15"<? if ($periodo1 == 15) echo " selected"; ?>>Quinzenal</option>
			<option value="30"<? if ($periodo1 == 30) echo " selected"; ?>>Mensal</option>
		</select></td>
</tr>
<tr>
	<td class="text">Data:</td>
	<td colspan="5">
		<input type="text" name="dtini1" value="<?=$dtini1?>" size="10" maxlength="10" class="campodataOnblur" onBlur="javascript: this.className='campodataOnblur';" onFocus="javascript: this.className='campodataOnfocus';">
		 <img src="../i/ic_calendario.png" width="16" height="18" border="0" align="top" onclick="javascript:return showCalendar('dtini1', 'dd/mm/y');" style="cursor:pointer;">
		<input type="text" name="dtfim1" value="<?=$dtfim1?>" size="10" maxlength="10" class="campodataOnblur" onBlur="javascript: this.className='campodataOnblur';" onFocus="javascript: this.className='campodataOnfocus';">
		 <img src="../i/ic_calendario.png" width="16" height="18" border="0" align="top" onclick="javascript:return showCalendar('dtfim1', 'dd/mm/y');" style="cursor:pointer;">
	</td>
</tr>

<?
}
if($relatorio==3 || $relatorio==5 || $relatorio==6 || $relatorio==7 || $relatorio == 11){ ?>
<tr>
  <td width="120" class="text">Vendedor:</td>
  <td width="755" colspan="5"><select name="vendedor" id="vendedor" class="selectOnblur" onBlur="javascript: this.className='selectOnblur';" onFocus="javascript: this.className='selectOnfocus';">
    <option value="">-- Selecione o vendedor --</option>
	<?
	//busca vendedores
	$sql = "SELECT f.func_cod, p.pess_nome FROM funcionarios f INNER JOIN pessoas p on (f.pess_cod = p.pess_cod) 
	WHERE f.reve_cod = ". $_SESSION["ss_empresa_conectada"] ." AND func_tipo='t' AND func_status = 't' ORDER BY p.pess_nome";
	$result2 = query($sql);
	for($i=0;$i<num_rows($result2);$i++)
	{
		?><option value="<?=result($result2, $i, "func_cod")?>"><?=result($result2, $i, "pess_nome")?></option><?
	}
	?>
  </select></td>
</tr>
<?
}
if($relatorio==5){ ?>
<tr>
  <td width="120" class="text">Financeira:</td>
  <td width="755" colspan="5">
  	<select name="financeira" onblur="javascript: this.className = 'selectOnblur';" onfocus="javascript: this.className = 'selectOnfocus';" class="selectOnblur">
  		<option value="">----------------</option>
  	<?php 
  	$sql = "SELECT p.pess_nome FROM financeiras f 
  	INNER JOIN pessoas p on (f.pess_cod = p.pess_cod) 
  	WHERE fina_status = TRUE
  	ORDER BY p.pess_nome";
	$resFin = query($sql);
	//var_dump($resFin, num_rows($resFin));
	for($i=0;$i<num_rows($resFin);$i++)
	{
		$financeira = result($resFin,$i,"pess_nome");
		echo "<option value='".$financeira."'>".$financeira."</option>";
	}
  	?>
  	</select>
  </td>
</tr>
<?php 
}
if ($relatorio == 4){//INI-if ($relatorio == 3)
?>
<tr>
	<td height="30" colspan="6" class="text"></td>
</tr>
<tr>
	<td width="120" class="text">Período:</td>
	<td width="755" colspan="5">
		<select name="periodo2" class="selectOnblur" onFocus="javascript: this.className='selectOnfocus';" onClick="javascript: this.className='selectOnblur';periodo(f.periodo2.value,2);">
			<option value=""<? if ($periodo1 == "") echo " selected"; ?>></option>
			<option value="1"<? if ($periodo1 == 1) echo " selected"; ?>>Diário</option>
			<option value="15"<? if ($periodo1 == 15) echo " selected"; ?>>Quinzenal</option>
			<option value="30"<? if ($periodo1 == 30) echo " selected"; ?>>Mensal</option>
		</select></td>
</tr>
<tr>
	<td class="text">Data:</td>
	<td colspan="5">
		<input type="text" name="dtini2" value="<?=$dtini1?>" size="10" maxlength="10" class="campodataOnblur" onBlur="javascript: this.className='campodataOnblur';" onFocus="javascript: this.className='campodataOnfocus';">
		 <img src="../i/ic_calendario.png" width="16" height="18" border="0" align="top" onclick="javascript:return showCalendar('dtini2', 'dd/mm/y');" style="cursor:pointer;">
		<input type="text" name="dtfim2" value="<?=$dtfim1?>" size="10" maxlength="10" class="campodataOnblur" onBlur="javascript: this.className='campodataOnblur';" onFocus="javascript: this.className='campodataOnfocus';">
		  <img src="../i/ic_calendario.png" width="16" height="18" border="0" align="top" onclick="javascript:return showCalendar('dtfim2', 'dd/mm/y');" style="cursor:pointer;">
	</td>
</tr>

<?
}
if ($relatorio == 10){
?>
<tr>
	<td height="30" colspan="6" class="text"></td>
</tr>
<tr>
	<td width="120" class="text"></td>
</tr>
<tr>
	<td class="text">Periodo:</td>
	<td colspan="5">
            <select name="dtini1" class="selectOnblur" onFocus="javascript: this.className='selectOnfocus';" onClick="javascript: this.className='selectOnblur';">
                <option value="">Selecione</option>
                <?
                
                for($i=0;$i<12;$i++){
                    $dataSemDia = date('m-Y', strtotime('-'.$i.' month'));
                    $dataComDia = date('d-m-Y', strtotime('-'.$i.' month'));
                    echo '<option value="'.$dataComDia.'">'.$dataSemDia.'</option>';
                }
                
                ?>
            </select>
<!--		<input type="text" name="dtini1" value="<?=$dtini1?>" size="10" maxlength="10" class="campodataOnblur" onBlur="javascript: this.className='campodataOnblur';" onFocus="javascript: this.className='campodataOnfocus';">
		 <img src="../i/ic_calendario.png" width="16" height="18" border="0" align="top" onclick="javascript:return showCalendar('dtini1', 'dd/mm/y');" style="cursor:pointer;">-->
	</td>
</tr>
<?
}
if ($relatorio > 1){ 
    if($relatorio != 10) {?>
<tr>
	<td width="120" class="text"></td>
	<td width="755">
		</td>
</tr>

	<tr>
      <td class="text">Posição:</td>
      <td colspan="5">
       		<select name="posicao_estoque" class="selectOnblur" onfocus="javascript: this.className = 'selectOnfocus';" onblur="javascript: this.className = 'selectOnblur';">
            <option value="">----</option>

			<? 	for($i=1;$i<=10;$i++)
				{
			?>
				<option <? if($posicao_estoque==$i){ echo "selected"; }?> value="<?=$i?>"><?=$i?></option>
			<?
				}
			?>
	  		</select> <span class="barNav"><a href="#"><img src="../i/bt_info.gif" width="17" height="19" border="0" align="top"><span>Neste Campo é posivel determinar a posição do Titulo na Loja ou Estoque ou em outra Loja do grupo. A regra pode ser montada conforme necessidade do Cliente.</span></a></span></td>
    </tr>
<?
    }

$gerarxml = "";
if ($relatorio == 3 || $relatorio == 2 || $relatorio == 7 || $relatorio == 9 || $relatorio == 11) {
    $gerarxml = '<input type="button" name="gerar_xml" id="gerar_xml" value="gerar xls" class="btn" onClick="javascript: return geraXLS();" >';

?>
	<tr id="idtipo">
      <td class="text">Tipo:</td>
      <td colspan="5"><select name="search_tipo" class="selectOnblur" onBlur="javascript: this.className='selectOnblur';" onFocus="javascript: this.className='selectOnfocus';">
        <option value="">--------------------</option>
        <option value="1">Pr&oacute;prio</option>
        <option value="2">Consignado</option>
      </select></td>
    </tr>
<?
}
if($relatorio == 2){?>
	<tr id="idordenar">
      <td class="text">Ordenar por:</td>
      <td colspan="5"><select name="search_ordem" class="selectOnblur" onBlur="javascript: this.className='selectOnblur';" onFocus="javascript: this.className='selectOnfocus';">
        <option value="">--------------------</option>
        <option value="1">Marca</option>
        <option value="2">Modelo</option>
        <option value="3">Ano</option>
        <option value="4">Cor</option>
        <option value="5">Placa</option>
        <option value="6">Posição</option>
        <option value="7">Tipo</option>
        <option value="8">R$ Compra</option>
        <option value="9">R$ Venda</option>
        <option value="10">Maior Período em Estoque</option>
        <option value="11">Menor Período em Estoque</option>
      </select></td>
    </tr>
<?}
?>

<tr>
	<td height="20" colspan="6" class="text"></td>
</tr>
<?
if($relatorio_botao == 10){
?>
    <tr>
            <td>
            <td colspan="5"><input type="submit" name="Gerar" id="Gerar" value="Gerar" class="btn" />            
    </tr>
<?
}else{
?>
    <tr>
    				<td>&nbsp;</td>
            <td colspan="5"><input type="submit" name="imprimir" id="imprimir" value="imprimir" class="btn">
            <?php echo $gerarxml; ?></td>
    </tr>
<?
}
?>
<tr>
	<td height="20" colspan="6" class="text"></td>
</tr>
<?
}
?>
<tr>
	  <td height="20" colspan="6"><? include("../icone_acrobat.php") ?></td>
	</tr>
	<tr>
	  <td height="20" colspan="6" class="text"></td>
	</tr>
</table>
</form>
