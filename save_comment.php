<?php
$id = basename($_POST['id']);

$name = trim($_POST['name']);
$message = trim($_POST['message']);

$path = "data/comments/$id";

$fp = fopen($path, "a");

$line = $name . "|" . $message . "|" . date("Y-m-d H:i:s") . "\n";

fwrite($fp, $line);
fclose($fp);

header("Location: view.php?id=".$id);
