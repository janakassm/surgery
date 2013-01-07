<?php /* Smarty version Smarty-3.1.7, created on 
         compiled from "application\views\common\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:97477a606b7e7113-21366400%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d1c48519ed5065bf6e5ce2fc4cf598deec909a2' => 
    array (
      0 => 'application\\views\\common\\header.tpl',
      1 => 1356855627,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '97477a606b7e7113-21366400',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_477a606b8525c',
  'variables' => 
  array (
    'base_url' => 0,
    'title' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_477a606b8525c')) {function content_477a606b8525c($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
css/ui-lightness/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
images/favicon.jpg" />

<script src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
js/jquery-ui.min.js" type="text/javascript"></script>


<script src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
js/tiny_mce/jquery.tinymce.js" type="text/javascript"></script>

<script src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
js/cufon-yui.js" type="text/javascript" ></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
js/fm-abhaya.js" type="text/javascript" ></script>


<script type="text/javascript">

//
$(document).ready(function(e) {
    Cufon.replace('ul,p,h1,h2,h3,h4',{autoDetect:true});
	Cufon.now();
});

//
</script>

<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>

</head>
<body>
<div class="main-wrapper"><?php }} ?>