<?php
	session_start();
	unset($_SESSION['secret']);
	unset($_SESSION['Id']);
	session_destroy();
	header("Location: ../");
?>
