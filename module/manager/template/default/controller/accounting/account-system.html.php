{error}
<div class="row">
	{if ($bAdd && Phpfox::getUserParam('manager.can_add_account_system')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_account_system'))}
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
						<label>Mô tả{required}</label>
					</div>
					<div class="table_right">
						<textarea name="val[description]" style="resize: vertical;" id="description" cols="30" rows="3" class="form-control" placeholder="Nội dung mô tả">{value type='textarea' id='description'}</textarea>
					</div>
					<div class="clear"></div>
				</div>
				{module name='manager.template.select-tinh-chat-ket-du'}
				{module name='manager.template.template-button' sLinkButton='manager.accounting.account-system'}
			</form>
		</div>
	{/if}

	{if ($bAdd && Phpfox::getUserParam('manager.can_add_account_system')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_account_system'))}
	<div class="col-sm-9">
	{else}
	<div class="col-sm-12">
	{/if}
		<div class="box table-responsive no-padding">
			{if isset($aRows) && !empty($aRows)}
	        <table class="table table-bordered table-striped">
	            <thead>
	                <tr>
	                    <th class="text-center" style="width: 50px;">STT</th>
	                    <th class="text-center">MÃ</th>
	                    <th class="text-left">MÔ TẢ</th>
	                    <th class="text-center">KẾT DƯ</th>
	                    {if Phpfox::getUserParam('manager.can_edit_account_system') ||
							Phpfox::getUserParam('manager.can_del_account_system')
	                    }
	                        <th class="text-center" style="width: 55px;">#</th>
	                    {/if}
	                </tr>
	            </thead>
	            <tbody>
	                {foreach from=$aRows key=iKey item=aRow}
	                <tr>
	                    <td class="text-center">{if $iNo = $iNo + 1}{$iNo}{/if}</td>
	                    <td class="text-center">{$aRow.code}</td>
	                    <td>{$aRow.description}</td>
	                    <td class="text-center">{$aRow.tckd|newsky_TCKD}</td>
	                    {if Phpfox::getUserParam('manager.can_edit_account_system') ||
							Phpfox::getUserParam('manager.can_del_account_system')
	                    }
	                    <td class="text-center">
	                        <div class="btn-group">
	                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
	                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
	                                {if Phpfox::getUserParam('manager.can_edit_account_system')}
	                                    <li><a href="{url link='manager.accounting.account-system' id=$aRow.account_system_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
	                                {/if}

	                                {if Phpfox::getUserParam('manager.can_del_account_system')}
		                                <li><a href="{url link='current' delete=$aRow.account_system_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa {$sName}</a></li>
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
	        
		    <div class="box-footer clearfix text-center">
		        {pager}
		    </div>
		</div>
	</div>
</div>