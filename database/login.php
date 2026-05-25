<?php
require 'config.php';
$data     = json_decode(file_get_contents("php://input"), true);
$usuario  = $conn->real_escape_string($data['usuario']  ?? '');
$password = $conn->real_escape_string($data['password'] ?? '');
$res      = $conn->query("SELECT id FROM usuarios WHERE usuario='$usuario' AND password='$password'");
echo json_encode(["ok" => $res->num_rows > 0]);
?>
