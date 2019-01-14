<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title></title>
    <link rel="stylesheet" href="resources/css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
    <script type="text/JavaScript" src="resources/js/sha.js"></script>
    <script>
        const baseAddr="index.php?p=forums";
        $(function () {
            $('div.forum_topic_row').on('click', function() {
                const fid = $(this).attr('fid');
                goToPage(baseAddr + '&t=' + fid);
            });
        });

        function goToPage(location){
            window.location=location;
        }
    </script>
</head>
<body>