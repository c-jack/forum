<?php
/* Smarty version 3.1.33, created on 2019-01-12 18:10:56
  from 'C:\Users\chris\PhpstormProjects\forum\smarty\templates\header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c3a1fa0577fe0_80058431',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '473f0581b4e817c7e8926b513213a9d2759a3ea9' => 
    array (
      0 => 'C:\\Users\\chris\\PhpstormProjects\\forum\\smarty\\templates\\header.tpl',
      1 => 1547312904,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c3a1fa0577fe0_80058431 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="top" class="nav">

    <span id="userBlock">
        <?php if ($_smarty_tpl->tpl_vars['loggedIn']->value) {?>

            Logged in as <?php echo $_smarty_tpl->tpl_vars['username']->value;?>


            <span class="logOut"><a href="index.php?p=logout">Log out</a></span>
        <?php } else { ?>

            Not logged in

        <?php }?>


    </span>


</div>

<?php }
}
