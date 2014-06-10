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
