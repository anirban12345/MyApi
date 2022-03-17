<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<div id="container">
<form method="post" action="upload" enctype="multipart/form-data">
	<input type="file" accept="image/*" name="userfile" />
	<button type="submit">Upload</button>
</form>
</div>

</body>
</html>
