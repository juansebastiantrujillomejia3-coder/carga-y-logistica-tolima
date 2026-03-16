<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Consultar Envío | Sistema Logístico</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        html{
    font-size: 18px;
}

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 20px;
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 16px;
        }

        .container {
            width: 100%;
            max-width: 760px;
        }

        /* --- Header --- */
        .header {
            background: linear-gradient(135deg, #ffaa00 0%, #ffaa00 100%);
            border-radius: 12px 12px 0 0;
            padding: 28px 32px;
            color: #fff;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 0.9rem;
            opacity: 0.85;
        }

        /* --- Card --- */
        .card {
            background: #fff;
            border-radius: 0 0 12px 12px;
            padding: 32px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.10);
        }

        /* --- Search form --- */
        .search-form {
            display: flex;
            gap: 12px;
            margin-bottom: 28px;
        }

        .search-form input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #cbd5e1;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .search-form input:focus {
            outline: none;
            border-color: #ffa600;
        }

        .search-form button {
            padding: 12px 28px;
            background: #ffbb00;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            white-space: nowrap;
        }

        .search-form button:hover  { background: #ffcc00; }
        .search-form button:active { transform: scale(0.98); }
        .search-form button:disabled { background: #94a3b8; cursor: not-allowed; }

        /* --- Alerts --- */
        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.95rem;
            display: none;
        }

        .alert.show { display: block; }
        .alert-error   { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
        .alert-warning { background: #fef3c7; color: #92400e; border-left: 4px solid #f59e0b; }
        .alert-success { background: #dcfce7; color: #166534; border-left: 4px solid #22c55e; }

        /* --- Result card --- */
        #resultado { display: none; }

        .result-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid #e2e8f0;
        }

        .guia-badge {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a3c5e;
            letter-spacing: 2px;
        }

        .estado-badge {
            padding: 5px 14px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .estado-pendiente   { background: #fef3c7; color: #b45309; }
        .estado-en_transito { background: #dbeafe; color: #d8871d; }
        .estado-entregado   { background: #dcfce7; color: #15803d; }
        .estado-devuelto    { background: #fce7f3; color: #9d174d; }
        .estado-cancelado   { background: #f1f5f9; color: #475569; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 540px) {
            .info-grid { grid-template-columns: 1fr; }
            .search-form { flex-direction: column; }
        }

        .info-item label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #ffaa00;
            margin-bottom: 4px;
        }

        .info-item span {
            font-size: 1.2rem;
            color: #ff8c00;
            font-weight: 500;
        }

        .info-item.full-width { grid-column: 1 / -1; }

        /* --- Route visual --- */
        .route-bar {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .route-city { font-weight: 700; color: #1a3c5e; font-size: 1rem; }
        .route-arrow { flex: 1; text-align: center; color: #94a3b8; font-size: 1.4rem; }

        /* --- Spinner --- */
        .spinner {
            width: 20px; height: 20px;
            border: 3px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: inline-block;
            vertical-align: middle;
            margin-right: 6px;
        }

        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="container">

        <!-- Header -->
        <div class="header">
            <h1>📦 Consultar Envío</h1>
            <p>Ingrese el número de guía para obtener la información del envío</p>
        </div>

        <!-- Card principal -->
        <div class="card">

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
            </div>

        </div><!-- /.card -->
    </div><!-- /.container -->

    <script>
        // Permitir buscar con Enter
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
            return d.toLocaleDateString('es-CO', { year:'numeric', month:'long', day:'2-digit' });
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

            // Estado de carga
            btnEl.disabled   = true;
            btnEl.innerHTML  = '<span class="spinner"></span> Buscando...';

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

                // [HU-65-3] Acceso sin autenticación
                if (response.status === 401) {
                    mostrarAlerta('error', '🔒 Acceso denegado. Debe iniciar sesión para consultar envíos.');
                    setTimeout(() => { window.location.href = '/login'; }, 2000);
                    return;
                }

                const json = await response.json();

                // [HU-65-2] Envío no encontrado
                if (response.status === 404) {
                    mostrarAlerta('warning', `📭 ${json.message}`);
                    return;
                }

                if (!response.ok) {
                    mostrarAlerta('error', json.message ?? 'Ocurrió un error inesperado. Intente más tarde.');
                    return;
                }

                // [HU-65-1] Mostrar resultado
                const d = json.data;
                document.getElementById('resGuia').textContent       = d.numero_guia;
                document.getElementById('resEstado').textContent     = estadoLabel(d.estado);
                document.getElementById('resEstado').className       = `estado-badge estado-${d.estado}`;
                document.getElementById('resOrigen').textContent     = d.ciudad_origen;
                document.getElementById('resDestino').textContent    = d.ciudad_destino;
                document.getElementById('resRemitente').textContent  = d.remitente;
                document.getElementById('resDestinatario').textContent = d.destinatario;
                document.getElementById('resDireccion').textContent  = d.direccion_destino;
                document.getElementById('resFechaReg').textContent   = formatFecha(d.fecha_registro);
                document.getElementById('resFechaEst').textContent   = formatFecha(d.fecha_entrega_est);
                document.getElementById('resPeso').textContent       = d.peso_kg ? `${d.peso_kg} kg` : '—';

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

        // Helper: obtener token del localStorage (o adaptar a tu mecanismo de auth)
        function getToken() {
            return localStorage.getItem('auth_token') ?? '';
        }
    </script>
</body>
</html>
