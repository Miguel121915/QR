<?php
require 'config.php';
$method = $_SERVER['REQUEST_METHOD'];
$data   = json_decode(file_get_contents("php://input"), true);

if ($method === 'GET') {
    $res  = $conn->query("SELECT * FROM personas ORDER BY nombre ASC");
    $rows = [];
    while ($row = $res->fetch_assoc()) $rows[] = $row;
    echo json_encode($rows);

} elseif ($method === 'POST') {
    $stmt = $conn->prepare(
        "INSERT INTO personas (nombre,matricula,instrumento,categoriaInstrumento,fechaNacimiento,tipo,nivel,foto,qrData,entrada,salida)
         VALUES (?,?,?,?,?,?,?,?,?,'-','-')"
    );
    $stmt->bind_param("sssssssss",
        $data['nombre'], $data['matricula'], $data['instrumento'],
        $data['categoriaInstrumento'], $data['fechaNacimiento'],
        $data['tipo'], $data['nivel'], $data['foto'], $data['qrData']
    );
    if ($stmt->execute()) {
        echo json_encode(["ok" => true, "id" => $conn->insert_id]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => $stmt->error]);
    }

} elseif ($method === 'PUT') {
    $stmt = $conn->prepare("UPDATE personas SET nombre=?, instrumento=? WHERE matricula=?");
    $stmt->bind_param("sss", $data['nombre'], $data['instrumento'], $data['matricula']);
    $stmt->execute();
    echo json_encode(["ok" => true]);

} elseif ($method === 'DELETE') {
    $mat = $conn->real_escape_string($data['matricula'] ?? '');
    $conn->query("DELETE FROM personas WHERE matricula='$mat'");
    echo json_encode(["ok" => true]);
}
?>
