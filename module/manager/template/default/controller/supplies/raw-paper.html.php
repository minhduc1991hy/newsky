{error}
<div class="row">
	{if ($bAdd && Phpfox::getUserParam('manager.can_add_raw_paper')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_raw_paper'))}
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

				{module name="manager.plan.select-color-code"}
				{module name="manager.supplies.select-supplies"}

				<div class="table">
					<div class="table_left">
						<label>Trọng lượng(gram){required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="number" name="val[weight]" id="weight" value="{value type='input' id='weight'}" placeholder="Trọng lượng" />
					</div>
					<div class="clear"></div>
				</div>

				{module name="manager.category.select-category" sTypeId=$sTypeIdCategory}
				{module name='manager.template.template-button' sLinkButton='manager.supplies.raw-paper'}
			</form>
		</div>
	{/if}

	{if ($bAdd && Phpfox::getUserParam('manager.can_add_raw_paper')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_raw_paper'))}
	<div class="col-sm-9">
	{else}
	<div class="col-sm-12">
	{/if}
		<div class="box">
		    <div class="box-body">
				{if isset($aRawpapers) && !empty($aRawpapers)}
		        <table class="table table-bordered table-striped">
		            <thead>
		                <tr>
		                    <th class="text-center" style="width: 50px;">STT</th>
		                    <th class="text-left">MÃ</th>
		                    <th class="text-left">TIÊU ĐỀ</th>
		                    <th class="text-left">NỘI DUNG</th>
		                    <th class="text-right">T.LƯỢNG(gram)</th>
		                    {if Phpfox::getUserParam('manager.can_edit_raw_paper') ||
								Phpfox::getUserParam('manager.can_del_raw_paper')
		                    }
		                        <th class="text-center" style="width: 55px;">#</th>
		                    {/if}
		                </tr>
		            </thead>
		            <tbody>
		                {foreach from=$aRawpapers key=iKey item=aRawpaper}
		                <tr>
		                    <td class="text-center">{if $iNo = $iNo + 1}{$iNo}{/if}</td>
		                    <td>{$aRawpaper.code}</td>
		                    <td>{$aRawpaper.title}</td>
		                    <td>
		                    	<p><strong>Danh mục: </strong>
		                    		{$aRawpaper.data_title}
		                    		{if isset($aRawpaper.data_description) && !empty($aRawpaper.data_description)} ({$aRawpaper.data_description}){/if}
		                    	</p>

		                    	<p><strong>Mã màu: </strong>
		                    		{$aRawpaper.color_title}
		                    		{if isset($aRawpaper.color_description) && !empty($aRawpaper.color_description)} ({$aRawpaper.color_description}){/if}
		                    	</p>

		                    	<p><strong>Nhà cung cấp: </strong>{$aRawpaper.supplie_code}</p>
		                    </td>
		                    <td class="text-right">{$aRawpaper.weight}</td>
		                    {if Phpfox::getUserParam('manager.can_edit_raw_paper') ||
								Phpfox::getUserParam('manager.can_del_raw_paper')
		                    }
		                    <td class="text-center">
		                        <div class="btn-group">
		                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
		                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
		                                {if Phpfox::getUserParam('manager.can_edit_raw_paper')}
		                                    <li><a href="{url link='manager.supplies.raw-paper' id=$aRawpaper.rawpaper_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
		                                {/if}

		                                {if Phpfox::getUserParam('manager.can_del_raw_paper')}
			                                <li><a href="{url link='current' delete=$aRawpaper.rawpaper_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa HDF, MDF</a></li>
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