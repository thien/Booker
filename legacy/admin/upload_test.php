<?php 
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');
if (isset($_SESSION['logged_in'])) {
?>
<html>
	<head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<title>
		Upload Files - Maths Homepage - Woodhouse College
		</title>
<?php include 'header.php'; ?>
	<div class="admincontainer">
	<h2><a href="index.php" id="logo">Upload Files</a></h2>

<?php
// This function will take $_SERVER['REQUEST_URI'] and build a breadcrumb based on the user's current path
function breadcrumbs($separator = ' &raquo; ', $home = 'Home') {
    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));  // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
    $base = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';     // This will build our "base URL" ... Also accounts for HTTPS :)
    $breadcrumbs = Array("<a href=\"$base\">$home</a>");  // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
    $last = end(array_keys($path));// Find out the index for the last value in our path array
    foreach ($path AS $x => $crumb) {    // Build the rest of the breadcrumbs
        $title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb)); // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
        if ($x != $last)   // If we are not on the last index, then display an <a> tag
            $breadcrumbs[] = "<a href=\"$base$crumb\">$title</a>";
        else  // Otherwise, just display the title (minus)
            $breadcrumbs[] = $title;
    }
    // Build our temporary array (pieces of bread) into one big string :)
    return implode($separator, $breadcrumbs);
}
?>

<p><?= breadcrumbs(' > ') ?></p>



	<form action="../functions/uploader.php" method="post" enctype="multipart/form-data" id="upload" class="upload">
		<select name="exam_subject">
		  <option value="maths">Mathematics</option>
		  <option value="further_maths">Further Mathematics</option>
		  <option value="uat">University Admissions Test</option>
		</select>

		<select name="exam_year">
			<?php 
			   for($i = 2004 ; $i <= date('Y'); $i++){
			      echo "<option>$i</option>";
			   }
			?>
		</select>
		<select name="exam_month">
		  <option value="June">June</option>
		  <option value="Jan">Jan</option>
		</select>
		<select name="exam_topic">
		  <option value="C1">Core 1</option>
		  <option value="C2">Core 2</option>
		  <option value="C3">Core 3</option>
		  <option value="C4">Core 4</option>
		  <option value="D1">Decision 1</option>
		  <option value="D2">Decision 2</option>
		  <option value="D3">Decision 3</option>
		  <option value="D4">Decision 4</option>
		  <option value="FP1">Further Maths 1</option>
		  <option value="FP2">Further Maths 2</option>
		  <option value="FP3">Further Maths 3</option>
		  <option value="FP4">Further Maths 4</option>
		  <option value="M1">Mechanics 1</option>
		  <option value="M2">Mechanics 1</option>
		  <option value="M3">Mechanics 1</option>
		  <option value="M4">Mechanics 1</option>
		  <option value="S1">Statistics 1</option>
		  <option value="S2">Statistics 2</option>
		  <option value="S3">Statistics 3</option>
		  <option value="S4">Statistics 4</option>
		  <option value="STEP1">STEP 1</option>
		  <option value="STEP2">STEP 2</option>
		  <option value="STEP3">STEP 3</option>
		  <option value="STEP4">STEP 4</option>
		</select>
<br>
			<input type="file" id="file" name="file[]" required multiple>
			<input type="submit" id="submit" name="submit" value="Upload">
			<div class="bar">
				<span class="bar-fill" id="pb">
					<span class="bar-fill-text" id="pt">
					</span>
				</span>
		</div>
		<div id="uploads" class="uploads">
			Uploaded File Links will appear here.
		</div>
	</form>
	</div>
	</body>
		<script src="../functions/uploader.js"></script>
		<script>
		$(document).ready(
    function(){
        $('input:submit').attr('disabled',true);
        $('input:file').change(
            function(){
                if ($(this).val()){
                    $('input:submit').removeAttr('disabled'); 
                }
                else {
                    $('input:submit').attr('disabled',true);
                }
            });
    });
		</script>

</html>
<?php
} else {
	header('Location: ../index.php');
}
?>