<?php
    header('Content-type: text/html');

    //abrindo includes
    include("../../config.php");
    include("../../functions.php");

    //start session + conexao
    session_start();
    conectar();
    conectar_mcn();

    if(!isset($_SESSION["ss_empresa_conectada"]) || empty($_SESSION["ss_empresa_conectada"])){
    ?>Sua sessão expirou! Será necessário efetuar o login no sistema novamente.<?
        exit();
    }

    $sql = "SELECT * from vendas where id_veiculo=". $_POST["veic_cod"];
    $verificaVenda = query($sql);
    if(num_rows($verificaVenda)==0)
    {
    if($_POST['preVenda'] == 'true')
    {
        include_once('./inse_saida_pre-venda.php');
        exit;
    }
    else
    {

        $fileLog = '/logs/estoque/log_vendaVeic_'.date("Y-m-d_H-i-s");
        // variaveis no comeco do script
        $varsINI = get_defined_vars();

        $totalPagamentos = number_format($_SESSION['total_pagamento'], 2, ',', '.');
	$totalPagamentos = str_replace(".","",$totalPagamentos);
	$totalPagamentos = str_replace(",",".",$totalPagamentos);

        $preco_venda = str_replace(".","",number_format($_POST['preco_venda'],2, ',', '.'));
        $preco_venda = str_replace(",",".",$preco_venda);
	

        if((float)$preco_venda > (float)$totalPagamentos){
            die(utf8_encode("O total de pagamentos incluídos é de R$ $totalPagamentos. Este valor deve ser maior ou igual ao valor da venda de R$ $preco_venda "));
        }

        if($_POST["senhaAdm"] != "" || $_POST["loginAdm"] != ""){
            $usuasenha_md5 = md5($_POST["senhaAdm"]);
            $usualogin1 = $_POST["loginAdm"];

            $sqlusua="SELECT
            a.usua_cod,
            a.usua_login,
            a.usua_email,
            a.usua_dtatua,
            a.usua_senha,
            a.reve_cod,
            a.fina_cod,
            a.grup_cod,
            a.pess_cod,
            b.pess_nome,
            a.usuario_tipo,
            g.grup_selecao
            FROM
            usuarios AS a
            INNER JOIN pessoas AS b ON (a.pess_cod=b.pess_cod)
            INNER JOIN grupos AS g ON (a.grup_cod=g.grup_cod)
            WHERE
            (a.usua_email LIKE '$usualogin1')
            AND a.usua_senha='$usuasenha_md5'
            AND a.usua_status='1'
            AND a.grup_cod='128'";


            //        echo $sqlusua;
            $rsusuario = query($sqlusua);
            if(num_rows($rsusuario) == 0)
            {
                die('Login e Senha de Administrador Incorretos');
            }
        }



        //dados veiculo
        $sql 	= "SELECT veic_cod, ma.marc_nome, m.mode_nome, veic_anomodelo, c.core_nome, veic_placa, veic_valorfinal, veic_valorcompra,posicao_estoque, veic_tipo ";
        $sql 	.= " FROM veiculos v INNER JOIN modelos m on (v.mode_cod = m.mode_cod) INNER JOIN marcas ma on (v.marc_cod = ma.marc_cod) ";
        $sql 	.= " INNER JOIN cores c on (v.core_cod = c.core_cod) ";
        $sql 	.= " WHERE reve_cod = ". $_SESSION["ss_empresa_conectada"] ." ";
        $sql	.= " AND veic_situacao in (2,7) AND veic_cod = ". $_POST["veic_cod"] ."";
        $result_veiculo = query($sql);
        $descricao_financeiro = "VENDA " . result($result_veiculo, 0, "marc_nome") ." ". result($result_veiculo, 0, "mode_nome") ." ". result($result_veiculo, 0, "veic_anomodelo") ." ". result($result_veiculo, 0, "core_nome") ." ". result($result_veiculo, 0, "veic_placa") ."";
        $valor_compra = result($result_veiculo, 0, "veic_valorcompra");
	$veic_tipo_bda =result($result_veiculo, 0, "veic_tipo");
        //$posicao_estoque=result($result_veiculo, 0, "posicao_estoque");

        $posicao_estoque = $_POST['posicao_estoque'];

        //Buscando parametros de categoria e subcategoria do financeiro
        $sql = "SELECT cate_cod, subc_cod FROM param WHERE nome_param = 'VENDA_VEICULO' AND reve_cod = ". $_SESSION["ss_empresa_conectada"] ."";
        $result_param = query($sql);
        if(num_rows($result_param)>0)
        {
            $cate_cod	= result($result_param, 0, "cate_cod");
            $subc_cod	= result($result_param, 0, "subc_cod");
        }
        else
        {
        ?>
        Atenção, o PARAMETRO 'VENDA_VEICULO' não foi configurado para sua empresa!
        <?
            exit();
        }

        $sql = "SELECT cate_cod, subc_cod FROM param WHERE nome_param = 'TROCO_NATROCA' AND reve_cod = ". $_SESSION["ss_empresa_conectada"] ."";
        $result_param = query($sql);
        if(num_rows($result_param)>0)
        {
            $cate_cod_troco = result($result_param, 0, "cate_cod");
            $subc_cod_troco = result($result_param, 0, "subc_cod");
        }
        else
        {
        ?>Atenção, o PARAMETRO 'TROCO_NATROCA' não foi configurado para sua empresa!
        <?
            exit();
        }

        $sql = "SELECT cate_cod, subc_cod FROM param WHERE nome_param = 'COMISSAO_VENDA' AND reve_cod = ". $_SESSION["ss_empresa_conectada"] ."";
        $result_param = query($sql);
        if(num_rows($result_param)>0)
        {
            $cate_cod_comis	= result($result_param, 0, "cate_cod");
            $subc_cod_comis	= result($result_param, 0, "subc_cod");
        }
        else
        {
        ?>Atenção, o PARAMETRO 'COMISSAO_VENDA' não foi configurado para sua empresa!
        <?
            exit();
        }


        $erro = false;
        $resp="";
        //iniciando transação
        
        query("set TRANSACTION ISOLATION LEVEL READ UNCOMMITTED");
        query("BEGIN TRANSACTION");
        
        query_mcn("set TRANSACTION ISOLATION LEVEL READ UNCOMMITTED");
        query_mcn("BEGIN TRANSACTION");

        //passo 1 - gravar informacoes da venda em [vendas]

        $_POST["preco_venda"] = str_replace(",", ".", $_POST["preco_venda"]);
        $_POST["valor_transferencia"] = str_replace(",", ".", $_POST["valor_transferencia"]);
        $_POST["valor_transferencia"] = number_format((double)$_POST["valor_transferencia"],2, '.', '');

        if(!$_POST["clientedocumento_cod"]){
            $_POST["clientedocumento_cod"] = 0;
        }

        $sql = "INSERT INTO vendas(id_veiculo, id_cliente, id_revenda, data_venda, valor_venda, id_vendedor,id_canal_venda,obs_canal_venda, id_usuario, observacao_recibo, valor_transferencia, id_clientedocumento) ";
        $sql .= " VALUES(". $_POST["veic_cod"] .", ". $_POST["clie_cod"] .", ". $_SESSION["ss_empresa_conectada"] .", ";
        $sql .= " '". fu_formata_data_insert($_POST["data_venda"]) ."', '". $_POST["preco_venda"] ."', ";
        $sql .= " ". $_POST["vendedor"] .",'".$_POST["id_canal"]."','".$_POST["obs_canal"]."', ". $_SESSION["ss_usuario_cod"] .", '". pg_escape_string(utf8_decode($_POST["observacao_venda"])) ."', '". $_POST["valor_transferencia"] ."', ". $_POST["clientedocumento_cod"] ." )";

        $rsVenda = query($sql);

        if($rsVenda === false)
        {
            
	    mail('bruno@revendamais.com.br','Erro query - inse_veiculo_action',$sql.''.pg_last_error());
            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 1.1!";
            $myError =$resp.pg_last_error();
            doLog($fileLog,$varsINI,get_defined_vars());
            $myError =$resp;
            echo $myError;

            query("ROLLBACK TRANSACTION");
            query_mcn("ROLLBACK TRANSACTION");
            exit;
        }



        $result_venda = query("SELECT CURRVAL('vendas_id_seq') as id_venda");
        $id_venda = result($result_venda, 0, "id_venda");
        $_SESSION["id_venda"] = $id_venda;

	if ($veic_tipo_bda==2)
	{

                //inserindo titulo no financeiro
                    $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                    $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                    $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                    $sql .= " VALUES ('". date("Y-m-d") ."', '". date("Y-m-d") ."', '". date("Y-m-01") ."', '". str_replace('VENDA ', 'COMPRA ', strtoupper($descricao_financeiro)) ."', 'f', ". $cate_cod .", ";
                    $sql .= " 0, ". $_SESSION["ss_empresa_conectada"] .", 0, 0, '0', '0', '". $valor_compra ."', ";
                    $sql .= " '0', '1', 'P', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                    $sql .= " NULL, 1,'$posicao_estoque')";
                    $rsTit = query($sql);
                    if($rsTit===false)
                    {
                        $erro = true;
                        $resp = "Erro movimentacao contas CONSIGNACAO!\n";
                        $myError =$resp.pg_last_error();
			$resp = $myError."\n".$sql."\n";
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;

                    }
                    //gravando relacao id_venda X id_movimento
                    $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                    $id_movimento = result($result_movimento, 0, "id_movimento");

                    $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                    $rsMov = query($sql);
                    if($rsMov===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!\n";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;

                    }

	}

        foreach($_SESSION["pagamentos"] as $pagamento){
            $pagamento['valor'] = str_replace('.', '', $pagamento['valor']);
            $pagamento['valor'] = str_replace(',', '.', $pagamento['valor']);

            switch($pagamento['tipo']){
                case "DIN":

                    $sql = "INSERT INTO vendas_dinheiro(id_venda, valor) VALUES(". $id_venda .", '". $pagamento['valor'] ."')";
                    $rsDin = query($sql);
                    if($rsDin===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;

                    }
                    //inserindo titulo no financeiro
                    $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                    $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                    $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                    $sql .= " VALUES ('". date("Y-m-d") ."', '". date("Y-m-d") ."', '". date("Y-m-01") ."', '". strtoupper($descricao_financeiro) ."', 'f', ". $cate_cod .", ";
                    $sql .= " ". $subc_cod .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". $pagamento["valor"] ."', ";
                    $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                    $sql .= " NULL, 1,'$posicao_estoque')";
                    $rsTit = query($sql);
                    if($rsTit===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;

                    }
                    //gravando relacao id_venda X id_movimento
                    $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                    $id_movimento = result($result_movimento, 0, "id_movimento");

                    $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                    $rsMov = query($sql);
                    if($rsMov===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;

                    }

                    break;
                case "CHE":

                    $sql = "INSERT INTO vendas_cheque(id_venda, id_banco, numero_agencia, numero_cheque, data_cheque, valor) ";
                    $sql .= " VALUES(". $id_venda .", ". $pagamento["cheque_banco"] .", '". $pagamento["cheque_agencia"] ."', ";
                    $sql .= " '". $pagamento["cheque_numero"] ."', '". fu_formata_data_insert($pagamento["vencimento"]) ."', ";
                    $sql .= " '". $pagamento["valor"] ."')";

                    $rsChe = query($sql);
                    if($rsChe===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //inserindo titulo no financeiro
                    $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                    $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                    $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                    $sql .= " VALUES ('". date("Y-m-d") ."', '". fu_formata_data_insert($pagamento["vencimento"]) ."', '". date("Y-m-01") ."', '". strtoupper($descricao_financeiro) ."', 'f', ". $cate_cod .", ";
                    $sql .= " ". $subc_cod .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". $pagamento["valor"] ."', ";
                    $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", '". $pagamento["cheque_numero"] ."', NULL, NULL, ". $pagamento["cheque_banco"] .", '". $pagamento["cheque_agencia"] ."', ";
                    $sql .= " NULL, 2,'$posicao_estoque')";
                    $rsTit = query($sql);
                    if($rsTit===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //gravando relacao id_venda X id_movimento
                    $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                    $id_movimento = result($result_movimento, 0, "id_movimento");

                    $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                    $rsMov = query($sql);
                    if($rsMov===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }


                    break;
                case "FIN":

                    $vlr_financiado_ret = 0;
                    if($pagamento["vlr_financiado_retorno"]!="")
                    {
                        $vlr_financiado_ret = str_replace(",", ".", $pagamento["vlr_financiado_retorno"]);

                        //inserindo titulo no financeiro sobre o retorno de financiamento
                        $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                        $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                        $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                        $sql .= " VALUES ('". date("Y-m-d") ."', '". date("Y-m-d") ."', '". date("Y-m-01") ."', 'RETORNO DA ". strtoupper($descricao_financeiro) ."', 'f', '654', ";
                        $sql .= " '0', ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". ($vlr_financiado_ret) ."', ";
                        $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                        $sql .= " NULL, NULL,'$posicao_estoque')";
                        $rsTit = query($sql);
                        
                        if($rsTit===false)
                        {
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                        //gravando relacao id_venda X id_movimento
                        $result_ret = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                        $id_retorno = result($result_ret, 0, "id_movimento");

                        $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_retorno.")";
                        $rsRet = query($sql);
                        if($rsRet===false)
                        {
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                    }

                    $vlr_financiado_plus = 0;
                    if($pagamento["vlr_financiado_plus"]!="")
                    {
                        $vlr_financiado_plus = str_replace(",", ".", $pagamento["vlr_financiado_plus"]);

                        //inserindo titulo no financeiro sobre o retorno de financiamento
                        $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                        $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                        $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                        $sql .= " VALUES ('". date("Y-m-d") ."', '". date("Y-m-d") ."', '". date("Y-m-01") ."', 'PLUS ". strtoupper($descricao_financeiro) ."', 'f', '682', ";
                        $sql .= " '0', ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". ($vlr_financiado_plus) ."', ";
                        $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                        $sql .= " NULL, NULL,'$posicao_estoque')";
                        $rsTit = query($sql);
                        if($rsTit===false)
                        {
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                        //gravando relacao id_venda X id_movimento
                        $result_ret = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                        $id_retorno = result($result_ret, 0, "id_movimento");

                        $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_retorno.")";
                        $rsRet = query($sql);
                        if($rsRet===false)
                        {
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                    }
                    $vlr_financiado_tac = 0;
                    if($pagamento["vlr_financiado_tac"]!="")
                    {
                        $vlr_financiado_tac = str_replace(",", ".", $pagamento["vlr_financiado_tac"]);

                        //inserindo titulo no financeiro sobre o retorno de financiamento
                        $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                        $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                        $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                        $sql .= " VALUES ('". date("Y-m-d") ."', '". date("Y-m-d") ."', '". date("Y-m-01") ."', 'TAC ". strtoupper($descricao_financeiro) ."', 'f', '681', ";
                        $sql .= " '0', ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". ($vlr_financiado_tac) ."', ";
                        $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                        $sql .= " NULL, NULL,'$posicao_estoque')";
                        $rsTit = query($sql);
                        if($rsTit===false)
                        {
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                        //gravando relacao id_venda X id_movimento
                        $result_ret = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                        $id_retorno = result($result_ret, 0, "id_movimento");

                        $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_retorno.")";
                        $rsRet = query($sql);
                        if($rsRet===false)
                        {
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                    }


                    $pagamento["valor_parcelas"] = str_replace(",", ".", $pagamento["valor_parcelas"]);

                    $sql = "INSERT INTO vendas_financiamento(id_venda, nome_financeira, numero_parcelas, valor_parcela, texto_adicional, valor, valor_retorno,valor_tac,valor_plus) ";
                    $sql .= " VALUES(". $id_venda .", '". $pagamento["financeira"] ."', ". $pagamento["fina_parcelas"] .", ";
                    $sql .= " '". $pagamento["valor_parcelas"] ."', '". $pagamento["fina_descricao"] ."', '". $pagamento["valor"] ."', '$vlr_financiado_ret','$vlr_financiado_tac','$vlr_financiado_plus') ";

                    $rsFin = query($sql);
                    if($rsFin===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //inserindo titulo no financeiro
                    $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                    $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                    $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                    $sql .= " VALUES ('". date("Y-m-d") ."', '". date("Y-m-d") ."', '". date("Y-m-01") ."', '". strtoupper($descricao_financeiro) ."', 'f', ". $cate_cod .", ";
                    $sql .= " ". $subc_cod .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". ($pagamento["valor"]) ."', ";
                    $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                    $sql .= " NULL, 12,'$posicao_estoque')";

                    $rsTit = query($sql);
                    if($rsTit===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //gravando relacao id_venda X id_movimento
                    $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                    $id_movimento = result($result_movimento, 0, "id_movimento");

                    $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                    $rsMov = query($sql);
                    if($rsMov===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    break;
                case "VEI":
                    
                    if(isset($pagamento["mode_cod"]))
                    {
                        $pagamento["modelo"]=$pagamento["mode_cod"];   
                    }
                    if(isset($pagamento["marc_cod"]))
                    {
                        $pagamento["marca"]=$pagamento["marc_cod"];   
                    }

                    $sql = "INSERT INTO veiculos(mode_cod, marc_cod, reve_cod, comb_cod, core_cod, tpve_cod, veic_dtentrada, ";
                    $sql .= " veic_placa, veic_chassi, veic_renavan, veic_km, veic_anomodelo, veic_anofabr, veic_valorcompra, veic_status, veic_tipo, veic_situacao, ";
                    $sql .= " veic_data_inc, moeda, veic_publicar, tipo_preco, veic_valorquitacao, veic_valordebitos, veic_valorliquido,veic_qtdportas, qtdpassageiros, camb_cod) ";
                    $sql .= " VALUES(". $pagamento["modelo"] .", ". $pagamento["marca"] .", ". $_SESSION["ss_empresa_conectada"] .", ". $pagamento["comb_cod"] .", ";
                    $sql .= " ". $pagamento["core_cod"] .", ". $pagamento["tpve_cod"] .", '". date('Y-m-d')  ."', ";
                    $sql .= " '". strtoupper($pagamento["placa"]) ."', '". $pagamento["chassi"] ."', '". $pagamento["renavam"] ."', '". $pagamento["veic_km"] ."', ". $pagamento["anomodelo"] .", ". $pagamento["anofabricacao"] .", '".str_replace(",",".",$pagamento["valor_compra"])."', ";
                    $sql .= " ". $pagamento["veic_status"] .", ". $pagamento["veic_tipo"] .", 1, '". date("Y-m-d") ."', 'RS', 0, 'A', '".str_replace(",",".",$pagamento["veic_valorquitacao"])."','".str_replace(",",".",$pagamento["veic_valordebitos"])."','".str_replace(",",".",$pagamento["valor"])."', ".$pagamento["veic_qtdportas"].", ".$pagamento["qtdpassageiros"].", ".$pagamento["camb_cod"].")";
                    //                    die($sql);
                    $rsVei = query($sql);
                    if($rsVei===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01 MRC teste de portas!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }
                    //print($sql)                 ;

                    $result_troca = query("SELECT CURRVAL('veiculos_veic_cod_seq') as id_veiculo");
                    $id_veiculo = result($result_troca, 0, "id_veiculo");

                    $sql = "INSERT INTO vendas_trocaveiculo(id_venda, id_veiculo, valor) VALUES(". $id_venda .", ". $id_veiculo .", '". $pagamento["valor"] ."')";
                    $rsTroca = query($sql);
                    if($rsTroca===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. TRO-01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    /* SALVAR ENTRADA DE ESTOQUE */
                    //CAMPOS DE VALORES FIXOS
                    $comp_intermediario	= $pagamento["veic_intermediario"];
                    if($comp_intermediario=="")
                        $comp_intermediario="NULL";
                    else
                        $comp_intermediario="'".$comp_intermediario."'";

                    $comp_tele1 = $comp_tele2 = $comp_tele3 = $comp_tele4 = "NULL";
                    $comp_status = "TRUE";
                    $veic_situacao = 2;
                    $comp_adicional = "";
                    $observacao_compra = "ENTROU COMO PARTE DO PAGAMENTO DA ".$descricao_financeiro;

                    $comp_data = ($_POST["data_venda"]==""?"":fu_formata_data_insert($_POST["data_venda"]));
                    if($comp_data=="")
                        $comp_data = date("Y-m-d");

                    $dtreferencia = date("Y-m-01");
                    if(isset($pagamento['cliente_doc_cod']) && $pagamento['cliente_doc_cod'] != ""){
                        $codigoClienteDocNome = $pagamento['cliente_doc_cod'];
                    }else{
                        $codigoClienteDocNome = 'null';
                    }
                    //gravando informações da compra
                    $sql = "INSERT INTO compras(clie_cod, veic_cod, reve_cod, comp_intermediario, comp_tele1, comp_tele2, comp_tele3, comp_status, comp_data, comp_adicional, " .
                    "observacao_compra,id_vendedor, clie_cod_nome_doc) 
                    VALUES(".$_POST['clie_cod'].", '".$id_veiculo."', '".$_SESSION["ss_empresa_conectada"]."', $comp_intermediario, $comp_tele1, $comp_tele2, $comp_tele3, '$comp_status', '".$comp_data."', '$comp_adicional', " .
                    "'". $observacao_compra ."',".$_POST["vendedor"].", $codigoClienteDocNome)";	

                    $rsIns = query($sql);

                    if ($rsIns === false){
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. TRO-02!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    $sql = " SELECT CURRVAL('compras_comp_cod_seq') as valor";
                    $result = query($sql);
                    $compra_cod = result($result, 0, "valor");

                    //DADOS USADOS NA TELA DE IMPRESSAO
                    $_SESSION["ss_ent_compra_cod"] = $compra_cod;

                    $sqlVeiculo = "UPDATE veiculos SET veic_situacao = '$veic_situacao', veic_dtentrada = NOW(), posicao_estoque = '$posicao_estoque' WHERE veic_cod = ".$id_veiculo;	
                    $rsUpd = query($sqlVeiculo);
                    if ($rsIns === false){
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. TRO-03!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }
                    //INICIO ENTRADA NO FINANCEIRO
                    $dtreferencia = date("Y-m-01");
                    $reve_cod = $_SESSION["ss_empresa_conectada"];
                    $veic_valorliquido = str_replace(",",".",$pagamento["valor"]);
                    $veic_valorquitacao = str_replace(",",".",$pagamento["veic_valorquitacao"]);
                    $veic_valordebitos = str_replace(",",".",$pagamento["veic_valordebitos"]);
                    $clie_cod = $_POST["clie_cod"];
			/*
                    if ($pagamento["veic_tipo"] == 1){
                        $rsParam = GetParametrosLoja('ENTRADA_ESTOQUE');
                        if ($rsParam === false) {
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. TRO-03!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                        $cate_cod = result($rsParam, 0, "cate_cod");
                        $subc_cod = (result($rsParam, 0, "subc_cod") == "" ? 0 : result($rsParam, 0, "subc_cod"));
                        $descricao_manutencao = "ENTRADA NO ESTOQUE (veiculo na troca) " . $pagamento["modelo"] . ", " . $pagamento["marca"]." ".strtoupper($pagamento["placa"]);
                        $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo,valor_pago, dre, tipo_movimento, clie_cod, compra_cod) 
                                    VALUES('" . date("Y-m-d") . "',	'" . date("Y-m-d") . "', '$dtreferencia', '$descricao_manutencao', 'f', $cate_cod, $subc_cod, $reve_cod, 0, 0, 0, 0, '$veic_valorliquido', 0, '1', 'P', $clie_cod, $compra_cod)";
                        $rsIns = query($sql);

                        if ($rsIns === false) {
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. TRO-03!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }

                        $sql = " SELECT CURRVAL('movimentacao_contas_id_seq') as valor";
                        $result = query($sql);
                        $conta_pagar = result($result, 0, "valor");
                    }
*/
		
                    //gera titulo a pagar do valor de quitacao e valor de debito
                    if ($veic_valorquitacao > 0) {
                        //salvando quitacao
                        //amortização de financiamento 117
                        $descricao_manutencao = "ENTRADA NO ESTOQUE (veiculo na troca) - Valor de quitação - " . $pagamento["modelo"] . ", " . $pagamento["marca"]." ".strtoupper($pagamento["placa"]);
                        $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo,valor_pago, dre, tipo_movimento, clie_cod, compra_cod) 
                            VALUES('" . date("Y-m-d") . "',	'" . date("Y-m-d") . "', '$dtreferencia', '$descricao_manutencao', 'f', 117, 0, $reve_cod, 0, 0, 0, 0, '$veic_valorquitacao', 0, '0', 'P', $clie_cod, $compra_cod)";
                        $rsIns = query($sql);
                        if ($rsIns === false) {
                            $erro = true;
                            $resp = "Ocorreu erro amortização de financiamento";
                            $myError =$resp.pg_last_error(); 
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                    }
                    if ($veic_valordebitos > 0) {
                        //salvando valor de debito
                        //ip´va/licencimaneto/multa/...... 82
                        $descricao_manutencao = "ENTRADA NO ESTOQUE (veiculo na troca) - Valor de debito - " . $pagamento["modelo"] . ", " . $pagamento["marca"]." ".strtoupper($pagamento["placa"]);
                        $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo,valor_pago, dre, tipo_movimento, clie_cod, compra_cod) 
                            VALUES('" . date("Y-m-d") . "',	'" . date("Y-m-d") . "', '$dtreferencia', '$descricao_manutencao', 'f', 82, 0, $reve_cod, 0, 0, 0, 0, '$veic_valordebitos', 0, '0', 'P', $clie_cod, $compra_cod)";
                        $rsIns = query($sql);
                        if ($rsIns === false) {
                            $erro = true;
                            $resp = "Ocorreu erro salvando valor de debito!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                    }
                    //FIM ENTRADA NO FINANCEIRO
                    
                    
                    /* FIM ENTRADA DE ESTOQUE */

                    //busca cidade da revenda
                    $rs_cidade = query("SELECT cida_cod FROM reve_cida WHERE reve_cod = ". $_SESSION["ss_empresa_conectada"]);
                    $id_cidade = result($rs_cidade, 0, "cida_cod");
                    break;
                case "CON":
                    $pagamento["valor"] = str_replace(",", ".", $pagamento["valor"]);

                    $sql = "INSERT INTO vendas_consorcio(id_venda, nome_consorcio, texto_adicional, valor) ";
                    $sql .= " VALUES(". $id_venda .", '". $pagamento["cons_nome"] ."', '". $pagamento["cons_descricao"] ."', ";
                    $sql .= " '". $pagamento["valor"] ."')";

                    $rsCon = query($sql);
                    if($rsCon===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //inserindo titulo no financeiro
                    $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                    $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                    $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                    $sql .= " VALUES ('". date("Y-m-d") ."', '". date("Y-m-d") ."', '". date("Y-m-01") ."', '". strtoupper($descricao_financeiro) ."', 'f', ". $cate_cod .", ";
                    $sql .= " ". $subc_cod .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". $pagamento["valor"] ."', ";
                    $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                    $sql .= " NULL, 13,'$posicao_estoque')";
                    $rsTit = query($sql);
                    if($rsTit===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //gravando relacao id_venda X id_movimento
                    $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                    $id_movimento = result($result_movimento, 0, "id_movimento");

                    $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                    $rsMov = query($sql);
                    if($rsMov===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    break;
                case "PRO":
                    $dias = $pagamento['promissoria_frequencia'];
                    $dtvencimento = fu_formata_data_insert($pagamento["vencimento"]);
                    $dtvencimento_new = $dtvencimento;
                    for($i=0;$i<$pagamento['promissoria_numero'];$i++){
                        
                        $numeroPromissoria = ($i + 1)."/".$pagamento['promissoria_numero'];
                        $valor_unitario = str_replace(",", ".", str_replace(".", "",$pagamento["valor_unitario"]));
                       
                        $sql = "INSERT INTO vendas_promissoria(id_venda, numero_promissoria, data_promissoria, valor) ";
                        $sql .= " VALUES(". $id_venda .", ";
                        $sql .= " '". $numeroPromissoria ."', '". $dtvencimento_new ."', ";
                        $sql .= " '". $valor_unitario ."')";

                        $rsChe = query($sql);
                        if($rsChe===false){
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - vendas promissoria ";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }

                        //inserindo titulo no financeiro
                        $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                        $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                        $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                        $sql .= " VALUES ('". date("Y-m-d") ."', '". $dtvencimento_new ."', '". date("Y-m-01") ."', 'PROMISSORIA ". strtoupper($descricao_financeiro) ."', 'f', ". $cate_cod .", ";
                        $sql .= " ". $subc_cod .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". $valor_unitario ."', ";
                        $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", '". $numeroPromissoria ."', NULL, NULL, ";
                        $sql .= " NULL, 9,'$posicao_estoque')";
                        $rsTit = query($sql);
                        if($rsTit===false){
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - movimentacao contas - $i $dtvencimento_new -";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }

                        //gravando relacao id_venda X id_movimento
                        $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                        $id_movimento = result($result_movimento, 0, "id_movimento");

                        $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                        $rsMov = query($sql);
                        if($rsMov===false){
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - vendas movimentacaocontas";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                        
                        if($dias=="30"){
                            $dtvencimento_new = date("Y-m-d", mktime(0, 0, 0, substr($dtvencimento, 5 ,2)+(1*($i+1)), substr($dtvencimento, 8 ,2), substr($dtvencimento, 0 ,4)));
			}else{
                            $dtvencimento_new = date("Y-m-d", mktime(0, 0, 0, substr($dtvencimento_new, 5 ,2), substr($dtvencimento_new, 8 ,2)+$dias, substr($dtvencimento_new, 0 ,4)));
			}
                        
                    }
                    
                    break;
                case "CAR":

                    $sql = "INSERT INTO vendas_cartaodecredito(id_venda, valor, data_parcela, valor_parcela) ";
                    $sql .= " VALUES(". $id_venda .", ". $pagamento["valor"] .", '". fu_formata_data_insert($pagamento["vencimento"]) ."', ";
                    $sql .= " '". $pagamento["valor"] ."')";
                    $rsChe = query($sql);
                    if($rsChe===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //inserindo titulo no financeiro
                    $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                    $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                    $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                    $sql .= " VALUES ('". date("Y-m-d") ."', '". fu_formata_data_insert($pagamento["vencimento"]) ."', '". date("Y-m-01") ."', '". strtoupper($descricao_financeiro) ."', 'f', ". $cate_cod .", ";
                    $sql .= " ". $subc_cod .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". $pagamento["valor"] ."', ";
                    $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", '', NULL, NULL, ";
                    $sql .= " NULL, 7,'$posicao_estoque')";
                    $rsTit = query($sql);
                    if($rsTit===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //gravando relacao id_venda X id_movimento
                    $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                    $id_movimento = result($result_movimento, 0, "id_movimento");

                    $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                    $rsMov = query($sql);
                    if($rsMov===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    break;
                case "DEB":

                    $sql = "INSERT INTO vendas_cartaodedebito(id_venda, valor, data_parcela, valor_parcela) ";
                    $sql .= " VALUES(". $id_venda .", ". $pagamento["valor"] .", '". fu_formata_data_insert($pagamento["vencimento"]) ."', ";
                    $sql .= " '". $pagamento["valor"] ."')";
                    $rsChe = query($sql);
                    if($rsChe===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar o tipo de pagamento debito - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //inserindo titulo no financeiro
                    $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                    $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                    $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                    $sql .= " VALUES ('". date("Y-m-d") ."', '". fu_formata_data_insert($pagamento["vencimento"]) ."', '". date("Y-m-01") ."', '". strtoupper($descricao_financeiro) ."', 'f', ". $cate_cod .", ";
                    $sql .= " ". $subc_cod .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". $pagamento["valor"] ."', ";
                    $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", '', NULL, NULL, ";
                    $sql .= " NULL, 10,'$posicao_estoque')";
                    $rsTit = query($sql);
                    if($rsTit===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //gravando relacao id_venda X id_movimento
                    $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                    $id_movimento = result($result_movimento, 0, "id_movimento");

                    $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                    $rsMov = query($sql);
                    if($rsMov===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    break;
                case "TED":
                    $sql = "INSERT INTO vendas_teddoc(id_venda, valor, vencimento) VALUES(". $id_venda .", '". $pagamento["valor"] ."', '". fu_formata_data_insert($pagamento["vencimento"]) ."')";
                    $rsDin = query($sql);
                    if($rsDin===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }
                    //inserindo titulo no financeiro
                    $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                    $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                    $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                    $sql .= " VALUES ('". date("Y-m-d") ."', '". fu_formata_data_insert($pagamento["vencimento"]) ."', '". date("Y-m-01") ."', '". strtoupper($descricao_financeiro) ."', 'f', ". $cate_cod .", ";
                    $sql .= " ". $subc_cod .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". $pagamento["valor"] ."', ";
                    $sql .= " '0', '1', 'R', ". $_POST["clie_cod"].", NULL, NULL, NULL, NULL, NULL, ";
                    $sql .= " NULL, 3,'$posicao_estoque')";
                    $rsTit = query($sql);
                    if($rsTit===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }
                    //gravando relacao id_venda X id_movimento
                    $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                    $id_movimento = result($result_movimento, 0, "id_movimento");

                    $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                    $rsMov = query($sql);
                    if($rsMov===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }


                    break;
                case "TRO":
                    $sql = "INSERT INTO vendas_devolucao(id_venda, valor, data_troconatroca) ";
                    $sql .= " VALUES(". $id_venda .", '". $pagamento["valor"] ."', '". fu_formata_data_insert($pagamento["vencimento"]) ."')";

                    $rsTro = query($sql);
                    if($rsTro===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }
                    //inserindo titulo no financeiro
                    $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                    $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                    $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                    $sql .= " VALUES ('". date("Y-m-d") ."', '". fu_formata_data_insert($pagamento["vencimento"]) ."', '". date("Y-m-01") ."', '". strtoupper($descricao_financeiro) ." - TROCO NA TROCA', 'f', ". $cate_cod_troco .", ";
                    $sql .= " ". $subc_cod_troco .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". $pagamento["valor"] ."', ";
                    $sql .= " '0', '1', 'P', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                    $sql .= " NULL, NULL,'$posicao_estoque')";
                    $rsTit = query($sql);
                    if($rsTit===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }

                    //gravando relacao id_venda X id_movimento
                    $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                    $id_movimento = result($result_movimento, 0, "id_movimento");

                    $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                    $rsMov = query($sql);
                    if($rsMov===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }
                    break;
                case "DUP":
                    $dias = $pagamento['duplicata_frequencia'];
                    $dtvencimento = fu_formata_data_insert($pagamento["vencimento"]);
                    $dtvencimento_new = $dtvencimento;
                    for($i=0;$i<$pagamento['duplicata_numero'];$i++){
                        $numeroDuplicata = ($i + 1)."/".$pagamento['duplicata_numero'];
                        $valor_unitario = str_replace(",", ".", str_replace(".", "",$pagamento["valor_unitario"]));
                        
                        $sql = "INSERT INTO vendas_duplicata(id_venda, numero_duplicata, data_duplicata, valor) ";
                        $sql .= " VALUES(". $id_venda .", ";
                        $sql .= " '". $numeroDuplicata ."', '". $dtvencimento_new ."', ";
                        $sql .= " '". $valor_unitario ."')";

                        $rsChe = query($sql);
                        if($rsChe===false){
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                        //inserindo titulo no financeiro
                        $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                        $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                        $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                        $sql .= " VALUES ('". date("Y-m-d") ."', '". $dtvencimento_new ."', '". date("Y-m-01") ."', 'DUPLICATA ". strtoupper($descricao_financeiro) ."', 'f', ". $cate_cod .", ";
                        $sql .= " ". $subc_cod .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". $valor_unitario ."', ";
                        $sql .= " '0', '1', 'R', ". $_POST["clie_cod"] .", '". $numeroDuplicata ."', NULL, NULL, ";
                        $sql .= " NULL, 11,'$posicao_estoque')";
                        $rsTit = query($sql);
                        if($rsTit===false){
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }

                        //gravando relacao id_venda X id_movimento
                        $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                        $id_movimento = result($result_movimento, 0, "id_movimento");

                        $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                        $rsMov = query($sql);
                        if($rsMov===false){
                            $erro = true;
                            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 01!";
                            $myError =$resp.pg_last_error();
                            doLog($fileLog,$varsINI,get_defined_vars());
                            $myError =$resp;
                            echo $myError;
                        }
                        
                        if($dias=="30"){
                            $dtvencimento_new = date("Y-m-d", mktime(0, 0, 0, substr($dtvencimento, 5 ,2)+(1*($i+1)), substr($dtvencimento, 8 ,2), substr($dtvencimento, 0 ,4)));
			}else{
                            $dtvencimento_new = date("Y-m-d", mktime(0, 0, 0, substr($dtvencimento_new, 5 ,2), substr($dtvencimento_new, 8 ,2)+$dias, substr($dtvencimento_new, 0 ,4)));
			}
                    }
                    
                    break;
                case "BOL":
                    $sql = "INSERT INTO vendas_boleto(id_venda, valor, vencimento, 
                            codigo_boleto, descricao_boleto) 
                        VALUES(". $id_venda .", '". $pagamento["valor"] ."', '". fu_formata_data_insert($pagamento["vencimento"]) ."',
                            '". $pagamento["boleto_numero"] ."','')";
                    $rsDin = query($sql);
                    if($rsDin===false)
                    {
                        $erro = true;
                        $resp = " Ocorreu erro ao registrar a venda do veículo - Vendas Boleto! ";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }
                    
                    //inserindo titulo no financeiro
                    $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                    $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                    $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                    $sql .= " VALUES ('". date("Y-m-d") ."', '". fu_formata_data_insert($pagamento["vencimento"]) ."', '". date("Y-m-01") ."', '". strtoupper($descricao_financeiro) ."', 'f', ". $cate_cod .", ";
                    $sql .= " ". $subc_cod .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". $pagamento["valor"] ."', ";
                    $sql .= " '0', '1', 'R', ". $_POST["clie_cod"].", NULL, NULL, NULL, NULL, NULL, ";
                    $sql .= " NULL, 5,'$posicao_estoque')";
                    $rsTit = query($sql);
                    if($rsTit===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - Mov Cont!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }
                    //gravando relacao id_venda X id_movimento
                    $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                    $id_movimento = result($result_movimento, 0, "id_movimento");

                    $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                    $rsMov = query($sql);
                    if($rsMov===false)
                    {
                        $erro = true;
                        $resp = "Ocorreu erro ao registrar a venda do veículo - Mov Cont vendas_movimentacaocontas!";
                        $myError =$resp.pg_last_error();
                        doLog($fileLog,$varsINI,get_defined_vars());
                        $myError =$resp;
                        echo $myError;
                    }


                    break;
            }
        }


        //passo 8 - gravar comissão do vendedor
        $sql = "select
        *
        from vendas_comissao vc
        where
        vc.data_comissao BETWEEN '".date('Y-m-01')."' and now() and
        vc.id_vendedor = {$_POST["vendedor"]}";
        $rsVendasComissao = query($sql);

        $totalVendas = num_rows($rsVendasComissao);
        $totalVendas = $totalVendas > 0 ? ($totalVendas+1):1;

        $sql = "select
        p.pess_nome
        from funcionarios f
        INNER JOIN pessoas p on (f.pess_cod = p.pess_cod)
        where f.func_cod = {$_POST["vendedor"]}";

        $func_nome = result(query($sql), 0, "pess_nome");
        $tipo_comissao              = 0;
        $valor_comissao             = 0;
        $valor_comissao_retorno     = 0;
        $func_comissao_retorno      = false;
        $func_tipo_comissao_retorno = 0;

        $sql = "select
        *
        from funcionarios_comissao fc
        where
        fc.func_cod = {$_POST["vendedor"]} AND
        {$totalVendas} BETWEEN fc.\"daVenda\" and fc.\"ateVenda\"";

        $result_vendedor = query($sql);

        //$sql = "SELECT p.*,f.* FROM funcionarios f INNER JOIN pessoas p on (f.pess_cod = p.pess_cod) 
        //WHERE f.reve_cod = ". $_SESSION["ss_empresa_conectada"] ." AND f.func_cod = ". $_POST["vendedor"] ."  ORDER BY p.pess_nome";
        //$result_vendedor = query($sql);

        $tipo_comissao 		= result($result_vendedor, 0, "func_comissao");
        $valor_comissao     = result($result_vendedor, 0, "func_valor");
        $valorComissao 	    = result($result_vendedor, 0, "func_valor");

        $func_comissao_retorno=result($result_vendedor, 0, "func_comissao_retorno");
        $func_tipo_comissao_retorno=result($result_vendedor, 0, "func_tipo_comissao_retorno");


        if( ($func_comissao_retorno=='t') && $vlr_financiado_ret>0)
        {
            if($func_tipo_comissao_retorno=="2")
            {
                $valor_comissao_retorno = result($result_vendedor, 0, "func_comissao_retorno_valor");
            }
            else
            {
                $valor_comissao_retorno = $vlr_financiado_ret * (result($result_vendedor, 0, "func_comissao_retorno_valor") / 100);
            }

        }
        else
        {
            $valor_comissao_retorno="0";
        }

        if($tipo_comissao==3 || $tipo_comissao=='3') //valor fixo
        {
            $sql = "INSERT INTO vendas_comissao(id_venda, data_comissao, valor, id_vendedor, id_tipocomissao, valor_retorno) ";
            $sql .= " VALUES(". $id_venda .", '". date("Y-m-d") ."', '". ($valor_comissao + $valor_comissao_retorno) ."', ". $_POST["vendedor"] .", ". $tipo_comissao .", '$valor_comissao_retorno')";
            $rsCom = query($sql);
            if($rsCom===false)
            {
                $erro = true;
                $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 1.2!";
                $myError =$resp.pg_last_error();
                doLog($fileLog,$varsINI,get_defined_vars());
                $myError =$resp;
                echo $myError;
            }

            if(1==2) //nao gerar mais titulos de comissao
            {
                //inserindo titulo no financeiro
                $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                $sql .= " VALUES ('". date("Y-m-d") ."', '". date("Y-m-d") ."', '". date("Y-m-01") ."', 'COMISSÃO DA ". strtoupper($descricao_financeiro) ." VENDEDOR - ".$func_nome."', 'f', ". $cate_cod_comis .", ";
                $sql .= " ". $subc_cod_comis .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". ($valor_comissao + $valor_comissao_retorno) ."', ";
                $sql .= " '0', '1', 'P', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                $sql .= " NULL, NULL,'$posicao_estoque')";
            }
        }
        elseif($tipo_comissao==2 || $tipo_comissao=='2') //percentual sobre a venda
        {
            $valor_comissao = $_POST["preco_venda"] * ($valor_comissao / 100);

            $sql = "INSERT INTO vendas_comissao(id_venda, data_comissao, valor, id_vendedor, id_tipocomissao, valor_retorno) ";
            $sql .= " VALUES(". $id_venda .", '". date("Y-m-d") ."', '". ($valor_comissao + $valor_comissao_retorno) ."', ". $_POST["vendedor"] .", ". $tipo_comissao .", '$valor_comissao_retorno')";
            $rsCom = query($sql);
            if($rsCom===false)
            {
                $erro = true;
                $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 1.3!";
                $myError =$resp.pg_last_error();
                doLog($fileLog,$varsINI,get_defined_vars());
                $myError =$resp;
                echo $myError;
            }

            if(1==2) //nao gerar mais titulos de comissao
            {

                //inserindo titulo no financeiro
                $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                $sql .= " VALUES ('". date("Y-m-d") ."', '". date("Y-m-d") ."', '". date("Y-m-01") ."', 'COMISSÃO DA ". strtoupper($descricao_financeiro) ." VENDEDOR - ".$func_nome."', 'f', ". $cate_cod_comis .", ";
                $sql .= " ". $subc_cod_comis .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". ($valor_comissao + $valor_comissao_retorno) ."', ";
                $sql .= " '0', '1', 'P', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                $sql .= " NULL, NULL,'$posicao_estoque')";
                $rsTit = query($sql);
                if($rsTit===false)
                {
                    $erro = true;
                    $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 1.4!";
                    $myError =$resp.pg_last_error();
                    doLog($fileLog,$varsINI,get_defined_vars());
                    $myError =$resp;
                    echo $myError;
                }

                //gravando relacao id_venda X id_movimento
                $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                $id_movimento = result($result_movimento, 0, "id_movimento");

                $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                $rsMov = query($sql);
                if($rsMov===false)
                {
                    $erro = true;

                    $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 1.5!";
                    $myError =$resp.pg_last_error();
                    doLog($fileLog,$varsINI,get_defined_vars());
                    $myError =$resp;
                    echo $myError;
                }
            }
        }
        elseif($tipo_comissao==1 || $tipo_comissao=='1') //percentual sobre o lucro
        {


            //custo de documentacoes
            $sql = "SELECT COALESCE(SUM(docu_valor),0) as valor FROM documentacoes WHERE veic_cod = ". $_POST["veic_cod"] ."";
            $rs_custo1 = query($sql);
            $custo = result($rs_custo1, 0, "valor");

            //custo de manutencoes
            $sql = "SELECT COALESCE(SUM(manu_valor),0) as valor FROM manutencoes WHERE veic_cod = ". $_POST["veic_cod"] ."";
            $rs_custo2 = query($sql);
            $custo += result($rs_custo2, 0, "valor");


            $valor_comissao = ($_POST["preco_venda"] - $valor_compra - $custo) * ($valor_comissao / 100);

            $sql = "INSERT INTO vendas_comissao(id_venda, data_comissao, valor, id_vendedor, id_tipocomissao, valor_retorno) ";
            $sql .= " VALUES(". $id_venda .", '". date("Y-m-d") ."', '". ($valor_comissao + $valor_comissao_retorno) ."', ". $_POST["vendedor"] .", ". $tipo_comissao .", '$valor_comissao_retorno')";
            $rsCom = query($sql);
            if($rsCom===false)
            {
                $erro = true;
                $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 1.6!";
                $myError =$resp.pg_last_error();
                doLog($fileLog,$varsINI,get_defined_vars());
                $myError =$resp;
                echo $myError;
            }

            if(1==2) //nao gerar mais titulos de comissao
            {
                //inserindo titulo no financeiro sobre a venda
                $sql = "INSERT INTO movimentacao_contas(dtemissao, dtvencimento, dtreferencia, descricao, conciliado, cate_cod, subc_cod, ";
                $sql .= " reve_cod, id_baixa_agrupada, valor_multa, valor_juros, valor_desconto, valor_titulo, ";
                $sql .= " valor_pago, dre, tipo_movimento, clie_cod, nro_documento, dtbaixa, conta_cod, chq_banco, chq_agencia, chq_conta, tipo_pagamento_id,posicao_estoque) ";
                $sql .= " VALUES ('". date("Y-m-d") ."', '". date("Y-m-d") ."', '". date("Y-m-01") ."', 'COMISSÃO DA ". strtoupper($descricao_financeiro) ." VENDEDOR - ".$func_nome."', 'f', ". $cate_cod_comis .", ";
                $sql .= " ". $subc_cod_comis .", ". $_SESSION["ss_empresa_conectada"] .", 0, '0', '0', '0', '". ($valor_comissao + $valor_comissao_retorno) ."', ";
                $sql .= " '0', '1', 'P', ". $_POST["clie_cod"] .", NULL, NULL, NULL, NULL, NULL, ";
                $sql .= " NULL, NULL,'$posicao_estoque')";
                $rsTit = query($sql);
                if($rsTit===false)
                {
                    $erro = true;
                    $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 1.7!";
                    $myError =$resp.pg_last_error();
                    doLog($fileLog,$varsINI,get_defined_vars());
                    $myError =$resp;
                    echo $myError;
                }

                //gravando relacao id_venda X id_movimento
                $result_movimento = query("SELECT CURRVAL('movimentacao_contas_id_seq') as id_movimento");
                $id_movimento = result($result_movimento, 0, "id_movimento");

                $sql = "INSERT INTO vendas_movimentacaocontas(id_venda, id_movimento) VALUES(". $id_venda .", ". $id_movimento .")";
                $rsMov = query($sql);
                if($rsMov===false)
                {
                    $erro = true;
                    $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 1.8!";
                    $myError =$resp.pg_last_error();
                    doLog($fileLog,$varsINI,get_defined_vars());
                    $myError =$resp;
                    echo $myError;
                }
            }

        }
        else
        {
            $myError ='erro comissao tipo_comissao='.print_r($tipo_comissao,true);
            doLog($fileLog,$varsINI,get_defined_vars());
        }

        $sql = "select * from vendas_comissao where
        id_vendedor = {$_POST["vendedor"]} AND
        data_comissao BETWEEN '".date('Y-m-01')."' and now()
        ORDER BY data_comissao desc;";
        $rs_vendasVendedor = query($sql);

        while($linha = pg_fetch_assoc($rs_vendasVendedor))
        {
            $sql = "select * from vendas where id = {$linha['id_venda']}";
            $rs_vendas = query($sql);

            $reveCod = result($rs_vendas, 0, "id_revenda");
            $veicCod = result($rs_vendas, 0, "id_veiculo");
            $valorVenda = result($rs_vendas, 0, "valor_venda");

            //dados veiculo
            $sql     = "SELECT veic_cod, ma.marc_nome, m.mode_nome, veic_anomodelo, c.core_nome, veic_placa, veic_valorfinal, veic_valorcompra,posicao_estoque ";
            $sql     .= " FROM veiculos v INNER JOIN modelos m on (v.mode_cod = m.mode_cod) INNER JOIN marcas ma on (v.marc_cod = ma.marc_cod) ";
            $sql     .= " INNER JOIN cores c on (v.core_cod = c.core_cod) ";
            $sql     .= " WHERE reve_cod = {$reveCod} ";
            $sql    .= " AND veic_cod = {$veicCod}";
            $result_veiculo = query($sql);

            $descricao_financeiro = "VENDA " . result($result_veiculo, 0, "marc_nome") ." ". result($result_veiculo, 0, "mode_nome") ." ". result($result_veiculo, 0, "veic_anomodelo") ." ". result($result_veiculo, 0, "core_nome") ." ". result($result_veiculo, 0, "veic_placa") ."";
            $valor_compra = result($result_veiculo, 0, "veic_valorcompra");
            $vlr_financiado_ret = 0;

            $sql = "select * from movimentacao_contas where
            descricao ilike 'RETORNO DA {$descricao_financeiro}' and 
            reve_cod = {$reveCod}
            ORDER BY dtemissao desc";
            $rs_MovContas = query($sql);

            if(num_rows($rs_MovContas) > 0)
            {   
                $vlr_financiado_ret = result($rs_MovContas, 0, "valor_titulo");
            }

            if( ($func_comissao_retorno=='t') && $vlr_financiado_ret>0)
            {
                if($func_tipo_comissao_retorno=="2")
                {
                    $valor_comissao_retorno = result($result_vendedor, 0, "func_comissao_retorno_valor");
                }
                else
                {
                    $valor_comissao_retorno = $vlr_financiado_ret * (result($result_vendedor, 0, "func_comissao_retorno_valor") / 100);
                }
            }
            else
            {   
                $valor_comissao_retorno="0";
            }

            if($tipo_comissao==3) //valor fixo
            {
                $valor_comissao = $valorComissao;
            }
            elseif($tipo_comissao==2) //percentual sobre a venda
            {
                $valor_comissao = $valorVenda * ($valorComissao / 100);
            }
            elseif($tipo_comissao==1) //percentual sobre o lucro
            {
                //custo de documentacoes
                $sql = "SELECT COALESCE(SUM(docu_valor),0) as valor FROM documentacoes WHERE veic_cod = {$veicCod}";
                $rs_custo1 = query($sql);
                $custo = result($rs_custo1, 0, "valor");

                //custo de manutencoes
                $sql = "SELECT COALESCE(SUM(manu_valor),0) as valor FROM manutencoes WHERE veic_cod = {$veicCod}";
                $rs_custo2 = query($sql);
                $custo += result($rs_custo2, 0, "valor");

                $valor_comissao = ($valorVenda - $valor_compra - $custo) * ($valorComissao / 100);

            }

            $valorUpdate = ($valor_comissao + $valor_comissao_retorno);

		if ($tipo_comissao == '')
			$tipo_comissao = 0;

            $sql = "update vendas_comissao set valor='{$valorUpdate}', id_tipocomissao={$tipo_comissao}, valor_retorno='{$valor_comissao_retorno}' where id_venda = '{$linha['id_venda']}' and id_vendedor='{$_POST["vendedor"]}'";
            query($sql);

        }

        
        //passo 9 - atualizar situacao do veiculo para veic_situacao = 3
        //ATUALIZA O VALOR FINAL DO VEICULO PARA O VALOR DA VENDA
        $sql = "UPDATE veiculos " .
        "	SET veic_valorfinal='".$_POST["preco_venda"]."',veic_situacao = 3, tipo_preco = 'A', veic_publicar = 0, veic_autosc = 0, veic_sitefacil = 0, veic_smc = 0, veic_mcn = FALSE, " .
        "	veic_vezes = NULL, veic_parcelas = NULL, posicao_estoque = $posicao_estoque " .
        "	WHERE reve_cod = " . $_SESSION["ss_empresa_conectada"] . " AND veic_cod = ". $_POST["veic_cod"];
        $rsSit= query($sql);
        if($rsSit===false)
        {
            $erro = true;

            $resp = "Ocorreu erro ao registrar a venda do veículo - cod. 1.9! ";

            $myError =$resp.pg_last_error();
            //            if($_SERVER['SERVER_ADDR'] == '186.233.145.90'){$resp = $resp . $myError;}
            doLog($fileLog,$varsINI,get_defined_vars());
            $myError =$resp;
            echo $myError;
        }

        $sqlWeb = "UPDATE veiculos_web " .
        "	SET enviado_meucarronovo = false, enviado_webmotors = false, enviado_socarrao = false, publicar=0, publicar_meucarronovo = 0, publicar_webmotors = 0, publicar_socarrao = 0, publicar_olx = 0, publicar_trovit = 0, publicar_icarros = 0, dt_deletesolr = '".date('Y-m-d H:i:s')."' ".
        "	WHERE veic_cod = ". $_POST["veic_cod"];
        $rsWeb= query($sqlWeb);

        // ficha cadastral do veiculos



        ///ficha cadastral do veiculos


        //passo 10 - fecha as publicidades dos veículos
        $fechaDest = fechaDestaque($_POST["veic_cod"], $_SESSION["ss_usuario_cod"]);
        if($fechaDest===false)
        {
            $erro  = true;
        }

        //EXCLUSAO DE IMAGENS
        /*$excImg = excluirImagemMCN($_POST["veic_cod"], $_SESSION["ss_usuario_cod"]);
        if($excImg===false)
        {
        $erro = true;
        }*/

        //passo 11 - Grava dados do Despachante
        if($_SESSION["ss_estoque_desp_cod"]!=""){
            $sqlDespacho = "INSERT INTO despacho(
            id_fornecedor, veic_cod, muni_origem, muni_destino, dt_envio,
            dt_devolvido,reve_cod,obs_adicional)
            VALUES ('".$_SESSION["ss_estoque_desp_cod"]."',
            ". $_SESSION["ss_estoque_veiccod"] .",
            '".$_SESSION["ss_estoque_muni_origem"]."',
            '".$_SESSION["ss_estoque_muni_destino"]."',
            '".fu_formata_data_insert($_SESSION["ss_estoque_despdtenvio"])."',
            '".fu_formata_data_insert($_SESSION["ss_estoque_despdtdevolvido"])."',
            ".$_SESSION["ss_empresa_conectada"].",
            '".$_SESSION["ss_estoque_obs_adicional"]."' )";
            $rs_despacho = query($sqlDespacho);
            if($rs_despacho===false)
            {
                $erro = true;
            }
        }else{
            if(isset($_POST['status']) && $_POST['status'] != ""){
                if($_POST['valor_pg_clien'] == ""){
                    $valor_pg_clien = "NULL";
                }else{
                    $valor_pg_clien = "'".fu_trata_valor_insert($_POST['valor_pg_clien'])."'";
                }
                if($_POST['dt_pg_clien'] == ""){
                    $dt_pg_clien = "NULL";
                }else{
                    $dt_pg_clien = "'".fu_formata_data_insert($_POST['dt_pg_clien'])."'"; 
                }

                $sqlDespacho = "INSERT INTO despacho(
                veic_cod, vlr_info_cliente, dt_pg_cliente, reve_cod, status)
                VALUES ('".$_POST["veic_cod"]."',$valor_pg_clien,$dt_pg_clien,'".$_SESSION["ss_empresa_conectada"]."','".$_POST['status']."')";   
                    $rs_despacho = query($sqlDespacho); 

                if ($rs_despacho === false){
                        query("ROLLBACK TRANSACTION");
                            echo "<div style='display:none;'>$sqlDespacho</div>";
                        $resp = "Não foi possível o Despacho do veículo!!!\\n\\n";    
                        $resp.= "Ocorreu erro na(s) seguinte(s) área(s):\\n\\n";
                        $resp.= "\\tInserir dados do Despachante!\\n";
                        echo "<script language=javascript>alert('$resp'); /*window.history.back();*/</script>";
                        $_SESSION["sqlwhere_resu_despacho"] = "";
                        exit;
                }
            }
        }

        /*echo "\n";
        $erro=true;#remover*/

        if($erro===true)
        {
            $resp = "Ocorreu erro ao registrar a venda do veículo!";
            $myError =$resp.pg_last_error();
            doLog($fileLog,$varsINI,get_defined_vars());
            $myError =$resp;
            echo $myError;

            query("ROLLBACK TRANSACTION");
            query_mcn("ROLLBACK TRANSACTION");

            exit;

        }
        else
        {
            include_once('../../libs/classes/PreVenda.class.php');                             
            $classPreVenda = new PreVenda();
            $classPreVenda->apagar($_SESSION['ss_empresa_conectada'],$_POST["veic_cod"]);

            //fim transacao
            query("COMMIT TRANSACTION");
            query_mcn("COMMIT TRANSACTION");

            $_SESSION['pagamentos'] = null;
            unset($_SESSION['pagamentos']);

            $query = 'SELECT aler_cod, aler_emails FROM alerta WHERE reve_cod = '.$_SESSION['ss_empresa_conectada'].' AND aler_tipo = 1';
            $resultAlerta = query($query);
            if(num_rows($resultAlerta) > 0){
                
                $emailDestinatario = result($resultAlerta, 0, 'aler_emails');
                
                $queryUsuario = '
                                SELECT pessoas.pess_cod, pess_nome, clie_email, telefones.tele_fone
                                FROM clientes
                                INNER JOIN pessoas ON clientes.pess_cod = pessoas.pess_cod AND clientes.clie_cod = ' . $_POST["clie_cod"] . '
                                LEFT JOIN telefones ON telefones.pess_cod = pessoas.pess_cod
                                LIMIT 1';
                $result_param = query($queryUsuario);
                if (num_rows($result_param) > 0) {
                    $pess_cod = result($result_param, 0, "pess_cod");
                    $pess_nome = result($result_param, 0, "pess_nome");
                    $clie_email = result($result_param, 0, "clie_email");
                    $tele_fone = result($result_param, 0, "tele_fone");
                }
                $queryVeiculo = '
                                SELECT marc_nome, mode_nome, core_nome, veic_anomodelo, veic_placa, veic_chassi, veic_valorcompra, veic_valorfinal
                                FROM veiculos
                                INNER JOIN marcas ON veiculos.marc_cod = marcas.marc_cod 
                                    AND veiculos.veic_cod = ' . $_POST['veic_cod'] . '
                                LEFT JOIN modelos ON veiculos.mode_cod = modelos.mode_cod
                                LEFT JOIN cores ON veiculos.core_cod = cores.core_cod ';
                $result_param = query($queryVeiculo);
                if (num_rows($result_param) > 0) {
                    $marc_nome = result($result_param, 0, "marc_nome");
                    $mode_nome = result($result_param, 0, "mode_nome");
                    $core_nome = result($result_param, 0, "core_nome");
                    $veic_anomodelo = result($result_param, 0, "veic_anomodelo");
                    $veic_placa = result($result_param, 0, "veic_placa");
                    $veic_chassi = result($result_param, 0, "veic_chassi");
                    $veic_valorcompra = result($result_param, 0, "veic_valorcompra");
                    $veic_valorfinal = result($result_param, 0, "veic_valorfinal");
                }
                if($veic_placa == ""){
                    $placaChassi = $veic_chassi;
                }else{
                    $placaChassi = $veic_placa;
                }

                $queryVenda = '
                                SELECT vendas.id, vendas.id_veiculo, vendas.id_cliente, vendas.id_revenda, vendas.data_venda, vendas.valor_venda,
                                    vendas.id_vendedor, pessoas.pess_cod AS pess_cod_vendedor, pessoas.pess_nome as vendedor,vendas.observacao_recibo 
                                FROM vendas 
                                INNER JOIN funcionarios ON (vendas.id_vendedor = funcionarios.func_cod) 
                                INNER JOIN pessoas ON (funcionarios.pess_cod = pessoas.pess_cod)
                                WHERE vendas.id_veiculo = ' . $_POST['veic_cod'] . ' AND vendas.id_revenda = ' . $_SESSION['ss_empresa_conectada'] . '';
                $result_param = query($queryVenda);
                if (num_rows($result_param) > 0) {
                    $id_venda = result($result_param, 0, "id");
                    $data_venda = result($result_param, 0, "data_venda");
                    $valor_venda = result($result_param, 0, "valor_venda");
                    $vendedor = result($result_param, 0, "vendedor");
                    $observacao_recibo = result($result_param, 0, "observacao_recibo");
                }

                $rs_compra = query('SELECT * FROM compras WHERE veic_cod = ' . $_POST['veic_cod'] . ' AND reve_cod=' . $_SESSION['ss_empresa_conectada'] . '');
                $result_param = query($queryVenda);
                if (num_rows($result_param) > 0) {
                    $comp_data = result($rs_compra, 0, "comp_data");
                }

                $final_data = (empty($data_venda) == true ? date('Y-m-d') : $data_venda);
                $dias_estoque = intval(date_difference($comp_data, $final_data));

                $result = query("SELECT rela_custopatio FROM relatorios WHERE (reve_cod='".$_SESSION["ss_empresa_conectada"]."')");
                if (num_rows($result) > 0) {
                    $custo_patio = result($result, 0, "rela_custopatio");
                }
                if ($veic_status = "Próprio") {
                    $custo_financeiro = (($veic_valorcompra / 100) * $custo_patio) * $dias_estoque;
                } else {
                    $custo_financeiro = 0;
                }

                $sql = "SELECT * from manutencoes WHERE tipo_registro = 'M' AND veic_cod = ".$_POST['veic_cod']." ORDER BY manu_dtservico DESC";
                $resultManutencao = query($sql);
                $total_manutencao = 0;
                for ($i = 0; $i < num_rows($resultManutencao); $i++) {
                    $status_manu = result($resultManutencao, $i, "manu_status");
                    if ($status_manu == "1" || $status_manu == "3") {
                        $total_manutencao += result($resultManutencao, $i, "manu_valor");
                    }
                }

                $sql = "SELECT * from manutencoes WHERE tipo_registro = 'D' AND veic_cod = ".$_POST['veic_cod']." ORDER BY manu_dtservico DESC";
                $resultDocumentacao = query($sql);
                $total_documentacao = 0;
                for ($i = 0; $i < num_rows($resultDocumentacao); $i++) {
                    $status_doc = result($resultDocumentacao, $i, "manu_status");
                    if ($status_doc == "1" || $status_doc == "3") {
                        $total_documentacao += result($resultDocumentacao, $i, "manu_valor");
                    }
                }

                $custo_total = $veic_valorcompra + $total_manutencao + $total_documentacao;
                $comissao = 0;
                if ($id_venda != "" && $id_venda != "0") {
                    $sql = "SELECT valor FROM vendas_comissao WHERE id_venda = " . $id_venda;
                    $rs_venda_comissao = query($sql);

                    if (num_rows($rs_venda_comissao) > 0) {
                        $comissao = result($rs_venda_comissao, 0, 'valor');
                    }

                    $custo_total+=$comissao;
                    // FIM RETORNO VALOR FINANCEIRO SAIDA.

                    $valor_retorno = 0;
                    //LUCRO
                    $lucro = (($veic_valorfinal + $valor_retorno + $plus + $tac) - ($custo_total));
                    $retorno = format_money((($lucro * 100) / ($custo_total)));
                }

                $sql = "SELECT * FROM nfe_nota n JOIN nfe_notaitens ni ON n.id_nfe = ni.id_nfe JOIN modelos mo ON ni.mode_cod = mo.mode_cod and veic_cod=".$_POST['veic_cod']." and \"nfe_statusMonitor\" = 6";
                $sql = query($sql);

                $nfe_dados["icms_valor"] = 0;
                $nfe_dados["pis_valor"] = 0;
                $nfe_dados["cofins_valor"] = 0;
                $nfe_dados["irpj_valor"] = 0;

                while ($linha = pg_fetch_assoc($sql)) {
                    $nfe_dados["icms_valor"] += $linha['nfe_imp_vl_icms'];
                    $nfe_dados["pis_valor"] += $linha['nfe_imp_vl_pis'];
                    $nfe_dados["cofins_valor"] += $linha['nfe_imp_vl_cofins'];
                    $nfe_dados["irpj_valor"] += $linha['nfe_imp_vl_irpj'];
                }

                $memsagem = '
                                ---------------------------------------------------------------------------
                                Resumo de veiculo vendido
                                ---------------------------------------------------------------------------
                                Data da Venda: ' . date('d/m/Y') . '

                                ' . $marc_nome . ' - ' . $mode_nome . '
                                ' . $veic_anomodelo . ' / ' . $core_nome . '
                                PLACA/CHASSI: '.$placaChassi.'

                                Cliente: '.$pess_nome.'
                                Telefone: '.$tele_fone.'
                                Email: '.$clie_email.'

                                VENDEDOR: '.$vendedor.'

                                Dias de Estoque: '.$dias_estoque.' dias
                                Custo Financeiro: R$'.number_format($custo_financeiro, 2, ",", ".").'

                                -----------VENDAS SEM NF--------------------------------
                                (+) R$ '.number_format($veic_valorfinal,2,",",".").' Valor da Venda
                                (-) R$ '.number_format($veic_valorcompra,2,",",".").' Valor da Compra 
                                (+) R$ '.number_format($valor_retorno,2,",",".").' Retorno de Financiamento
                                (+) R$ '.number_format($tac,2,",",".").' Tac Financiamento
                                (+) R$ '.number_format($plus,2,",",".").' Plus Financiamento: 
                                (-) R$ '.number_format($total_manutencao,2,",",".").' Despesas de Manutenções
                                (-) R$ '.number_format($total_documentacao,2,",",".").' Despesas de Documentações
                                (-) R$ '.number_format($comissao,2,",",".").' Comissão do Vendedor
                                <strong>R$ '.number_format($lucro,2,",",".").' Margem de Lucro
                                '.$retorno.'% Percentual de Retorno </strong>
                                ---------------------------------------------------------------------------
                                Caso algum dos valores acima esteja errado 
                                favor corrigir no sistema.
                                ---------------------------------------------------------------------------
                                Para desativar ou editar este alerta, acesse Conf.Gerais -> alertas';
                $memsagem = nl2br($memsagem);
                $query = "INSERT INTO email_envio (data_programada,de,para,
                        nome_de,nome_para,assunto,texto,tipo_mensagem,
                        origem,reve_cod,id_usuario,id_revendaemail) 
                    VALUES ('".date('Y-m-d')."','info@revendamais.com.br','$emailDestinatario',
                        'Revenda Mais', '$emailDestinatario','Venda - $mode_nome / $veic_anomodelo / $placaChassi ','$memsagem','SIS',
                        'REV','4','2383','4')";
                query($query);
                
            }

            desconectar();
            desconectar_mcn();
            echo "1";
        }
    }
    }
    else
    {
        ?>
            Atenção, existe uma venda do mesmo item em andamento!
        <?
    }

?>
