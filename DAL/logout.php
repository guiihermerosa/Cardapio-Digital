<?php
session_start();
session_destroy();
header('Location: ../VIEW/index.php');
exit;
?> 