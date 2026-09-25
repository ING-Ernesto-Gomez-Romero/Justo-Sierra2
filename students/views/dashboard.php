<?php
// Función de utilidad (Formatear tags)
function formatear_tag($texto) {
    if (empty($texto)) { return "N/A"; }
    $formato = str_replace('_', ' ', $texto);
    return ucwords($formato);
}

// Arreglo de carreras
$carreras_ejemplo = [
    'administracion' => 'Administración',
    'derecho' => 'Derecho',
    'contaduria' => 'Contaduría',
    'sistemas' => 'Ing. en Sistemas',
    'psicologia' => 'Psicología',
    'diseno_grafico' => 'Diseño Gráfico',
    'arquitectura' => 'Arquitectura',
    'mercadotecnia' => 'Mercadotecnia'
];

// --- LÓGICA DE DISEÑO PARA EL GRID DE BÚSQUEDA ---
$show_limpiar = (!empty($termino_busqueda) || !empty($tipo_contrato_filtro) || !empty($carrera_filtro));
$col_contrato = $show_limpiar ? 'col-md-4' : 'col-md-5';
$col_carrera = $show_limpiar ? 'col-md-4' : 'col-md-5';
$col_buscar = $show_limpiar ? 'col-md-2' : 'col-md-2';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Alumnos | Justo Sierra</title>
    
    <link rel="stylesheet" href="../assets/css/style.css?v=2">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* ESTILOS ELIMINADOS: Navbar ahora se importa de header.php */
        
        /* Estilos de los Widgets */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 40px;
        }
        .widget-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
        }
        .widget-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(230,0,19,0.08);
        }
        .widget-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(230, 0, 19, 0.1);
            color: var(--color-js-rojo-secundario);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }
        .widget-content { flex: 1; }
        .widget-content h3 {
            margin: 0;
            font-size: 1rem;
            color: var(--color-texto-secundario);
            font-weight: 500;
        }
        .widget-content .widget-value {
            margin: 5px 0 0 0;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--color-js-rojo-secundario);
        }
        .progress-bar-bg {
            background: #eee;
            border-radius: 10px;
            height: 8px;
            width: 100%;
            margin-top: 10px;
            overflow: hidden;
        }
        .progress-bar-fill {
            background: linear-gradient(90deg, #E60013, #FCC800);
            height: 100%;
            border-radius: 10px;
            transition: width 1s ease-in-out;
        }

        .search-bar-container {
            margin: 0 auto 40px auto !important; 
            padding: 35px 40px; 
            background-color: var(--color-blanco); 
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 10px 40px rgba(0,0,0,0.05); 
            border-radius: 20px; 
            max-width: 1000px;
        }
    </style>
</head>
<body>
    
    <?php include 'partials/header.php'; ?>
    
    <div class="container animate fadeRight" style="max-width: 1100px; padding-top: 40px;">
        <h2 style="font-weight: 700; color: var(--color-js-rojo-principal);">Resumen de tu Cuenta</h2>
        <div class="summary-grid">
            <!-- Widget 1: Completitud -->
            <div class="widget-card">
                <div class="widget-icon"><i class="fas fa-chart-pie"></i></div>
                <div class="widget-content">
                    <h3>Perfil Completado</h3>
                    <div class="widget-value"><?php echo $porcentaje_perfil; ?>%</div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: <?php echo $porcentaje_perfil; ?>%;"></div>
                    </div>
                </div>
            </div>
            
            <!-- Widget 2: Postulaciones -->
            <div class="widget-card">
                <div class="widget-icon"><i class="fas fa-paper-plane"></i></div>
                <div class="widget-content">
                    <h3>Postulaciones Activas</h3>
                    <div class="widget-value"><?php echo $total_postulaciones; ?></div>
                </div>
            </div>
            
            <!-- Widget 3: Última Actividad -->
            <div class="widget-card">
                <div class="widget-icon"><i class="fas fa-history"></i></div>
                <div class="widget-content">
                    <h3>Última Actividad</h3>
                    <?php if ($ultima_actividad): ?>
                        <div class="widget-value" style="font-size: 1.2rem;"><?php echo ucfirst(htmlspecialchars($ultima_actividad['estado_postulacion'])); ?></div>
                        <p style="margin:5px 0 0 0; font-size: 0.85rem; color: #777;">En: <?php echo htmlspecialchars($ultima_actividad['nombre_empresa']); ?></p>
                    <?php else: ?>
                        <div class="widget-value" style="font-size: 1.2rem; color: #999;">Sin Actividad</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="search-bar-container animate fadeRight" style="animation-delay: 0.1s;">
        <h3 style="text-align: center; margin-bottom: 25px; color: var(--color-js-rojo-principal); font-weight: 700; font-size: 1.5rem;">
            Explora Vacantes
        </h3>
        <form action="dashboard.php" method="GET" class="search-layout w-100"> 
            
            <div class="row mb-3">
                <div class="col-12">
                    <input type="text" name="search" class="search-input" 
                           placeholder="Buscar vacantes por título, empresa o ubicación..."
                           value="<?php echo htmlspecialchars($termino_busqueda); ?>"
                           style="width: 100%;">
                </div>
            </div>
            
            <div class="row g-2 align-items-center">
                
                <div class="<?php echo $col_contrato; ?>">
                    <select name="contrato" class="filter-select" 
                            style="width: 100%; height: 48px;">
                        <option value="">Tipo de Contrato</option>
                        <?php $opciones_contrato = [
                            'tiempo_completo' => 'Tiempo Completo',
                            'medio_tiempo' => 'Medio Tiempo',
                            'practicas' => 'Prácticas / Pasantía',
                            'por_proyecto' => 'Por Proyecto'
                        ];
                        foreach ($opciones_contrato as $val => $label): ?>
                            <option value="<?php echo $val; ?>" <?php echo $tipo_contrato_filtro === $val ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="<?php echo $col_carrera; ?>">
                    <select name="carrera" class="filter-select" 
                            style="width: 100%; height: 48px;">
                        <option value="">Todas las Carreras</option>
                        <?php foreach ($carreras_ejemplo as $val => $label): ?>
                            <option value="<?php echo $val; ?>" <?php echo $carrera_filtro === $val ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="<?php echo $col_buscar; ?>">
                    <button type="submit" class="boton-principal search-button w-100" style="height: 48px;">Buscar</button>
                </div>

                <?php if ($show_limpiar): ?>
                <div class="col-md-2">
                    <a href="dashboard.php" class="btn-secundario-form w-100" style="height: 48px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;">
                        Limpiar
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <div class="dashboard-container animate fadeRight" style="animation-delay: 0.2s;">
        <h2 style="text-align: left; margin-bottom: 30px;">
            Vacantes Encontradas (<?php echo count($vacantes); ?>)
        </h2>

        <?php if ($error_busqueda): ?>
            <div class='mensaje error'><?php echo $error_busqueda; ?></div>
        <?php elseif (count($vacantes) > 0): ?>
            <div class="job-list">
                <?php foreach ($vacantes as $vacante): ?>
                    <div class="job-card">
                        
                        <div class="job-card-header">
                            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--color-texto-principal);">
                                <?php echo htmlspecialchars($vacante['titulo']); ?>
                            </h2>
                            <h3 style="font-size: 1rem; color: var(--color-js-rojo-principal); font-weight: 500; margin-top: 5px;">
                                <?php echo htmlspecialchars($vacante['nombre_empresa']); ?>
                            </h3>
                        </div>
                        
                        <div class="job-card-body">
                            <div class="job-card-tags" style="margin-bottom: 15px;">
                                <?php 
                                    $tags = [
                                        $vacante['tipo_contrato'],
                                        $vacante['modalidad']
                                    ];
                                    foreach ($tags as $tag_val): 
                                        $clase = ($tag_val === $vacante['tipo_contrato']) ? 'tag-contrato' : '';
                                ?>
                                    <span class="tag <?php echo $clase; ?>"><?php echo formatear_tag($tag_val); ?></span>
                                <?php endforeach; ?>
                            </div>
                            
                            <p style="margin-top: 15px; font-size: 0.95rem; color: var(--color-texto-secundario);">
                                <i class="fas fa-map-marker-alt" style="color: var(--color-js-rojo-secundario);"></i> Ubicación: <?php echo htmlspecialchars($vacante['ubicacion']); ?>
                            </p>
                            <p style="font-size: 0.95rem; color: var(--color-texto-secundario);">
                                <i class="far fa-calendar-alt" style="color: var(--color-js-rojo-secundario);"></i> Publicado: <?php echo date('d/M/Y', strtotime($vacante['fecha_publicacion'])); ?>
                            </p>
                        </div>
                        
                        <div class="job-card-footer">
                            <span style="color: var(--color-js-rojo-principal); font-weight: 700;">
                                ¡Aplica antes de que sea tarde!
                            </span>
                            
                            <a href="detalle_vacante.php?id=<?php echo $vacante['id_vacante']; ?>" 
                               class="boton-principal-sm">
                                <i class="fas fa-arrow-right"></i> Ver Detalle
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="job-card-empty">
                <h2>No se encontraron vacantes.</h2>
                <p>Intenta una búsqueda diferente o revisa más tarde.</p>
            </div>
        <?php endif; ?>
        
    </div>

</body>
</html>
