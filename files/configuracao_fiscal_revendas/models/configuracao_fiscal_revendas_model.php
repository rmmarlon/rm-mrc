<?php
    /**
     * Created by PhpStorm.
     * User: Atendimento
     * Date: 22/05/14
     * Time: 15:38
     */

    class configuracao_fiscal_revendas_model extends MY_Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function get()
        {
            $query = $this->db->query(
                                    "SELECT r.*, p.pess_nome
                                    FROM revendas r
                                    join pessoas p on r.pess_cod = p.pess_cod
                                    WHERE reve_status = 1
                                    AND r.reve_cod not in
                                    (SELECT distinct reve_cod
                                    FROM nfe_configuracao_fiscal WHERE conf_fisc_situacao != 'C')
                                    ORDER BY pess_nome"
            );
            return $query->result();
        }
    }
/*
 * query a
 *
$tipo = $this->db->query("select n.id, n.reve_cod, CASE WHEN n.nfe_reve_cod_clas_fis=49
THEN '1' WHEN n.nfe_reve_cod_clas_fis=47
THEN '2' END as tipoFiscal
from nfe_empresa n
inner join revendas r on r.reve_cod = n.reve_cod
WHERE r.reve_status = 1
GROUP BY n.id,n.reve_cod, tipoFiscal
order by n.reve_cod"
);
$ids = '';
while($l = $tipo)
{
$tp = $this->db->select('*')
->from('nfe_configuracao_fiscal')
->where('conf_fisc_situacao','A')
->where('reve_cod',$l['reve_cod'])
->where('conf_fisc_tipo',$l['tipoFiscal']);
if($tp->result() == 0)
{
$empresas[$l['reve_cod']]['empresas'][] = $l['id'];

$ids .= $l['reve_cod'].',';
}
/*query("
SELECT *
FROM nfe_configuracao_fiscal
WHERE conf_fisc_situacao !='C'
and reve_cod = {$l['reve_cod']}
and conf_fisc_tipo = {$l['tipofiscal']}");
}

$tipo = $this->db->query("
SELECT r.*,p.pess_nome
FROM revendas r
join pessoas p
on r.pess_cod = p.pess_cod
WHERE reve_status = 1
AND r.reve_cod in ({$ids}) ORDER BY pess_nome
");
/*
*
* */