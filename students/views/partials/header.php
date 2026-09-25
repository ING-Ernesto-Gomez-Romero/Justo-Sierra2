<?php
// Evitar iniciar sesión si ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nombre_alumno = $_SESSION['nombre_alumno'] ?? 'Alumno';
$foto_perfil = $_SESSION['foto_perfil'] ?? null;
?>

<style>
    /* Estilos del Header Institucional Premium */
    .premium-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        /* Gradiente oficial con ligera transparencia para el glassmorphism */
        background: linear-gradient(60deg, rgba(230, 0, 19, 0.95) 0%, rgba(230, 0, 19, 0.90) 65%, rgba(252, 200, 0, 0.95) 100%);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0 20px;
        box-shadow: 0 4px 20px rgba(230, 0, 19, 0.25);
    }

    .header-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 70px;
    }

    .header-brand {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: white;
        font-weight: 700;
        font-size: 1.3rem;
    }

    .header-brand span {
        font-weight: 900;
        margin-left: 5px;
    }

    .header-nav {
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: color 0.2s ease;
        position: relative;
    }

    .nav-link:hover {
        color: white;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: white;
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    /* Menú del Usuario (Dropdown) */
    .user-menu {
        position: relative;
        cursor: pointer;
    }

    .user-profile-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 10px;
        border-radius: 30px;
        background: transparent;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }

    .user-profile-btn:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .user-avatar-placeholder {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--color-js-rojo-principal, #E60013), var(--color-js-amarillo, #FCC800));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        border: 2px solid white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .user-name {
        font-weight: 600;
        color: white;
        font-size: 0.95rem;
    }

    /* Dropdown Content */
    .dropdown-content {
        display: none;
        position: absolute;
        top: 110%;
        right: 0;
        background: white;
        min-width: 200px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
        animation: fadeIn 0.2s ease;
    }

    .dropdown-content.show {
        display: block;
    }

    .dropdown-item {
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--color-texto-secundario, #555);
        text-decoration: none;
        transition: background 0.2s ease;
        font-size: 0.9rem;
    }

    .dropdown-item:hover {
        background: rgba(0,0,0,0.02);
        color: var(--color-js-rojo-principal, #E60013);
    }

    .dropdown-divider {
        height: 1px;
        background: rgba(0,0,0,0.05);
        margin: 5px 0;
    }

    .text-danger {
        color: #e74c3c !important;
    }

    .text-danger:hover {
        background: #fdedec;
    }

    /* Mobile Menu Toggle */
    .mobile-menu-btn {
        display: none;
        font-size: 1.5rem;
        color: white;
        background: none;
        border: none;
        cursor: pointer;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsividad */
    @media (max-width: 768px) {
        .mobile-menu-btn {
            display: block;
        }

        .header-nav {
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            background: linear-gradient(180deg, rgba(230,0,19,0.95) 0%, rgba(252,200,0,0.95) 100%);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            flex-direction: column;
            gap: 0;
            box-shadow: 0 10px 15px rgba(0,0,0,0.05);
            clip-path: polygon(0 0, 100% 0, 100% 0, 0 0); /* Oculto por defecto */
            transition: clip-path 0.3s ease;
        }

        .header-nav.active {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);
        }

        .nav-link {
            width: 100%;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .user-menu {
            width: 100%;
            padding: 15px 20px;
        }
        
        .dropdown-content {
            position: static;
            box-shadow: none;
            border: none;
            background: #f9f9f9;
        }
    }
</style>

<header class="premium-header">
    <div class="header-container">
        <!-- Logo -->
        <a href="dashboard.php" class="header-brand">
            Bolsa de Trabajo <span>Justo Sierra</span>
        </a>

        <!-- Botón Móvil -->
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Enlaces y Usuario -->
        <nav class="header-nav" id="headerNav">
            <a href="dashboard.php" class="nav-link">Inicio</a>
            <a href="mis_postulaciones.php" class="nav-link">Mis Postulaciones</a>
            <a href="carga_documentos.php" class="nav-link">Documentos</a>

            <div class="user-menu" id="userMenuBtn">
                <div class="user-profile-btn">
                    <div class="user-name">Hola, <?php echo htmlspecialchars(explode(' ', $nombre_alumno)[0]); ?></div>
                    <?php if (!empty($foto_perfil)): ?>
                        <img src="../uploads/perfiles/<?php echo htmlspecialchars($foto_perfil); ?>" alt="Avatar" class="user-avatar">
                    <?php else: ?>
                        <div class="user-avatar-placeholder"><i class="fas fa-user"></i></div>
                    <?php endif; ?>
                    <i class="fas fa-chevron-down" style="font-size: 0.8rem; color: rgba(255,255,255,0.8);"></i>
                </div>
                
                <div class="dropdown-content" id="userDropdown">
                    <a href="perfil_alumno.php" class="dropdown-item">
                        <i class="fas fa-user-circle"></i> Mi Perfil
                    </a>
                    <a href="actualizar_perfil.php" class="dropdown-item">
                        <i class="fas fa-cog"></i> Configuración
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="../logout.php" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Toggle Mobile Menu
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const headerNav = document.getElementById('headerNav');
        const icon = mobileBtn.querySelector('i');

        mobileBtn.addEventListener('click', function() {
            headerNav.classList.toggle('active');
            if(headerNav.classList.contains('active')){
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Toggle User Dropdown
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');

        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        // Cerrar dropdown al hacer click fuera
        document.addEventListener('click', function() {
            if(userDropdown.classList.contains('show')) {
                userDropdown.classList.remove('show');
            }
        });
    });
</script>
