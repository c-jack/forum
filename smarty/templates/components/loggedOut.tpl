{if !$loggedIn }
    <span>Logged out - redirecting</span>
    <script>setTimeout(function () {
            window.location.href = "index.php";
        }, 2000); 
    </script>
{/if}