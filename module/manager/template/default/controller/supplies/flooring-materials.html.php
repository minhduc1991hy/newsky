{error}
<div class="row">
	{if ($bAdd && Phpfox::getUserParam('manager.can_add_flooring_materials')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_flooring_materials'))}
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

				<div class="table">
					<div class="table_left">
						<label>Tiêu đề{required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="text" name="val[title]" id="title" value="{value type='input' id='title'}" placeholder="Tiêu đề" />
					</div>
					<div class="clear"></div>
				</div>

				<div class="table">
					<div class="table_left">
						<label>Chiều rộng(mm){required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="number" name="val[width]" id="width" value="{value type='input' id='width'}" placeholder="Chiều rộng" />
					</div>
					<div class="clear"></div>
				</div>

				<div class="table">
					<div class="table_left">
						<label>Chiều dài(mm){required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="number" name="val[length]" id="length" value="{value type='input' id='length'}" placeholder="Chiều dài" />
					</div>
					<div class="clear"></div>
				</div>
				
				
				{module name="manager.template.select-inventoried-unit"}
				{module name="manager.template.select-sale-unit"}
				{module name="manager.category.select-category" sTypeId=$sTypeIdCategory}
				{module name='manager.template.template-button' sLinkButton='manager.supplies.flooring-materials'}
			</form>
		</div>
	{/if}

	{if ($bAdd && Phpfox::getUserParam('manager.can_add_flooring_materials')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_flooring_materials'))}
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
		                    <th class="text-left">NỘI DUNG</th>
		                    <th class="text-right">DÀI(mm)</th>
		                    <th class="text-right">RỘNG(mm)</th>
		                    <th class="text-right">ĐƠN VỊ KK</th>
		                    <th class="text-right">ĐƠN VỊ BÁN</th>
		                    {if Phpfox::getUserParam('manager.can_edit_flooring_materials') ||
								Phpfox::getUserParam('manager.can_del_flooring_materials')
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
		                    	<p><strong>Tiêu đề: </strong>{$aRow.title}</p>
		                    	<p><strong>Danh mục: </strong>
		                    		{$aRow.data_title}
		                    		{if isset($aRow.data_description) && !empty($aRow.data_description)} ({$aRow.data_description}){/if}
		                    	</p>
		                    </td>
		                    <td class="text-right">{$aRow.length}</td>
		                    <td class="text-right">{$aRow.width}</td>
		                    <td class="text-right">{$aRow.inventoried_unit|newsky_inventoried_unit}</td>
		                    <td class="text-right">{$aRow.sale_unit|newsky_sale_unit}</td>
		                    
		                    {if Phpfox::getUserParam('manager.can_edit_flooring_materials') ||
								Phpfox::getUserParam('manager.can_del_flooring_materials')
		                    }
		                    <td class="text-center">
		                        <div class="btn-group">
		                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
		                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
		                                {if Phpfox::getUserParam('manager.can_edit_flooring_materials')}
		                                    <li><a href="{url link='manager.supplies.flooring-materials' id=$aRow.material_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
		                                {/if}

		                                {if Phpfox::getUserParam('manager.can_del_flooring_materials')}
			                                <li><a href="{url link='current' delete=$aRow.material_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa {$sName}</a></li>
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