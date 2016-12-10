<div class="table">
	<div class="table_left">
		<label>{if isset($sTitle) && !empty($sTitle)}{$sTitle}{else}Kiểu rãnh{/if}{if $bRequired}{required}{/if}</label>
	</div>
	<div class="table_right">
		<select name="val[kieu_ranh]" id="kieu_ranh" class="form-control">
			<option value="">Chọn:</option>
			{if isset($aDatas) && !empty($aDatas)}
				{foreach from=$aDatas key=iKey item=sData}
					<option value="{$iKey}" {value type='select' id='kieu_ranh' default=''.$iKey.''}>{$sData}</option>
				{/foreach}
			{/if}
		</select>
	</div>
	<div class="clear"></div>
</div>