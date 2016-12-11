

{if ($bAdd && Phpfox::getUserParam('manager.can_add_vansan')) || ($bEdit && Phpfox::getUserParam('manager.can_edit_vansan'))}
<h4 class="title text-center"><strong>{if $bEdit}Sửa{else}Thêm{/if} {$sName}</strong></h4>
{error}
<form action="{url link='current'}" id="js_form_manager_add" method="POST">
	<div class="row">
		<div class="col-md-6">

			<div class="table">
				<div class="table_left">
					<label>Mã {$sName}{required}</label>
				</div>
				<div class="table_right">
					<input class="form-control" type="text" name="val[code]" id="code" value="{value type='input' id='code'}" placeholder="Mã {$sName}" />
				</div>
				<div class="clear"></div>
			</div>
			{module name="manager.template.select-unit"}
			{module name="manager.category.select-category" sTypeId=$sTypeIdCategory sTitle='Giá hoạch toán'}
			{module name="manager.plan.select-color-code" sTitle='Giấy vân'}
			{module name="manager.plan.select-color-schemas-codelike" sLikeCode='cx' sTitle='Giấy chống xước'}
			{module name="manager.supplies.select-hdf"}

		</div>
		<div class="col-md-6">
			{module name="manager.plan.select-color-schemas-codelike" sLikeCode='cb' sTitle='Giấy cân bằng'}
			<div class="row">
				<div class="col-md-6">
					{module name="manager.template.select-kieuvatcanh"}
				</div>
				<div class="col-md-6">
					{module name="manager.template.select-kieu-ranh"}
				</div>
			</div>
			{module name="manager.template.select-bemat"}
			{module name="manager.template.select-khuon-duoi"}
			{module name="manager.plan.select-flooring-dim"}
			<div class="table">
				<div class="table_left">
					<label>Đóng gói(tấm/hộp){required}</label>
				</div>
				<div class="table_right">
					<input class="form-control" type="number" name="val[packing]" id="packing" value="{value type='input' id='packing'}" placeholder="Đóng gói(tấm/hộp)" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>

	<div class="table_clear text-center">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-md-offset-3">
				{module name='manager.template.template-button' sLinkButton='manager.plan.vansan'}
			</div>
		</div>
	</div>
</form>
<br>
<br>
{/if}
<div class="row">
	<div class="col-sm-12">
		<div class="box">
		    <div class="box-body">
				{if isset($aRows) && !empty($aRows)}
		        <table class="table table-bordered table-striped">
		            <thead>
		                <tr>
		                    <th class="text-center" style="width: 50px;">STT</th>
		                    <th class="text-left" style="width: 150px;">MÃ</th>
		                    <th class="text-center">NỘI DUNG</th>
		                    <th class="text-right">ĐÓNG GÓI</th>
		                    {if Phpfox::getUserParam('manager.can_edit_vansan') ||
								Phpfox::getUserParam('manager.can_del_vansan')
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
		                    	<div class="row">
		                    		<div class="col-md-6">
		                    			<p><strong>Class hoạch toán: </strong>{$aRow.data_title}{if !empty($aRow.data_description)} ({$aRow.data_description}){/if}</p>
				                    	<p><strong>Giấy vân: </strong>{$aRow.color_code}{if !empty($aRow.color_title)} ({$aRow.color_title}){/if}</p>
				                    	<p><strong>Giấy chống xước: </strong>{$aRow.colorcx_code}{if !empty($aRow.colorcx_title)} ({$aRow.colorcx_title}){/if}</p>
				                    	<p><strong>Giấy cân bằng: </strong>{$aRow.colorbx_code}{if !empty($aRow.colorbx_title)} ({$aRow.colorbx_title}){/if}</p>
				                    	<p><strong>HDF: </strong>{$aRow.hdf_code}{if !empty($aRow.hdf_description)} ({$aRow.hdf_description}){/if}</p>
		                    		</div>
		                    		<div class="col-md-6">
		                    			<p><strong>Kiểu vát cạnh: </strong>{$aRow.vat_canh|newsky_kieu_vat}</p>
				                    	<p><strong>Kiểu rãnh: </strong>{$aRow.kieu_ranh|newsky_kieu_ranh}</p>
				                    	<p><strong>Bề mặt: </strong>{$aRow.be_mat|newsky_be_mat}</p>
				                    	<p><strong>Khuôn dưới: </strong>{$aRow.khuon_duoi|newsky_khuon_duoi}</p>
				                    	<p><strong>Kích thước: </strong>{$aRow.flooring_dim_code}({$aRow.flooring_dim_width}x{$aRow.flooring_dim_length}x{$aRow.flooring_dim_thickness})</p>
		                    		</div>
		                    	</div>
		                    </td>
		                    <td class="text-right">{$aRow.packing} {$aRow.unit|newsky_unit}</td>
		                    {if Phpfox::getUserParam('manager.can_edit_vansan') ||
								Phpfox::getUserParam('manager.can_del_vansan')
		                    }
		                    <td class="text-center">
		                        <div class="btn-group">
		                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
		                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
		                                {if Phpfox::getUserParam('manager.can_edit_vansan')}
		                                    <li><a href="{url link='manager.plan.vansan' id=$aRow.vansan_id}"><i class="fa fa-pencil"></i> Sửa thông tin</a></li>
		                                {/if}

		                                {if Phpfox::getUserParam('manager.can_del_vansan')}
			                                <li><a href="{url link='current' delete=$aRow.vansan_id}" onclick="if(!confirm('Bạn có chắc chắn muốn xóa không?')) return false;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa {$sName}</a></li>
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