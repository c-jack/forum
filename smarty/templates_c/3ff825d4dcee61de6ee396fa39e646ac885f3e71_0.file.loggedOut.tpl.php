<?php
/* Smarty version 3.1.33, created on 2019-01-12 21:34:48
  from 'C:\Users\chris\PhpstormProjects\forum\smarty\templates\components\loggedOut.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c3a4f68ad7c21_98108467',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3ff825d4dcee61de6ee396fa39e646ac885f3e71' => 
    array (
      0 => 'C:\\Users\\chris\\PhpstormProjects\\forum\\smarty\\templates\\components\\loggedOut.tpl',
      1 => 1547325233,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c3a4f68ad7c21_98108467 (Smarty_Internal_Template $_smarty_tpl) {
if (!$_smarty_tpl->tpl_vars['loggedIn']->value) {?>
    <span>Logged out - redirecting</span>
    <?php echo '<script'; ?>
>setTimeout(function () {
            window.location.href = "index.php";
        }, 2000); 
    <?php echo '</script'; ?>
>
<?php }
}
}
