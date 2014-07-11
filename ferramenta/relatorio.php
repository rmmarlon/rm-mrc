<?php
header('Content-Type: text/html; charset=iso-8859-1');
define('FPDF_FONTPATH','font/');
require('conADODBopen.php');
//require_once("classes/autoload.php");
require('fpdf/fpdf.php');
require("tool/funcoes.php");

$rs_cores = pg_query("SELECT core_nome FROM cores WHERE (core_cod='1')");

class PDF extends FPDF{
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(20, 6, "Loja Car", 0, 0,'L');
        $this->Cell(180, 6, "Listagem de Estoque", 0, 1, 'R');
        $this->SetFont('helvetica', '', 8);
        $this->SetTextColor(0,0,0);
        $this->Cell(100, 6, date("d/m/Y - H:M:s") . " Usuário Marlon", 0, 1, 'L');
        $this->Cell(90, 6, "", 0, 1, 'C');
        $this->SetTextColor(255,255,255);
        $this->SetFont('helvetica', '', 8);
        $this->Cell(10, 4, "Pos", 0, 0, 'C', 1);
        //$this->Cell(20, 4, "marca", 0, 0, 'C', 1);
        $this->Cell(50, 4, "Modelo", 0, 0, 'C', 1);
        $this->Cell(8, 4, "Ano", 0, 0, 'C', 1);
        $this->Cell(18, 4, "Cor", 0, 0, 'C', 1);
        $this->Cell(6, 4, "C", 0, 0, 'C', 1);
        $this->Cell(15, 4, "Placa", 0, 0, 'C', 1);
        $this->Cell(10, 4, "KM", 0, 0, 'C', 1);
        $this->Cell(15, 4, "Vl Venda", 0, 0, 'C', 1);
        $this->Cell(15, 4, "Vl Minimo", 0, 0, 'C', 1);
        $this->Cell(50, 4, "Opcionais", 0, 1, 'C', 1);
    }

    function Footer(){
        //Vai para 1.5 cm da parte inferior
        $this->SetY(-15);
        //Seleciona a fonte Arial it�lico 8
        $this->SetFont('Arial','I',8);
        //Imprime o n�mero da p�gina corrente e o total de p�ginas
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetMargins(5, 5);
$pdf->Open();
$pdf->AddPage();
$sql = pg_query("SELECT b.posicao_estoque,
                            b.veic_cod,
                            c.mode_nome,
                            d.marc_nome,
                            b.veic_anomodelo,
                            b.core_cod,
                            b.comb_cod,
                            b.veic_placa,
                            b.veic_hp,
                            b.veic_km,
                            b.veic_valormnvenda,
                            b.veic_valorfinal
                    FROM veiculos AS b, modelos AS c, marcas AS d
                    WHERE (b.veic_situacao = 2)
                    AND (b.mode_cod=c.mode_cod)
                    AND (d.marc_cod=b.marc_cod)
                    AND (c.marc_cod=d.marc_cod)
                    AND (b.reve_cod='2490')
                    ORDER BY d.marc_nome,
                             c.mode_nome,
                             b.veic_anomodelo");

if(pg_num_rows($sql) > 0)
{
    while($result=pg_fetch_array($sql))
    {
        $posicao_estoque = $result["posicao_estoque"];
        $veic_cod = $result["veic_cod"];
        $mode_nome = $result["mode_nome"];
        $marc_nome = $result["marc_nome"];
        $veic_anomodelo = $result["veic_anomodelo"];
        $core_cod = $result["core_cod"];
        $comb_cod = $result["comb_cod"];
        $veic_placa = $result["veic_placa"];
        $veic_hp = $result["veic_hp"];
        $veic_km = $result["veic_km"];
        $veic_valormnvenda = $result["veic_valormnvenda"];
        $veic_valorfinal = $result["veic_valorfinal"];
        if (!empty($core_cod)) {
            $rs_cores = pg_query("SELECT core_nome FROM cores WHERE (core_cod='$core_cod')");
            if ($rsC=pg_fetch_array($rs_cores)) {
                $core_nome = $rsC["core_nome"];
            }
        }
        if(!empty($comb_cod))
        {
            $rs_combustivel = pg_query("SELECT comb_abreviatura FROM combustiveis WHERE comb_cod='$comb_cod'");
            if($rsCm=pg_fetch_array($rs_combustivel))
            {
                $comb_abreviatura = $rsCm["comb_abreviatura"];
            }
        }
        $aces_abreviatura = "";
        if(!empty($veic_cod))
        {
            $rs_acessorios = pg_query("SELECT b.aces_abreviatura FROM veic_aces AS a, acessorios AS b WHERE (a.aces_cod=b.aces_cod) AND (a.veic_cod='$veic_cod')");
            for($j=0; $j<pg_num_rows($rs_acessorios);$j++)
            {
                if($rsA=pg_fetch_array($rs_acessorios))
                {
                    $aces_abreviatura .= ", " . $rsA["aces_abreviatura"];
                }
            }
            $aces_abreviatura = substr($aces_abreviatura,2);
        }
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('helvetica','',7);
        $pdf->Cell(10,4, $posicao_estoque, 'LTRB', 0, 'C',1);
        //$pdf->Cell(20,4, $marc_nome, 'LTRB', 0, 'L',1);
        $pdf->Cell(50,4, $mode_nome, 'LTRB', 0, 'L',1);
        $pdf->Cell(8,4, $veic_anomodelo, 'LTRB', 0, 'C',1);
        $pdf->Cell(18,4, $core_nome, 'LTRB', 0, 'C',1);
        $pdf->Cell(6,4, $comb_abreviatura, 'LTRB', 0, 'L',1);
        $pdf->Cell(15,4, $veic_placa, 'LTRB', 0, 'C',1);
        $pdf->Cell(10,4, $veic_km, 'LTRB', 0, 'C',1);
        //$pdf->Cell(10,4, $veic_hp, 'LTRB', 0, 'C',1);
        $pdf->Cell(15,4, $veic_valorfinal, 'LTRB', 0, 'C',1);
        $pdf->Cell(15,4, $veic_valormnvenda, 'LTRB', 0, 'C',1);
        $y1=$pdf->GetY();
        $pdf->MultiCell(50,4, "$aces_abreviatura", 1, 1, 'L',0);
        $y2=$pdf->GetY();
        if($y1 < ($y - 4))
        {
            $pdf->SetY($y1 + 4);
            $lin = (($y2-4) - $y1)/4;
            for($k=0;$k< $lin;$k++)
            {
                if($lin > 1 && $k != ($lin-1))
                {
                    $pdf->Cell(10, 4, "", 'LR',0, 'L', 1);
                    //$pdf->Cell(20, 4, "", 'LR',0, 'L', 1);
                    $pdf->Cell(50, 4, "", 'LR',0, 'L', 1);
                    $pdf->Cell(15, 4, "", 'LR',0, 'R', 1);
                    $pdf->Cell(10, 4, "", 'LR',0, 'L', 1);
                    $pdf->Cell(5, 4, "", 'LR',0, 'L', 1);
                    $pdf->Cell(15, 4, "", 'LR',0, 'L', 1);
                    $pdf->Cell(12, 4, "", 'LR',0, 'L', 1);
                    //$pdf->Cell(10, 4, "", 'LR',0, 'L', 1);
                    $pdf->Cell(15, 4, "", 'LR',0, 'L', 1);
                    $pdf->Cell(15, 4, "", 'LR',0, 'L', 1);
                }
                else
                {
                    $pdf->Cell(10, 4, "", 'LRB',0, 'L', 1);
                    //$pdf->Cell(20, 4, "", 'LRB',0, 'L', 1);
                    $pdf->Cell(50, 4, "", 'LRB',0, 'L', 1);
                    $pdf->Cell(15, 4, "", 'LRB',0, 'R', 1);
                    $pdf->Cell(10, 4, "", 'LRB',0, 'L', 1);
                    $pdf->Cell(5, 4, "", 'LRB',0, 'L', 1);
                    $pdf->Cell(15, 4, "", 'LRB',0, 'L', 1);
                    $pdf->Cell(12, 4, "", 'LRB',0, 'L', 1);
                    //$pdf->Cell(10, 4, "", 'LRB',0, 'L', 1);
                    $pdf->Cell(15, 4, "", 'LRB',0, 'L', 1);
                    $pdf->Cell(15, 4, "", 'LRB',0, 'L', 1);
                }
            }
            $pdf->SetY($y2);
        }
        $aces_abreviatura= "";
    }
}
ob_start ();
$pdf->Output();

require_once('conADODBclose.php');

/*$pdf->Cell(10,4,$resul['veic_anomodelo'],1,0,'L');
 * veic_valorfinal   = valor da venda
 * veic_valormnvenda = valor minimo venda
 * veic_valorcompra  = valor da compra
 * veic_valorliquido = valor liquido
 *
 *
 * */