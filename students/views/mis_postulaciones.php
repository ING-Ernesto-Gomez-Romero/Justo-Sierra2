<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Postulaciones - Bolsa JS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Estilos de Tarjetas de Postulación */
        .postulaciones-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .postulacion-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--color-borde);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .postulacion-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .postulacion-header {
            padding: 20px 20px 15px;
            border-bottom: 1px solid #f0f0f0;
            position: relative;
        }
        
        .postulacion-header h3 {
            font-size: 1.1rem;
            color: var(--color-texto-principal);
            margin: 0 0 8px 0;
            font-weight: 700;
            padding-right: 90px; /* Espacio para el badge */
        }
        
        .postulacion-fecha {
            font-size: 0.85rem;
            color: var(--color-texto-secundario);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .postulacion-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .empresa-logo {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #eee;
        }
        
        .empresa-info h4 {
            margin: 0;
            font-size: 1rem;
            color: var(--color-texto-principal);
        }
        
        .postulacion-footer {
            padding: 15px 20px;
            background: #fafafa;
            border-top: 1px solid #f0f0f0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .btn-ver-detalle {
            background: transparent;
            color: var(--color-js-rojo-principal);
            border: 1px solid var(--color-js-rojo-principal);
            padding: 10px 15px;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: block;
        }
        
        .btn-ver-detalle:hover {
            background: var(--color-js-rojo-principal);
            color: white;
        }
        
        .btn-tramite {
            background: #f39c12;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: block;
        }
        
        .btn-tramite:hover {
            background: #e67e22;
            color: white;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            position: absolute;
            top: 20px;
            right: 20px;
        }
        
        .status-enviada { background-color: #eaf3fb; color: #3498db; }
        .status-en_proceso { background-color: #fef5e6; color: #f39c12; }
        .status-aceptada, .status-aceptado { background-color: #eafaf1; color: #2ecc71; }
        .status-rechazada, .status-rechazado { background-color: #fdedec; color: #e74c3c; } 
    </style>
</head>
<body>

    <?php include 'partials/header.php'; ?>

    <div class="dashboard-container animate fadeRight">

        <h1>Historial de Postulaciones</h1>

        <?php if ($error_bd): ?>
            <div class="mensaje error"><?php echo htmlspecialchars($error_bd); ?></div>
        <?php elseif (empty($postulaciones)): ?>
            <div class="job-card-empty" style="text-align: left;">
                <h2>No has realizado ninguna postulación.</h2>
                <p>Visita el <a href="dashboard.php">Dashboard</a> para encontrar vacantes.</p>
            </div>
        <?php else: ?>

            <div class="postulaciones-grid animate fadeRight" style="animation-delay: 0.1s;">
                <?php foreach ($postulaciones as $p): ?>
                    <?php
                        $estado_raw = trim(strtolower($p['estado_postulacion']));
                        if ($estado_raw === 'en_proceso') {
                            $estado_display = 'En proceso';
                        } else {
                            $estado_display = ucfirst($estado_raw);
                        }
                    ?>
                    <div class="postulacion-card">
                        <div class="postulacion-header">
                            <h3><?php echo htmlspecialchars($p['titulo_vacante']); ?></h3>
                            <div class="postulacion-fecha">
                                <i class="far fa-calendar-alt"></i> Postulado: <?php echo date('d/m/Y', strtotime($p['fecha_postulacion'])); ?>
                            </div>
                            <span class="status-badge status-<?php echo $estado_raw; ?>">
                                <?php echo htmlspecialchars($estado_display); ?>
                            </span>
                        </div>
                        
                        <div class="postulacion-body">
                            <?php if (!empty($p['logo_empresa'])): ?>
                                <img src="<?php echo htmlspecialchars($p['logo_empresa']); ?>" 
                                     alt="Logo <?php echo htmlspecialchars($p['nombre_empresa']); ?>"
                                     class="empresa-logo">
                            <?php else: ?>
                                <div class="empresa-logo" style="display:flex; align-items:center; justify-content:center; background:#f5f5f5; color:#aaa; font-size:1.5rem;">
                                    <i class="far fa-building"></i>
                                </div>
                            <?php endif; ?>
                            <div class="empresa-info">
                                <h4><?php echo htmlspecialchars($p['nombre_empresa']); ?></h4>
                            </div>
                        </div>
                        
                        <div class="postulacion-footer">
                            <a href="detalle_vacante.php?id=<?php echo $p['id_vacante']; ?>" class="btn-ver-detalle">
                                <i class="fas fa-search"></i> Ver Detalles
                            </a>
                            
                            <?php if (in_array($estado_raw, ['aceptada', 'aceptado', 'en_proceso'])): ?>
                                <a href="servicio_social.php?id_postulacion=<?php echo $p['id_postulacion']; ?>" class="btn-tramite">
                                    <i class="fas fa-file-signature"></i> Trámite de Servicio Social
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>

</body>
</html>
