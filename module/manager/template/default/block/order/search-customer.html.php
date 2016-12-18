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
		<input type="text" onkeyup="$Core.searchUserAddAdmin(this, {if $sTypeId == 'edit_customer'}'edit_customer'{else}'order'{/if});" name="val[input_search]" id="input_search" value="{value type='input' id='input_search'}" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
		<p><em>Nhập từ khóa tìm kiếm khách hàng, tên khách hàng, Id khách hàng, Số điện thoại, Email</em></p>
	</div>
</div>
<ul class="clearfix template-list-user"></ul>

<script type="text/javascript">
{literal}
	var timer = null;
    $Core.searchUserAddAdmin = function(ele, Type){
    	var sKeyword = $(ele).val();
    	var iCount = 0;
    	clearTimeout(timer);
    	timer = setTimeout(function(){
    		$.ajaxCall('user.searchUser', 'sKeyword='+ sKeyword+'&type=' + Type, 'GET');
	    }, 500);
    }
{/literal}
{if $sTypeId == 'edit_customer'}
{literal}
$Core.updateCustomerOrder = function(iUserId){
	var OrderId = {/literal}'{$sItemId}'{literal};
	$.ajaxCall('manager.order.updateCustomerOrder', 'OrderId='+ OrderId+'&iUserId=' + iUserId, 'GET');
}
{/literal}
{/if}
</script>
