<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
</head>
<body>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/header.html"); ?>    

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/home.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/about.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/contact.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/signup.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/login.html"); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/manageAccount.html"); ?>

    <?php include($_SERVER['DOCUMENT_ROOT'] . "/appShell/footer.html"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/appShell.js"></script>
    
    <script>
		$(document).ready(function() {
		    $('section').eq(0).show(); 
		    $('.navbar-nav').on('click', 'a', function() {
		        $($(this).attr('href')).show().siblings('section:visible').hide();
		    });
		});
    </script>

</body>
</html> 