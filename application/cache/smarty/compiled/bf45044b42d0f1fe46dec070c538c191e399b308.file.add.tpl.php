<?php /* Smarty version Smarty-3.1.7, created on 
         compiled from "application\views\admin\categories\add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2681551160e1a03b411-78311557%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf45044b42d0f1fe46dec070c538c191e399b308' => 
    array (
      0 => 'application\\views\\admin\\categories\\add.tpl',
      1 => 1360399998,
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
    'lvl1childCategories' => 0,
    'lvl2childCategories' => 0,
    'lvl3childCategories' => 0,
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
		if( $("input[name='category_level']:checked").val() != 0)
		{
			$("#parent-category").removeAttr('disabled');
		}
		else
		{
			$("#parent-category").attr('disabled','disabled');
		}
	});
	
	$("input[name='category_level']").trigger('change');
	
	
});

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
            <input type="radio" name="category_level"  value="0" checked />Top Level<br />
            <input type="radio" name="category_level"  value="1" />Sub level 1<br />
            <input type="radio" name="category_level"  value="2" />Level 2<br />
            <input type="radio" name="category_level"  value="3" />Level 3<br />
            
            <input type="radio" name="category_level"  value="-1" />Bottom menu<br />
        
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
            
           	<select id="parent-category" name="category_parent_id" >
            	<option value="0">No parent</option>
            	<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categoryList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                	<?php $_smarty_tpl->tpl_vars['lvl1childCategories'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value->GetChildCategories(), null, 0);?>
                	<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_id;?>
" class="menu-level-1"><span  class="sinhala " ><?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_sin;?>
</span></option>
                    <?php if ($_smarty_tpl->tpl_vars['lvl1childCategories']->value){?>
                    	
                    	<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lvl1childCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                        	<?php $_smarty_tpl->tpl_vars['lvl2childCategories'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value->GetChildCategories(), null, 0);?>
                			<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_id;?>
" class="menu-level-2"><span  class="sinhala" ><?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_sin;?>
</span></option>
                            
                            <?php if ($_smarty_tpl->tpl_vars['lvl2childCategories']->value){?>
                                <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lvl2childCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                                	<?php $_smarty_tpl->tpl_vars['lvl3childCategories'] = new Smarty_variable($_smarty_tpl->tpl_vars['category']->value->GetChildCategories(), null, 0);?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_id;?>
" class="menu-level-3"><span  class="sinhala" ><?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_sin;?>
</span></option>
                                    
                                    <?php if ($_smarty_tpl->tpl_vars['lvl3childCategories']->value){?>
                                    	<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['lvl3childCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
?>
                                    		<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value->category_id;?>
" class="menu-level-4"><span  class="sinhala" ><?php echo $_smarty_tpl->tpl_vars['category']->value->category_title_sin;?>
</span></option>
                                        <?php } ?>
                                    <?php }?>
                                    
                            	<?php } ?>
                            <?php }?>
                            
                        <?php } ?>
                        
                    <?php }?>
                <?php } ?>
            </select><br />
            
            <label>Category title in (<span class="sinhala" >සිංහල</span>) </label><input type="text" name="category_title_sin"  id="category_title_sin"/>
            <label>Category title in english </label><input type="text" name="category_title_eng" id="category_title_eng"/><br>
            
            
            
            <button type="submit" name="add_new" value="1">Add category</button>
            
        </form>
        
        
        <div>
        	<ul></ul>
        </div>
    </div>
    
    
<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php }} ?>