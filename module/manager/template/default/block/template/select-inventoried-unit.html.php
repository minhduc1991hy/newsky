<div class="table">
	<div class="table_left">
		<label>{if isset($sTitle) && !empty($sTitle)}{$sTitle}{else}Đơn vị kiểm kê{/if}{if $bRequired}{required}{/if}</label>
	</div>
	<div class="table_right">
		<select name="val[inventoried_unit]" id="inventoried_unit" class="form-control">
			<option value="">Chọn:</option>
			{if isset($aDatas) && !empty($aDatas)}
				{foreach from=$aDatas key=iKey item=sData}
					<option value="{$iKey}" {value type='select' id='inventoried_unit' default=''.$iKey.''}>{$sData}</option>
				{/foreach}
			{/if}
		</select>
	</div>
	<div class="clear"></div>
</div>