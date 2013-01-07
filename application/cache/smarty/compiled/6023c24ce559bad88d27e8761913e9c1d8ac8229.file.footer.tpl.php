<?php /* Smarty version Smarty-3.1.7, created on 
         compiled from "application\views\common\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26502477a606b85d832-73778338%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6023c24ce559bad88d27e8761913e9c1d8ac8229' => 
    array (
      0 => 'application\\views\\common\\footer.tpl',
      1 => 1350307248,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26502477a606b85d832-73778338',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'csslinks' => 0,
    'base_url' => 0,
    'csslink' => 0,
    'jslinks' => 0,
    'jslink' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_477a606b88783',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_477a606b88783')) {function content_477a606b88783($_smarty_tpl) {?></div>
</body>

<!--load custom css links -->
<?php  $_smarty_tpl->tpl_vars['csslink'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['csslink']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['csslinks']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['csslink']->key => $_smarty_tpl->tpl_vars['csslink']->value){
$_smarty_tpl->tpl_vars['csslink']->_loop = true;
?>
<link href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
css/<?php echo $_smarty_tpl->tpl_vars['csslink']->value;?>
" rel="stylesheet" type="text/css" />
<?php } ?>
<!--end of loading custom css links -->

<!--load custom js links -->
<?php  $_smarty_tpl->tpl_vars['jslink'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['jslink']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['jslinks']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['jslink']->key => $_smarty_tpl->tpl_vars['jslink']->value){
$_smarty_tpl->tpl_vars['jslink']->_loop = true;
?>
<script src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
js/<?php echo $_smarty_tpl->tpl_vars['jslink']->value;?>
" type="text/javascript"></script>
<?php } ?>
<!--end of loading custom js links -->

</html>
<?php }} ?>