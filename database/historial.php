<?php
require 'config.php';
$method = $_SERVER['REQUEST_METHOD'];
$data   = json_decode(file_get_contents("php://input"), true);

if ($method === 'GET') {
    $mat = $conn->real_escape_string($_GET['matricula'] ?? '');
    $sql = $mat
        ? "SELECT * FROM historial WHERE matricula='$mat' ORDER BY fecha DESC, hora DESC"
        : "SELECT * FROM historial ORDER BY fecha DESC, hora DESC";
    $res  = $conn->query($sql);
    $rows = [];
    while ($row = $res->fetch_assoc()) $rows[] = $row;
    echo json_encode($rows);

} elseif ($method === 'POST') {
    $matricula    = $conn->real_escape_string($data['matricula']    ?? '');
    $fecha        = $conn->real_escape_string($data['fecha']        ?? '');
    $hora         = $conn->real_escape_string($data['hora']         ?? '');
    $tipoRegistro = $conn->real_escape_string($data['tipoRegistro'] ?? '');

    $stmt = $conn->prepare("INSERT INTO historial (matricula,fecha,hora,tipoRegistro) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $matricula, $fecha, $hora, $tipoRegistro);
    $stmt->execute();

    if ($tipoRegistro === 'entrada') {
        $stmt2 = $conn->prepare("UPDATE personas SET entrada=? WHERE matricula=?");
    } else {
        $stmt2 = $conn->prepare("UPDATE personas SET salida=? WHERE matricula=?");
    }
    $stmt2->bind_param("ss", $hora, $matricula);
    $stmt2->execute();

    echo json_encode(["ok" => true]);
}
?>
