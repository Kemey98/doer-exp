<?php
echo "Please wait!";
require_once 'core/init.php';
?>
<script type="text/javascript">
	localStorage.removeItem("filtertimeframeID");
	localStorage.removeItem("activeTab");
</script>
<?php

$user = new User();
$user->logout();

Redirect::to('login.php');
?>
