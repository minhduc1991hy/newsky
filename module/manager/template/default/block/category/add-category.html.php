{if $bEdit}
	<span class="label label-danger">
		<a href="javascript:void(0);" onclick="$.ajaxCall('manager.category.getFormAddCategory', 'sTypeId={$sTypeId}'); $Core.showLoadding(); return false;" style="color: #fff; display: inline-block;">Thêm mới</a>
	</span>
{/if}
<form action="javascript:void(0);" method="POST" id="js_add_category_product" onsubmit="$Core.submitAddCategory(this);">
	<input type="hidden" name="val[type_id]" value="{$sTypeId}">
	{if $bEdit}
		<input type="hidden" name="val[product_id]" value="{$aForms.product_id}">
	{/if}
	<div class="row">
		<div class="col-sm-6">
			<div class="table">
				<div class="table_left">
					<label>Tên danh mục{required}</label>
				</div>
				<div class="table_right">
					<input class="form-control" type="text" name="val[title]" value="{value type='input' id='title'}" placeholder="Nhập tên danh mục" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="table">
				<div class="table_left">
					<label>Mô tả</label>
				</div>
				<div class="table_right">
					<input class="form-control" type="text" name="val[description]" value="{value type='input' id='description'}" placeholder="Mô tả" />
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="table_clear text-center">
				<input type="submit" value="{if $bEdit}Cập nhật{else}Thêm mới{/if}" class="button btn btn-success"/>
			</div>
		</div>
	</div>
</form>

{literal}
<script type="text/javascript">
	$Core.hideLoadding();
    $Core.submitAddCategory = function(ele){
    	var aFormDatas = $(ele).serialize();
    	$.ajaxCall('manager.category.submitAddCategory', aFormDatas);
    	$Core.showLoadding();
    }
</script>
{/literal}