<html>
	<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<title>
		Upload Files - Maths Homepage - Woodhouse College
		</title>
<?php include 'header.php'; ?>
	<div class="admincontainer">
	<h2><a href="index.php" id="logo">Users</a></h2>

<?php include '../functions/breadcrumbs.php'; ?>
<p><?= breadcrumbs(' > ') ?></p>


<a href="?add">Add New Human</a>
<ul>
 <?php foreach($users as $user): ?>
        <li>
          <form action="" method="post">
            <div>
              <?php htmlout($users['name']); ?>
              <input type="hidden" name="id" value="<?php
                  echo $author['id']; ?>">
              <input type="submit" name="action" value="Edit">
              <input type="submit" name="action" value="Delete">
            </div>
          </form>
        </li>
      <?php endforeach; ?>

</ul>
	

</body>
</html>
<?php
} else {
	header('Location: ../index.php');
}
?>