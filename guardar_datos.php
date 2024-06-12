<?php
include '../config/db.php'; // Incluir el archivo de conexión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idFrente = $_POST['idFrente'];
    $idSupervisor = $_POST['idSupervisor'];
    $fechaCorte = $_POST['fechacorte'];
    $idFinca = "1";
    $idEmpleadoArray = $_POST['codigo'];
    $metrosArray = $_POST['metros'];

    // Verificar si todos los datos necesarios están presentes
    if (empty($idFrente) || empty($idSupervisor) || empty($fechaCorte) || empty($idEmpleadoArray) || empty($idFinca)) {
        echo 'Por favor complete todos los campos.';
        exit;
    }

    // Preparar la consulta preparada para la inserción de datos
    $query = "INSERT INTO capturametros (idFrente, idSupervisor, fechaCorte, idEmpleado, fincaLote, metros) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $conn->prepare($query);

    // Verificar si la preparación de la consulta fue exitosa
    if (!$statement) {
        echo 'Error al preparar la consulta: ' . $conn->error;
        exit;
    }

    // Vincular parámetros a la consulta preparada y ejecutarla dentro del bucle
    foreach ($idEmpleadoArray as $index => $idEmpleado) {
        $metros = $metrosArray[$index];

        if (!empty($metros) && $metros > 0) {
            $statement->bind_param("iiisis", $idFrente, $idSupervisor, $fechaCorte, $idEmpleado, $idFinca, $metros);
            $result = $statement->execute();

            if ($result) {
                echo 'Datos guardados correctamente.';
            } else {
                echo 'Error al guardar datos: ' . $conn->error;
            }
        }
    }

    // Cerrar la consulta preparada después de su uso
    $statement->close();
}
?>
