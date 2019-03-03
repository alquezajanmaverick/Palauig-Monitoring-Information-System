<?php
require_once('access.php');
session_start();
session_destroy();
header("Location:".ROOT_URL);