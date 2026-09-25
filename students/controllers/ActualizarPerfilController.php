<?php
require_once __DIR__ . '/../models/AlumnoModel.php';
require_once __DIR__ . '/../../config/Security.php';

class ActualizarPerfilController {
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
        $nombre_alumno = $_SESSION['nombre_alumno'] ?? 'Alumno';
        $error_bd = null;
        $mensaje = '';
        $error = false;
        $perfil = null;
        $cv_actual_url = null;

        $alumnoModel = new AlumnoModel($this->conexion);

        // Lógica para obtener datos actuales del alumno
        try {
            $perfil = $alumnoModel->obtenerPerfil($id_alumno);

            if (!$perfil) {
                die("Error: No se pudo cargar el perfil del alumno.");
            }

            if (!empty($perfil['cv_url'])) {
                // Ruta apunta a CVS dentro de students
                $cv_actual_url = "CVS/" . rawurlencode(htmlspecialchars($perfil['cv_url']));
            }

        } catch (PDOException $e) {
            $error_bd = "Error al cargar el perfil: " . $e->getMessage();
        }

        // Lógica para procesar el formulario (POST)
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_cambios'])) {

            $csrf_token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCsrfToken($csrf_token)) {
                $mensaje = "Error de seguridad (CSRF). Intenta enviar el formulario de nuevo."; $error = true;
            } else {

            $carrera = $_POST['carrera'] ?? $perfil['carrera'];
            $perfil_linkedin = trim($_POST['perfil_linkedin'] ?? ($perfil['perfil_linkedin'] ?? null));
            $cv_nuevo_nombre = $perfil['cv_url']; // Usar cv_url por defecto

            // Lógica de subida de archivo CV
            if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] == UPLOAD_ERR_OK) {
                $target_dir = __DIR__ . "/../CVS/"; // Ruta absoluta al directorio CVS
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }
                $original_filename = basename($_FILES["cv_file"]["name"]);
                $file_extension = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
                $safe_filename = preg_replace('/[^A-Za-z0-9_\-.]/', '_', pathinfo($original_filename, PATHINFO_FILENAME));
                $cv_nuevo_nombre = $id_alumno . "_" . time() . "_" . $safe_filename . "." . $file_extension;
                $target_file = $target_dir . $cv_nuevo_nombre;
                $uploadOk = 1;

                // Validaciones
                if ($_FILES["cv_file"]["size"] > 5 * 1024 * 1024) { // 5MB
                    $mensaje = "Error: El archivo es demasiado grande (Máx 5MB)."; $error = true; $uploadOk = 0;
                }
                if ($file_extension != "pdf") {
                    $mensaje = "Error: Solo se permiten archivos PDF."; $error = true; $uploadOk = 0;
                }

                // Verificación de Tipo MIME real (Magic Bytes)
                if ($uploadOk == 1) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $_FILES["cv_file"]["tmp_name"]);
                    finfo_close($finfo);

                    if ($mime_type !== 'application/pdf') {
                        $mensaje = "Error: El contenido del archivo no es un PDF válido."; $error = true; $uploadOk = 0;
                    }
                }

                // Intentar mover el archivo subido
                if ($uploadOk == 1) {
                    $cv_anterior_path = !empty($perfil['cv_url']) ? $target_dir . $perfil['cv_url'] : null;
                    if ($cv_anterior_path && file_exists($cv_anterior_path) && $perfil['cv_url'] !== $cv_nuevo_nombre) {
                        @unlink($cv_anterior_path);
                    }
                    if (!move_uploaded_file($_FILES["cv_file"]["tmp_name"], $target_file)) {
                        $mensaje = "Error al subir el archivo CV. Verifica permisos en la carpeta 'CVS'."; $error = true;
                        $cv_nuevo_nombre = $perfil['cv_url']; // Revertir
                    }
                }
            } elseif (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] != UPLOAD_ERR_NO_FILE) {
                $mensaje = "Error al intentar subir el archivo CV. Código: " . $_FILES['cv_file']['error']; $error = true;
            }

            $foto_perfil_nombre = $perfil['foto_perfil'] ?? null;

            // Lógica de subida de Foto de Perfil
            if (isset($_FILES['foto_file']) && $_FILES['foto_file']['error'] == UPLOAD_ERR_OK) {
                $target_dir_foto = __DIR__ . "/../../uploads/perfiles/";
                $original_filename_foto = basename($_FILES["foto_file"]["name"]);
                $file_extension_foto = strtolower(pathinfo($original_filename_foto, PATHINFO_EXTENSION));
                $safe_filename_foto = preg_replace('/[^A-Za-z0-9_\-.]/', '_', pathinfo($original_filename_foto, PATHINFO_FILENAME));
                $foto_nuevo_nombre = $id_alumno . "_" . time() . "_foto." . $file_extension_foto;
                $target_file_foto = $target_dir_foto . $foto_nuevo_nombre;
                $uploadOkFoto = 1;

                if ($_FILES["foto_file"]["size"] > 2 * 1024 * 1024) { // 2MB
                    $mensaje = "Error: La foto es demasiado grande (Máx 2MB)."; $error = true; $uploadOkFoto = 0;
                }
                if (!in_array($file_extension_foto, ['jpg', 'jpeg', 'png'])) {
                    $mensaje = "Error: Solo se permiten imágenes JPG y PNG."; $error = true; $uploadOkFoto = 0;
                }

                if ($uploadOkFoto == 1) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime_type = finfo_file($finfo, $_FILES["foto_file"]["tmp_name"]);
                    finfo_close($finfo);
                    if (!in_array($mime_type, ['image/jpeg', 'image/png'])) {
                        $mensaje = "Error: El contenido del archivo no es una imagen válida."; $error = true; $uploadOkFoto = 0;
                    }
                }

                if ($uploadOkFoto == 1) {
                    $foto_anterior_path = !empty($perfil['foto_perfil']) ? $target_dir_foto . $perfil['foto_perfil'] : null;
                    if ($foto_anterior_path && file_exists($foto_anterior_path)) {
                        @unlink($foto_anterior_path);
                    }
                    if (move_uploaded_file($_FILES["foto_file"]["tmp_name"], $target_file_foto)) {
                        $foto_perfil_nombre = $foto_nuevo_nombre;
                    } else {
                        $mensaje = "Error al subir la foto de perfil."; $error = true;
                    }
                }
            } elseif (isset($_FILES['foto_file']) && $_FILES['foto_file']['error'] != UPLOAD_ERR_NO_FILE) {
                $mensaje = "Error al intentar subir la foto. Código: " . $_FILES['foto_file']['error']; $error = true;
            }

            // Si no hubo error de subida, actualizamos la BD
            if (!$error) {
                try {
                    $alumnoModel->actualizarPerfil($id_alumno, $carrera, $cv_nuevo_nombre, $perfil_linkedin, $foto_perfil_nombre);

                    // Refrescar perfil
                    $perfil = $alumnoModel->obtenerPerfil($id_alumno);
                    // Recargar datos
                    $perfil['carrera'] = $carrera;
                    $perfil['cv_url'] = $cv_nuevo_nombre;
                    $perfil['perfil_linkedin'] = $perfil_linkedin;
                    $perfil['foto_perfil'] = $foto_perfil_nombre;
                    $_SESSION['foto_perfil'] = $foto_perfil_nombre;

                    $mensaje = "Perfil y CV actualizados correctamente."; $error = false;                     $cv_actual_url = "CVS/" . rawurlencode(htmlspecialchars($perfil['cv_url']));
                    if (!empty($perfil['cv_url'])) {
                        $cv_actual_url = "CVS/" . rawurlencode(htmlspecialchars($perfil['cv_url']));
                    } else { $cv_actual_url = null; }

                } catch (PDOException $e) {
                    $mensaje = "Error al actualizar la base de datos: " . $e->getMessage(); $error = true;
                }
            }
            }
        }

        // Lista de carreras
        $carreras_ejemplo = [
            'administracion' => 'Administración', 'derecho' => 'Derecho', 'contaduria' => 'Contaduría',
            'sistemas' => 'Ing. en Sistemas Computacionales', 'psicologia' => 'Psicología',
            'diseno_grafico' => 'Diseño Gráfico', 'arquitectura' => 'Arquitectura', 'mercadotecnia' => 'Mercadotecnia'
        ];

        require_once __DIR__ . '/../views/actualizar_perfil.php';
    }
}
