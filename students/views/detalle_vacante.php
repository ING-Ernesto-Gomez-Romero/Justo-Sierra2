<?php
// Función de utilidad (Formatear tags)
function formatear_tag($texto) {
    if (empty($texto)) { return "N/A"; }
    $formato = str_replace('_', ' ', $texto);
    return ucwords($formato);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle: <?php echo htmlspecialchars($vacante['titulo'] ?? 'Vacante'); ?></title>
    
    <link rel="stylesheet" href="../assets/css/style.css?v=2">
    <link rel="stylesheet" href="../assets/css/index.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* ESTILOS ELIMINADOS: Navbar ahora se importa de header.php */

        /* Contenedor Flex para las dos columnas */
        .detail-card-container { 
            display: flex; 
            gap: 30px; 
            margin-top: 30px;
        }
        .detail-main { 
            flex: 3; 
            padding: 40px;
            background-color: var(--color-blanco);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            border: none;
        }
        .detail-sidebar { 
            flex: 1; 
            padding: 30px; 
            background-color: var(--color-blanco); 
            border-radius: 20px; 
            height: fit-content;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            border: none;
        }
        
        /* Metadatos dentro del sidebar */
        .sidebar-item {
            padding: 10px 0;
            border-bottom: 1px dashed var(--color-borde);
            font-size: 0.95rem;
        }
        .sidebar-item:last-child { border-bottom: none; }
        .sidebar-item strong { 
            color: var(--color-js-rojo-secundario); 
            display: block; 
            font-size: 0.8rem;
            margin-bottom: 3px;
        }
        .sidebar-item-value { 
            font-weight: 500; 
            color: var(--color-texto-principal);
        }

        /* Responsive para móvil */
        @media (max-width: 992px) {
            .detail-card-container {
                flex-direction: column;
            }
            .detail-main { padding: 20px; }
        }
    </style>
</head>
<body>
    
    <?php include 'partials/header.php'; ?>
    
    <div class="dashboard-container animate fadeRight">
        <a href="dashboard.php" class="back-link" style="font-weight: 600; margin: 20px 0; display: inline-block;">
            <i class="fas fa-arrow-left"></i> Volver al Catálogo
        </a>

        <?php if ($error_bd): ?>
            <div class='mensaje error'><?php echo htmlspecialchars($error_bd); ?></div>
        <?php elseif ($vacante): ?>

            <div class="detail-card-container animate fadeRight" style="animation-delay: 0.1s;">
                
                <div class="detail-main">
                    <h1 style="color: var(--color-js-rojo-principal); margin-bottom: 5px; font-size: 2.5rem;"><?php echo htmlspecialchars($vacante['titulo']); ?></h1>
                    <h2 style="font-size: 1.25rem; color: var(--color-texto-secundario); margin-bottom: 25px;"><?php echo htmlspecialchars($vacante['nombre_empresa']); ?></h2>
                    
                    <h3 style="font-size: 1.2rem; color: var(--color-js-rojo-secundario); margin-top: 30px;">Descripción de la Vacante</h3>
                    <p style="white-space: pre-wrap; font-size: 1rem; color: var(--color-texto-principal); margin-top: 10px;">
                        <?php echo htmlspecialchars($vacante['descripcion']); ?>
                    </p>
                    
                    <div style="margin-top: 40px; text-align: center;">
                        <?php if ($vacante['ya_postulado'] > 0): ?>
                            <button class="boton-principal" disabled style="background-color: var(--color-exito); opacity: 0.8; cursor: default; padding: 12px 30px;">
                                <i class="fas fa-check"></i> Ya Postulado
                            </button>
                            <p style="color: var(--color-exito); margin-top: 10px; font-weight: 600;">Ya enviaste tu postulación a esta vacante.</p>
                        <?php else: ?>
                            <a href="#" id="btn-postular" data-id="<?php echo $id_vacante; ?>" class="boton-principal" style="padding: 12px 30px;">
                                <i class="fas fa-paper-plane"></i> <span id="text-postular">Postular Ahora</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="detail-sidebar">
                    <h3 style="font-size: 1.1rem; color: var(--color-js-rojo-secundario); border-bottom: 1px solid var(--color-borde); padding-bottom: 10px; margin-bottom: 15px;">
                        Detalles Clave
                    </h3>
                    
                    <div class="sidebar-item">
                        <strong><i class="fas fa-map-marker-alt"></i> UBICACIÓN</strong>
                        <span class="sidebar-item-value"><?php echo htmlspecialchars($vacante['ubicacion']); ?></span>
                    </div>
                    
                    <div class="sidebar-item">
                        <strong><i class="fas fa-dollar-sign"></i> SALARIO</strong>
                        <span class="sidebar-item-value"><?php echo $vacante['salario_ofrecido'] ? '$' . number_format($vacante['salario_ofrecido'], 2) : 'No especificado'; ?></span>
                    </div>
                    
                    <div class="sidebar-item">
                        <strong><i class="far fa-calendar-alt"></i> PUBLICADO</strong>
                        <span class="sidebar-item-value"><?php echo date('d/m/Y', strtotime($vacante['fecha_publicacion'])); ?></span>
                    </div>

                    <div style="margin-top: 15px;">
                        <span class="key-tag" style="background-color: #fbe6c2; color: #e65100;"><?php echo formatear_tag($vacante['tipo_contrato']); ?></span>
                        <span class="key-tag"><?php echo formatear_tag($vacante['modalidad']); ?></span>
                    </div>

                    <h3 style="font-size: 1.1rem; margin-top: 30px; color: var(--color-js-rojo-secundario); border-bottom: 1px solid var(--color-borde); padding-bottom: 10px; margin-bottom: 15px;">
                        Acerca de la Empresa
                    </h3>
                    <p style="font-size: 1rem;">
                        <a href="<?php echo htmlspecialchars($vacante['sitio_web']); ?>" target="_blank" style="font-weight: 600; color: var(--color-texto-principal);">
                            <?php echo htmlspecialchars($vacante['nombre_empresa']); ?>
                        </a>
                    </p>
                    <p style="font-size: 0.9em; color: var(--color-texto-secundario);">
                        <i class="fas fa-globe"></i> Visitar Sitio Web
                    </p>
                </div>

            </div>

        <?php endif; ?>
    </div>

    <script>
        const btnPostular = document.getElementById('btn-postular');
        if(btnPostular) {
            btnPostular.addEventListener('click', function(e) {
                e.preventDefault();
                
                const idVacante = this.getAttribute('data-id');
                const btnIcon = this.querySelector('i');
                const btnText = document.getElementById('text-postular');
                
                // UI de carga
                btnPostular.style.opacity = '0.7';
                btnPostular.style.pointerEvents = 'none';
                btnIcon.className = 'fas fa-spinner fa-spin';
                btnText.textContent = 'Enviando...';
                
                fetch('procesar_postulacion.php?id=' + idVacante, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.exito) {
                        btnPostular.style.backgroundColor = 'var(--color-exito)';
                        btnIcon.className = 'fas fa-check';
                        btnText.textContent = '¡Postulado!';
                        
                        // Añadir nota de éxito debajo
                        const pNota = document.createElement('p');
                        pNota.style.color = 'var(--color-exito)';
                        pNota.style.marginTop = '10px';
                        pNota.style.fontWeight = '600';
                        pNota.textContent = 'Ya enviaste tu postulación a esta vacante.';
                        btnPostular.parentNode.appendChild(pNota);
                    } else {
                        btnPostular.style.opacity = '1';
                        btnPostular.style.pointerEvents = 'auto';
                        btnPostular.style.backgroundColor = 'var(--color-error)';
                        btnIcon.className = 'fas fa-times';
                        btnText.textContent = 'Error: Reintenta';
                        alert(data.mensaje);
                    }
                })
                .catch(error => {
                    btnPostular.style.opacity = '1';
                    btnPostular.style.pointerEvents = 'auto';
                    btnIcon.className = 'fas fa-exclamation-triangle';
                    btnText.textContent = 'Error de conexión';
                });
            });
        }
    </script>
</body>
</html>
