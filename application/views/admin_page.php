<html>
<head>
<title>Admin Page</title>

</head>
<body>
<div id="profile">
<?php
echo "Hello <b id='welcome'><i>" . $user_name . "</i> !</b>";
echo "Welcome to Admin Page";
echo "Your User id is " . $user_id;
echo "Your Password is " . $user_pw;
?>
<b id="logout"><a href="logout">Logout</a></b>
</div>
</body>
</html>