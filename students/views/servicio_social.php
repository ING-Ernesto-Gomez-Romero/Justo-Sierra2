<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trámite de Servicio Social</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Google Fonts & Font Awesome para iconografía y tipografía premium -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --color-js-rojo: #E60013;
            --color-js-rojo-dark: #b3000f;
            --color-js-amarillo: #FCC800;
            --bg-gradient: linear-gradient(135deg, #f6f8f9 0%, #e5ebee 100%);
            --card-bg: #ffffff;
            --text-main: #2c3e50;
            --text-muted: #7f8c8d;
        }

        body { 
            background: var(--bg-gradient) !important; 
            font-family: 'Outfit', sans-serif !important;
            color: var(--text-main);
            margin: 0;
            min-height: 100vh;
        }
        
        /* ESTILOS ELIMINADOS: Navbar ahora se importa de header.php */
        .ss-container { 
            max-width: 900px; 
            margin: 50px auto; 
            padding: 45px; 
            background: var(--card-bg) !important; 
            border-radius: 20px; 
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05), 0 5px 15px rgba(0,0,0,0.03); 
            border-top: 6px solid var(--color-js-rojo);
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .ss-header {
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f2f5;
        }

        .ss-container h2 { 
            color: var(--text-main) !important; 
            margin-top: 0; 
            margin-bottom: 15px; 
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .ss-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            font-size: 1.1rem;
        }
        
        .ss-meta div {
            background: #f8f9fa;
            padding: 10px 20px;
            border-radius: 8px;
            border-left: 4px solid var(--color-js-amarillo);
        }
        
        .ss-meta span.label { color: var(--text-muted); font-size: 0.95rem; display: block; margin-bottom: 4px;}
        .ss-meta span.value { color: var(--color-js-rojo); font-weight: 600; }

        .reglas { 
            background: linear-gradient(120deg, rgba(252, 200, 0, 0.08), rgba(252, 200, 0, 0.15)) !important; 
            border-left: 5px solid var(--color-js-amarillo); 
            padding: 25px 30px; 
            margin-bottom: 40px; 
            border-radius: 0 12px 12px 0; 
            box-shadow: 0 4px 15px rgba(252, 200, 0, 0.05);
        }
        .reglas h3 { color: #b38f00 !important; margin-top: 0; font-size: 1.3rem; display: flex; align-items: center; gap: 10px; margin-bottom: 15px;}
        .reglas ul { padding-left: 20px; margin-bottom: 0; line-height: 1.7;}
        .reglas li { margin-bottom: 10px; color: var(--text-main) !important; font-size: 1.05rem;}

        .etapa { 
            background: #ffffff;
            border: 2px solid #f0f2f5 !important; 
            padding: 35px; 
            margin-bottom: 30px; 
            border-radius: 16px; 
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            position: relative;
            overflow: hidden;
        }
        
        .etapa:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.06);
            border-color: #e2e6ea !important;
        }

        .etapa.activa { 
            border-color: rgba(230, 0, 19, 0.2) !important; 
            background: linear-gradient(to bottom right, #ffffff, rgba(230, 0, 19, 0.02)) !important; 
            box-shadow: 0 8px 30px rgba(230, 0, 19, 0.08); 
        }
        
        .etapa.activa::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 6px; height: 100%;
            background: var(--color-js-rojo);
            border-radius: 16px 0 0 16px;
        }

        .etapa h3 { 
            margin-top: 0; 
            color: var(--color-js-rojo) !important; 
            font-size: 1.5rem;
            font-weight: 700; 
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .etapa p { line-height: 1.6; font-size: 1.05rem; color: #4b5563; }

        .btn-action { 
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--color-js-rojo) 0%, var(--color-js-rojo-dark) 100%); 
            color: #fff !important; 
            padding: 14px 28px; 
            border: none; 
            border-radius: 10px; 
            cursor: pointer; 
            font-weight: 600; 
            font-size: 1.05rem; 
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); 
            text-decoration: none;
            box-shadow: 0 6px 15px rgba(230, 0, 19, 0.25);
            margin-top: 15px;
        }
        
        .btn-action:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 10px 25px rgba(230, 0, 19, 0.35); 
            background: linear-gradient(135deg, var(--color-js-rojo-dark) 0%, var(--color-js-rojo) 100%);
        }

        .btn-action i { font-size: 1.2rem; }

        .alerta { 
            background: rgba(230, 0, 19, 0.06); 
            color: var(--color-js-rojo-dark); 
            padding: 18px 24px; 
            border-radius: 10px; 
            margin-top: 25px; 
            font-weight: 500; 
            border-left: 4px solid var(--color-js-rojo);
            display: flex;
            align-items: flex-start;
            gap: 15px;
            line-height: 1.6;
        }
        
        .alerta i { margin-top: 4px; font-size: 1.3rem; color: var(--color-js-rojo); }
        
        .status-success {
            color: #1e8449 !important;
            background: rgba(39, 174, 96, 0.12);
            padding: 12px 20px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 1.05rem;
            margin-bottom: 20px;
            border: 1px solid rgba(39, 174, 96, 0.2);
        }
        
        .status-success i { font-size: 1.2rem; }

    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <div class="ss-container">
        <div class="ss-header">
            <h2>Trámite de Servicio Social</h2>
            <div class="ss-meta">
                <div>
                    <span class="label">Empresa</span>
                    <span class="value"><?= htmlspecialchars($postulacion['nombre_empresa'] ?? '') ?></span>
                </div>
                <div>
                    <span class="label">Vacante</span>
                    <span class="value"><?= htmlspecialchars($postulacion['titulo'] ?? '') ?></span>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['demo_document'])): ?>
            <div class="alerta">
                <i class="fas fa-circle-info"></i>
                <div><strong>Modo demostración:</strong> el trámite fue registrado, pero los documentos institucionales privados no se incluyen en este repositorio público.</div>
            </div>
        <?php endif; ?>

        <!-- Panel de Instrucciones y Lineamientos -->
        <div class="reglas">
            <h3><i class="fas fa-clipboard-list"></i> Lineamientos Institucionales</h3>
            <ul>
                <li>El Servicio Social se realiza en un lapso mínimo de 6 meses y máximo de 2 años.</li>
                <li>Se deben cubrir un total de 480 horas en la Ciudad de México o 600 horas en cualquier Estado de la República.</li>
                <li>Es importante no tener adeudos Administrativos para poder realizar el trámite.</li>
                <li>Si el Servicio Social es cancelado por la empresa, se someterá a revisión y el alumno puede ser acreedor a una sanción de entre 3 y 6 meses antes de poder reiniciar el trámite.</li>
            </ul>
        </div>

        <?php $estado = $tramite['estado_tramite'] ?? null; ?>

        <!-- Módulo 1: Carta de Presentación y Créditos -->
        <div class="etapa <?= !$estado || $estado === 'solicitud_creditos' ? 'activa' : '' ?>">
            <h3><i class="fas fa-file-invoice"></i> Módulo 1: Carta de Créditos</h3>
            <?php if (!$estado): ?>
                <form method="POST" target="_blank">
                    <?= Security::getCsrfInput() ?>
                    <input type="hidden" name="accion" value="iniciar_tramite">
                    <p>Para iniciar tu trámite, descarga la <strong>Carta de Créditos</strong>. Al descargarla, el sistema registrará el inicio de tu trámite.</p>
                    <button type="submit" class="btn-action"><i class="fas fa-file-download"></i> Descargar Carta de Créditos</button>
                </form>
                <div class="alerta">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Aviso Importante:</strong> Este documento debe imprimirse físicamente para realizar el pago en Cajas antes de continuar con los documentos de Servicio Social.
                    </div>
                </div>
            <?php else: ?>
                <div class="status-success"><i class="fas fa-check-circle"></i> Trámite iniciado correctamente</div>
                <p>Ya puedes descargar nuevamente tu Carta de Créditos si lo necesitas.</p>
                <span class="btn-action" title="Documento privado excluido de la demo">
                    <i class="fas fa-lock"></i> Documento no incluido en la demo
                </span>
                
                <?php if ($estado === 'solicitud_creditos'): ?>
                    <div class="alerta">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Acción Pendiente:</strong> Realiza el pago en Cajas. Una vez que Servicios Escolares valide tu pago en el sistema, se desbloqueará el documento final de Servicio Social.
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Módulo 2: Documento de Servicio Social (Desbloqueado tras el pago) -->
        <?php if ($estado && $estado !== 'solicitud_creditos'): ?>
        <div class="etapa activa">
            <h3><i class="fas fa-file-signature"></i> Módulo 2: Documento de Servicio Social</h3>
            <div class="status-success"><i class="fas fa-check-double"></i> Tu pago ha sido validado por Servicios Escolares.</div>
            <p>Ya puedes descargar tu formato oficial de Servicio Social para continuar con tu proceso en la empresa.</p>
            <span class="btn-action" title="Documento privado excluido de la demo">
                <i class="fas fa-lock"></i> Documento no incluido en la demo
            </span>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
