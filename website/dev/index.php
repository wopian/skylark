<h1>We can have html in our included file</h1>

<?php
// Here we will echo some simple text
echo '<p>This is where the main content will be</p>';
?>
<p>More html stuff can go here.</p>

<!-- Begin Dynamic Content -->
<div class="Content">

<?php
// include the main.php page
include_once('content.php');
?>

</div>
<!-- End Dynamic Content -->
