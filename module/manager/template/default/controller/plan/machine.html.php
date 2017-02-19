{error}
<div class="row">
	{if ($bAdd && Phpfox::getUserParam('manager.can_add_machine')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_machine'))}
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
						<label>Ghi chú</label>
					</div>
					<div class="table_right">
						<textarea name="val[note]" style="resize: vertical;" id="note" cols="30" rows="3" class="form-control" placeholder="Ghi chú">{value type='textarea' id='note'}</textarea>
					</div>
					<div class="clear"></div>
				</div>

				<div class="table">
					<div class="table_left">
						<label>Giá mua{required}</label>
					</div>
					<div class="table_right">
						<input class="form-control" type="text" name="val[price_buy]" id="price_buy" value="{value type='input' id='price_buy'}" placeholder="Giá mua" />
					</div>
					<div class="clear"></div>
				</div>

				<div class="table">
					<div class="table_left">
						<label>Ngày mua{required}</label>
					</div>
					<div class="table_right">
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input name="val[date_buy]" value="{value type='input' id='date_buy'}" type="text" class="datepicker form-control pull-right" class="datepicker" id="date_buy">
						</div>
					</div>
					<div class="clear"></div>
				</div>

				{module name="manager.category.select-category" sTypeId=$sTypeIdCategory sTitle='Công đoạn'}
				{module name='manager.template.template-button' sLinkButton='manager.plan.machine'}
			</form>
		</div>
	{/if}

	{if ($bAdd && Phpfox::getUserParam('manager.can_add_machine')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_machine'))}
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
	                    <th class="text-center">NỘI DUNG</th>
	                    <th class="text-center">NGÀY</th>
	                    <th class="text-left">GIÁ(VNĐ)</th>
	                    {if Phpfox::getUserParam('manager.can_edit_machine') ||
							Phpfox::getUserParam('manager.can_del_machine')
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
	                    	<p><strong>Công đoạn: </strong>{$aRow.data_title}{if isset($aRow.data_description) && !empty($aRow.data_description)} ({$aRow.data_description}){/if}</p>
	                    	<p><strong>Ghi chú: </strong>{$aRow.note}</p>
	                    </td>
	                    <td class="text-center">{$aRow.date_buy|date:'manager.time_stamp'}</td>
	                    <td class="text-right">{$aRow.price_buy|number_format:'0':'.':'.'}</td>
	                    {if Phpfox::getUserParam('manager.can_edit_machine') ||
							Phpfox::getUserParam('manager.can_del_machine')
	                    }
	                    <td class="text-center">
	                        <div class="btn-group">
	                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
	                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
	                                {if Phpfox::getUserParam('manager.can_edit_machine')}
	                                    <li><a href="{url link='manager.plan.machine' id=$aRow.machine_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
	                                {/if}

	                                {if Phpfox::getUserParam('manager.can_del_machine')}
		                                <li><a href="{url link='current' delete=$aRow.machine_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa {$sName}</a></li>
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