<?php /* Smarty version Smarty-3.1.7, created on 
         compiled from "application\views\admin\categories\add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2681551160e1a03b411-78311557%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf45044b42d0f1fe46dec070c538c191e399b308' => 
    array (
      0 => 'application\\views\\admin\\categories\\add.tpl',
      1 => 1360652147,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2681551160e1a03b411-78311557',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_51160e1a3b57b',
  'variables' => 
  array (
    'headder' => 0,
    'base_url' => 0,
    'categoryList' => 0,
    'prvId' => 0,
    'category' => 0,
    'parentCategory' => 0,
    'opened' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51160e1a3b57b')) {function content_51160e1a3b57b($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['headder']->value;?>


<script type="text/javascript">
var base_url = "<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
";
var get_url ="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
xcalls/get/"; 
//
$(document).ready(function(e) {
   
   $("input[name='category_level']").change(function(e) {  
   		var level = $("input[name='category_level']:checked").val();
		GetCategories(level);
	});
	
	$("#init-category-level").trigger('change');
	
});

function GetCategories(level)
{
	$.post(
		get_url+'getCategoriesAsOptions',
		{'level':level},
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

function SetupCategoryDropDown()
{
	
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
    
        <form method="post">
            <input id="init-category-level" type="radio" name="category_level"  value="0" checked />Main Menu
            <div class="clear2"></div>
            <input type="radio" name="category_level"  value="1" />Side Menu
            <div class="clear2"></div>
            <input type="radio" name="category_level"  value="2" />Bottom menu
            <div class="clear10"></div>
        
            <!--<select id="parent-category" name="category_parent_id" >
            	<option value="0">No parent</option>
                <?php $_smarty_tpl->tpl_vars['prvId'] = new Smarty_variable(0, null, 0);?>
                <?php $_smarty_tpl->tpl_vars['opened'] = new Smarty_variable(false, null, 0);?>
            	<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categoryList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                	<?php if ($_smarty_tpl->tpl_vars['prvId']->value!=$_smarty_tpl->tpl_vars['category']->value->category_parent_id){?>
                    	<?php $_smarty_tpl->tpl_vars['prvId'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value->category_parent_id, null, 0);?>
                    	<?php $_smarty_tpl->tpl_vars['parentCategory'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value->GetPatrentDetails(), null, 0);?>
                        <?php $_smarty_tpl->tpl_vars['opened'] = new Smarty_variable(true, null, 0);?>
                    <optgroup label="<?php echo $_smarty_tpl->tpl_vars['parentCategory']->value->category_title_sin;?>
">
                    <?php }?>
                		<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_id;?>
"><span  class="sinhala" ><?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_sin;?>
</span></option>
                    <?php if ($_smarty_tpl->tpl_vars['prvId']->value!=$_smarty_tpl->tpl_vars['category']->value->category_parent_id&&$_smarty_tpl->tpl_vars['opened']->value){?>
                    	<?php $_smarty_tpl->tpl_vars['opened'] = new Smarty_variable(false, null, 0);?>
                    </optgroup>	
                    <?php }?>
                <?php } ?>
            </select><br />-->
            <label style="width:200px">Parent Category</label>
           	<select id="parent-category" name="category_parent_id" style="width:400px;" class="inputText">
            	
            	
            </select>
            <div class="clear10"></div>
            
            <label style="width:200px">Category title in සිංහල </label><input type="text" name="category_title_sin"  id="category_title_sin" class="inputText" style="width:400px;"/>
            <div class="clear5"></div>
            <label style="width:200px">Category title in english </label><input type="text" name="category_title_eng" id="category_title_eng" class="inputText" style="width:400px;"/>
            <div class="clear5"></div>
            <button type="submit" name="add_new" value="1" class="green-btn btn">Save Category</button>
            <div class="clear10"></div>
            
        </form>
        
        
        <div>
        	<ul></ul>
        </div>
    </div>
    
    
<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php }} ?>