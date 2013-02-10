<?php /* Smarty version Smarty-3.1.7, created on 
         compiled from "application\views\guest\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:533150de8f0d8b4095-03132040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0843f50b08d02ec58c0bc4b25e5142732a1e53b8' => 
    array (
      0 => 'application\\views\\guest\\index.tpl',
      1 => 1360399671,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '533150de8f0d8b4095-03132040',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_50de8f0d99fe4',
  'variables' => 
  array (
    'headder' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50de8f0d99fe4')) {function content_50de8f0d99fe4($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['headder']->value;?>


<script type="text/javascript">
//
$(document).ready(function(e) {
	$(".accordion").accordion({
		heightStyle: "content"	
	});
});
//
</script>

<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>
<?php }} ?>