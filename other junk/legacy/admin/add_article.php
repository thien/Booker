<?php 

session_start();

include_once('../includes/connection.php');

if (isset($_SESSION['logged_in'])) {
	if (isset($_POST['title'], $_POST['content'])) {
		$title = $_POST['title'];
		$tags = $_POST['tags'];
		$content = nl2br($_POST['content']);
	
		if (empty($title) or empty($content)) {
			$error = 'All fields are required!';
		}	else {
		$query = $pdo->prepare('INSERT INTO articles (article_title, article_tags, article_content, article_timestamp) VALUES (?, ?, ?, ?)');
		$query->bindValue(1, $title);
		$query->bindValue(2, $tags);
		$query->bindValue(3, $content);
		$query->bindValue(4, time());
		$query->execute();
		header('Location: index.php');
		}
	}

	?>

<html>
	<head>
		<title>
		Maths Homepage - Woodhouse College
		</title>
	<?php include 'header.php';?>
<p><?= breadcrumbs(' / ') ?></p>
	<div class="admincontainer">
		<div id="heading">Add Article</div>
		<?php if (isset($error)) { ?>
			<small style="color:#aa0000;"><?php echo $error; ?></small>
			<br><br>
		<?php }?>
		<form action="add.php" method="post" autocomplete="off">
			<input type="text" name="title" placeholder="Title" />
			<input type="text" name="tags" placeholder="Tags" />
			<br><br>
			<textarea rows="15" cols="50" placeholder="Content" name="content"></textarea><br><br>
			<input type="submit" value="Add Article"/>
		</form>
		
	</div>
	</body>
</html>



<?php
} else {
	header('Location: ../admin/login.php');	
	$error = 'You need to login!';
}
?>