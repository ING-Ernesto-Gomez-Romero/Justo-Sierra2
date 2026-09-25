<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Perfil y CV - Bolsa JS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=2">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <?php include 'partials/header.php'; ?>

    <div class="dashboard-container animate fadeRight">
        <div class="form-card card profile-edit-card animate fadeRight" style="animation-delay: 0.1s;">
            <h1 style="text-align: center; margin-bottom: 30px;">Actualizar Perfil y CV</h1>

            <?php if (!empty($mensaje)): ?>
                <div class="mensaje <?php echo $error ? 'error' : 'exito'; ?>"><?php echo htmlspecialchars($mensaje); ?></div>
            <?php endif; ?>
            <?php if ($error_bd): ?>
                 <div class="mensaje error"><?php echo htmlspecialchars($error_bd); ?></div>
            <?php endif; ?>

            <form action="actualizar_perfil.php" method="POST" enctype="multipart/form-data">
                <?php echo Security::getCsrfInput(); ?>

                <h2>Foto de Perfil</h2>
                <div class="mb-3" style="text-align: center;">
                    <?php if (!empty($perfil['foto_perfil'])): ?>
                        <img src="../../uploads/perfiles/<?php echo htmlspecialchars($perfil['foto_perfil']); ?>" alt="Foto Perfil" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 3px solid #E60013;">
                    <?php else: ?>
                        <div style="width: 120px; height: 120px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto; border: 3px solid #ccc; font-size: 2rem; color: #999;">
                            <i class="fas fa-user"></i>
                        </div>
                    <?php endif; ?>
                    <label for="foto_file" style="display:block;">Subir Nueva Foto (JPG, PNG. Máx 2MB):</label>
                    <div class="custom-file-input-wrapper" style="max-width: 300px; margin: 0 auto;">
                        <button type="button" class="custom-file-input-button" id="btn-foto"> <i class="fas fa-image"></i> Cambiar Foto </button>
                        <input type="file" id="foto_file" name="foto_file" accept=".jpg, .jpeg, .png" style="display:none;">
                        <span class="file-name-display-foto" style="display:block; margin-top:10px;">Sin foto nueva seleccionada</span>
                    </div>
                </div>

                <h2 style="margin-top: 30px;">Datos Académicos</h2>
                <div class="mb-3">
                    <label for="carrera">Carrera:</label>
                    <select id="carrera" name="carrera" class="filter-select" style="width: 100%;" required>
                        <option value="">-- Selecciona tu Carrera --</option>
                        <?php foreach ($carreras_ejemplo as $val => $label): ?>
                            <option value="<?php echo $val; ?>" <?php echo ($perfil['carrera'] ?? '') === $val ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="input-field" style="margin-top: 20px; margin-bottom: 20px;">
                    <input type="text" id="perfil_linkedin" name="perfil_linkedin"
                           value="<?php echo htmlspecialchars($perfil['perfil_linkedin'] ?? ''); ?>"
                           placeholder="Ej: https://www.linkedin.com/in/tu-usuario">
                    <label for="perfil_linkedin" class="active" style="transform: translateY(-14px) scale(0.8); transform-origin: 0 0;">Perfil LinkedIn (URL completa, opcional)</label>
                </div>

                <h2 style="margin-top: 30px;">Currículum Vitae (CV)</h2>
                <div class="mb-3">
                    <label for="cv_file">Subir CV (Solo archivo PDF, máx 5MB):</label>
                    <div class="custom-file-input-wrapper">
                        <button type="button" class="custom-file-input-button"> <i class="fas fa-upload"></i> Seleccionar archivo </button>
                        <input type="file" id="cv_file" name="cv_file" accept=".pdf">
                        <span class="file-name-display">Sin archivo seleccionado</span>
                    </div>

                    <?php if ($cv_actual_url): ?>
                        <a href="<?php echo $cv_actual_url; ?>" target="_blank" class="current-cv-link"> <i class="fas fa-check-circle"></i> **CV Actual** Ver archivo subido </a>
                    <?php else: ?>
                        <p class="current-cv-link" style="color: var(--color-texto-secundario); font-weight: normal;"> <i class="fas fa-times-circle" style="color: var(--color-error);"></i> No tienes un CV subido. </p>
                    <?php endif; ?>
                    <p class="cv-upload-note">*Al subir un nuevo archivo PDF, el anterior será reemplazado automáticamente.*</p>
                </div>

                <div class="form-actions profile-edit-actions">
                    <a href="perfil_alumno.php" class="btn-secundario-form">Volver al Perfil</a>
                    <button type="submit" name="guardar_cambios" class="boton-principal"> <i class="fas fa-save"></i> Guardar Cambios </button>
                </div>
            </form>
        </div>
    </div>

   <script>
        const customButton = document.querySelector('.custom-file-input-button');
        const fileInput = document.getElementById('cv_file');
        const fileNameDisplay = document.querySelector('.file-name-display');

        customButton.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
            } else {
                fileNameDisplay.textContent = 'Sin archivo seleccionado';
            }
        });

        const btnFoto = document.getElementById('btn-foto');
        const fotoInput = document.getElementById('foto_file');
        const fotoNameDisplay = document.querySelector('.file-name-display-foto');

        if (btnFoto && fotoInput) {
            btnFoto.addEventListener('click', function() {
                fotoInput.click();
            });
            fotoInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    fotoNameDisplay.textContent = this.files[0].name;
                } else {
                    fotoNameDisplay.textContent = 'Sin foto nueva seleccionada';
                }
            });
        }
    </script>

</body>
</html>
