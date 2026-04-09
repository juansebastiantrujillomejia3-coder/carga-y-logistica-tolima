<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Consultar Envío | Sistema Logístico</title>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --naranja:     #F5A623;
            --naranja-dark:#D4881A;
            --rojo:        #E8431A;
            --rojo-dark:   #C2350F;
            --gris-oscuro: #1A1A1A;
            --gris-medio:  #2D2D2D;
            --gris-claro:  #F7F7F7;
            --blanco:      #FFFFFF;
            --texto:       #333333;
            --borde:       #E0E0E0;
            --sombra:      0 4px 24px rgba(0,0,0,0.10);
        }
 
        * { box-sizing: border-box; margin: 0; padding: 0; }
 
        body {
            font-family: 'Barlow', sans-serif;
            background: var(--gris-claro);
            min-height: 100vh;
            color: var(--texto);
        }
 
        /* ── HEADER ── */
        .header {
            background: var(--gris-oscuro);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
        }
 
        .header-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: stretch;
            gap: 0;
        }
 
        .logo-band {
            background: linear-gradient(135deg, var(--naranja) 0%, var(--rojo) 100%);
            padding: 14px 40px 14px 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            clip-path: polygon(0 0, 100% 0, 92% 100%, 0 100%);
        }
 
        .logo-icon { width: 38px; height: 38px; }
 
        .logo-text {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            color: white;
            letter-spacing: 1px;
        }
 
        .header-title {
            padding: 14px 24px;
            display: flex;
            align-items: center;
        }


        /* ── NAV ── */
        .header-nav {
            margin-left: auto;
            display: flex;
            align-items: stretch;
            gap: 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 0 20px;
            color: #aaa;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
            border-bottom: 3px solid transparent;
            transition: color 0.2s, border-color 0.2s, background 0.2s;
        }

        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.05);
            border-bottom-color: var(--naranja);
        }

        .nav-link.active {
            color: var(--naranja);
            border-bottom-color: var(--naranja);
        }

        @media (max-width: 700px) {
        .header-nav { display: none; } /* opcional: ocultar en móvil */
        }

        

        
 
        .header-title span {
            color: var(--naranja);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
 
        /* ── HERO ── */
        .hero {
            background: linear-gradient(135deg, var(--gris-oscuro) 0%, var(--gris-medio) 100%);
            border-bottom: 3px solid var(--naranja);
            padding: 32px 24px;
        }
 
        .hero-inner {
            max-width: 760px;
            margin: 0 auto;
        }
 
        .hero h1 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            color: white;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
 
        .hero h1 span { color: var(--naranja); }
 
        .hero p {
            color: #aaa;
            font-size: 0.9rem;
            margin-top: 6px;
        }
 
        /* ── MAIN ── */
        .main {
            max-width: 760px;
            margin: 32px auto;
            padding: 0 24px 60px;
        }
 
        /* ── CARD ── */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--sombra);
            overflow: hidden;
        }
 
        .card-body { padding: 28px; }
 
        /* ── SEARCH FORM ── */
        .search-form {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }
 
        .search-form input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid var(--borde);
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Barlow', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--texto);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
 
        .search-form input:focus {
            outline: none;
            border-color: var(--naranja);
            box-shadow: 0 0 0 3px rgba(245,166,35,0.15);
        }
 
        .search-form button {
            padding: 12px 28px;
            background: linear-gradient(135deg, var(--naranja) 0%, var(--rojo) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            box-shadow: 0 4px 16px rgba(232,67,26,0.3);
            white-space: nowrap;
        }
 
        .search-form button:hover   { opacity: 0.92; }
        .search-form button:active  { transform: scale(0.98); }
        .search-form button:disabled { opacity: 0.5; cursor: not-allowed; }
 
        /* ── ALERTS ── */
        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.93rem;
            display: none;
            align-items: center;
            gap: 10px;
        }
 
        .alert.show      { display: flex; }
        .alert-error     { background: #fff0ee; color: #c0392b; border-left: 4px solid var(--rojo); }
        .alert-warning   { background: #fffbf0; color: #8a6000; border-left: 4px solid var(--naranja); }
        .alert-success   { background: #f0fff4; color: #1a7a3c; border-left: 4px solid #2ecc71; }
 
        /* ── RESULTADO ── */
        #resultado { display: none; }
 
        .result-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid var(--borde);
        }
 
        .guia-badge {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--gris-oscuro);
            letter-spacing: 3px;
        }
 
        .estado-badge {
            padding: 5px 14px;
            border-radius: 999px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
 
        .estado-pendiente   { background: #fffbf0; color: #8a6000;  border: 1px solid var(--naranja); }
        .estado-en_transito { background: #fff0ee; color: var(--rojo); border: 1px solid var(--rojo); }
        .estado-entregado   { background: #f0fff4; color: #1a7a3c;  border: 1px solid #2ecc71; }
        .estado-devuelto    { background: #fce7f3; color: #9d174d;  border: 1px solid #ec4899; }
        .estado-cancelado   { background: #f1f5f9; color: #475569;  border: 1px solid #94a3b8; }
 
        /* ── ROUTE BAR ── */
        .route-bar {
            background: var(--gris-oscuro);
            border-radius: 8px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
 
        .route-city {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            color: white;
            font-size: 1.1rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
 
        .route-arrow {
            flex: 1;
            text-align: center;
            color: var(--naranja);
            font-size: 1.6rem;
        }
 
        /* ── INFO GRID ── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
 
        .info-item label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #888;
            margin-bottom: 4px;
        }
 
        .info-item span {
            font-size: 0.97rem;
            color: var(--gris-oscuro);
            font-weight: 500;
        }
 
        .info-item.full-width { grid-column: 1 / -1; }
 
        /* ── SPINNER ── */
        .spinner {
            width: 18px; height: 18px;
            border: 3px solid rgba(255,255,255,0.4);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: inline-block;
            vertical-align: middle;
            margin-right: 6px;
        }
 
        @keyframes spin { to { transform: rotate(360deg); } }
 
        @media (max-width: 540px) {
            .info-grid   { grid-template-columns: 1fr; }
            .search-form { flex-direction: column; }
            .hero h1     { font-size: 2rem; }
        }
    </style>
</head>
<body>
 
    <!-- HEADER -->
<header class="header">
    <div class="header-inner">
        <div class="logo-band">
            <svg class="logo-icon" viewBox="0 0 60 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="2"  y="4"  width="32" height="8"  rx="4" fill="white" opacity="0.9"/>
                <rect x="4"  y="16" width="28" height="8"  rx="4" fill="white" opacity="0.9"/>
                <rect x="8"  y="28" width="20" height="8"  rx="4" fill="white" opacity="0.7"/>
                <rect x="36" y="4"  width="22" height="10" rx="5" fill="white"/>
                <rect x="36" y="18" width="20" height="8"  rx="4" fill="white"/>
                <circle cx="42" cy="34" r="5" fill="white"/>
                <circle cx="54" cy="34" r="5" fill="white"/>
            </svg>
            <span class="logo-text">carga y logistica tolima</span>
        </div>
        <div class="header-title">
            <span>Sistema de Guías</span>
        </div>

        <!-- MENÚ DE NAVEGACIÓN -->
        <nav class="header-nav">
            <a href="/guias/registrar" class="nav-link {{ request()->is('guias/registrar') ? 'active' : '' }}">
                ✏️ Registrar Guía
            </a>
            <a href="/envios/consultar" class="nav-link {{ request()->is('envios/consultar') ? 'active' : '' }}">
                🔍 Consultar Envío
            </a>
        </nav>
    </div>
</header>
 
    <!-- HERO -->
    <div class="hero">
        <div class="hero-inner">
            <h1>Consultar <span>Envío</span></h1>
            <p>Ingrese el número de guía para obtener la información del envío</p>
        </div>
    </div>
 
    <!-- MAIN -->
    <main class="main">
        <div class="card">
            <div class="card-body">
 
                <!-- Formulario de búsqueda -->
                <div class="search-form">
                    <input
                        type="text"
                        id="inputGuia"
                        placeholder="Ej: GU-2024-00123"
                        maxlength="50"
                        autocomplete="off"
                    />
                    <button id="btnBuscar" onclick="buscarEnvio()">
                        🔍 Buscar
                    </button>
                </div>
 
                <!-- Alertas -->
                <div id="alertError"   class="alert alert-error"></div>
                <div id="alertWarning" class="alert alert-warning"></div>
                <div id="alertSuccess" class="alert alert-success"></div>
 
                <!-- Resultado -->
                <div id="resultado">
                    <div class="result-header">
                        <span class="guia-badge" id="resGuia"></span>
                        <span class="estado-badge" id="resEstado"></span>
                    </div>
 
                    <!-- Ruta origen → destino -->
                    <div class="route-bar">
                        <span class="route-city" id="resOrigen"></span>
                        <span class="route-arrow">→</span>
                        <span class="route-city" id="resDestino"></span>
                    </div>
 
                    <!-- Grilla de información -->
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Remitente</label>
                            <span id="resRemitente"></span>
                        </div>
                        <div class="info-item">
                            <label>Destinatario</label>
                            <span id="resDestinatario"></span>
                        </div>
                        <div class="info-item full-width">
                            <label>Dirección de destino</label>
                            <span id="resDireccion"></span>
                        </div>
                        <div class="info-item">
                            <label>Fecha de registro</label>
                            <span id="resFechaReg"></span>
                        </div>
                        <div class="info-item">
                            <label>Entrega estimada</label>
                            <span id="resFechaEst"></span>
                        </div>
                        <div class="info-item">
                            <label>Peso (kg)</label>
                            <span id="resPeso"></span>
                        </div>
                        <div class="info-item full-width" id="itemDescripcion">
                            <label>Descripción</label>
                            <span id="resDescripcion"></span>
                        </div>
                    </div>
                </div><!-- /#resultado -->
 
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </main>
 
    <script>
        // Buscar con Enter
        document.getElementById('inputGuia').addEventListener('keydown', function (e) {
            if (e.key === 'Enter') buscarEnvio();
        });
 
        function ocultarAlertas() {
            ['alertError', 'alertWarning', 'alertSuccess'].forEach(id => {
                const el = document.getElementById(id);
                el.classList.remove('show');
                el.textContent = '';
            });
        }
 
        function mostrarAlerta(tipo, mensaje) {
            const idMap = { error: 'alertError', warning: 'alertWarning', success: 'alertSuccess' };
            const el = document.getElementById(idMap[tipo]);
            el.textContent = mensaje;
            el.classList.add('show');
        }
 
        function formatFecha(val) {
            if (!val) return '—';
            const d = new Date(val);
            return d.toLocaleDateString('es-CO', { year: 'numeric', month: 'long', day: '2-digit' });
        }
 
        function estadoLabel(estado) {
            const map = {
                pendiente:   'Pendiente',
                en_transito: 'En tránsito',
                entregado:   'Entregado',
                devuelto:    'Devuelto',
                cancelado:   'Cancelado',
            };
            return map[estado] ?? estado;
        }
 
        async function buscarEnvio() {
            const inputEl = document.getElementById('inputGuia');
            const btnEl   = document.getElementById('btnBuscar');
            const guia    = inputEl.value.trim().toUpperCase();
 
            ocultarAlertas();
            document.getElementById('resultado').style.display = 'none';
 
            if (!guia) {
                mostrarAlerta('warning', '⚠️ Por favor ingrese un número de guía para realizar la búsqueda.');
                inputEl.focus();
                return;
            }
 
            btnEl.disabled  = true;
            btnEl.innerHTML = '<span class="spinner"></span> Buscando...';
 
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
 
                const response = await fetch(`/api/envios/buscar?numero_guia=${encodeURIComponent(guia)}`, {
                    method:  'GET',
                    headers: {
                        'Accept':        'application/json',
                        'X-CSRF-TOKEN':  token,
                        'Authorization': `Bearer ${getToken()}`,
                    },
                });
 
                if (response.status === 401) {
                    mostrarAlerta('error', '🔒 Acceso denegado. Debe iniciar sesión para consultar envíos.');
                    setTimeout(() => { window.location.href = '/login'; }, 2000);
                    return;
                }
 
                const json = await response.json();
 
                if (response.status === 404) {
                    mostrarAlerta('warning', `📭 ${json.message}`);
                    return;
                }
 
                if (!response.ok) {
                    mostrarAlerta('error', json.message ?? 'Ocurrió un error inesperado. Intente más tarde.');
                    return;
                }
 
                const d = json.data;
                document.getElementById('resGuia').textContent         = d.numero_guia;
                document.getElementById('resEstado').textContent       = estadoLabel(d.estado);
                document.getElementById('resEstado').className         = `estado-badge estado-${d.estado}`;
                document.getElementById('resOrigen').textContent       = d.ciudad_origen;
                document.getElementById('resDestino').textContent      = d.ciudad_destino;
                document.getElementById('resRemitente').textContent    = d.remitente;
                document.getElementById('resDestinatario').textContent = d.destinatario;
                document.getElementById('resDireccion').textContent    = d.direccion_destino;
                document.getElementById('resFechaReg').textContent     = formatFecha(d.fecha_registro);
                document.getElementById('resFechaEst').textContent     = formatFecha(d.fecha_entrega_est);
                document.getElementById('resPeso').textContent         = d.peso_kg ? `${d.peso_kg} kg` : '—';
 
                const descripEl = document.getElementById('itemDescripcion');
                if (d.descripcion) {
                    document.getElementById('resDescripcion').textContent = d.descripcion;
                    descripEl.style.display = 'block';
                } else {
                    descripEl.style.display = 'none';
                }
 
                document.getElementById('resultado').style.display = 'block';
                mostrarAlerta('success', '✅ Envío encontrado correctamente.');
 
            } catch (err) {
                console.error(err);
                mostrarAlerta('error', '❌ Error de conexión. Verifique su red e intente nuevamente.');
            } finally {
                btnEl.disabled  = false;
                btnEl.innerHTML = '🔍 Buscar';
            }
        }
 
        function getToken() {
            return localStorage.getItem('auth_token') ?? '';
        }
    </script>
</body>
</html>
