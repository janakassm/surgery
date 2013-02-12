{$headder}

<script type="text/javascript">
//{literal}
$(document).ready(function(e) {
	
});
//{/literal}
</script>
{literal}
<style>
label{
	width:100px;
}
select{
	min-width:300px;
}
</style>
{/literal}
<a href="{$base_url}admin/categories/add" class="white-btn btn" style="">Add Category</a>
<div class="clear20"></div>
<form method="post">
<label >Main menu</label>
{if $mainMenuHtml}
<select id="mainMenu" name="cat_id" class="inputTxt" >
	{$mainMenuHtml}
</select>
<button type="submit" name="edit" value="1" id="mainMenuEdit" class="green-btn">Edit</button>
{else}
<label class="info">No Items</label>
{/if}
</form>
<div class="clear20"></div>


<form method="post">
<label >Side menu</label>
{if $sideMenuHtml}
<select id="sideMenu" name="cat_id" class="inputTxt" >
	{$sideMenuHtml}
</select>
<button type="submit" name="edit" value="1" id="mainMenuEdit" class="green-btn">Edit</button>
{else}
<label class="info">No Items</label>
{/if}
</form>
<div class="clear20"></div>


<form method="post">
<label >Bottom menu</label>
{if $bottomMenuHtml}
<select id="bottomMenu" name="cat_id" class="inputTxt" >
	{$bottomMenuHtml}
</select>
<button type="submit" name="edit" value="1" id="mainMenuEdit" class="green-btn">Edit</button>
{else}
<label class="info">No Items</label>
{/if}
</form>
<div class="clear20"></div>

{$footer}