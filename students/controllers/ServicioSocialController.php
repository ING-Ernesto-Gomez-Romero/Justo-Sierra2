<?php
require_once __DIR__ . '/../models/ServicioSocialModel.php';
require_once __DIR__ . '/../models/AlumnoModel.php';
require_once __DIR__ . '/../../config/Security.php';

class ServicioSocialController {
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

        $id_alumno = $_SESSION['id_alumno'];
        $id_postulacion = $_GET['id_postulacion'] ?? null;

        if (!$id_postulacion) {
            die("ID de postulación no proporcionado.");
        }

        $model = new ServicioSocialModel($this->conexion);
        $alumnoModel = new AlumnoModel($this->conexion);
        
        $alumno = $alumnoModel->obtenerPerfil($id_alumno);
        $postulacion = $model->obtenerPostulacionAceptada($id_alumno, $id_postulacion);
        
        if (!$postulacion) {
            die("Postulación no válida.");
        }

        $tramite = $model->obtenerTramitePorAlumnoYPostulacion($id_alumno, $id_postulacion);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCsrfToken($csrf_token)) {
                die("Solicitud no válida.");
            }

            $accion = $_POST['accion'] ?? '';
            
            if ($accion === 'iniciar_tramite') {
                if (!$tramite) {
                    // Create an initial record with just basic info to let admin know
                    $model->crearTramiteInicial($id_alumno, $id_postulacion, $postulacion['nombre_empresa'], 'Servicios Escolares', 'Cajas');
                    $tramite = $model->obtenerTramitePorAlumnoYPostulacion($id_alumno, $id_postulacion);
                }
                
                // The original institutional document is intentionally excluded from the public demo.
                header("Location: servicio_social.php?id_postulacion=" . urlencode($id_postulacion) . "&demo_document=1");
                exit;
            }
        }

        $nombre_alumno = $alumno['nombres'] ?? $alumno['nombre'] ?? 'Alumno';
        require_once __DIR__ . '/../views/servicio_social.php';
    }
}
