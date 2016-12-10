{error}
<div class="row">
	{if ($bAdd && Phpfox::getUserParam('manager.can_add_hotplate')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_hotplate'))}
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
				
				{module name="manager.template.select-bemat"}
				{module name="manager.template.select-position"}
				{module name="manager.supplies.select-supplies"}
				<div class="table">
					<div class="table_left">
						<label>Tình trạng {$sName}</label>
					</div>
					<div class="table_right">
						<textarea name="val[comment]" style="resize: vertical;" id="comment" cols="30" rows="3" class="form-control" placeholder="Tình trạng {$sName}">{value type='textarea' id='comment'}</textarea>
					</div>
					<div class="clear"></div>
				</div>
					
				{module name='manager.template.template-button' sLinkButton='manager.supplies.hotplate'}
			</form>
		</div>
	{/if}

	{if ($bAdd && Phpfox::getUserParam('manager.can_add_hotplate')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_hotplate'))}
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
		                    <th class="text-left">BỀ MẶT</th>
		                    <th class="text-center">VỊ TRÍ</th>
		                    <th class="text-left">NHÀ CC</th>
		                    <th class="text-left">TÌNH TRẠNG</th>
		                    {if Phpfox::getUserParam('manager.can_edit_hotplate') ||
								Phpfox::getUserParam('manager.can_del_hotplate')
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
		                    	{$aRow.be_mat|newsky_be_mat}
		                    </td>
		                    <td class="text-center">{$aRow.position|newsky_position}</td>
		                    <td>{$aRow.supplie_code}</td>
		                    <td>{$aRow.comment}</td>
		                    {if Phpfox::getUserParam('manager.can_edit_hotplate') ||
								Phpfox::getUserParam('manager.can_del_hotplate')
		                    }
		                    <td class="text-center">
		                        <div class="btn-group">
		                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
		                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
		                                {if Phpfox::getUserParam('manager.can_edit_hotplate')}
		                                    <li><a href="{url link='manager.supplies.hotplate' id=$aRow.hotplate_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
		                                {/if}

		                                {if Phpfox::getUserParam('manager.can_del_hotplate')}
			                                <li><a href="{url link='current' delete=$aRow.hotplate_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa {$sName}</a></li>
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