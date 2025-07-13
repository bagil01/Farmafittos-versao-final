<?php
session_start();
session_destroy();
header('Location: /farmafittos-vers-o-final/admin/index.php');
exit;
