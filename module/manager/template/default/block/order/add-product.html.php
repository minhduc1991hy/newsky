{if !isset($aUser) || $aUser.user_group_id != GUEST_USER_ID}
	{no_item_message}
{else}
<form action="javascript:void(0);" onsubmit="$Core.addProductOrder(this);" method="POST">
	<input type="hidden" name="val[user_id]" value="{$aUser.user_id}">
	<div class="row">
		<div class="col-sm-6">
			{module name="manager.plan.select-vansan"}
		</div>
		<div class="col-sm-6">
			{module name="manager.plan.select-skirting"}
		</div>
		<div class="col-sm-6">
			<div class="table">
				<div class="table_left">
					<label>Số lượng{required}</label>
				</div>
				<div class="table_right">
					<input name="val[quantity]" value="{value type='input' id='quantity'}" type="number" class="form-control" placeholder="Nhập số lượng">
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="col-sm-6">
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
		</div>
		<div class="col-sm-12">
			<div class="table">
				<div class="table_left"><label for="">Mô tả</label></div>
				<div class="table_right">
					<textarea name="val[description]" style="resize: vertical;" cols="30" rows="3" class="form-control" placeholder="Nhập thông tin mô tả">{value type='textarea' id='description'}</textarea>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-sm-offset-3">
			<div class="table_clear">
				<input type="submit" value="THÊM SẢN PHẨM" class="button btn btn-success btn-block">
			</div>
		</div>
	</div>
</form>

{literal}
<script type="text/javascript">
    $Core.addProductOrder = function(ele){
    	var aFormDatas = $(ele).serialize();
		if (typeof(aFormDatas)) {
			$Core.showLoadding();
		    $.ajaxCall('manager.order.addProductOrder', aFormDatas);
		    return false;
		}
    }

    $('.datepicker').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true
	});
</script>
{/literal}
{/if}