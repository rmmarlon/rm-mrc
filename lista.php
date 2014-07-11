<!--BEGIN EXAMPLE TABLE PORTLET-->
<div class='box light-grey'>
	<div class='portlet-body'>
		<table class='table table-striped table-bordered table-hover' id='simple_2'>
			<thead>
				<tr>
					<th width='5%'>
						teste_cod
					</th>
					<th width='5%'>
						teste_telefone
					</th>
				<td width='3%'>
						Ações
					</td>
				</tr>
			</thead>
			<tbody>
				{itens}
					<tr>
						<td>
							{teste_cod}
						</td>
						<td>
							{teste_telefone}
						</td>
						<td>
							<button data-id='{}' data-find='{find}' class='form-edit btn btn-link btn-xs' type='button'>
								Alterar 
							</button>
							<button data-id='{}' data-find='{find}' class='form-delete brn btn-link btn-xs' type='button'>
								Excluir
							</button>
						</td>
					</tr>
					{/itens}
			</tbody>
		</table>
		<!-- /.modal -->
	</div>
</div>

////////sessao ci r+
array (size=23)
'session_id' => string '69f9dc61dfbb36aa08a65d7b2436d1ae' (length=32)
'ip_address' => string '::1' (length=3)
'user_agent' => string 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:30.0) Gecko/20100101 Firefox/30.0' (length=72)
'last_activity' => int 1405107674
'user_data' => string '' (length=0)
'increment' => int 1
'token' => string 'b0a98a194bbfbe1d0a1579070430cd35' (length=32)
'loggedin' => boolean true
'bloqueia_acesso' => string 'f' (length=1)
'ss_usuario_cod' => string '5433' (length=4)
'ss_usuario_login' => string 'marlon@revendamais.com.br' (length=25)
'ss_usuario_email' => string 'marlon@revendamais.com.br' (length=25)
'ss_usuario_senha' => string 'ef5048848b8386457a43b9f5f6ffc459' (length=32)
'ss_usuario_paginacao' => string '300' (length=3)
'ss_usuario_grupo' => string '126' (length=3)
'ss_usuario_key' => int 1405107676
'validouEmail' => boolean true
'ss_empresa_conectada' => string '1136' (length=4)
'ss_nova_conta' => boolean false
'ss_situacao_nova_conta' => int 100
'ss_redir_mcn' => string 'index2.php?err=1' (length=16)
'ss_empresa_multi' => string 't' (length=1)
'ss_usuario_nome' => string 'Marlon' (length=6)
