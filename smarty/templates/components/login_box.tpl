{if !$loggedIn }
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
{/if}