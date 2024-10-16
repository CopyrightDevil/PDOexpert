<?php
session_start();
session_unset(); // Verwijdert alle sessievariabelen
session_destroy(); // Vernietigt de sessie

// Redirect naar register.php
header("Location: register.php");
exit;
