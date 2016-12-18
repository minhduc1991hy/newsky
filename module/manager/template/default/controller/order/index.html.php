{error}
<div class="row">
	<div class="col-sm-12">
		<div class="box">
		    <div class="box-body">
				{if isset($aRows) && !empty($aRows)}
		        <table class="table table-bordered table-striped">
		            <thead>
		                <tr>
		                    <th class="text-center" style="width: 100px;">STT/MÃ</th>
		                    <th class="text-center">NỘI DUNG</th>
		                    <th class="text-center" style="width: 55px;">#</th>
		                </tr>
		            </thead>
		            <tbody>
		                {foreach from=$aRows key=iKey item=aRow}
		                <tr>
		                    <td class="text-center">
		                    	<strong>{if $iNo = $iNo + 1}{$iNo}{/if}</strong>
		                    	<br>
		                    	{$aRow.code}
		                    </td>
		                    <td class="order_{$aRow.order_id}">
		                    	<div class="info_customer">
		                    		<p><strong style="font-size: 13px; display: inline-block; background: #00a65a; color: #fff; padding: 0 5px; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;">THÔNG TIN: </strong></p>
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
		                    				<strong>Trạng thái:</strong> 
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
		                    		<p><strong style="font-size: 13px; display: inline-block; background: #00a65a; color: #fff; padding: 0 5px; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px;">SẢN PHẨM </strong> ({$aRow.products|count} sản phẩm)</p>
		                    		<ul class="clearfix template-list-product">
		                    			{if isset($aRow.products) && !empty($aRow.products)}
		                    			{foreach from=$aRow.products key=key item=aProduct}
										<li class="item product_{$aProduct.order_product_id}">
											<div class="button" style="position: relative; top: 0; margin-top: 0; right: 0;">
												<a href="javascript:void(0);" onclick="tb_show('SỬA SẢN PHẨM', $.ajaxBox('manager.order.formAddProduct','item_id={$aProduct.order_product_id}&type=edit_product'), '', '', '', '', 900); return false;" title="Chỉnh sửa" style="padding: 0 10px; width: auto;font-size: 13px;"><i class="fa fa-pencil" aria-hidden="true"></i> Chỉnh sửa</a>
												<a href="javascript:void(0);" onclick="if (confirm('Bạn có chắc muốn xóa sản phẩm này không?')){l}$.ajaxCall('manager.order.deleteProduct','product_id={$aProduct.order_product_id}'); $Core.showLoadding();{r} return false;" title="Xóa" style="padding: 0 10px; width: auto;font-size: 13px;"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
												<div class="clear"></div>
											</div>
											<p style="font-size: 14px;">
												<em><strong>Số lượng:</strong> {$aProduct.quantity} - <strong>Ngày giao:</strong> {$aProduct.deadline|date:'manager.time_stamp'}</em>
												{if isset($aProduct.description) && !empty($aProduct.description)}
													<em>- <strong>Mô tả:</strong> {$aProduct.description}</em>
												{/if}
											</p>
											<div class="template_info_horizontal">
												<div class="row">
													<div class="col-md-2"><span class="title">Ván sàn:</span></div>
													<div class="col-md-10">
														<div class="wrapper_line" style="height: inherit;">
															<!-- <a href="javascript:void(0);" class="view_more" onclick="$Core.viewMoreInfoHorizontal(this);">Xem thêm</a> -->
															{if isset($aProduct.vansan.code)}
																<span class="label label-default">{$aProduct.vansan.code}</span>
															{/if}
															{if isset($aProduct.vansan.hdf_code)}
																<span class="label label-default">
																	{$aProduct.vansan.hdf_code}
																</span>
															{/if}
															{if isset($aProduct.vansan.color_code)}
																<span class="label label-default">
																	{$aProduct.vansan.color_code}
																</span>
															{/if}
															{if isset($aProduct.vansan.colorcx_code)}
																<span class="label label-default">
																	{$aProduct.vansan.colorcx_code}
																</span>
															{/if}
															{if isset($aProduct.vansan.colorbx_code)}
																<span class="label label-default">
																	{$aProduct.vansan.colorbx_code}
																</span>
															{/if}
															{if isset($aProduct.vansan.flooring_dim_code)}
																<span class="label label-default">
																	{$aProduct.vansan.flooring_dim_code}
																</span>
															{/if}
															
														</div>
													</div>
												</div>
											</div>

											<div class="template_info_horizontal">
												<div class="row">
													<div class="col-md-2"><span class="title">Phào chân tường:</span></div>
													<div class="col-md-10">
														<div class="wrapper_line">
															<!-- <a href="javascript:void(0);" class="view_more" onclick="$Core.viewMoreInfoHorizontal(this);">Xem thêm</a> -->
															{if isset($aProduct.skirting.code)}
																<span class="label label-default">{$aProduct.skirting.code}</span>
															{/if}
															{if isset($aProduct.skirting.hdf_code)}
																<span class="label label-default">
																	{$aProduct.skirting.hdf_code}
																</span>
															{/if}
															{if isset($aProduct.skirting.color_code)}
																<span class="label label-default">
																	{$aProduct.skirting.color_code}
																</span>
															{/if}
															{if isset($aProduct.skirting.flooring_dim_code)}
																<span class="label label-default">
																	{$aProduct.skirting.flooring_dim_code}
																</span>
															{/if}
														</div>
													</div>
												</div>
											</div>
										</li>
										{/foreach}
										{/if}
									</ul>
		                    	</div>
		                    </td>
		                    <td class="text-center">
		                        <div class="btn-group">
		                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-bars"></i></button>
		                            <ul class="dropdown-menu" role="menu" style="right: 0; left: inherit;">
		                                <li><a href="javascript:void(0);" onclick="tb_show('THÊM SẢN PHẨM', $.ajaxBox('manager.order.formAddProduct','item_id={$aRow.order_id}&type=add_product'), '', '', '', '', 900); return false;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm sản phẩm</a></li>
		                                <li><a href="javascript:void(0);" onclick="tb_show('ĐỔI KHÁCH HÀNG', $.ajaxBox('manager.order.searchCustomerForm','item_id={$aRow.order_id}&type_id=edit_customer'), '', '', '', '', 900); return false;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Đổi khách hàng</a></li>
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
		    </div>
		    <!-- /.box-body -->
		    <div class="box-footer clearfix text-center">
		        {pager}
		    </div>
		</div>
	</div>
</div>