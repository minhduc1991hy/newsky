{error}
<form action="javascript:void(0);" onsubmit="$Core.addProductOrder(this);" method="POST">
<div class="row">
	<div class="col-sm-3">
		<h4>THÔNG TIN KHÁCH HÀNG</h4>
		<div class="table">
			<div class="table_left"><label for="">Tìm khách hàng</label></div>
			<div class="table_right">
				<input type="text" onkeyup="$Core.searchUserAddAdmin(this);" name="val[input_search]" id="input_search" value="{value type='input' id='input_search'}" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
				<p><em>Nhập từ khóa tìm kiếm khách hàng, tên khách hàng, Id khách hàng, Số điện thoại, Email</em></p>
			</div>
		</div>
		<ul class="clearfix template-list-user"></ul>
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
		
	</div>
	
	<div class="col-sm-3">
		<h4>THÊM SẢN PHẨM</h4>
		
		

		<div class="table">
			<div class="table_left">
				<label>Số lượng{required}</label>
			</div>
			<div class="table_right">
				<input name="val[quantity]" value="{value type='input' id='quantity'}" type="number" class="form-control" placeholder="Nhập số lượng">
			</div>
			<div class="clear"></div>
		</div>

		<div class="table">
			<div class="table_left">
				<label>Ngày giao hàng{required}</label>
			</div>
			<div class="table_right">
				<div class="input-group date">
					<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</div>
					<input name="val[deadline]" value="{value type='input' id='deadline'}" type="text" class="datepicker form-control pull-right">
				</div>
			</div>
			<div class="clear"></div>
		</div>

		<div class="table">
			<div class="table_left"><label for="">Mô tả</label></div>
			<div class="table_right">
				<textarea name="val[description]" style="resize: vertical;" cols="30" rows="3" class="form-control" placeholder="Nhập thông tin mô tả">{value type='textarea' id='description'}</textarea>
			</div>
		</div>

		<div class="table_clear">
			<input type="submit" value="THÊM SẢN PHẨM" class="button btn btn-success btn-block">
		</div>
	</div>

	<div class="col-sm-6">
		<h4>SẢN PHẨM</h4>
		<ul class="clearfix template-list-product">
			<li class="item">
				<h4>K305.T9.V6.2C78.R2</h4>
				<p><em>Số lượng: 2500 - Ngày giao: 21/12/2016</em></p>
				<p><em>Mô tả: Đây là thông tin mô tả</em></p>
				<div class="button clearfix">
					<a href="javascript:void(0);" title="Xóa sản phẩm"><i class="fa fa-times" aria-hidden="true"></i></a>
				</div>
			</li>
			<li class="item">
				<h4>K305.T9.V6.2C78.R2</h4>
				<p><em>Số lượng: 2500 - Ngày giao: 21/12/2016</em></p>
				<div class="button clearfix">
					<a href="javascript:void(0);" title="Xóa sản phẩm"><i class="fa fa-times" aria-hidden="true"></i></a>
				</div>
			</li>
			<li class="item">
				<h4>K305.T9.V6.2C78.R2</h4>
				<p><em>Số lượng: 2500 - Ngày giao: 21/12/2016</em></p>
				<div class="button clearfix">
					<a href="javascript:void(0);" title="Xóa sản phẩm"><i class="fa fa-times" aria-hidden="true"></i></a>
				</div>
			</li>
		</ul>
	</div>
</div>
</form>

{literal}
<script type="text/javascript">
	var timer = null;
    $Core.searchUserAddAdmin = function(ele){
    	var sKeyword = $(ele).val();
    	var iCount = 0;
    	clearTimeout(timer);
    	timer = setTimeout(function(){
    		$.ajaxCall('user.searchUser', 'sKeyword='+ sKeyword, 'GET');
	    }, 500);
    }


    $Core.addProductOrder = function(ele){
    	var aFormDatas = $(ele).serialize();
		if (typeof(aFormDatas)) {
		    $.ajaxCall('manager.order.addProductOrder', aFormDatas);
		    return false;
		}
    }
</script>
{/literal}