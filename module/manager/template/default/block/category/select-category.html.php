{if isset($sTypeId)}
<div class="table">
	<div class="table_left">
		<label>{if isset($sTitle) && !empty($sTitle)}{$sTitle}{else}Class giá HT{/if}{if $bRequired}{required}{/if}</label>
		<span class="label label-danger">
			<a href="javascript:void(0);" onclick="tb_show('Danh sách {if isset($sTitle) && !empty($sTitle)}{$sTitle}{else}danh mục{/if}', $.ajaxBox('manager.category.listCategory', 'sTypeId={$sTypeId}&height=250&width=600')); $Core.showLoadding(); return false;" style="color: #fff; display: inline-block;">Thêm mới</a>
		</span>
	</div>
	<div class="table_right">
		<select name="val[product_id]" id="product_id" class="form-control">
			<option value="">Chọn:</option>
			{if isset($aCategories) && !empty($aCategories)}
				{foreach from=$aCategories key=iKey item=aCategory}
					<option value="{$aCategory.product_id}" {value type='select' id='product_id' default=''.$aCategory.product_id.''}>
						{$aCategory.title}
						{if isset($aCategory.description) && !empty($aCategory.description)}
							({$aCategory.description})
						{/if}
					</option>
				{/foreach}
			{/if}
		</select>
	</div>
	<div class="clear"></div>
</div>
{/if}