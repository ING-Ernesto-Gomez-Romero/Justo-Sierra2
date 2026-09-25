<?php
require_once __DIR__ . '/../models/VacanteModel.php';
require_once __DIR__ . '/../models/AlumnoModel.php';
require_once __DIR__ . '/../models/PostulacionModel.php';

class DashboardController {
    private $conexion;

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    public function index() {
        session_start();

        if (!isset($_SESSION['id_alumno']) || ($_SESSION['rol'] ?? '') !== 'alumno') {
            header("Location: ../login.php"); 
            exit();
        }

        $id_alumno = $_SESSION['id_alumno'];
        $nombre_alumno = $_SESSION['nombre_alumno'] ?? 'Alumno';
        $vacantes = [];
        $error_busqueda = null;

        // LÓGICA DE BÚSQUEDA (GET)
        $termino_busqueda = $_GET['search'] ?? '';
        $tipo_contrato_filtro = $_GET['contrato'] ?? '';
        $carrera_filtro = $_GET['carrera'] ?? ''; 

        // LÓGICA DE RESUMEN DEL ALUMNO
        $alumnoModel = new AlumnoModel($this->conexion);
        $postulacionModel = new PostulacionModel($this->conexion);

        $perfil = $alumnoModel->obtenerPerfil($id_alumno);
        $postulaciones = $postulacionModel->obtenerMisPostulaciones($id_alumno);

        // Calcular Completitud
        $porcentaje_perfil = 10; // Base por registrarse (nombre, email, matricula, semestre)
        if (!empty($perfil['carrera'])) $porcentaje_perfil += 30;
        if (!empty($perfil['cv_url'])) $porcentaje_perfil += 40;
        if (!empty($perfil['perfil_linkedin'])) $porcentaje_perfil += 10;
        if (!empty($perfil['foto_perfil'])) $porcentaje_perfil += 10;

        $total_postulaciones = count($postulaciones);
        $ultima_actividad = !empty($postulaciones) ? $postulaciones[0] : null;

        try {
            $vacanteModel = new VacanteModel($this->conexion);
            $vacantes = $vacanteModel->buscarVacantesActivas($termino_busqueda, $tipo_contrato_filtro, $carrera_filtro);
        } catch (PDOException $e) {
            error_log("Error de BD al buscar vacantes: " . $e->getMessage());
            $error_busqueda = "Error al conectar con el catálogo de vacantes. Por favor, intente más tarde.";
        }

        // Pasar variables a la vista
        require_once __DIR__ . '/../views/dashboard.php';
    }
}
