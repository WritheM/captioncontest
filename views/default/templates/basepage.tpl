<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="keywords" content="{$page->meta_keywords}{if $page->meta_keywords != "" && $site->metakeywords != ""},{/if}{$site->metakeywords}" />
	<meta name="description" content="{$page->meta_description}{if $page->meta_description != "" && $site->metadescription != ""} - {/if}{$site->metadescription}" />	
	<meta name="application-name" content="{$site->code}-{$site->version}" />
	<title>{$page->meta_title}{if $page->meta_title != "" && $site->metatitle != ""} - {/if}{$site->metatitle}</title>

	<link href="{$smarty.const.WWW_TOP}/views/{$site->style}/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen" />
{if $site->style != "" && $site->style != "/"}	<link href="{$smarty.const.WWW_TOP}/views/{$site->style}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
{/if}
	<link rel="shortcut icon" type="image/ico" href="{$smarty.const.WWW_TOP}/views/{$site->style}/img/favicon.ico"/>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="{$smarty.const.WWW_TOP}/views/{$site->style}/js/bootstrap.min.js"></script> 
    
	<script type="text/javascript">
	/* <![CDATA[ */	
		var SERVERROOT = "{$serverroot}";
		var UID = {if $loggedin==='true'}{$userdata.ID}{else}-1{/if};
	/* ]]> */		
	</script>
	{$page->head}
    

	{strip}
	<div id="statusbar">
		{if $loggedin=="true"}
			Welcome back <a href="{$smarty.const.WWW_TOP}/profile">{$userdata.username}</a>. <a href="{$smarty.const.WWW_TOP}/logout">Logout</a>
		{else}
			<a href="{$smarty.const.WWW_TOP}/login">Login</a> or <a href="{$smarty.const.WWW_TOP}/register">Register</a>
		{/if}
	</div>
	{/strip}

	<div id="logo">
		<a class="logolink" title="{$site->title} Logo" href="{$smarty.const.WWW_TOP}{$site->home_link}"><img class="logoimg" alt="{$site->title} Logo" src="{$smarty.const.WWW_TOP}/views/{$site->style}/img/logo.png" /></a>

		{if $site->menuposition==2}<ul>{$main_menu}</ul>{/if}

		<h1><a href="{$smarty.const.WWW_TOP}{$site->home_link}">{$site->title}</a></h1>
		<p><em>{$site->strapline}</em></p>
	</div>
  
	<hr />
	
	<div id="header">
		<div id="menu"> 

			{if $loggedin=="true"}
				{$header_menu}
			{/if}
						
		</div> 
	</div>
	
	<div id="page">
		
		<div id="content">
			{if $page->getSubDomain() == 'dev'}
				<div id="alert_beta" class="alert alert-note" >
				  <button type="button" class="close" onclick="jQuery('#alert_beta').hide(200);">&times;</button>
				  <strong>Note:</strong> You are on the beta server. Functionality and stability can not be gauranteed.
                </div>
			{/if}
			{$page->content}
		</div>

		{if $site->menuposition==1}
		<div id="sidebar">
			<ul>		
			
			{$main_menu}
			
			</ul>
		</div>
		{/if}
	
	</div>

	<div class="footer">
	<p>
        &copy;{$smarty.now|date_format:"%Y"} {$site->title}, All Rights Reserved. <br/>
		{$site->footer}
		<br />Powered by <a title="WritheM Caption Contest" href="https://github.com/WritheM/captioncontest">wmcc</a><br/>
	</p>
	</div>
	

{if $loggedin=="true"}
<input type="hidden" name="UID" value="{$userdata.ID}" />
<input type="hidden" name="RSSTOKEN" value="{$userdata.rsstoken}" />
{/if}
	
</body>
</html>
