<?php
session_start();

if (isset($_SESSION['user'])) {
	echo $_SESSION['user']['nombre'];
} else {
	echo 'no';
}
?>
