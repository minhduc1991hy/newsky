{error}
<div class="row">
	{if ($bAdd && Phpfox::getUserParam('manager.can_add_skirting')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_skirting'))}
		<div class="col-sm-3">
			<h4 class="title text-center">{if $bEdit}Sửa{else}Thêm{/if} {$sName}</h4>
			<form action="{url link='current'}" id="js_form_manager_add" method="POST">
				<div class="table">
					<div class="table_left">
						<label>Mã {$sName}{required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="text" name="val[code]" id="code" value="{value type='input' id='code'}" placeholder="Mã {$sName}" />
					</div>
					<div class="clear"></div>
				</div>
				
				{module name="manager.category.select-category" sTypeId=$sTypeIdCategory}
				{module name="manager.plan.select-color-code" sTitle='Giấy vân'}
				{module name="manager.supplies.select-hdf"}
				{module name="manager.plan.select-flooring-dim"}

				<div class="table">
					<div class="table_left">
						<label>Đóng gói(cây/hộp){required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="number" name="val[packing]" id="packing" value="{value type='input' id='packing'}" placeholder="Đóng gói(cây/hộp)" />
					</div>
					<div class="clear"></div>
				</div>
				{module name="manager.template.select-inventoried-unit" sTitle="Đơn vị tính"}
				{module name='manager.template.template-button' sLinkButton='manager.plan.skirting'}
			</form>
		</div>
	{/if}

	{if ($bAdd && Phpfox::getUserParam('manager.can_add_skirting')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_skirting'))}
	<div class="col-sm-9">
	{else}
	<div class="col-sm-12">
	{/if}
		<div class="box">
		    <div class="box-body">
				{if isset($aRows) && !empty($aRows)}
		        <table class="table table-bordered table-striped">
		            <thead>
		                <tr>
		                    <th class="text-center" style="width: 50px;">STT</th>
		                    <th class="text-left">MÃ</th>
		                    <th class="text-center">NỘI DUNG</th>
		                    <th class="text-left">ĐÓNG GÓI</th>
		                    {if Phpfox::getUserParam('manager.can_edit_skirting') ||
								Phpfox::getUserParam('manager.can_del_skirting')
		                    }
		                        <th class="text-center" style="width: 55px;">#</th>
		                    {/if}
		                </tr>
		            </thead>
		            <tbody>
		                {foreach from=$aRows key=iKey item=aRow}
		                <tr>
		                    <td class="text-center">{if $iNo = $iNo + 1}{$iNo}{/if}</td>
		                    <td>{$aRow.code}</td>
		                    <td>
		                    	<p><strong>CLASS: </strong>{$aRow.data_title}{if isset($aRow.data_description) && !empty($aRow.data_description)} ({$aRow.data_description}){/if}</p>
		                    	<p><strong>Giấy vân: </strong>{$aRow.color_code}{if isset($aRow.color_title) && !empty($aRow.color_title)} ({$aRow.color_title}){/if}</p>
		                    	<p><strong>HDF: </strong>{$aRow.hdf_code}{if isset($aRow.hdf_description) && !empty($aRow.hdf_description)} ({$aRow.hdf_description}){/if}</p>
		                    	<p><strong>KÍCH THƯỚC: </strong>{$aRow.flooring_dim_code} ({$aRow.flooring_dim_width} x {$aRow.flooring_dim_length} x {$aRow.flooring_dim_thickness})</p>
		                    </td>
		                    <td class="text-right">{$aRow.packing} {$aRow.inventoried_unit|newsky_inventoried_unit}</td>
		                    {if Phpfox::getUserParam('manager.can_edit_skirting') ||
								Phpfox::getUserParam('manager.can_del_skirting')
		                    }
		                    <td class="text-center">
		                        <div class="btn-group">
		                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
		                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
		                                {if Phpfox::getUserParam('manager.can_edit_skirting')}
		                                    <li><a href="{url link='manager.plan.skirting' id=$aRow.skirting_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
		                                {/if}

		                                {if Phpfox::getUserParam('manager.can_del_skirting')}
			                                <li><a href="{url link='current' delete=$aRow.skirting_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa {$sName}</a></li>
		                                {/if}
		                            </ul>
		                        </div>
		                    </td>
		                    {/if}
		                </tr>
		                {/foreach}
		            </tbody>
		        </table>
		        {else}
		            {no_item_message}
		        {/if}
		    </div>
		    <!-- /.box-body -->
		    <div class="box-footer clearfix text-center">
		        {pager}
		    </div>
		</div>
	</div>
</div>