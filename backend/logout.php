<?php
// ── Cierra la sesión del usuario ──
session_start();
session_destroy();
echo 'ok';
?>
