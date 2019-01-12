<div id="top" class="nav">

    <span id="userBlock">
        {if $loggedIn }

            Logged in as {$username}

            <span class="logOut"><a href="index.php?p=logout">Log out</a></span>
        {else}

            Not logged in

        {/if}


    </span>


</div>

