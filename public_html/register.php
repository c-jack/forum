<?php
require( "header.php" );
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 30/12/2018
 * Time: 18:50
 */
if (isset($_POST['username'],$_POST['firstName'],$_POST['lastName'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $first_name = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);

    $values = array( "username"=>$username,
                     "first_name"=>$first_name,
                     "last_name"=>$last_name,
                     "email"=>$email,
                     "password"=>$password );
    $register = new \user\Register( $values );
    echo "test";
}

?>
<h1>Register with us</h1>
<?php
if (!empty($error_msg)) {
    echo $error_msg;
}
?>
<ul>
    <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
    <li>Emails must have a valid email format</li>
    <li>Passwords must be at least 6 characters long</li>
    <li>Passwords must contain
        <ul>
            <li>At least one upper case letter (A..Z)</li>
            <li>At least one lower case letter (a..z)</li>
            <li>At least one number (0..9)</li>
        </ul>
    </li>
    <li>Your password and confirmation must match exactly</li>
</ul>
<form method="post" name="registration_form" action="<?php echo utils::clean($_SERVER['PHP_SELF'],'url'); ?>">
    Username: <input type='text' name='username' id='username' /><br>
    First name: <input type='text' name='firstName' id='firstName' /><br>
    Last name: <input type='text' name='lastName' id='lastName' /><br>
    Email: <input type="text" name="email" id="email" /><br>
    Password: <input type="password"
                     name="password"
                     id="password"/><br>
    Confirm password: <input type="password"
                             name="confirmpwd"
                             id="confirmpwd" /><br>
    <input type="button"
           value="Register"
           onclick="return registerFormHash(this.form,
                                   this.form.username,
								   this.form.firstName,
								   this.form.lastName,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" />
</form>
<p>Return to the <a href="index.php">login page</a>.</p></form>

</body>
</html>