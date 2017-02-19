{error}
<div class="row">
	<div class="col-sm-12">
		<div class="box table-responsive no-padding">
			{if isset($aRows) && !empty($aRows)}
	        <table class="table table-striped">
	            <thead>
	                <tr>
	                    <th class="text-center" style="width: 100px;">STT/MÃ</th>
	                    <th class="text-center">NỘI DUNG</th>
	                    <th class="text-center" style="width: 55px;">#</th>
	                </tr>
	            </thead>
	            <tbody>
	                {foreach from=$aRows key=iKey item=aRow}
	                <tr class="order_{$aRow.order_id}">
	                    <td class="text-center">
	                    	<strong>{if $iNo = $iNo + 1}{$iNo}{/if}</strong>
	                    	<br>
	                    	{$aRow.code}
	                    </td>
	                    <td>
	                    	<div class="info_customer">
	                    		<p><strong style="font-size: 13px; display: inline-block; background: #00a65a; color: #fff; padding: 0 5px; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;">THÔNG TIN KHÁCH HÀNG: </strong></p>
	                    		<div class="row">
	                    			<div class="col-xs-6 col-sm-6 col-md-4">
	                    				<strong>Tên khách hàng:</strong> {$aRow.full_name}
	                    			</div>
	                    			<div class="col-xs-6 col-sm-6 col-md-4">
	                    				<strong>Email:</strong> {$aRow.email}
	                    			</div>
	                    			<div class="col-xs-6 col-sm-6 col-md-4">
	                    				<strong>Số điện thoại:</strong> {$aRow.phone}
	                    			</div>
	                    			<div class="col-xs-6 col-sm-6 col-md-4">
	                    				<strong>Ngày đặt:</strong> {$aRow.time_stamp|date:'manager.time_stamp'}
	                    			</div>
	                    			<div class="col-xs-6 col-sm-6 col-md-4">
	                    				<strong>Trạng thái:</strong> {$aRow.status_id|newsky_status_order}
	                    			</div>
	                    			{if isset($aRow.user_contact) && !empty($aRow.user_contact)}
									<div class="col-xs-12">
	                    				<strong>Địa chỉ:</strong> {$aRow.user_contact}
	                    			</div>
	                    			{/if}
	                    		</div>
	                    	</div>
							<br>
	                    	<div class="info_customer">
	                    		<p><strong style="font-size: 13px; display: inline-block; background: #00a65a; color: #fff; padding: 0 5px; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;">THÔNG TIN SẢN PHẨM </strong> ({$aRow.products|count} sản phẩm)</p>

								<table class="table table-striped">
									<tbody>
										<tr style="color: #fff; text-align: center; font-weight: bold; background: #333;">
											<td class="text-left" style="width: 260px;">Sản phẩm</td>
											<td class="text-right" style="width: 75px;">Số lượng</td>
											<td style="width: 85px;">Ngày giao</td>
											<td>Mô tả</td>
											<td style="width: 39px;">#</td>
										</tr>
										{if isset($aRow.products) && !empty($aRow.products)}
											{foreach from=$aRow.products key=key item=aProduct}

											<tr style="background-color: #e4e4e4; {if $aRow.status_id != STATUS_ORDER_DONE && $aProduct.deadline < PHPFOX_TIME}color: red;{/if}" class="product_{$aProduct.order_product_id}">
												<td>
													{if isset($aProduct.vansan.code)}{$aProduct.vansan.code}{/if}
													{if isset($aProduct.vansan.hdf_code)}.{$aProduct.vansan.hdf_code}{/if}
													{if isset($aProduct.vansan.color_code)}.{$aProduct.vansan.color_code}{/if}
													{if isset($aProduct.vansan.colorcx_code)}.{$aProduct.vansan.colorcx_code}{/if}
													{if isset($aProduct.vansan.colorbx_code)}.{$aProduct.vansan.colorbx_code}{/if}
													{if isset($aProduct.vansan.flooring_dim_code)}.{$aProduct.vansan.flooring_dim_code}{/if}
													<br>
													{if isset($aProduct.skirting.code)}{$aProduct.skirting.code}{/if}
													{if isset($aProduct.skirting.hdf_code)}.{$aProduct.skirting.hdf_code}{/if}
													{if isset($aProduct.skirting.color_code)}.{$aProduct.skirting.color_code}{/if}
													{if isset($aProduct.skirting.flooring_dim_code)}.{$aProduct.skirting.flooring_dim_code}{/if}
												</td>
												<td class="text-right">{$aProduct.quantity|number_format:0:'.':'.'}</td>
												<td class="text-center">{$aProduct.deadline|date:'manager.time_stamp'}</td>
												<td>
													{if isset($aProduct.description) && !empty($aProduct.description)}
														{$aProduct.description}
													{else}
														-
													{/if}
												</td>
												<td class="text-center">
													<div class="btn-group">
							                            <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
							                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
							                            	<li><a href="{url link='manager.order.quick-calendar' id=$aProduct.order_product_id}" title="Lên lịch nhanh"><i class="fa fa-calendar" aria-hidden="true"></i> Lên lịch nhanh</a></li>
							                            	<li><a href="javascript:void(0);" title="Kiểm tra nhập dữ liệu"><i class="fa fa-check-square" aria-hidden="true"></i> Kiểm tra nhập dữ liệu</a></li>
							                            	<li role="presentation" class="divider"></li>
							                            	<li><a href="javascript:void(0);" title="Lịch sản suất"><i class="fa fa-calendar-o" aria-hidden="true"></i> Lịch sản suất</a></li>
							                            	<li><a href="javascript:void(0);" title="Nhật ký sản suất"><i class="fa fa-book" aria-hidden="true"></i> Nhật ký sản suất</a></li>
							                            	<li role="presentation" class="divider"></li>
							                                <li><a href="javascript:void(0);" onclick="tb_show('SỬA SẢN PHẨM', $.ajaxBox('manager.order.formAddProduct','item_id={$aProduct.order_product_id}&type=edit_product'), '', '', '', '', 900); return false;" title="Chỉnh sửa"><i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sửa</a></li>
							                                <li><a href="javascript:void(0);" onclick="if (confirm('Bạn có chắc muốn xóa sản phẩm này không?')){l}$.ajaxCall('manager.order.deleteProduct','product_id={$aProduct.order_product_id}'); $Core.showLoadding();{r} return false;" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a></li>
							                            </ul>
							                        </div>
												</td>
											</tr>
											{/foreach}
										{/if}
									</tbody>
								</table>
	                    	</div>
	                    </td>
	                    <td class="text-center">
	                        <div class="btn-group">
	                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
	                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
	                                <li><a href="javascript:void(0);" onclick="tb_show('THÊM SẢN PHẨM', $.ajaxBox('manager.order.formAddProduct','item_id={$aRow.order_id}&type=add_product'), '', '', '', '', 900); return false;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm sản phẩm</a></li>
	                                <li><a href="javascript:void(0);" onclick="tb_show('ĐỔI KHÁCH HÀNG', $.ajaxBox('manager.order.searchCustomerForm','item_id={$aRow.order_id}&type_id=edit_customer'), '', '', '', '', 900); return false;"><i class="fa fa-user-circle" aria-hidden="true"></i> Đổi khách hàng</a></li>
	                            </ul>
	                        </div>
	                    </td>
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