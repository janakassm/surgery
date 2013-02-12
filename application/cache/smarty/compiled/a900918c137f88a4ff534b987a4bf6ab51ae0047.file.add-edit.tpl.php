<?php /* Smarty version Smarty-3.1.7, created on 
         compiled from "application\views\admin\categories\add-edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24360511a0a1b057f69-36110217%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a900918c137f88a4ff534b987a4bf6ab51ae0047' => 
    array (
      0 => 'application\\views\\admin\\categories\\add-edit.tpl',
      1 => 1360665757,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24360511a0a1b057f69-36110217',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_511a0a1b21cb9',
  'variables' => 
  array (
    'headder' => 0,
    'base_url' => 0,
    'category' => 0,
    'msg' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_511a0a1b21cb9')) {function content_511a0a1b21cb9($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['headder']->value;?>


<script type="text/javascript">
var base_url = "<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
";
var get_url ="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
xcalls/get/"; 
var selected_pid = "<?php echo $_smarty_tpl->tpl_vars['category']->value->category_parent_id;?>
";
var selected_level = "<?php echo $_smarty_tpl->tpl_vars['category']->value->category_level;?>
";
//
$(document).ready(function(e) {
   
   $("input[name='category_level']").change(function(e) {  
   		var level = $("input[name='category_level']:checked").val();
		GetCategories(level);
	});
	
	if(selected_level=="" || selected_level== 0)
		$("#category-level-0").trigger('change');
	else
		$("#category-level-"+selected_level).trigger('click');
	
	
});

function GetCategories(level)
{
	$.post(
		get_url+'getCategoriesAsOptions',
		{'level':level,'selected_id':selected_pid},
		function(respond)
		{
			if(respond.success)
			{
				var optionList = '<option value="0">No parent</option>'+respond.html;
				
				$("#parent-category").html(optionList);
			}
		},
		'json'
	);
}



//
</script>

<style>
optgroup{
	margin-top:5px;
	margin-bottom:2px;	
}
optgroup option{
	padding-left:10px;
}

</style>

	<div>
    	<?php echo $_smarty_tpl->tpl_vars['msg']->value;?>

    </div>
    <div class="clear20"></div>
    <div>
    
        <form method="post">
            <input id="category-level-0" type="radio" name="category_level"  value="0" checked />Main Menu
            <div class="clear2"></div>
            <input id="category-level-1" type="radio" name="category_level"  value="1" />Side Menu
            <div class="clear2"></div>
            <input id="category-level-2" type="radio" name="category_level"  value="2" />Bottom menu
            <div class="clear10"></div>
        
           
            <label style="width:200px">Parent Category</label>
           	<select id="parent-category" name="category_parent_id" style="width:400px;" class="inputText">
            	
            	
            </select>
            <div class="clear10"></div>
            
            <label style="width:200px">Category title in සිංහල </label><input type="text" name="category_title_sin"  id="category_title_sin" class="inputText" style="width:400px;" value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_sin;?>
"/>
            <div class="clear5"></div>
            <label style="width:200px">Category title in english </label><input type="text" name="category_title_eng" id="category_title_eng" class="inputText" style="width:400px;" value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_eng;?>
"/>
            <div class="clear5"></div>
            <a class="grey-btn btn" href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
admin/categories">Back</a>
            <button type="submit" name="save" value="1" class="green-btn" style="float:right">Save Category</button>
            <button type="button" id="mainMenuEdit" class="red-btn" style="float:right">Delete</button>
            <div class="clear10"></div>
            
        </form>
        
        
        <div>
        	<ul></ul>
        </div>
    </div>
    
    
<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php }} ?>