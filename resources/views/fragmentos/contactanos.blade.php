<div id="contactanos" class="contact-container">
    <div class="contact-form">
        <!-- Título -->
        <h1 class="contact-title">CONTÁCTANOS</h1>
        <p class="contact-subtitle">Completa el formulario y conecta tu marca con el mundo del <span
                class="streaming-highlight">streaming</span></p>

        <!-- Mensajes de éxito y error -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <input type="hidden" name="tipo_contacto" value="empresa">

            <!-- Primera fila: Correo y Nombre de Empresa -->
            <div class="form-row">
                <!-- Correo -->
                <div class="form-group">
                    <label for="correo" class="form-label">Correo:</label>
                    <input type="email" id="correo" name="correo" required class="form-input"
                        value="{{ old('correo') }}" placeholder="Ingrese su correo electrónico">
                </div>

                <!-- Nombre de Empresa -->
                <div class="form-group">
                    <label for="nombre_empresa" class="form-label">Nombre de Empresa:</label>
                    <input type="text" id="nombre_empresa" name="nombre_empresa" required class="form-input"
                        value="{{ old('nombre_empresa') }}" placeholder="Ingrese el nombre de su empresa">
                </div>
            </div>

            <!-- Segunda fila: Persona de Contacto y Cargo -->
            <div class="form-row">
                <!-- Persona de Contacto -->
                <div class="form-group">
                    <label for="persona_contacto" class="form-label">Persona de Contacto:</label>
                    <input type="text" id="persona_contacto" name="persona_contacto" required class="form-input"
                        value="{{ old('persona_contacto') }}" placeholder="Nombre de la persona de contacto">
                </div>

                <!-- Cargo -->
                <div class="form-group">
                    <label for="cargo" class="form-label">Cargo:</label>
                    <input type="text" id="cargo" name="cargo" required class="form-input" value="{{ old('cargo') }}"
                        placeholder="Ingrese el cargo de la persona de contacto">
                </div>
            </div>

            <!-- Tercera fila: Teléfono y RUC -->
            <div class="form-row">
                <!-- Número de Teléfono -->
                <div class="form-group">
                    <label for="telefono" class="form-label">Número de Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" required class="form-input"
                        value="{{ old('telefono') }}" placeholder="Ingrese el número de teléfono">
                </div>

                <!-- RUC -->
                <div class="form-group">
                    <label for="ruc" class="form-label">RUC:</label>
                    <input type="text" id="ruc" name="ruc" maxlength="11" required class="form-input"
                        value="{{ old('ruc') }}" placeholder="Ingrese el RUC de la empresa">
                </div>
            </div>

            <!-- Cuarta fila: Sector de Empresa y Tamaño de Empresa -->
            <div class="form-row">
                <!-- Sector de Empresa -->
                <div class="form-group">
                    <label for="sector_empresa" class="form-label">Sector de Empresa:</label>
                    <select id="sector_empresa" name="sector_empresa" required class="form-select">
                        <option value="">Seleccionar sector...</option>
                        <option value="Tecnología" {{ old('sector_empresa') == 'Tecnología' ? 'selected' : '' }}>
                            Tecnología</option>
                        <option value="Financiero" {{ old('sector_empresa') == 'Financiero' ? 'selected' : '' }}>
                            Financiero</option>
                        <option value="Retail" {{ old('sector_empresa') == 'Retail' ? 'selected' : '' }}>Retail</option>
                        <option value="Manufactura" {{ old('sector_empresa') == 'Manufactura' ? 'selected' : '' }}>
                            Manufactura</option>
                        <option value="Salud" {{ old('sector_empresa') == 'Salud' ? 'selected' : '' }}>Salud</option>
                        <option value="Educación" {{ old('sector_empresa') == 'Educación' ? 'selected' : '' }}>Educación
                        </option>
                        <option value="Construcción" {{ old('sector_empresa') == 'Construcción' ? 'selected' : '' }}>
                            Construcción</option>
                        <option value="Transporte" {{ old('sector_empresa') == 'Transporte' ? 'selected' : '' }}>
                            Transporte</option>
                        <option value="Alimentario" {{ old('sector_empresa') == 'Alimentario' ? 'selected' : '' }}>
                            Alimentario</option>
                        <option value="Turismo" {{ old('sector_empresa') == 'Turismo' ? 'selected' : '' }}>Turismo
                        </option>
                        <option value="Otro" {{ old('sector_empresa') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <!-- Tamaño de Empresa -->
                <div class="form-group">
                    <label for="tamaño_empresa" class="form-label">Tamaño de Empresa:</label>
                    <select id="tamaño_empresa" name="tamaño_empresa" required class="form-select">
                        <option value="">Seleccionar tamaño...</option>
                        <option value="startup" {{ old('tamaño_empresa') == 'startup' ? 'selected' : '' }}>Startup
                        </option>
                        <option value="pequeña" {{ old('tamaño_empresa') == 'pequeña' ? 'selected' : '' }}>Pequeña (1-50
                            empleados)</option>
                        <option value="mediana" {{ old('tamaño_empresa') == 'mediana' ? 'selected' : '' }}>Mediana (51-250
                            empleados)</option>
                        <option value="grande" {{ old('tamaño_empresa') == 'grande' ? 'selected' : '' }}>Grande (251-1000
                            empleados)</option>
                        <option value="corporativa" {{ old('tamaño_empresa') == 'corporativa' ? 'selected' : '' }}>
                            Corporativa (1000+ empleados)</option>
                    </select>
                </div>
            </div>

            <!-- Quinta fila: Servicio y Presupuesto -->
            <div class="form-row">
                <!-- Servicio Deseado -->
                <div class="form-group">
                    <label for="servicio" class="form-label">Servicio Deseado:</label>
                    <select id="servicio" name="servicio" required class="form-select">
                        <option value="">Seleccionar servicio...</option>
                        <option value="Streaming Corporativo" {{ old('servicio') == 'Streaming Corporativo' ? 'selected' : '' }}>Streaming Corporativo</option>
                        <option value="Producción de Contenido" {{ old('servicio') == 'Producción de Contenido' ? 'selected' : '' }}>Producción de Contenido</option>
                        <option value="Marketing Digital" {{ old('servicio') == 'Marketing Digital' ? 'selected' : '' }}>
                            Marketing Digital</option>
                        <option value="Eventos Virtuales" {{ old('servicio') == 'Eventos Virtuales' ? 'selected' : '' }}>
                            Eventos Virtuales</option>
                        <option value="Consultoría en Streaming" {{ old('servicio') == 'Consultoría en Streaming' ? 'selected' : '' }}>Consultoría en Streaming</option>
                        <option value="Capacitación Digital" {{ old('servicio') == 'Capacitación Digital' ? 'selected' : '' }}>Capacitación Digital</option>
                        <option value="Gestión de Redes Sociales" {{ old('servicio') == 'Gestión de Redes Sociales' ? 'selected' : '' }}>Gestión de Redes Sociales</option>
                    </select>
                </div>

                <!-- Presupuesto Estimado -->
                <div class="form-group">
                    <label for="presupuesto_estimado" class="form-label">Presupuesto Estimado:</label>
                    <select id="presupuesto_estimado" name="presupuesto_estimado" required class="form-select">
                        <option value="">Seleccionar presupuesto...</option>
                        <option value="Menos de $5,000" {{ old('presupuesto_estimado') == 'Menos de $5,000' ? 'selected' : '' }}>Menos de $5,000</option>
                        <option value="$5,000 - $15,000" {{ old('presupuesto_estimado') == '$5,000 - $15,000' ? 'selected' : '' }}>$5,000 - $15,000</option>
                        <option value="$15,000 - $50,000" {{ old('presupuesto_estimado') == '$15,000 - $50,000' ? 'selected' : '' }}>$15,000 - $50,000</option>
                        <option value="$50,000 - $100,000" {{ old('presupuesto_estimado') == '$50,000 - $100,000' ? 'selected' : '' }}>$50,000 - $100,000</option>
                        <option value="Más de $100,000" {{ old('presupuesto_estimado') == 'Más de $100,000' ? 'selected' : '' }}>Más de $100,000</option>
                        <option value="A consultar" {{ old('presupuesto_estimado') == 'A consultar' ? 'selected' : '' }}>A
                            consultar</option>
                    </select>
                </div>
            </div>

            <!-- Sexta fila: Urgencia -->
            <div class="form-row">
                <!-- Urgencia -->
                <div class="form-group">
                    <label for="urgencia" class="form-label">Urgencia del Proyecto:</label>
                    <select id="urgencia" name="urgencia" required class="form-select">
                        <option value="">Seleccionar urgencia...</option>
                        <option value="baja" {{ old('urgencia') == 'baja' ? 'selected' : '' }}>Baja (3+ meses)</option>
                        <option value="media" {{ old('urgencia') == 'media' ? 'selected' : '' }}>Media (1-3 meses)
                        </option>
                        <option value="alta" {{ old('urgencia') == 'alta' ? 'selected' : '' }}>Alta (2-4 semanas)</option>
                        <option value="urgente" {{ old('urgencia') == 'urgente' ? 'selected' : '' }}>Urgente (1-2 semanas)
                        </option>
                    </select>
                </div>
            </div>

            <!-- Descripción del proyecto - Ancho completo -->
            <div class="textarea-group">
                <div class="form-group">
                    <label for="consulta" class="form-label">Descripción del Proyecto (máximo 500 caracteres):</label>
                    <textarea id="consulta" name="consulta" maxlength="500" required class="form-textarea"
                        placeholder="Describa brevemente su proyecto (máximo 500 caracteres)">{{ old('consulta') }}</textarea>
                </div>
            </div>

            <!-- Botón Enviar -->
            <button type="submit" class="submit-button">
                Enviar
            </button>
        </form>

    </div>
</div>