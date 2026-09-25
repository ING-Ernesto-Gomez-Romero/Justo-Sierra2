<?php
class CargaDocumentosController {
    private $conexion;

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['id_alumno']) || ($_SESSION['rol'] ?? '') !== 'alumno') {
            header("Location: ../login.php");
            exit;
        }
        require_once __DIR__ . '/../models/AlumnoModel.php';
        $alumnoModel = new AlumnoModel($this->conexion);
        $perfil = $alumnoModel->obtenerPerfil($_SESSION['id_alumno']);
        $nombre_alumno = $perfil['nombres'] ?? 'Alumno';

        $mensaje = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para procesar la subida de archivos (Simulación visual)
            $mensaje = "Documentos cargados con éxito (Simulación de la plataforma).";
        }

        require_once __DIR__ . '/../views/carga_documentos.php';
    }
}
