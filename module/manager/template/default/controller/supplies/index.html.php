{error}
<div class="row">
	{if ($bAdd && Phpfox::getUserParam('manager.can_add_hdf')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_hdf'))}
		<div class="col-sm-3">
			<h4 class="title text-center">{if $bEdit}Sửa{else}Thêm{/if} nhà cung cấp</h4>
			<form action="{url link='current'}" id="js_form_manager_add" method="POST">
				<div class="table">
					<div class="table_left">
						<label>Mã nhà cung cấp{required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="text" name="val[code]" id="code" value="{value type='input' id='code'}" placeholder="Mã nhà cung cấp" />
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="table">
					<div class="table_left">
						<label>Tên nhà cung cấp{required}</label>
					</div>
					<div class="table_right">
						<textarea name="val[name]" style="resize: vertical;" id="name" cols="30" rows="3" class="form-control" placeholder="Nhập tên nhà cung cấp (tên công ty)">{value type='textarea' id='name'}</textarea>
					</div>
					<div class="clear"></div>
				</div>

				<div class="table">
					<div class="table_left">
						<label>Địa chỉ{required}</label>
					</div>
					<div class="table_right">
						<textarea name="val[address]" style="resize: vertical;" id="address" cols="30" rows="3" class="form-control" placeholder="Nhập địa chỉ nhà cung cấp ">{value type='textarea' id='address'}</textarea>
					</div>
					<div class="clear"></div>
				</div>

				<div class="table">
					<div class="table_left">
						<label>Số điện thoại</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="tel" name="val[phone]" id="phone" value="{value type='input' id='phone'}" placeholder="Số điện thoại nhà cung cấp" />
					</div>
					<div class="clear"></div>
				</div>

				<div class="table">
					<div class="table_left">
						<label>Mô tả</label>
					</div>
					<div class="table_right">
						<textarea name="val[description]" style="resize: vertical;" id="description" cols="30" rows="3" class="form-control" placeholder="Nội dung mô tả">{value type='textarea' id='description'}</textarea>
					</div>
					<div class="clear"></div>
				</div>
				
				{module name='manager.template.template-button' sLinkButton='manager.supplies.index'}
			</form>
		</div>
	{/if}


	{if ($bAdd && Phpfox::getUserParam('manager.can_add_hdf')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_hdf'))}
	<div class="col-sm-9">
	{else}
	<div class="col-sm-12">
	{/if}
		<div class="box">
		    <div class="box-body">
				{if isset($aSupplies) && !empty($aSupplies)}
		        <table class="table table-bordered table-striped">
		            <thead>
		                <tr>
		                    <th class="text-center" style="width: 50px;">STT</th>
		                    <th class="text-left">Mã NCC</th>
		                    <th class="text-left">NỘI DUNG</th>
		                    {if Phpfox::getUserParam('manager.can_edit_supplies') ||
								Phpfox::getUserParam('manager.can_del_supplies')
		                    }
		                        <th class="text-center" style="width: 55px;">#</th>
		                    {/if}
		                </tr>
		            </thead>
		            <tbody>
		                {foreach from=$aSupplies key=iKey item=aSupplie}
		                <tr>
		                    <td class="text-center">{if $iNo = $iNo + 1}{$iNo}{/if}</td>
		                    <td>{$aSupplie.code}</td>
		                    <td>
		                    	<p><strong>Tên nhà cung cấp: </strong>{$aSupplie.name}</p>
		                    	<p><strong>Địa chỉ: </strong>{$aSupplie.address}</p>
		                    	<p><strong>Số điện thoại: </strong>{$aSupplie.phone}</p>
		                    	<p><strong>Mô tả: </strong>{$aSupplie.description}</p>
		                    </td>
		                    {if Phpfox::getUserParam('manager.can_edit_supplies') ||
								Phpfox::getUserParam('manager.can_del_supplies')
		                    }
		                    <td class="text-center">
		                        <div class="btn-group">
		                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
		                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
		                                {if Phpfox::getUserParam('manager.can_edit_supplies')}
		                                    <li><a href="{url link='manager.supplies.index' id=$aSupplie.supplie_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
		                                {/if}

		                                {if Phpfox::getUserParam('manager.can_del_supplies')}
			                                <li><a href="{url link='current' delete=$aSupplie.supplie_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa nhà cung cấp</a></li>
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