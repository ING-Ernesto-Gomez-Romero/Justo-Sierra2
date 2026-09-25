<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga de Documentos - Servicio Social</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
            max-width: 800px; 
            margin: 50px auto; 
            padding: 45px; 
            background: var(--card-bg) !important; 
            border-radius: 20px; 
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05); 
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
        
        .etapa { 
            background: #ffffff;
            border: 2px solid #e2e6ea !important; 
            padding: 35px; 
            border-radius: 16px; 
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
        
        .btn-action { 
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
            color: #fff !important; 
            padding: 14px 28px; 
            border: none; 
            border-radius: 10px; 
            cursor: pointer; 
            font-weight: 600; 
            font-size: 1.05rem; 
            transition: all 0.3s ease; 
            box-shadow: 0 6px 15px rgba(16, 185, 129, 0.25);
            margin-top: 15px;
            width: 100%;
            justify-content: center;
        }
        
        .btn-action:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.35); 
        }

        .status-success {
            color: #1e8449 !important;
            background: rgba(39, 174, 96, 0.12);
            padding: 12px 20px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            margin-bottom: 20px;
            border: 1px solid rgba(39, 174, 96, 0.2);
            width: 100%;
            box-sizing: border-box;
        }

        .upload-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .upload-card {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
        }

        .upload-card:hover {
            border-color: var(--color-js-rojo);
            background: #ffffff;
            box-shadow: 0 8px 20px rgba(230,0,19,0.06);
            transform: translateY(-2px);
        }

        .upload-icon {
            font-size: 2.5rem;
            color: var(--color-js-amarillo);
            margin-bottom: 15px;
        }

        .upload-card label {
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
            display: block;
            font-size: 1.1rem;
        }

        .upload-card p.hint {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .upload-card input[type="file"] {
            width: 100%;
            cursor: pointer;
            padding: 10px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            box-sizing: border-box;
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            .upload-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <div class="ss-container">
        <div class="ss-header">
            <h2>Carga de Documentos</h2>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Aquí podrás subir los documentos requeridos firmados y sellados por la empresa para validar tu proceso de Servicio Social.</p>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div class="status-success"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <div class="etapa">
            <h3><i class="fas fa-file-upload"></i> Subir Archivos Requeridos</h3>
            
            <form action="carga_documentos.php" method="POST" enctype="multipart/form-data">
                <div class="upload-grid">
                    <div class="upload-card">
                        <i class="fas fa-file-contract upload-icon"></i>
                        <label>Carta de Aceptación</label>
                        <p class="hint">Documento oficial firmado y sellado por la empresa. Formato PDF.</p>
                        <input type="file" name="carta_aceptacion" accept=".pdf" required>
                    </div>

                    <div class="upload-card">
                        <i class="fas fa-project-diagram upload-icon"></i>
                        <label>Plan de Trabajo</label>
                        <p class="hint">Cronograma de actividades a realizar en la empresa. Formato PDF.</p>
                        <input type="file" name="plan_trabajo" accept=".pdf" required>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 15px;">
                    <button type="submit" class="btn-action" style="padding: 15px 40px; font-size: 1.15rem; border-radius: 30px; width: auto;">
                        <i class="fas fa-cloud-upload-alt"></i> Confirmar Carga de Documentos
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
