<?php 

session_start();

include_once('../includes/connection.php');
include_once('../includes/article.php');
$article = new Article;
$id = $_GET['id'];

if (isset($_SESSION['logged_in'])){
//display delete articles.
	if (isset($_GET['id'])){
		$query = $pdo->prepare('DELETE FROM articles WHERE article_id = ?');
		$query->bindValue(1, $id);
		$query->execute();
		header('Location: delete.php');
	}
$articles = $article->fetch_all()
?>
<html>
	<head>
		<title>
		Maths Homepage - Woodhouse College
		</title>
	<?php include 'header.php';?>
	<div class="admincontainer">
		<a href="index.php" id="logo"> CMS</a>
		
		<br><br>
		
	<form action="delete.php" method="get">
		<select name="id">
			<?php foreach ($articles as $article) { ?>
				<option value="<?php echo $article['article_id']; ?>">
					<?php echo $article['article_title'];?>
				</option>
			<?php } ?>
			</select>
			<input type="submit" value="Delete"/>
	</form>
	
		</div>
		</body>
	</html>


<?php
} else {
//displays login.
header('Location: ../admin/login.php');	
$error = 'You need to login!';
}

?>