<!--BEGIN EXAMPLE TABLE PORTLET-->
<div class='box light-grey'>
	<div class='portlet-body'>
		<table class='table table-striped table-bordered table-hover' id='simple_2'>
			<thead>
				<tr>
					<th width="4%" class="table-checkbox">
						<input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
					</th>
					<th width='5%'>
						agen_cod
					</th>
					<th width='5%'>
						agen_nome
					</th>
					<th width='5%'>
						agen_status
					</th>
					<th width='5%'>
						banc_cod
					</th>
					<th width='5%'>
						reve_cod
					</th>
					<th width='5%'>
						agencia_codigo
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
						<input type="checkbox" class="checkboxes" value="1" />
					</td>
						<td>
							{agen_cod}
						</td>
						<td>
							{agen_nome}
						</td>
						<td>
							{agen_status}
						</td>
						<td>
							{banc_cod}
						</td>
						<td>
							{reve_cod}
						</td>
						<td>
							{agencia_codigo}
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
