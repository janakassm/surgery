<?php /* Smarty version Smarty-3.1.7, created on 
         compiled from "application\views\admin\categories\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:29533511a0408078082-44229083%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f14060aa0cac70d8315d0f12aa8c81f4bde4e540' => 
    array (
      0 => 'application\\views\\admin\\categories\\index.tpl',
      1 => 1360665435,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29533511a0408078082-44229083',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_511a04081224d',
  'variables' => 
  array (
    'headder' => 0,
    'base_url' => 0,
    'mainMenuHtml' => 0,
    'sideMenuHtml' => 0,
    'bottomMenuHtml' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_511a04081224d')) {function content_511a04081224d($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['headder']->value;?>


<script type="text/javascript">
//
$(document).ready(function(e) {
	
});
//
</script>

<style>
label{
	width:100px;
}
select{
	min-width:300px;
}
</style>

<a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
admin/categories/add" class="white-btn btn" style="">Add Category</a>
<div class="clear20"></div>
<form method="post">
<label >Main menu</label>
<?php if ($_smarty_tpl->tpl_vars['mainMenuHtml']->value){?>
<select id="mainMenu" name="cat_id" class="inputTxt" >
	<?php echo $_smarty_tpl->tpl_vars['mainMenuHtml']->value;?>

</select>
<button type="submit" name="edit" value="1" id="mainMenuEdit" class="green-btn">Edit</button>
<button type="button" id="mainMenuEdit" class="red-btn">Delete</button>
<?php }else{ ?>
<label class="info">No Items</label>
<?php }?>
</form>
<div class="clear20"></div>


<form method="post">
<label >Side menu</label>
<?php if ($_smarty_tpl->tpl_vars['sideMenuHtml']->value){?>
<select id="sideMenu" name="cat_id" class="inputTxt" >
	<?php echo $_smarty_tpl->tpl_vars['sideMenuHtml']->value;?>

</select>
<button type="submit" name="edit" value="1" id="mainMenuEdit" class="green-btn">Edit</button>
<button type="button" id="mainMenuEdit" class="red-btn">Delete</button>
<?php }else{ ?>
<label class="info">No Items</label>
<?php }?>
</form>
<div class="clear20"></div>


<form method="post">
<label >Bottom menu</label>
<?php if ($_smarty_tpl->tpl_vars['bottomMenuHtml']->value){?>
<select id="bottomMenu" name="cat_id" class="inputTxt" >
	<?php echo $_smarty_tpl->tpl_vars['bottomMenuHtml']->value;?>

</select>
<button type="submit" name="edit" value="1" id="mainMenuEdit" class="green-btn">Edit</button>
<button type="button" id="mainMenuEdit" class="red-btn">Delete</button>
<?php }else{ ?>
<label class="info">No Items</label>
<?php }?>
</form>
<div class="clear20"></div>

<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>
<?php }} ?>