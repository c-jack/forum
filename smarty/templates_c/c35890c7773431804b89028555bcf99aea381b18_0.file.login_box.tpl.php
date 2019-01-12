<?php
/* Smarty version 3.1.33, created on 2019-01-12 18:16:55
  from 'C:\Users\chris\PhpstormProjects\forum\smarty\templates\components\login_box.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c3a2107cbd471_90346505',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c35890c7773431804b89028555bcf99aea381b18' => 
    array (
      0 => 'C:\\Users\\chris\\PhpstormProjects\\forum\\smarty\\templates\\components\\login_box.tpl',
      1 => 1547313412,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c3a2107cbd471_90346505 (Smarty_Internal_Template $_smarty_tpl) {
if (!$_smarty_tpl->tpl_vars['loggedIn']->value) {?>
<div class="loginContainer">
    <div class="loginBox">
        <form action="?p=login" method="post" name="login_form">
            <span class="title">Login</span>
            <div class="floating-label">
                <input placeholder="Email" type="email" name="email" id="email" autocomplete="off">
                <label for="email">Email:</label>
            </div>
            <div class="floating-label">
                <input placeholder="Password" type="password" name="password" id="password" autocomplete="off" onkeydown = "if (event.keyCode === 13) document.getElementById('submitLogin').click()">
                <label for="password">Password:</label>

            </div>
            <input type="button" id="submitLogin" value="Login" onclick="formhash(this.form, this.form.password);" />
        </form>
    </div>
</div>
<?php }
}
}
