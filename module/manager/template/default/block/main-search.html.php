{if isset($aFilterSearchs) && !empty($aFilterSearchs)}
<aside class="main-sidebar-search {if !$bCloseFilterSearch}collapse in{/if}" id="collapseSearch">
	<h1 class="title-control text-success">LỌC/TÌM KIẾM</h1>
	<div id="search-control" class="{if !isset($sCloseOpenSearch) || $sCloseOpenSearch != 'open'} nd_none {/if}">
	    <div class="wrapper-search">
	        <form method="post" action="{url link='current'}" class="searcha">
	        	<div class="box-body">
		        	{if isset($sHtmlExtentSearHead) && !empty($sHtmlExtentSearHead)}{$sHtmlExtentSearHead}{/if}
	            	{foreach from=$aFilterSearchs key=sKeySearch item=aFilterSearch}
						<div class="form-group">
							{if isset($aFilterSearch.mxlabel)}<label>{$aFilterSearch.mxlabel}</label>{/if}
							{filter key=$sKeySearch}
						</div>
	            	{/foreach}
		            <div class="table_clear">
		                <input type="submit" value="Tìm kiếm" class="btn btn-success btn-block" name="search[submit]" />
		            </div>
		            {if isset($sHtmlExtentSearFooter) && !empty($sHtmlExtentSearFooter)}{$sHtmlExtentSearFooter}{/if}
	            </div>
	        </form>
	    </div>
	</div>
</aside>
{/if}