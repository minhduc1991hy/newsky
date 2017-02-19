{error}
<div class="row">
	{if ($bAdd && Phpfox::getUserParam('manager.can_add_flooring_dim')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_flooring_dim'))}
		<div class="col-sm-3">
			<h4 class="title text-center">{if $bEdit}Sửa{else}Thêm{/if} kích cỡ ván sàn</h4>
			<form action="{url link='current'}" id="js_form_manager_add" method="POST">
				<div class="table">
					<div class="table_left">
						<label>Mã kích cỡ ván sàn{required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="text" name="val[code]" id="code" value="{value type='input' id='code'}" placeholder="Mã kích cỡ ván sàn" />
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
				
				<div class="table">
					<div class="table_left">
						<label>Độ dày(mm){required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="number" name="val[thickness]" id="thickness" value="{value type='input' id='thickness'}" placeholder="Độ dày" />
					</div>
					<div class="clear"></div>
				</div>
				{module name='manager.template.template-button' sLinkButton='manager.plan.flooring-dim'}
			</form>
		</div>
	{/if}

	{if ($bAdd && Phpfox::getUserParam('manager.can_add_flooring_dim')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_flooring_dim'))}
	<div class="col-sm-9">
	{else}
	<div class="col-sm-12">
	{/if}
		<div class="box table-responsive no-padding">
			{if isset($aFlooringDims) && !empty($aFlooringDims)}
	        <table class="table table-bordered table-striped">
	            <thead>
	                <tr>
	                    <th class="text-center" style="width: 50px;">STT</th>
	                    <th class="text-left">MÃ</th>
	                    <th class="text-left">KÍCH THƯỚC</th>
	                    {if Phpfox::getUserParam('manager.can_edit_flooring_dim') ||
							Phpfox::getUserParam('manager.can_del_flooring_dim')
	                    }
	                        <th class="text-center" style="width: 55px;">#</th>
	                    {/if}
	                </tr>
	            </thead>
	            <tbody>
	                {foreach from=$aFlooringDims key=iKey item=aFlooringDim}
	                <tr>
	                    <td class="text-center">{if $iNo = $iNo + 1}{$iNo}{/if}</td>
	                    <td>{$aFlooringDim.code}</td>
	                    <td>{$aFlooringDim.width} x {$aFlooringDim.length} x {$aFlooringDim.thickness}</td>
	                    
	                    {if Phpfox::getUserParam('manager.can_edit_flooring_dim') ||
							Phpfox::getUserParam('manager.can_del_flooring_dim')
	                    }
	                    <td class="text-center">
	                        <div class="btn-group">
	                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
	                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
	                                {if Phpfox::getUserParam('manager.can_edit_flooring_dim')}
	                                    <li><a href="{url link='manager.plan.flooring-dim' id=$aFlooringDim.flooringdim_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
	                                {/if}

	                                {if Phpfox::getUserParam('manager.can_del_flooring_dim')}
		                                <li><a href="{url link='current' delete=$aFlooringDim.flooringdim_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa ván sàn</a></li>
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