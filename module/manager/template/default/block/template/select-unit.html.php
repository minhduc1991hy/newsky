<div class="table">
	<div class="table_left">
		<label>{if isset($sTitle) && !empty($sTitle)}{$sTitle}{else}Đơn vị tính{/if}{if $bRequired}{required}{/if}</label>
	</div>
	<div class="table_right">
		<select name="val[unit]" id="unit" class="form-control">
			<option value="">Chọn:</option>
			{if isset($aDatas) && !empty($aDatas)}
				{foreach from=$aDatas key=iKey item=sData}
					<option value="{$iKey}" {value type='select' id='unit' default=''.$iKey.''}>{$sData}</option>
				{/foreach}
			{/if}
		</select>
	</div>
	<div class="clear"></div>
</div>