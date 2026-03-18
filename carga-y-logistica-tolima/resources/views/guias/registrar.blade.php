<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrar Guía | 23M&M</title>
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
            padding: 14px 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            clip-path: polygon(0 0, 100% 0, 92% 100%, 0 100%);
            padding-right: 40px;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
        }

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
            gap: 10px;
        }

        .header-title span {
            color: var(--naranja);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .header-badge {
            background: var(--rojo);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
            letter-spacing: 1px;
        }

        /* ── HERO BAND ── */
        .hero {
            background: linear-gradient(135deg, var(--gris-oscuro) 0%, var(--gris-medio) 100%);
            border-bottom: 3px solid var(--naranja);
            padding: 32px 24px;
        }

        .hero-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .hero h1 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero h1 span {
            color: var(--naranja);
        }

        .hero p {
            color: #aaa;
            font-size: 0.9rem;
            margin-top: 6px;
        }

        .hero-scrum {
            background: rgba(245,166,35,0.15);
            border: 1px solid var(--naranja);
            border-radius: 8px;
            padding: 10px 18px;
            text-align: center;
            white-space: nowrap;
        }

        .hero-scrum .scrum-id {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--naranja);
        }

        .hero-scrum .scrum-label {
            font-size: 0.75rem;
            color: #888;
        }

        /* ── MAIN LAYOUT ── */
        .main {
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 24px 60px;
        }

        /* ── ALERTS ── */
        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.93rem;
            display: none;
            align-items: center;
            gap: 12px;
        }

        .alert.show { display: flex; }
        .alert-error   { background: #fff0ee; color: #c0392b; border-left: 4px solid var(--rojo); }
        .alert-success { background: #f0fff4; color: #1a7a3c; border-left: 4px solid #2ecc71; }
        .alert-warning { background: #fffbf0; color: #8a6000; border-left: 4px solid var(--naranja); }

        /* ── FORM CARD ── */
        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--sombra);
            overflow: hidden;
        }

        /* ── SECTION HEADERS ── */
        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 28px;
            border-bottom: 1px solid var(--borde);
            background: var(--gris-claro);
        }

        .section-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .dot-orange { background: var(--naranja); }
        .dot-red    { background: var(--rojo); }
        .dot-dark   { background: var(--gris-oscuro); }
        .dot-green  { background: #2ecc71; }

        .section-header h2 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--gris-oscuro);
        }

        .section-tag {
            margin-left: auto;
            font-size: 0.7rem;
            color: #999;
            background: #eee;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }

        /* ── FORM BODY ── */
        .section-body {
            padding: 24px 28px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 18px;
        }

        .col-span-2 { grid-column: span 2; }
        .col-span-3 { grid-column: span 3; }

        @media (max-width: 700px) {
            .form-grid, .form-grid-3 { grid-template-columns: 1fr; }
            .col-span-2, .col-span-3 { grid-column: span 1; }
            .hero-inner { flex-direction: column; }
        }

        /* ── FIELDS ── */
        .field { display: flex; flex-direction: column; gap: 6px; }

        .field label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #666;
        }

        .field label .req {
            color: var(--rojo);
            margin-left: 2px;
        }

        .field input,
        .field select,
        .field textarea {
            padding: 10px 14px;
            border: 2px solid var(--borde);
            border-radius: 8px;
            font-size: 0.93rem;
            font-family: 'Barlow', sans-serif;
            color: var(--texto);
            transition: border-color 0.2s, box-shadow 0.2s;
            background: white;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            outline: none;
            border-color: var(--naranja);
            box-shadow: 0 0 0 3px rgba(245,166,35,0.15);
        }

        .field input.error,
        .field select.error {
            border-color: var(--rojo);
            box-shadow: 0 0 0 3px rgba(232,67,26,0.10);
        }

        .field-error {
            font-size: 0.75rem;
            color: var(--rojo);
            display: none;
        }

        .field-error.show { display: block; }

        .field textarea { resize: vertical; min-height: 80px; }

        /* Guía number special styling */
        #numero_guia {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gris-oscuro);
        }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: var(--borde);
            margin: 0;
        }

        /* ── ESTADO PAQUETE ── */
        .estado-options {
            display: flex;
            gap: 16px;
        }

        .estado-option {
            flex: 1;
            border: 2px solid var(--borde);
            border-radius: 10px;
            padding: 14px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .estado-option:hover { border-color: var(--naranja); }

        .estado-option input[type="radio"] { display: none; }

        .estado-option.selected-good  { border-color: #2ecc71; background: #f0fff4; }
        .estado-option.selected-bad   { border-color: var(--rojo); background: #fff0ee; }

        .estado-icon { font-size: 1.5rem; }

        .estado-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--texto);
        }

        .estado-sublabel {
            font-size: 0.75rem;
            color: #999;
        }

        /* ── TOTAL CALCULATOR ── */
        .total-box {
            background: var(--gris-oscuro);
            border-radius: 10px;
            padding: 20px 24px;
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .total-items {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .total-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .total-item-label {
            font-size: 0.7rem;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .total-item-value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
        }

        .total-final {
            text-align: right;
        }

        .total-final-label {
            font-size: 0.75rem;
            color: var(--naranja);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .total-final-value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--naranja);
        }

        /* ── SUBMIT AREA ── */
        .submit-area {
            padding: 24px 28px;
            background: var(--gris-claro);
            border-top: 1px solid var(--borde);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .submit-info {
            font-size: 0.82rem;
            color: #888;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--naranja) 0%, var(--rojo) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 40px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            box-shadow: 0 4px 16px rgba(232,67,26,0.3);
        }

        .btn-submit:hover   { opacity: 0.92; }
        .btn-submit:active  { transform: scale(0.98); }
        .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; }

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

        /* ── SUCCESS MODAL ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.show { display: flex; }

        .modal {
            background: white;
            border-radius: 16px;
            padding: 40px;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: modalIn 0.3s ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, var(--naranja), var(--rojo));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
        }

        .modal h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--gris-oscuro);
            margin-bottom: 8px;
        }

        .modal p {
            color: #666;
            font-size: 0.93rem;
            line-height: 1.5;
            margin-bottom: 8px;
        }

        .modal-guia {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--rojo);
            letter-spacing: 3px;
            margin: 16px 0;
            padding: 12px 20px;
            background: #fff0ee;
            border-radius: 8px;
            border: 2px dashed var(--rojo);
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-modal {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 1px;
            cursor: pointer;
            border: none;
            transition: opacity 0.2s;
        }

        .btn-modal:hover { opacity: 0.85; }

        .btn-nueva {
            background: linear-gradient(135deg, var(--naranja), var(--rojo));
            color: white;
        }

        .btn-ver {
            background: var(--gris-claro);
            color: var(--gris-oscuro);
            border: 2px solid var(--borde) !important;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-inner">
            <div class="logo-band">
                <!-- Logo inline SVG (camión estilizado) -->
                <svg class="logo-icon" viewBox="0 0 60 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="4" width="32" height="8" rx="4" fill="white" opacity="0.9"/>
                    <rect x="4" y="16" width="28" height="8" rx="4" fill="white" opacity="0.9"/>
                    <rect x="8" y="28" width="20" height="8" rx="4" fill="white" opacity="0.7"/>
                    <rect x="36" y="4" width="22" height="10" rx="5" fill="white"/>
                    <rect x="36" y="18" width="20" height="8" rx="4" fill="white"/>
                    <circle cx="42" cy="34" r="5" fill="white"/>
                    <circle cx="54" cy="34" r="5" fill="white"/>
                </svg>
                <span class="logo-text">carga y logistica tolima</span>
            </div>
            <div class="header-title">
                <span>Sistema de Guías</span>
                <span class="header-badge">SCRUM-6</span>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <div class="hero">
        <div class="hero-inner">
            <div>
                <h1>Registro de <span>Guía</span><br>de Envío</h1>
                <p>Vincula una nueva guía a la planilla 23M&M correspondiente</p>
            </div>
            <div class="hero-scrum">
                <div class="scrum-id">SCRUM-6</div>
                <div class="scrum-label">Historia de Usuario</div>
                <div class="scrum-label">Sprint 1 · In Progress</div>
            </div>
        </div>
    </div>

    <!-- MAIN -->
    <main class="main">

        <!-- Alertas globales -->
        <div id="alertError"   class="alert alert-error">
            <span>⚠️</span><span id="alertErrorMsg"></span>
        </div>
        <div id="alertSuccess" class="alert alert-success">
            <span>✅</span><span id="alertSuccessMsg"></span>
        </div>

        <div class="form-card">

            <!-- ── SECCIÓN 1: DATOS DE LA GUÍA ── -->
            <div class="section-header">
                <span class="section-dot dot-orange"></span>
                <h2>Datos de la Guía</h2>
                <span class="section-tag">CA1 · CA2 · CA4</span>
            </div>
            <div class="section-body">
                <div class="form-grid">
                    <div class="field">
                        <label>Número de Guía <span class="req">*</span></label>
                        <input type="text" id="numero_guia" placeholder="300004299741" maxlength="20" autocomplete="off"/>
                        <span class="field-error" id="err_numero_guia"></span>
                    </div>
                    <div class="field">
                        <label>Planilla 23M&M <span class="req">*</span></label>
                        <select id="planilla_id">
                            <option value="">Cargando planillas...</option>
                        </select>
                        <span class="field-error" id="err_planilla_id"></span>
                    </div>
                    <div class="field">
                        <label>Fecha de Admisión <span class="req">*</span></label>
                        <input type="datetime-local" id="fecha_admision"/>
                        <span class="field-error" id="err_fecha_admision"></span>
                    </div>
                    <div class="field">
                        <label>Referencia / RFT</label>
                        <input type="text" id="referencia" placeholder="RFT1191935"/>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- ── SECCIÓN 2: REMITENTE ── -->
            <div class="section-header">
                <span class="section-dot dot-orange"></span>
                <h2>Remitente</h2>
                <span class="section-tag">Origen</span>
            </div>
            <div class="section-body">
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Nombre / Empresa <span class="req">*</span></label>
                        <input type="text" id="remitente_nombre" placeholder="BANCO COLPATRIA RED MULTIBANCA PISO 14"/>
                        <span class="field-error" id="err_remitente_nombre"></span>
                    </div>
                    <div class="field col-span-2">
                        <label>Dirección <span class="req">*</span></label>
                        <input type="text" id="remitente_direccion" placeholder="KR 7 24 89 PISO 14"/>
                        <span class="field-error" id="err_remitente_direccion"></span>
                    </div>
                    <div class="field">
                        <label>Ciudad <span class="req">*</span></label>
                        <input type="text" id="remitente_ciudad" placeholder="BOGOTÁ"/>
                        <span class="field-error" id="err_remitente_ciudad"></span>
                    </div>
                    <div class="field">
                        <label>Teléfono</label>
                        <input type="text" id="remitente_telefono" placeholder="3154393228"/>
                    </div>
                    <div class="field">
                        <label>Cédula / NIT</label>
                        <input type="text" id="remitente_cedula" placeholder="860034594-1"/>
                    </div>
                    <div class="field">
                        <label>Código Postal</label>
                        <input type="text" id="remitente_codigo_postal" placeholder="110311"/>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- ── SECCIÓN 3: DESTINATARIO ── -->
            <div class="section-header">
                <span class="section-dot dot-red"></span>
                <h2>Destinatario</h2>
                <span class="section-tag">Destino</span>
            </div>
            <div class="section-body">
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Nombre <span class="req">*</span></label>
                        <input type="text" id="destinatario_nombre" placeholder="LINA MARIA FERNANDEZ SOLER"/>
                        <span class="field-error" id="err_destinatario_nombre"></span>
                    </div>
                    <div class="field col-span-2">
                        <label>Dirección <span class="req">*</span></label>
                        <input type="text" id="destinatario_direccion" placeholder="KR 3 11 16"/>
                        <span class="field-error" id="err_destinatario_direccion"></span>
                    </div>
                    <div class="field">
                        <label>Ciudad <span class="req">*</span></label>
                        <input type="text" id="destinatario_ciudad" placeholder="IBAGUÉ - TOLIMA"/>
                        <span class="field-error" id="err_destinatario_ciudad"></span>
                    </div>
                    <div class="field">
                        <label>Teléfono</label>
                        <input type="text" id="destinatario_telefono" placeholder="3212204247"/>
                    </div>
                    <div class="field">
                        <label>Cédula</label>
                        <input type="text" id="destinatario_cedula" placeholder="65769830"/>
                    </div>
                    <div class="field">
                        <label>Código Postal</label>
                        <input type="text" id="destinatario_codigo_postal" placeholder="730001"/>
                    </div>
                    <div class="field">
                        <label>Zona</label>
                        <input type="text" id="destinatario_zona" placeholder="1"/>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- ── SECCIÓN 4: CONTENIDO Y PESOS ── -->
            <div class="section-header">
                <span class="section-dot dot-dark"></span>
                <h2>Contenido y Pesos</h2>
                <span class="section-tag">CA2</span>
            </div>
            <div class="section-body">
                <div class="form-grid">
                    <div class="field col-span-2">
                        <label>Descripción del contenido <span class="req">*</span></label>
                        <input type="text" id="descripcion_contenido" placeholder="TECLADO INALÁMBRICO"/>
                        <span class="field-error" id="err_descripcion_contenido"></span>
                    </div>
                    <div class="field">
                        <label>Unidades <span class="req">*</span></label>
                        <input type="number" id="unidades" value="1" min="1"/>
                    </div>
                </div>
                <div class="form-grid-3" style="margin-top:18px;">
                    <div class="field">
                        <label>Peso Real (kg) <span class="req">*</span></label>
                        <input type="number" id="peso_real_kg" placeholder="1.000" step="0.001" min="0.001"/>
                        <span class="field-error" id="err_peso_real_kg"></span>
                    </div>
                    <div class="field">
                        <label>Peso Volumétrico (kg)</label>
                        <input type="number" id="peso_volumetrico_kg" placeholder="0.000" step="0.001"/>
                    </div>
                    <div class="field">
                        <label>Peso a Cobrar (kg) <span class="req">*</span></label>
                        <input type="number" id="peso_cobrar_kg" placeholder="1.000" step="0.001" min="0.001"/>
                        <span class="field-error" id="err_peso_cobrar_kg"></span>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- ── SECCIÓN 5: VALORES ── -->
            <div class="section-header">
                <span class="section-dot dot-orange"></span>
                <h2>Valores</h2>
                <span class="section-tag">CA2</span>
            </div>
            <div class="section-body">
                <div class="form-grid">
                    <div class="field">
                        <label>Valor Declarado (COP) <span class="req">*</span></label>
                        <input type="number" id="valor_declarado" placeholder="100000" min="0" oninput="calcularTotal()"/>
                        <span class="field-error" id="err_valor_declarado"></span>
                    </div>
                    <div class="field">
                        <label>Valor a Recaudar (COP)</label>
                        <input type="number" id="valor_recaudo" placeholder="0" min="0"/>
                    </div>
                    <div class="field">
                        <label>Flete (COP) <span class="req">*</span></label>
                        <input type="number" id="flete" placeholder="14965" min="0" oninput="calcularTotal()"/>
                        <span class="field-error" id="err_flete"></span>
                    </div>
                    <div class="field">
                        <label>C. Manejo (COP)</label>
                        <input type="number" id="manejo" placeholder="2000" min="0" oninput="calcularTotal()"/>
                    </div>
                    <div class="field">
                        <label>Otros (COP)</label>
                        <input type="number" id="otros" placeholder="0" min="0" oninput="calcularTotal()"/>
                    </div>
                </div>

                <!-- Total automático -->
                <div class="total-box">
                    <div class="total-items">
                        <div class="total-item">
                            <span class="total-item-label">Flete</span>
                            <span class="total-item-value" id="disp_flete">$ 0</span>
                        </div>
                        <div class="total-item">
                            <span class="total-item-label">+ Manejo</span>
                            <span class="total-item-value" id="disp_manejo">$ 0</span>
                        </div>
                        <div class="total-item">
                            <span class="total-item-label">+ Otros</span>
                            <span class="total-item-value" id="disp_otros">$ 0</span>
                        </div>
                    </div>
                    <div class="total-final">
                        <div class="total-final-label">Total Fletes</div>
                        <div class="total-final-value" id="disp_total">$ 0</div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- ── SECCIÓN 6: ESTADO DEL PAQUETE (CA7) ── -->
            <div class="section-header">
                <span class="section-dot dot-green"></span>
                <h2>Estado del Paquete</h2>
                <span class="section-tag">CA7</span>
            </div>
            <div class="section-body">
                <div class="estado-options">
                    <label class="estado-option" id="opt_buen_estado" onclick="selectEstado('buen_estado')">
                        <input type="radio" name="estado_paquete" value="buen_estado" checked/>
                        <span class="estado-icon">✅</span>
                        <div>
                            <div class="estado-label">Buen Estado</div>
                            <div class="estado-sublabel">El paquete llegó sin novedades</div>
                        </div>
                    </label>
                    <label class="estado-option" id="opt_con_novedad" onclick="selectEstado('con_novedad')">
                        <input type="radio" name="estado_paquete" value="con_novedad"/>
                        <span class="estado-icon">⚠️</span>
                        <div>
                            <div class="estado-label">Con Novedad</div>
                            <div class="estado-sublabel">El paquete presenta algún problema</div>
                        </div>
                    </label>
                </div>

                <div id="novedad_section" style="display:none; margin-top:18px;">
                    <div class="field">
                        <label>Descripción de la Novedad <span class="req">*</span></label>
                        <textarea id="novedad_descripcion" placeholder="Describa detalladamente la novedad encontrada en el paquete..."></textarea>
                        <span class="field-error" id="err_novedad_descripcion"></span>
                    </div>
                </div>
            </div>

            <!-- ── SUBMIT ── -->
            <div class="submit-area">
                <span class="submit-info">
                    Los campos marcados con <span style="color:var(--rojo)">*</span> son obligatorios · CA2
                </span>
                <button class="btn-submit" id="btnGuardar" onclick="registrarGuia()">
                    Registrar Guía
                </button>
            </div>

        </div><!-- /.form-card -->
    </main>

    <!-- MODAL DE ÉXITO (CA6) -->
    <div class="modal-overlay" id="modalExito">
        <div class="modal">
            <div class="modal-icon">📦</div>
            <h3>¡Guía Registrada!</h3>
            <p>La guía fue asociada exitosamente a la planilla 23M&M.</p>
            <div class="modal-guia" id="modalNumeroGuia">300004299741</div>
            <p id="modalPlanilla" style="color:#999; font-size:0.85rem;"></p>
            <div class="modal-actions">
                <button class="btn-modal btn-nueva" onclick="nuevaGuia()">+ Nueva Guía</button>
                <button class="btn-modal btn-ver" onclick="cerrarModal()">Ver Detalle</button>
            </div>
        </div>
    </div>

    <script>
        // ── Cargar planillas al iniciar (CA1) ──
        document.addEventListener('DOMContentLoaded', () => {
            cargarPlanillas();
            // Fecha actual por defecto
            const now = new Date();
            const local = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
                            .toISOString().slice(0, 16);
            document.getElementById('fecha_admision').value = local;
        });

        async function cargarPlanillas() {
            try {
                const res = await fetch('/api/planillas', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${getToken()}`,
                    }
                });
                const json = await res.json();
                const select = document.getElementById('planilla_id');
                select.innerHTML = '<option value="">— Seleccione una planilla —</option>';
                json.data.forEach(p => {
                    select.innerHTML += `<option value="${p.id}">${p.numero_planilla}${p.descripcion ? ' — ' + p.descripcion : ''}</option>`;
                });
            } catch (e) {
                document.getElementById('planilla_id').innerHTML =
                    '<option value="">Error al cargar planillas</option>';
            }
        }

        // ── Estado del paquete (CA7) ──
        function selectEstado(valor) {
            document.getElementById('opt_buen_estado').classList.remove('selected-good', 'selected-bad');
            document.getElementById('opt_con_novedad').classList.remove('selected-good', 'selected-bad');
            document.getElementById('novedad_section').style.display = 'none';

            if (valor === 'buen_estado') {
                document.getElementById('opt_buen_estado').classList.add('selected-good');
            } else {
                document.getElementById('opt_con_novedad').classList.add('selected-bad');
                document.getElementById('novedad_section').style.display = 'block';
            }
        }

        // Inicializar estado visual
        selectEstado('buen_estado');

        // ── Calculadora de totales ──
        function calcularTotal() {
            const flete  = parseFloat(document.getElementById('flete').value)  || 0;
            const manejo = parseFloat(document.getElementById('manejo').value) || 0;
            const otros  = parseFloat(document.getElementById('otros').value)  || 0;
            const total  = flete + manejo + otros;

            const fmt = v => '$ ' + v.toLocaleString('es-CO');
            document.getElementById('disp_flete').textContent  = fmt(flete);
            document.getElementById('disp_manejo').textContent = fmt(manejo);
            document.getElementById('disp_otros').textContent  = fmt(otros);
            document.getElementById('disp_total').textContent  = fmt(total);
        }

        // ── Limpiar errores ──
        function limpiarErrores() {
            document.querySelectorAll('.field-error').forEach(el => {
                el.textContent = '';
                el.classList.remove('show');
            });
            document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
            ['alertError', 'alertSuccess'].forEach(id => {
                document.getElementById(id).classList.remove('show');
            });
        }

        function mostrarError(campo, msg) {
            const el = document.getElementById('err_' + campo);
            if (el) { el.textContent = msg; el.classList.add('show'); }
            const input = document.getElementById(campo);
            if (input) input.classList.add('error');
        }

        // ── Registrar guía ──
        async function registrarGuia() {
            limpiarErrores();
            const btn = document.getElementById('btnGuardar');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span> Registrando...';

            const estadoPaquete = document.querySelector('input[name="estado_paquete"]:checked')?.value ?? 'buen_estado';

            const payload = {
                planilla_id:              parseInt(document.getElementById('planilla_id').value) || null,
                numero_guia:              document.getElementById('numero_guia').value.trim().toUpperCase(),
                fecha_admision:           document.getElementById('fecha_admision').value,
                referencia:               document.getElementById('referencia').value.trim() || null,
                remitente_nombre:         document.getElementById('remitente_nombre').value.trim(),
                remitente_direccion:      document.getElementById('remitente_direccion').value.trim(),
                remitente_ciudad:         document.getElementById('remitente_ciudad').value.trim(),
                remitente_telefono:       document.getElementById('remitente_telefono').value.trim() || null,
                remitente_cedula:         document.getElementById('remitente_cedula').value.trim() || null,
                remitente_codigo_postal:  document.getElementById('remitente_codigo_postal').value.trim() || null,
                destinatario_nombre:      document.getElementById('destinatario_nombre').value.trim(),
                destinatario_direccion:   document.getElementById('destinatario_direccion').value.trim(),
                destinatario_ciudad:      document.getElementById('destinatario_ciudad').value.trim(),
                destinatario_telefono:    document.getElementById('destinatario_telefono').value.trim() || null,
                destinatario_cedula:      document.getElementById('destinatario_cedula').value.trim() || null,
                destinatario_codigo_postal: document.getElementById('destinatario_codigo_postal').value.trim() || null,
                destinatario_zona:        document.getElementById('destinatario_zona').value.trim() || null,
                descripcion_contenido:    document.getElementById('descripcion_contenido').value.trim(),
                unidades:                 parseInt(document.getElementById('unidades').value) || 1,
                peso_real_kg:             parseFloat(document.getElementById('peso_real_kg').value) || null,
                peso_volumetrico_kg:      parseFloat(document.getElementById('peso_volumetrico_kg').value) || null,
                peso_cobrar_kg:           parseFloat(document.getElementById('peso_cobrar_kg').value) || null,
                valor_declarado:          parseFloat(document.getElementById('valor_declarado').value) || 0,
                flete:                    parseFloat(document.getElementById('flete').value) || 0,
                manejo:                   parseFloat(document.getElementById('manejo').value) || 0,
                otros:                    parseFloat(document.getElementById('otros').value) || 0,
                valor_recaudo:            parseFloat(document.getElementById('valor_recaudo').value) || 0,
                estado_paquete:           estadoPaquete,
                novedad_descripcion:      estadoPaquete === 'con_novedad'
                                          ? document.getElementById('novedad_descripcion').value.trim()
                                          : null,
            };

            try {
                const res = await fetch('/api/guias', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                        'Authorization': `Bearer ${getToken()}`,
                    },
                    body: JSON.stringify(payload),
                });

                const json = await res.json();

                // CA4 - Duplicado
                if (res.status === 422) {
                    const errors = json.errors ?? {};
                    Object.entries(errors).forEach(([campo, msgs]) => {
                        mostrarError(campo, msgs[0]);
                    });
                    const alertEl = document.getElementById('alertError');
                    document.getElementById('alertErrorMsg').textContent = 'Por favor corrija los errores indicados.';
                    alertEl.classList.add('show');
                    return;
                }

                if (!res.ok) {
                    document.getElementById('alertErrorMsg').textContent = json.message ?? 'Error inesperado.';
                    document.getElementById('alertError').classList.add('show');
                    return;
                }

                // CA6 - Éxito: mostrar modal
                document.getElementById('modalNumeroGuia').textContent = json.data.numero_guia;
                document.getElementById('modalPlanilla').textContent =
                    'Planilla: ' + (json.data.planilla?.numero_planilla ?? '');
                document.getElementById('modalExito').classList.add('show');

            } catch(e) {
                document.getElementById('alertErrorMsg').textContent = 'Error de conexión. Verifique su red.';
                document.getElementById('alertError').classList.add('show');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Registrar Guía';
            }
        }

        function nuevaGuia() {
            document.getElementById('modalExito').classList.remove('show');
            document.querySelectorAll('input:not([type=radio]):not([type=datetime-local]), textarea').forEach(el => {
                el.value = '';
            });
            document.getElementById('planilla_id').selectedIndex = 0;
            selectEstado('buen_estado');
            calcularTotal();
            document.getElementById('numero_guia').focus();
        }

        function cerrarModal() {
            document.getElementById('modalExito').classList.remove('show');
        }

        function getToken() {
            return localStorage.getItem('auth_token') ?? '';
        }
    </script>
</body>
</html>
