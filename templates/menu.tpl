<div id="wrapper">
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<img class="navbar-brand"src="{$smarty.const.DOMAIN}/images/logos/{$smarty.session.cliente}{if isset($smarty.session.local)}.{$smarty.session.local}{/if}.png" />
		</div>

		<ul class="nav navbar-top-links navbar-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu dropdown-user">
					{*<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>*}
					{*</li>*}
					{*<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>*}
					{*</li>*}
					{*<li class="divider"></li>*}
					<li><a href="/salir"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
					</li>
				</ul>
				<!-- /.dropdown-user -->
			</li>
		</ul>
		<div class="navbar-default sidebar" role="navigation">
			<div class="sidebar-nav navbar-collapse">
				<ul class="nav" id="side-menu">
					<li>
						<a href="/inicio"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
					</li>
					{foreach item=item from=$smarty.session.menu key=key}
						<li>
							<a href="#">
								<i class="fa
								 {if $key == 'configuracion'}
									fa-gear
								{elseif $key == 'tickets'}
									fa-ticket
								{elseif $key == 'contabilidad'}
									fa-bar-chart-o
								{/if}
								 fa-fw"></i>
								{$key|capitalize}{if count($item) > 0}<span class="fa arrow"></span>{/if}</a>
							{if count($item) > 0}
							<ul class="nav nav-second-level">
							{/if}
							{foreach item=submenu from=$item}
								<li>
									<a href="/{$key}/{$submenu}">{$submenu|capitalize}</a>
								</li>
							{/foreach}
							{if count($item) > 0}
							</ul>
							{/if}
						</li>
					{/foreach}
				</ul>
			</div>
		</div>
	</nav>
	<div id="page-wrapper">





{*<div class="container align_center">*}
	{*<img src="{$smarty.const.DOMAIN}/images/logos/{$smarty.session.cliente}{if isset($smarty.session.local)}.{$smarty.session.local}{/if}.png" {if ($smarty.const.TEMPLATE_NAME != 'login') && ($smarty.const.TEMPLATE_NAME != 'contrasena')} width="150px"{/if}>*}
{*</div>*}
{*<br>*}
{*<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>*}
{*<script>$(document).ready(function(){*}
    {*$(".menu  .m1 span:not('.noop')").on("click", function() {literal}{window.location='{/literal}{$smarty.const.DOMAIN}{literal}/' +this.textContent.toLocaleLowerCase().trim();});{/literal}*}
    {*$(".menu  .m2 span").on("click", function() {literal}{window.location='{/literal}{$smarty.const.DOMAIN}{literal}/'+$(this).parent().parent().prev().text().toLocaleLowerCase().trim()+'/' +this.textContent.toLocaleLowerCase().trim();});*}
    {*$(".menu .m1 span").hover(function() {$(this).next('li .m2').css('display', 'inline');});*}
    {*$('.menu').menu({position: {my:'center bottom', at:'center bottom'}});*}
{*}{/literal});</script>*}
{*<ul class="menu align_center">*}
    {*<li class="m1"><span>Inicio</span></li>*}
    {*{foreach item=item from=$smarty.session.menu key=key}*}
    {*<li class="m1"><span{if count($item) > 0} class="noop" onclick="$('.menu').menu('expand');"{/if}>{$key|capitalize}</span>*}
            {*{if count($item) > 0}*}
                {*<ul>*}
            {*{/if}*}
            {*{foreach item=submenu from=$item}*}
                {*<li class="m2"><span>{$submenu|capitalize}</span></li>*}
            {*{/foreach}*}
            {*{if count($item) > 0}*}
                {*</ul>*}
            {*{/if}*}
        {*</li>*}
    {*{/foreach}*}
    {*<li class="m1"><span>Salir</span></li>*}
{*</ul>*}