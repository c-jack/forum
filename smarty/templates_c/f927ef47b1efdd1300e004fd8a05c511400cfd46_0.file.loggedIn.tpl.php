<?php
/* Smarty version 3.1.33, created on 2019-01-12 21:35:02
  from 'C:\Users\chris\PhpstormProjects\forum\smarty\templates\components\loggedIn.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c3a4f76d2e6e3_50691337',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f927ef47b1efdd1300e004fd8a05c511400cfd46' => 
    array (
      0 => 'C:\\Users\\chris\\PhpstormProjects\\forum\\smarty\\templates\\components\\loggedIn.tpl',
      1 => 1547325224,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c3a4f76d2e6e3_50691337 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['loggedIn']->value) {?>
    <span>Logged in - redirecting</span>
    <?php echo '<script'; ?>
>setTimeout(function () {
            window.location.href = "index.php";
        }, 2000);
    <?php echo '</script'; ?>
>
<?php }
}
}
