
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Bolsa de Trabajo JS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/index.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        .student-profile-container { max-width: 900px; margin: 40px auto; }
        .student-profile-card {
            background: white; border-radius: 20px; padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: none;
            display: flex; flex-direction: column; gap: 30px;
        }
        .student-profile-header {
            display: flex; align-items: center; gap: 20px; border-bottom: 1px solid #eee; padding-bottom: 20px;
        }
        .student-profile-avatar {
            width: 100px; height: 100px; border-radius: 50%; object-fit: cover;
            border: 3px solid var(--js-red); background: #eee;
            display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: #ccc;
        }
        .student-profile-title h2 { margin: 0 0 5px 0; color: var(--premium-dark); }
        .student-profile-title p { margin: 0; color: var(--premium-gray); font-size: 1rem; }
        .student-profile-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;
        }
        .student-profile-item { background: #f8f9fa; padding: 20px; border-radius: 12px; }
        .student-profile-item label { display: block; font-size: 0.85rem; color: var(--premium-gray); text-transform: uppercase; font-weight: 600; margin-bottom: 5px; }
        .student-profile-item .value { font-size: 1.1rem; font-weight: 500; color: var(--premium-dark); }
        .student-profile-actions { display: flex; gap: 15px; margin-top: 20px; }
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <div class="dashboard-container student-profile-container animate fadeRight">
        <?php if ($error_bd): ?>
            <div class="card" style="padding: 20px; background: #ffebee; color: #c62828;"><?php echo htmlspecialchars($error_bd); ?></div>
        <?php elseif ($perfil): ?>
            <div class="student-profile-card">
                <div class="student-profile-header">
                    <?php if (!empty($perfil['foto_perfil'])): ?>
                        <img src="../uploads/perfiles/<?php echo htmlspecialchars($perfil['foto_perfil']); ?>" alt="Foto" class="student-profile-avatar">
                    <?php else: ?>
                        <div class="student-profile-avatar"><i class="fas fa-user"></i></div>
                    <?php endif; ?>
                    <div class="student-profile-title">
                        <h2><?php echo htmlspecialchars($perfil['nombre'] . ' ' . $perfil['apellidos']); ?></h2>
                        <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($perfil['email']); ?></p>
                    </div>
                </div>

                <div class="student-profile-grid">
                    <div class="student-profile-item">
                        <label>Matrícula</label>
                        <div class="value"><?php echo htmlspecialchars($perfil['matricula']); ?></div>
                    </div>
                    <div class="student-profile-item">
                        <label>Carrera</label>
                        <div class="value"><?php echo htmlspecialchars($perfil['carrera'] ?? 'No especificada'); ?></div>
                    </div>
                    <div class="student-profile-item">
                        <label>Semestre</label>
                        <div class="value"><?php echo isset($perfil['semestre']) ? htmlspecialchars($perfil['semestre']) . 'mo' : 'N/A'; ?></div>
                    </div>
                    <div class="student-profile-item">
                        <label>LinkedIn</label>
                        <div class="value">
                            <?php if (!empty($perfil['perfil_linkedin'])): 
                                $url = $perfil['perfil_linkedin'];
                                if (!preg_match("~^(?:f|ht)tps?://~i", $url)) $url = "https://" . $url;
                            ?>
                                <a href="<?php echo htmlspecialchars($url); ?>" target="_blank" style="color: #0077b5;"><i class="fab fa-linkedin"></i> Ver Perfil</a>
                            <?php else: ?>
                                <span style="color: var(--premium-gray);">No proporcionado</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="student-profile-actions">
                    <a href="actualizar_perfil.php" class="btn"><i class="fas fa-edit"></i> Editar Perfil</a>
                    <a href="mis_postulaciones.php" class="btn" style="background: var(--premium-gray);"><i class="fas fa-briefcase"></i> Postulaciones</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
