<?php
session_start();

if (isset($_SESSION['user'])) {
    echo 'ok';
} else {
    echo 'no';
}
?>
