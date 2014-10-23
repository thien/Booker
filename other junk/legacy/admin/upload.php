<?php 
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');
if (isset($_SESSION['logged_in'])) {
?>
<html>
	<head>
		<title>
		Upload Files - Maths Homepage - Woodhouse College
		</title>
<?php include 'header.php'; ?>
	<div class="admincontainer">
	<h2><a href="index.php" id="logo">Upload Files</a></h2>

<?php

// This function will take $_SERVER['REQUEST_URI'] and build a breadcrumb based on the user's current path
function breadcrumbs($separator = ' &raquo; ', $home = 'Home') {
    // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));

    // This will build our "base URL" ... Also accounts for HTTPS :)
    $base = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

    // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
    $breadcrumbs = Array("<a href=\"$base\">$home</a>");

    // Find out the index for the last value in our path array
    $last = end(array_keys($path));

    // Build the rest of the breadcrumbs
    foreach ($path AS $x => $crumb) {
        // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
        $title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb));

        // If we are not on the last index, then display an <a> tag
        if ($x != $last)
            $breadcrumbs[] = "<a href=\"$base$crumb\">$title</a>";
        // Otherwise, just display the title (minus)
        else
            $breadcrumbs[] = $title;
    }

    // Build our temporary array (pieces of bread) into one big string :)
    return implode($separator, $breadcrumbs);
}

?>

<p><?= breadcrumbs(' > ') ?></p>

	<form action="../functions/uploader.php" method="post" enctype="multipart/form-data" id="upload" class="upload">


		<select>
		  <option value="image">Picture</option>
		  <option value="doc">Document</option>
		  <option value="video">Video</option>
		  <option value="exampaper">Exam Paper</option>
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
		<script>
		document.getElementById('submit').addEventListener('click', function(e) {
			e.preventDefault(); //prevent default behaviour
				var f = document.getElementById('file');
				var pb = document.getElementById('pb');
				var pt = document.getElementById('pt');
				app.uploader({
					files: f,
					progressBar: pb,
					progress: pt,
					processor: '../functions/uploader.php',
					finished: function(data) {
						var uploads = document.getElementById('uploads');
						var succeeded = document.createElement('div');
						var failed = document.createElement('div');

						var	anchor;
						var	span;
						var	x;

						if(data.failed.length) {
							failed.innerHTML = '<p>The the following files have failed to upload:</p>';
						}

						uploads.innerText = '';

						for(x = 0; x < data.succeeded.length; x = x + 1) {
							anchor = document.createElement('a');
							anchor.href = '../media/files/' + data.succeeded[x].file;
							anchor.innerText = data.succeeded[x].name;
							anchor.target = '_blank';
							succeeded.appendChild(anchor);
						}
						for(x = 0; x < data.failed.length; x = x + 1) {
							span = document.createElement('span');
							span.innerText = data.failed[x].name;
							failed.appendChild(span);
						}

				
						uploads.appendChild(succeeded);
						uploads.appendChild(failed);
			
					},
					error: function() {
						console.log('Not Working');
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