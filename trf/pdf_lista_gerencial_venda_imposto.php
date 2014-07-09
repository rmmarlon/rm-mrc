    <?

    define('FPDF_FONTPATH','font/');

    include("../../config.php");
    include("../../functions.php");
    require_once("../../fpdf/fpdf.php");

    session_start();
    conectar();

    $reve_cod = $_SESSION["ss_empresa_conectada"];
    $total = 0;
    $acumulado = 0;
    $total_docu = 0;
    $total_manu = 0;
    $total_compra = 0;
    $total_finan = 0;
    $total_total = 0;
    $total_venda = 0;
    $total_venda_vp = 0;
    $total_marg_contrib = 0;
    $total_resultado = 0;
    $total_porcentagem = 0;
    $total_estoque = 0;

    if($_REQUEST["search_tipo"]!="")
    {
        $str_where = $str_where . " AND veic.veic_tipo = '".$_REQUEST["search_tipo"]."'";
        $is_where = true;
    }
    if($_REQUEST["posicao_estoque"]!="")
    {
        $str_where = $str_where . " AND veic.posicao_estoque='".$_REQUEST["posicao_estoque"]."'";
        $is_where = true;
    }
    if($_REQUEST["vendedor"]!="")
    {
        $str_where = $str_where . " AND vend.id_vendedor='".pg_escape_string($_REQUEST["vendedor"])."' ";
        $is_where = true;
    }

    // Dimensões da Página (Formato A4)
    //tam[0] -> Altura da página
    //tam[1] -> Largura da página
    $tam[0] = 210;
    $tam[1] = 297;
    $result = query("SELECT reve_razao FROM revendas WHERE reve_cod='$reve_cod'");
    if (num_rows($result) > 0) {
        $reve_nome = result($result,0,"reve_razao");
    }

    $sql = 	"SELECT COUNT(veic.veic_cod) AS total " .
        "	FROM vendas vend " .
        "	JOIN veiculos veic on (vend.id_veiculo = veic.veic_cod) " .
        "	WHERE vend.id IS NOT NULL AND veic.veic_situacao=3 AND vend.data_venda >= '$dtini' " .
        "	AND vend.data_venda <= '$dtfim' AND veic.reve_cod=$reve_cod $str_where";
    $result = query($sql);

    if (num_rows($result) > 0) {
        $veic_total = result($result,0,"total");
    }
    class PDF extends FPDF
    {
        function Header()
        {
            $this->SetFont('helvetica','B',11);
            $this->Cell(20, 6, retornaRevenda(), 0, 0, 'L');
            $this->SetFont('helvetica','B',11);
            $this->Cell(260, 6, "Lista gerencial de veículos vendidos" , 0, 1, 'R');
            $this->SetFont('helvetica', '', 8);
            $this->SetTextColor(0, 0, 0);
            $this->Cell(100, 6, date("d/m/Y - H:m:s") . " Usuário: ". $_SESSION["ss_usuario_nome"], 0, 1, 'L');


            $this->SetFillColor(0,0,0);
            $this->SetTextColor(255, 255, 255);
            $this->SetFont('helvetica', 'B', 8);
            $this->Cell(15, 4, "Código", 0, 0,'C',1);
            $this->Cell(15, 4, "DT Venda", 0, 0,'C',1);
            $this->Cell(35, 4, "Modelo", 0, 0,'C',1);
            $this->Cell(10, 4, "Ano", 0, 0,'C',1);
            $this->Cell(17, 4, "Cor", 0, 0,'C',1);
            $this->Cell(15, 4, "Placa", 0, 0,'C',1);
            $this->Cell(7, 4, "Pos.", 0, 0,'C',1);
            $this->Cell(15, 4, "Situação", 0, 0,'C',1);
            $this->Cell(17, 4, "Compra", 0, 0,'C',1);
            $this->Cell(10, 4, "Dias", 0, 0,'C',1);
            $this->Cell(15, 4, "Manut.", 0, 0,'C',1);
            $this->Cell(15, 4, "Doc.", 0, 0,'C',1);
            $this->Cell(15, 4, "Despesas", 0, 0,'C',1);
            $this->Cell(15, 4, "Impostos", 0, 0,'C',1);
            $this->Cell(17, 4, "Total", 0, 0,'C',1);
            $this->Cell(17, 4, "Venda", 0, 0,'C',1);
            $this->Cell(15, 4, "Ret.Finan.", 0, 0,'C',1);
            $this->Cell(15, 4, "Lucro", 0, 0,'C',1);
            $this->Cell(30, 4, "vendedor", 0, 1,'C',1);
        }

        function Footer()
        {
            //Vai para 1.5 cm da parte inferior
            $this->SetY(-15);
            //Seleciona a fonte helvetica itálico 8
            $this->SetFont('helvetica','',8);
            //Imprime o número da página corrente e o total de páginas
            $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    $pdf = new PDF('L', 'mm', $tam);
    $pdf->AliasNbPages();
    $pdf->SetMargins(8, 5, 2);
    $pdf->Open();
    $pdf->AddPage();
    $aux = explode("-", $dtini);
    $aux_dtini = "$aux[2]/$aux[1]/$aux[0]";
    $aux = explode("-", $dtfim);
    $aux_dtfim = "$aux[2]/$aux[1]/$aux[0]";

    $sql = "SELECT pess.pess_nome,vend.data_venda, c.comp_data, (vend.data_venda - c.comp_data) as diferenca_data, veic.veic_cod, mode.mode_nome, " .
        "		veic.veic_anomodelo, core.core_nome, veic.veic_placa, veic.veic_tipo, veic.veic_valorcompra, veic.veic_valorfinal,veic.posicao_estoque, " .
        "		veic.veic_status, veic.veic_nfentrada, vend.id " .
        "       FROM vendas vend " .
        "		JOIN veiculos veic on (vend.id_veiculo = veic.veic_cod) " .
        "		LEFT JOIN compras c on (veic.veic_cod = c.veic_cod) " .
        "		JOIN modelos mode on (veic.mode_cod = mode.mode_cod) " .
        "		JOIN cores core ON (veic.core_cod = core.core_cod) " .
        "		JOIN funcionarios func on (vend.id_vendedor = func.func_cod) " .
        "		JOIN pessoas pess on (func.pess_cod = pess.pess_cod) " .
        "		LEFT JOIN vendas_comissao comi ON (vend.id = comi.id_venda) " .
        " 	WHERE veic.veic_situacao=3 " .
        "		AND vend.data_venda BETWEEN '$dtini' AND '$dtfim' " .
        "		AND veic.reve_cod=$reve_cod $str_where " .
        " 	ORDER BY vend.data_venda, " .
        "		mode.mode_nome";

    $result = query($sql);

    if (num_rows($result) > 0)
    {
        for($i=0;$i<num_rows($result);$i++)
        {
            $porcentagem = 0;
            $venda_vp = 0;
            $resultado = 0;
            $marg_contrib = 0;
            $vendedor_nome = substr(result($result,$i,"pess_nome"),0,18);
            $vend_data = result($result,$i,"data_venda");
            $veic_dtentrada = result($result,$i,"veic_dtentrada");
            $estoque = result($result,$i,"diferenca_data");
            $veic_cod = result($result,$i,"veic_cod");
            $mode_nome = substr(result($result,$i,"mode_nome"),0,22);
            $veic_anomodelo = result($result,$i,"veic_anomodelo");
            $core_nome = result($result,$i,"core_nome");
            $veic_placa = result($result,$i,"veic_placa");
            $veic_status = $global_veic_tipo[result($result, $i, "veic_tipo")];
            $veic_valorcompra = result($result,$i,"veic_valorcompra");
            $veic_valorvenda = result($result,$i,"veic_valorfinal");
            $veic_nfentrada = result($result, $i, "veic_nfentrada");
            $posicao_estoque = result($result, $i, "posicao_estoque");
            $id_venda = result($result, $i,"id");
            $sql = "SELECT SUM(manu_valor) AS documentacoes " .
                "	FROM manutencoes " .
                "	WHERE veic_cod='$veic_cod' " .
                "		AND tipo_registro = 'D' AND manu_status != 2";
            $rs_docu = query($sql);
            if (num_rows($rs_docu) > 0)
            {
                $docu_valor = result($rs_docu,0,"documentacoes");
            }
            else
            {
                $docu_valor = 0;
            }

            $sql = "SELECT SUM(manu_valor) AS manutencoes " .
                "	FROM manutencoes " .
                "	WHERE veic_cod='$veic_cod' " .
                "		AND tipo_registro = 'M' " .
                "		AND manu_status != 2";
            $rs_manu = query($sql);
            if (num_rows($rs_manu) > 0)
            {
                $manu_valor = result($rs_manu,0,"manutencoes");
            }
            else
            {
                $manu_valor = 0;
            }
            //RETORNA IMPOSTO DO VEICULOS
            $sqlImposto= "SELECT COALESCE(SUM(nfe.nfe_imp_vl_cofins
                                  +  nfe.nfe_imp_vl_icms
                                  + nfe.nfe_imp_vl_ii
                                  + nfe.nfe_imp_vl_irpj
                                  + nfe.nfe_imp_vl_base_ipi
                                  + nfe.nfe_imp_vl_pis), 0) as impostos
                        from nfe_nota nfe
                        INNER JOIN nfe_notaitens item ON nfe.id_nfe=item.id_nfe
                        where item.veic_cod='$veic_cod'";

            $resultImposto = query($sqlImposto);
            if(num_rows($resultImposto) > 0)
            {
                $imposto = result($resultImposto,0,"impostos");
            }
            else
            {
                $imposto='';
            }

            // RETORNO VALOR FINANCEIRO SAIDA.
            $valor_retorno=0;
            $sql="SELECT id,  (valor_retorno+valor_plus+valor_tac) as retorno FROM vendas_financiamento WHERE id_venda=$id_venda";
            $rs_financeira = query($sql);

            if (num_rows($rs_financeira) > 0) {
                $valor_retorno = result($rs_financeira, 0, "retorno");
            }

            // FIM RETORNO VALOR FINANCEIRO SAIDA.

            //Valor total de gasto
            $total = ($veic_valorcompra + $docu_valor + $manu_valor);
            $total_despesa = ($manu_valor*-1)+($docu_valor*-1);
            //Tipo da situação é próprio
            if ($veic_status == "Próprio")
            {


                $situacao = "Próprio";
                $proprio["cont"] += 1;
                $proprio["compra"] += $veic_valorcompra;
                $proprio["estoque"] += $estoque;
                $proprio["manu"] += $manu_valor;
                $proprio["docu"] += $docu_valor;
                $proprio["total"] += $total;
                $proprio['total_despesa'] += $total_despesa;
                $proprio['total_imposto'] += $imposto;
                $proprio["venda"] += $veic_valorvenda;
                $proprio["vlretorno"] += $valor_retorno;
                $proprio["lucro"] += (($veic_valorvenda+$valor_retorno) - $total);





            }

            // Tipo da situação é consignado
            if ($veic_status == "Consignado") {
                $situacao = "Consignado";
                $consignado["cont"] += 1;
                $consignado["compra"] += $veic_valorcompra;
                $consignado["estoque"] += $estoque;
                $consignado["manu"] += $manu_valor;
                $consignado["docu"] += $docu_valor;
                $consignado["total"] += $total;
                $consignado['total_despesa'] += $total_despesa;
                $consignado['total_imposto'] += $imposto;
                $consignado["venda"] += $veic_valorvenda;
                $consignado["vlretorno"] += $valor_retorno;
                $consignado["lucro"] += (($veic_valorvenda+$valor_retorno) - $total);
            }

            $pdf->SetFillColor(255,255,255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('helvetica', '', 7);
            $pdf->Cell(15, 4, $veic_cod,'LTRB', 0,'L',1);
            $pdf->Cell(15, 4, format_date($vend_data),'LTRB', 0,'L',1);
            $pdf->Cell(35, 4, "$mode_nome",'LTRB', 0,'L',1);
            $pdf->Cell(10, 4, "$veic_anomodelo",'LTRB', 0,'L',1);
            $pdf->Cell(17, 4, "$core_nome",'LTRB', 0,'L',1);
            $pdf->Cell(15, 4, "$veic_placa",'LTRB', 0,'L',1);
            $pdf->Cell(7, 4, "$posicao_estoque",'LTRB', 0,'C',1);
            $pdf->Cell(15, 4, "$situacao",'LTRB', 0,'L',1);
            $pdf->Cell(17, 4, format_money($veic_valorcompra*-1),'LTRB', 0,'R',1);
            $pdf->Cell(10, 4, "$estoque",'LTRB', 0,'R',1);
            $pdf->Cell(15, 4, format_money($manu_valor*-1),'LTRB', 0,'R',1);
            $pdf->Cell(15, 4, format_money($docu_valor*-1),'LTRB', 0,'R',1);
            $pdf->Cell(15, 4, format_money($total_despesa),'LTRB', 0,'R',1);
            $pdf->Cell(15, 4, format_money($imposto*-1),'LTRB', 0,'R',1);
            $pdf->Cell(17, 4, format_money($total*-1),'LTRB', 0,'R',1);
            $pdf->Cell(17, 4, format_money($veic_valorvenda),'LTRB', 0,'R',1);
            $pdf->Cell(15, 4, format_money($valor_retorno),'LTRB', 0,'R',1);
            $lucro = (($veic_valorvenda+$valor_retorno) - $total);
            $pdf->Cell(15, 4, format_money($lucro),'LTRB', 0,'R',1);

            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(30, 4,"$vendedor_nome",'LTRB', 1,'C',1);

            $total_imposto += $imposto;
            $total_docu += $docu_valor;
            $total_manu += $manu_valor;
            $total_compra += $veic_valorcompra;
            $total_total += $total;
            $total_venda += $veic_valorvenda;
            $total_lucro += $lucro;
            $total_estoque += $estoque;
            $total_retorno_finan += $valor_retorno;

            // SUBTOTAL ACUMULADOR
            if($contador=="39")
            {
                if ($total_estoque > 0)
                {
                    $media_estoque = number_format($total_estoque / num_rows($result),0);
                }

                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('helvetica', 'B', 7);
                $pdf->Cell(129, 4, "Total:",'LTRB', 0,'L',1);
                $pdf->Cell(17, 4, format_money($total_compra*-1),'LTRB', 0,'R',1);
                $pdf->Cell(10, 4, "$media_estoque",'LTRB', 0,'R',1);
                $pdf->Cell(15, 4, format_money($total_despesa),'LTRB', 0,'R',1);
                $pdf->Cell(15, 4, format_money($total_imposto*-1),'LTRB', 0,'R',1);
                $pdf->Cell(17, 4, format_money($total_total*-1),'LTRB', 0,'R',1);
                $pdf->Cell(17, 4, format_money($total_venda),'LTRB', 0,'R',1);
                $pdf->Cell(15, 4, format_money($total_retorno_finan),'LTRB', 0,'R',1);
                $lucro = (($total_venda+$total_retorno_finan) - $total_total);
                $pdf->Cell(15, 4, format_money($lucro),'LTRB', 0,'R',1);


                $pdf->Ln();
                $pdf->Ln();
                $contador="0";
                $pdf->AddPage();

            }
            $contador++;
            ///FIM SUBTOTAL ACUMULADO
        }


        if ($total_estoque > 0)
        {
            $media_estoque = number_format($total_estoque / num_rows($result),0);
        }

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', 'B', 7);
        $pdf->Cell(129, 4, "Total:",'LTRB', 0,'L',1);
        $pdf->Cell(17, 4, "-".format_money($total_compra*-1),'LTRB', 0,'R',1);
        $pdf->Cell(10, 4, "$media_estoque",'LTRB', 0,'R',1);
        $pdf->Cell(15, 4, format_money($total_manu*-1),'LTRB', 0,'R',1);
        $pdf->Cell(15, 4, format_money($total_docu*-1),'LTRB', 0,'R',1);
        $pdf->Cell(15, 4, format_money(($total_manu*-1)+($total_docu*-1)),'LTRB', 0,'R',1);
        $pdf->Cell(15, 4, format_money($total_imposto*-1),'LTRB', 0,'R',1);
        $pdf->Cell(17, 4, format_money($total_total*-1),'LTRB', 0,'R',1);
        $pdf->Cell(17, 4, format_money($total_venda),'LTRB', 0,'R',1);
        $pdf->Cell(15, 4, format_money($total_retorno_finan),'LTRB', 0,'R',1);
        $lucro = (($total_venda+$total_retorno_finan) - $total_total);
        $pdf->Cell(15, 4, format_money($lucro),'LTRB', 0,'R',1);


        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(120, 4, "Tipo Total", 0, 0,'L',1);
        $pdf->Cell(18, 4, "Quantidade", 0, 0,'C',1);
        $pdf->Cell(18, 4, "Compra", 0, 0,'C',1);
        $pdf->Cell(15, 4, "Dias", 0, 0,'C',1);
        $pdf->Cell(18, 4, "Desp.", 0, 0,'C',1);
        /*$pdf->Cell(18, 4, "Manut.", 0, 0,'C',1);
        $pdf->Cell(18, 4, "Doc.", 0, 0,'C',1);*/
        $pdf->Cell(18, 4, "Impost.", 0, 0,'C',1);
        $pdf->Cell(18, 4, "Total", 0, 0,'C',1);
        $pdf->Cell(18, 4, "Venda", 0, 0,'C',1);
        $pdf->Cell(18, 4, "Ret.Finan.", 0, 0,'C',1);
        $pdf->Cell(18, 4, "Lucro", 0, 1,'C',1);


        //############################### Tipos de situação próprio ##########################
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(120, 4, "Próprio", 'LTRB', 0,'L',1);
        if (empty($proprio["cont"])) {
            $proprio["cont"] = "0";
        }
        $pdf->Cell(18, 4, $proprio["cont"], 'LTRB', 0,'C',1);
        $pdf->Cell(18, 4, format_money($proprio["compra"]*-1), 'LTRB', 0,'R',1);


        if (empty($proprio["estoque"]) || $proprio["cont"] == "0") {
            $proprio["estoque"] = "0";
        } else {
            $proprio_estoque = $proprio["estoque"]/$proprio["cont"];
        }
        $pdf->Cell(15, 4, number_format($proprio_estoque,0), 'LTRB', 0,'C',1);
        $pdf->Cell(18, 4, format_money($proprio['total_despesa']), 'LTRB', 0,'R',1);
        /*$pdf->Cell(18, 4, format_money($proprio["manu"]*-1), 'LTRB', 0,'R',1);
        $pdf->Cell(18, 4, format_money($proprio["docu"]*-1), 'LTRB', 0,'R',1);*/
        $pdf->Cell(18, 4, format_money($proprio['total_imposto']),'LTRB', 0,'R',1);
        $pdf->Cell(18, 4, format_money($proprio["total"]*-1), 'LTRB', 0,'R',1);
        $pdf->Cell(18, 4, format_money($proprio["venda"]), 'LTRB', 0,'R',1);
        $pdf->Cell(18, 4, format_money($proprio["vlretorno"]), 'LTRB', 0,'R',1);
        $lucro = (($proprio["venda"]+$proprio["vlretorno"]) - $proprio["total"]);
        $pdf->Cell(18, 4, format_money($lucro),'LTRB', 1,'R',1);


        //############################# Tipos de situação consignado #########################

        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(120, 4, "Consignado", 'LTRB', 0,'L',1);
        if (empty($consignado["cont"])) {
            $consignado["cont"] = "0";}

        $pdf->Cell(18, 4, $consignado["cont"], 'LTRB', 0,'C',1);
        $pdf->Cell(18, 4, format_money($consignado["compra"]*-1), 'LTRB', 0,'R',1);

        if (empty($consignado["estoque"])) {
            $consignado["estoque"] = "0";	}

        if (empty($consignado["estoque"]) || $consignado["cont"] == "0") {

            //$consignado["estoque"] = "0";
            $consignado_estoque = "0";
        } else {
            $consignado_estoque = number_format(($consignado["estoque"]/$consignado["cont"]),0);
        }
        $pdf->Cell(15, 4, $consignado_estoque, 'LTRB', 0,'C',1);
        $pdf->Cell(18, 4, format_money($consignado['total_despesa']), 'LTRB', 0,'R',1);
        /*$pdf->Cell(18, 4, format_money($consignado["manu"]*-1), 'LTRB', 0,'R',1);
        $pdf->Cell(18, 4, format_money($consignado["docu"]*-1), 'LTRB', 0,'R',1);*/
        $pdf->Cell(18, 4, format_money($consignado['total_imposto']),'LTRB', 0,'R',1);
        $pdf->Cell(18, 4, format_money($consignado["total"]*-1), 'LTRB', 0,'R',1);
        $pdf->Cell(18, 4, format_money($consignado["venda"]), 'LTRB', 0,'R',1);
        $pdf->Cell(18, 4, format_money($consignado["vlretorno"]), 'LTRB', 0,'R',1);
        $lucro = (($consignado["venda"]+$consignado["vlretorno"]) - $consignado["total"]);
        $pdf->Cell(18, 4, format_money($lucro),'LTRB', 1,'R',1);

    }

    desconectar();
    $name =  date('dmY-His')."listagem_gerencial_venda.pdf";
    $pdf->Output('../../temp/'.$name);
    Header("Location: ../../temp/$name");

    ?>