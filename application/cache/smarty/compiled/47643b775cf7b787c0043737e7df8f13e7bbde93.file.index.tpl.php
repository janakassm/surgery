<?php /* Smarty version Smarty-3.1.7, created on 
         compiled from "application/views/admin/articles/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:63438700150ebc25ec79fb6-60336383%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '47643b775cf7b787c0043737e7df8f13e7bbde93' => 
    array (
      0 => 'application/views/admin/articles/index.tpl',
      1 => 1357631693,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63438700150ebc25ec79fb6-60336383',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_50ebc25ecc622',
  'variables' => 
  array (
    'headder' => 0,
    'base_url' => 0,
    'articleList' => 0,
    'article' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50ebc25ecc622')) {function content_50ebc25ecc622($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['headder']->value;?>


<script type="text/javascript">
//
$(document).ready(function(e) {
	
});
//
</script>

<a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
admin/articles/add">Add Article</a>
<div class="clear"></div>
<?php  $_smarty_tpl->tpl_vars['article'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['article']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['articleList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['article']->key => $_smarty_tpl->tpl_vars['article']->value){
$_smarty_tpl->tpl_vars['article']->_loop = true;
?>
<div>
	<span><?php echo $_smarty_tpl->tpl_vars['article']->value->article_title;?>
</span>-<span><?php echo $_smarty_tpl->tpl_vars['article']->value->GetArticleCategoryTitle();?>
</span>
	<div class="buttonSection">
		<a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
admin/articles/edit?id=<?php echo $_smarty_tpl->tpl_vars['article']->value->article_id;?>
">Edit</a>
		<a href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
admin/articles/delete?id=<?php echo $_smarty_tpl->tpl_vars['article']->value->article_id;?>
">Delete</a>
	</div>
</div>
<div class="clear"></div>
<?php } ?>

<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>
<?php }} ?>