<?php 

  if (isset($_SESSION['logged_in']))
  {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $forename = $_SESSION['forename'];
    $surname  = $_SESSION['surname'];
    echo "Welcome back $forename.<br>
          Your full name is $forename $surname.<br>
          Your username is '$username'
          and your password is '$password'.";
}


if(isset($_SESSION['user_name'])){
    echo "Welcome '{$_SESSION['user_name']}'";
}

echo '
<meta charset="UTF-8">
<link rel="stylesheet" href="../assets/style.css"/>
</head>
<body>
<div class="admin-navigator">
	<img id="logo" src="../assets/images/logosq.png"/>
	<form id="search" method="get" action="http://www.google.com">
		        <input type="text" class="search_bar" maxlength="120" value="Search">
	</form>
	<div id="user">
		<a href="">Chuck Norrison</a><a href="logout.php">(logout)</a>
	</div>
	<ul id="menu">
		    <li><a href="/admin">Dashboard</a></li>
		    <li><a href="add_article.php">Add</a></li>    
			    	 <ul><a href="add_article.php">Add Post</a></ul>
			    	 <ul><a href="upload.php">Upload Files</a></ul>
			    	 <ul><a href="upload.php">Announcement</a></ul>
			    	 <ul><a href="upload.php">Countdown</a></ul>
		   	<li><a href="/">Manage</a></li>
			    	 <ul><a href="../add_article.php">Edit Posts</a></ul>
			    	 <ul><a href="../add_article.php">Edit Media</a></ul>
			    	 <ul><a href="../add_article.php">Edit Exam Papers</a></ul>

		    <li><a href="#">Settings</a></li>
	</ul>
</div>

<div class="admincontainer">
';
include_once('../functions/breadcrumbs.php');


?>