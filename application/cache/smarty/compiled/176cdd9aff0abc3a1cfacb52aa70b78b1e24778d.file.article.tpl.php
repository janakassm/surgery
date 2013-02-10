<?php /* Smarty version Smarty-3.1.7, created on 
         compiled from "application\views\articles\article.tpl" */ ?>
<?php /*%%SmartyHeaderCode:191445113e4baed6f54-32958317%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '176cdd9aff0abc3a1cfacb52aa70b78b1e24778d' => 
    array (
      0 => 'application\\views\\articles\\article.tpl',
      1 => 1360258278,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '191445113e4baed6f54-32958317',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5113e4bb02b5e',
  'variables' => 
  array (
    'headder' => 0,
    'footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5113e4bb02b5e')) {function content_5113e4bb02b5e($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['headder']->value;?>

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