{error}
<ul class="clearfix template_tab_order">
	{if isset($aOrderSessions) && !empty($aOrderSessions)}
		{foreach from=$aOrderSessions key=iUserId item=aOrderSession}
			<li class="item {if isset($aUser.user_id) && $aUser.user_id == $iUserId}active{/if}">
				<a href="{url link='manager.order.add' user=$iUserId}" class="title" title="{$aOrderSession.user.full_name}"><span class="pull-left"><i class="fa fa-circle-o"></i></span> {$aOrderSession.user.full_name}</a>
				<a href="javascript:void(0);" onclick="if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')){l}$.ajaxCall('manager.order.removeOrder','user_id={$iUserId}&user_id_current={if isset($aUser.user_id)}{$aUser.user_id}{/if}'); $Core.showLoadding(); return false;{r}" class="pull-right" title="Xóa đơn hàng"><i class="fa fa-times" aria-hidden="true"></i></a>
			</li>
		{/foreach}
	{/if}
	<li class="item new {if !isset($aUser) || empty($aUser)}active{/if}">
		<a href="{url link='manager.order.add'}" class="title"><span class="pull-left"><i class="fa fa-plus" aria-hidden="true"></i></span> Mới</a>
	</li>
</ul>

<form action="javascript:void(0);" onsubmit="$.ajaxCall('manager.order.addOrder', 'user_id={if isset($aUser.user_id)}{$aUser.user_id}{/if}'); $Core.showLoadding();" method="POST">
<div class="row">
	{if !isset($aUser) || empty($aUser)}
	<div class="col-sm-6 col-sm-offset-3">
		<h4 class="text-center">TÌM KIẾM THÔNG TIN KHÁCH HÀNG</h4>
		<div class="table">
			<div class="table_left">
				<label for="">Tìm khách hàng</label>
				{if Phpfox::getUserParam('user.can_add_user')}
					<span class="label label-danger">
						<a href="{url link='user.manager.add.customer'}" target="_blank" style="color: #fff; display: inline-block;">Thêm khác hàng mới</a>
					</span>
				{/if}
			</div>
			<div class="table_right">
				<input type="text" onkeyup="$Core.searchUserAddAdmin(this, 'order');" name="val[input_search]" id="input_search" value="{value type='input' id='input_search'}" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
				<p><em>Nhập từ khóa tìm kiếm khách hàng, tên khách hàng, Id khách hàng, Số điện thoại, Email</em></p>
			</div>
		</div>
		<ul class="clearfix template-list-user"></ul>
	</div>
	{else}
	<div class="col-sm-4">
		<h4>THÔNG TIN KHÁCH HÀNG</h4>
		<div class="table">
			<div class="table_left"><label for="">Họ tên khách hàng</label></div>
			<div class="table_right">
				<input type="text" name="val[full_name]" value="{value type='input' id='full_name'}" class="form-control" disabled>
			</div>
		</div>

		<div class="table">
			<div class="table_left"><label for="">Số điện thoại</label></div>
			<div class="table_right">
				<input type="text" name="val[phone]" value="{value type='input' id='phone'}" class="form-control" disabled>
			</div>
		</div>
		
		
		<div class="table">
			<div class="table_left"><label for="">Email</label></div>
			<div class="table_right">
				<input type="text" name="val[email]" value="{value type='input' id='email'}" class="form-control" disabled>
			</div>
		</div>

		<div class="table">
			<div class="table_left"><label for="">Địa chỉ</label></div>
			<div class="table_right">
				<textarea name="val[user_contact]" style="resize: vertical;" cols="30" rows="3" class="form-control" disabled>{value type='textarea' id='user_contact'}</textarea>
			</div>
		</div>

		<div class="table_clear">
			<input type="submit" value="ĐẶT HÀNG" class="button btn btn-success btn-block">
		</div>
	</div>
	
	<div class="col-sm-8">
		<h4>
			<span style="vertical-align: middle;">SẢN PHẨM</span> &nbsp;
			<span class="label label-success">
				<a href="javascript:void(0);" onclick="tb_show('THÊM SẢN PHẨM', $.ajaxBox('manager.order.formAddProduct','item_id={$aUser.user_id}'), '', '', '', '', 900); return false;" target="_blank" style="color: #fff; display: inline-block; font-size: 12px; font-weight: normal;">
					Thêm sản phẩm
				</a>
			</span>
			 &nbsp;
			<span class="label label-danger">
				<a href="javascript:void(0);" onclick="if (confirm('Bạn có chắc chắn muốn reset toàn bộ sản phẩm không?')){l}$.ajaxCall('manager.order.resetProduct','user_id={$aUser.user_id}'); $Core.showLoadding();{r} return false;" target="_blank" style="color: #fff; display: inline-block; font-size: 12px; font-weight: normal;">
					Reset sản phẩm
				</a>
			</span>
		</h4>
		{if isset($OrderUser.products) && !empty($OrderUser.products)}
			<ul class="clearfix template-list-product">
				{foreach from=$OrderUser.products key=key item=aProduct}
				<li class="item">
					<h4>{$aProduct.vansan.code}.{$aProduct.skirting.code}</h4>
					<p>
						<em>Số lượng: {$aProduct.quantity} - Ngày giao: {$aProduct.deadline|date:'manager.time_stamp'}</em>
						{if isset($aProduct.description) && !empty($aProduct.description)}
							<em>- Mô tả: {$aProduct.description}</em>
						{/if}
					</p>

					<div class="button clearfix">
						<a href="javascript:void(0);" onclick="if (confirm('Bạn có chắc muốn xóa sản phẩm này không?')){l}$.ajaxCall('manager.order.removeProduct','product_id={$key}&user_id={$aUser.user_id}'); $Core.showLoadding();{r} return false;" title="Xóa sản phẩm"><i class="fa fa-times" aria-hidden="true"></i></a>
					</div>
				</li>
				{/foreach}
			</ul>
		{else}
			{no_item_message}
		{/if}
	</div>
	{/if}
</div>
</form>

{literal}
<script type="text/javascript">
	var timer = null;
    $Core.searchUserAddAdmin = function(ele, Type){
    	var sKeyword = $(ele).val();
    	var iCount = 0;
    	clearTimeout(timer);
    	timer = setTimeout(function(){
    		$.ajaxCall('user.searchUser', 'sKeyword='+ sKeyword+'&type=' + Type, 'GET');
	    }, 500);
    }
</script>
{/literal}