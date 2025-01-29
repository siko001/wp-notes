<?php
// Generate a nonce
$nonce = wp_create_nonce('my_nonce_action');
?>

<!-- Create a link with the nonce included -->
<a href="<?= admin_url('admin-post.php?action=my_action&nonce=' . $nonce) ?>">Click to Perform Action</a>'