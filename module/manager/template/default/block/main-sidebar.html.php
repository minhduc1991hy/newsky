<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        {if isset($aMenus) && !empty($aMenus)}
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                {foreach from=$aMenus key=menuKey item=aMenu}
                    <li class="treeview {if isset($aMenu.active) && $aMenu.active}active{/if}">
                        <a href="{if !isset($aMenu.child) || empty($aMenu.child)}{url link=$aMenu.link}{else}javascript:void(0);{/if}">
                            {if isset($aMenu.icon) && !empty($aMenu.icon)}{$aMenu.icon}{/if}
                            <span>{$aMenu.name}</span>
                            {if isset($aMenu.child) && !empty($aMenu.child)}
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            {/if}
                        </a>
                        
                        {if isset($aMenu.child) && !empty($aMenu.child)}
                        <ul class="treeview-menu">
                            {foreach from=$aMenu.child key=menuChildKey item=aMenuChild}
                                <li class="{if isset($aMenuChild.active) && $aMenuChild.active}active{/if}"><a href="{url link=$aMenuChild.link}">
                                    {if isset($aMenuChild.icon) && !empty($aMenuChild.icon)}
                                        {$aMenuChild.icon}
                                    {else}
                                        <i class="fa fa-circle-o"></i>
                                    {/if}
                                    {$aMenuChild.name}
                                </a></li>
                            {/foreach}
                        </ul>
                        {/if}
                    </li>
                {/foreach}
            </ul>
        {/if}
    </section>
</aside>