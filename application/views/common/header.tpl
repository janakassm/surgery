<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="{$base_url}css/style.css" rel="stylesheet" type="text/css" />
<link href="{$base_url}css/ui-lightness/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="{$base_url}images/favicon.jpg" />

<script src="{$base_url}js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="{$base_url}js/jquery-ui.min.js" type="text/javascript"></script>


<script src="{$base_url}js/tiny_mce/jquery.tinymce.js" type="text/javascript"></script>

<script src="{$base_url}js/cufon-yui.js" type="text/javascript" ></script>
<script src="{$base_url}js/unicode-convert.js" type="text/javascript" ></script>
<script src="{$base_url}js/jquery.selection.js" type="text/javascript" ></script>
<script type="text/javascript">

//{literal}
$(document).ready(function(e) {
    //Cufon.replace('ul,p,h1,h2,h3,h4',{autoDetect:true});
	//Cufon.now();
});

//{/literal}
</script>

<title>{$title}</title>

</head>
<body>
<div class="mainWrapper">	
	<div class="leftWrapper">
    	<div class="leftWrapperTop"></div>
        <div class="leftWrapperBottom">
        	<ul class="leftMainNav">
            	{foreach $categoryList as $category}
                	{$catIsActive = ''}
                	{if $activeLinks && is_array($activeLinks)}
                    	{foreach $activeLinks as $key => $activeId}
                        	{if $activeId ==  $category->category_id}
                            	{$catIsActive = 'active'}
                                {$activeLinks[$key]|smartyUnset}
                            {/if}
                        {/foreach}
                    {/if}
                    
                	<li class="{$catIsActive} "><a>{$category->category_title_sin}</a></li>
                {/foreach}
            	
                
            </ul>
        </div>
	</div>
    <div class="centerWrapper">
    	<div class="banner">
    		<div class="logo"><img src="{$base_url}images/common/logo.png" width="282" height="90" /></div>
            <div class="searchBar"><input class="inputText searchBox" type="text" /><input class="searchButton inputButton" type="button" /></div>
        </div>
        <div class="clear10"></div>
    	<div class="mainContent">