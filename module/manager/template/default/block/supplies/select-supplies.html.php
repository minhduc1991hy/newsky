<div class="table">
	<div class="table_left">
		<label>Tên nhà cung cấp{if $bRequired}{required}{/if}</label>
		<span class="label label-danger">
			<a href="{url link='manager.supplies.index.add'}" target="_blank" style="color: #fff; display: inline-block;">Thêm mới</a>
		</span>
	</div>
	<div class="table_right">
		<select name="val[supplie_id]" id="supplie_id" class="form-control">
			<option value="">Chọn:</option>
			{if isset($aSupplies) && !empty($aSupplies)}
				{foreach from=$aSupplies key=iKey item=aSupplie}
					<option value="{$aSupplie.supplie_id}" {value type='select' id='supplie_id' default=''.$aSupplie.supplie_id.''}>
						{$aSupplie.code}
						<!-- {if isset($aSupplie.name) && !empty($aSupplie.name)}
							({$aSupplie.name})
						{/if} -->
					</option>
				{/foreach}
			{/if}
		</select>
	</div>
	<div class="clear"></div>
</div>