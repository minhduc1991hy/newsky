{error}
<div class="row">
	{if ($bAdd && Phpfox::getUserParam('manager.can_add_project_category')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_project_category'))}
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
						<label>Tên {$sName}{required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="text" name="val[title]" id="title" value="{value type='input' id='title'}" placeholder="Tiêu đề" />
					</div>
					<div class="clear"></div>
				</div>
				
				{module name='manager.template.template-button' sLinkButton='manager.project.category'}
			</form>
		</div>
	{/if}

	{if ($bAdd && Phpfox::getUserParam('manager.can_add_project_category')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_project_category'))}
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
	                    <th class="text-left">MÃ</th>
	                    <th class="text-left">TÊN</th>
	                    {if Phpfox::getUserParam('manager.can_edit_project_category') ||
							Phpfox::getUserParam('manager.can_del_project_category')
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
	                    <td>{$aRow.title}</td>
	                    {if Phpfox::getUserParam('manager.can_edit_project_category') ||
							Phpfox::getUserParam('manager.can_del_project_category')
	                    }
	                    <td class="text-center">
	                        <div class="btn-group">
	                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
	                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
	                                {if Phpfox::getUserParam('manager.can_edit_project_category')}
	                                    <li><a href="{url link='manager.project.category' id=$aRow.project_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
	                                {/if}

	                                {if Phpfox::getUserParam('manager.can_del_project_category')}
		                                <li><a href="{url link='current' delete=$aRow.project_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa {$sName}</a></li>
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