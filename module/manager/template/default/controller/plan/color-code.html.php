{error}
<div class="row">
	{if ($bAdd && Phpfox::getUserParam('manager.can_add_color_code')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_color_code'))}
		<div class="col-sm-3">
			<h4 class="title text-center">{if $bEdit}Sửa{else}Thêm{/if} màu</h4>
			<form action="{url link='current'}" id="js_form_manager_add" method="POST">
				<div class="table">
					<div class="table_left">
						<label>Mã màu{required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="text" name="val[code]" id="code" value="{value type='input' id='code'}" placeholder="Mã màu" />
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

				{module name="manager.category.select-category" sTypeId=$sTypeIdCategory}
				{module name='manager.template.template-button' sLinkButton='manager.plan.color-code'}
			</form>
		</div>
	{/if}

	{if ($bAdd && Phpfox::getUserParam('manager.can_add_color_code')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_color_code'))}
	<div class="col-sm-9">
	{else}
	<div class="col-sm-12">
	{/if}
		<div class="box">
		    <div class="box-body">
				{if isset($aColorSchemas) && !empty($aColorSchemas)}
		        <table class="table table-bordered table-striped">
		            <thead>
		                <tr>
		                    <th class="text-center" style="width: 50px;">STT</th>
		                    <th class="text-left">Mã MÀU</th>
		                    <th class="text-left">TIÊU ĐỀ</th>
		                    <th class="text-left">DANH MỤC</th>
		                    {if Phpfox::getUserParam('manager.can_edit_color_code') ||
								Phpfox::getUserParam('manager.can_del_color_code')
		                    }
		                        <th class="text-center" style="width: 55px;">#</th>
		                    {/if}
		                </tr>
		            </thead>
		            <tbody>
		                {foreach from=$aColorSchemas key=iKey item=aColorSchema}
		                <tr>
		                    <td class="text-center">{if $iNo = $iNo + 1}{$iNo}{/if}</td>
		                    <td>{$aColorSchema.code}</td>
		                    <td>{$aColorSchema.title}</td>
		                    <td>
		                    	{$aColorSchema.data_title}
		                    	{if isset($aColorSchema.data_description) && !empty($aColorSchema.data_description)}({$aColorSchema.data_description}){/if}
		                    </td>

		                    {if Phpfox::getUserParam('manager.can_edit_color_code') ||
								Phpfox::getUserParam('manager.can_del_color_code')
		                    }
		                    <td class="text-center">
		                        <div class="btn-group">
		                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
		                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
		                                {if Phpfox::getUserParam('manager.can_edit_color_code')}
		                                    <li><a href="{url link='manager.plan.color-code' id=$aColorSchema.color_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
		                                {/if}

		                                {if Phpfox::getUserParam('manager.can_del_color_code')}
			                                <li><a href="{url link='current' delete=$aColorSchema.color_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa màu</a></li>
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