<?php
session_start();
$db = new mysqli('localhost','root','','project')
	or die($db->connect_error);