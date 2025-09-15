<?php

namespace App\Http\Controllers;

use Dotenv\Dotenv;
use Illuminate\Support\Facades\App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Almacenar una nueva consulta de contacto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $dotenv = Dotenv::createImmutable(base_path()); // Carga el archivo .env
        $dotenv->load();

        // Determinar si es formulario de empresa o persona
        $esEmpresa = $request->has('nombre_empresa');

        if ($esEmpresa) {
            // Validaciones para empresas
            $validator = Validator::make($request->all(), [
                'correo' => 'required|email|max:255',
                'nombre_empresa' => 'required|string|max:255',
                'persona_contacto' => 'required|string|max:255',
                'cargo' => 'required|string|max:255',
                'telefono' => 'required|string|max:20',
                'ruc' => 'required|string|max:11',
                'sector_empresa' => 'required|string|max:255',
                'tamaño_empresa' => 'required|in:startup,pequeña,mediana,grande,corporativa',
                'servicio' => 'required|string|max:255',
                'presupuesto_estimado' => 'required|string|max:100',
                'urgencia' => 'required|in:baja,media,alta,urgente',
                'consulta' => 'required|string|max:500',
            ], [
                'correo.required' => 'El correo es obligatorio.',
                'correo.email' => 'El correo debe tener un formato válido.',
                'nombre_empresa.required' => 'El nombre de la empresa es obligatorio.',
                'persona_contacto.required' => 'La persona de contacto es obligatoria.',
                'cargo.required' => 'El cargo es obligatorio.',
                'telefono.required' => 'El número de teléfono es obligatorio.',
                'ruc.required' => 'El RUC es obligatorio.',
                'ruc.max' => 'El RUC no puede exceder los 11 caracteres.',
                'sector_empresa.required' => 'Debe seleccionar un sector de empresa.',
                'tamaño_empresa.required' => 'Debe seleccionar el tamaño de empresa.',
                'servicio.required' => 'Debe seleccionar un servicio.',
                'presupuesto_estimado.required' => 'Debe seleccionar un presupuesto estimado.',
                'urgencia.required' => 'Debe seleccionar la urgencia del proyecto.',
                'consulta.required' => 'La descripción del proyecto es obligatoria.',
                'consulta.max' => 'La descripción no puede exceder los 500 caracteres.',
            ]);
        } else {
            // Validaciones para personas (formulario original)
            $validator = Validator::make($request->all(), [
                'correo' => 'required|email|max:255',
                'nombre_completo' => 'required|string|max:255',
                'telefono' => 'required|string|max:20',
                'servicio' => 'required|string|max:255',
                'consulta' => 'required|string|max:500',
            ], [
                'correo.required' => 'El correo es obligatorio.',
                'correo.email' => 'El correo debe tener un formato válido.',
                'nombre_completo.required' => 'El nombre completo es obligatorio.',
                'telefono.required' => 'El número de teléfono es obligatorio.',
                'servicio.required' => 'Debe seleccionar un servicio.',
                'consulta.required' => 'La descripción de la consulta es obligatoria.',
                'consulta.max' => 'La consulta no puede exceder los 500 caracteres.',
            ]);
        }

        // Si la validación falla
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // PRIMER CORREO: Para los administradores
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port = env('MAIL_PORT');
            
            // Configuraciones adicionales para SSL/TLS
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Configuración del correo
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            
            $mailTo = env('MAIL_TO', env('MAIL_FROM_ADDRESS'));
            $mail->addAddress($mailTo);

            // Agregar direcciones adicionales en producción
            if (!App::environment("local")) {
                $mail->addAddress('jruiz@corporacionibgroup.pe');
                $mail->addAddress('jruiz@corpibgroup.com');
                $mail->addAddress('ruizjosea1@gmail.com');
                $mail->addAddress('cm.outplacement.coaching@corpibgroup.com');
            }

            // Contenido del correo según el tipo
            $mail->isHTML(true);
            
            if ($esEmpresa) {
                $mail->Subject = 'FORM.IBSTREAM.EMPRESAS. ' . $request->input('nombre_empresa');
                $mail->Body = $this->generateCompanyEmailTemplate($request);
            } else {
                $mail->Subject = 'FORM.IBSTREAM.PERSONAS. ' . $request->input('nombre_completo');
                $mail->Body = $this->generatePersonEmailTemplate($request);
            }

            $mail->send();

            // SEGUNDO CORREO: Confirmación para el usuario
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port = env('MAIL_PORT');
            
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($request->input('correo'));

            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de recepción de tu consulta';
            
            if ($esEmpresa) {
                $mail->Body = $this->generateCompanyConfirmationTemplate($request);
            } else {
                $mail->Body = $this->generatePersonConfirmationTemplate($request);
            }

            $mail->send();

            // Crear el registro en la base de datos
            if ($esEmpresa) {
                $contact = Contact::create([
                    'tipo_contacto' => 'empresa',
                    'correo' => $request->correo,
                    'telefono' => $request->telefono,
                    'servicio' => $request->servicio,
                    'consulta' => $request->consulta,
                    'nombre_empresa' => $request->nombre_empresa,
                    'persona_contacto' => $request->persona_contacto,
                    'cargo' => $request->cargo,
                    'ruc' => $request->ruc,
                    'sector_empresa' => $request->sector_empresa,
                    'tamaño_empresa' => $request->tamaño_empresa,
                    'presupuesto_estimado' => $request->presupuesto_estimado,
                    'urgencia' => $request->urgencia,
                ]);
            } else {
                $contact = Contact::create([
                    'tipo_contacto' => 'persona',
                    'correo' => $request->correo,
                    'nombre_completo' => $request->nombre_completo,
                    'telefono' => $request->telefono,
                    'servicio' => $request->servicio,
                    'consulta' => $request->consulta,
                ]);
            }

            // Opcional: Enviar email de notificación
            $this->sendNotificationEmail($contact);

            // Redireccionar con consulta de éxito
            return redirect()->back()->with('success', 'Su consulta ha sido enviada exitosamente. Nos pondremos en contacto con usted pronto.');

        } catch (\Exception $e) {
            // Manejar errores con más detalle
            Log::error('Error en formulario de contacto: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al enviar el mensaje: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Generar template de email para empresas
     */
    private function generateCompanyEmailTemplate($request)
    {
        return '
        <html>
            <head>
                <style>
                    body {
                        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f7f7f7;
                        color: #000;
                    }
                    .container {
                        width: 100%;
                        max-width: 650px;
                        margin: 0 auto;
                        padding: 30px;
                        background-color: #ffffff;
                        border-radius: 8px;
                        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    }
                    h2 {
                        color: #2a3d66;
                        font-size: 24px;
                        margin-bottom: 15px;
                    }
                    p {
                        font-size: 16px;
                        color: #000;
                        line-height: 1.6;
                        margin-bottom: 20px;
                    }
                    .footer {
                        font-size: 12px;
                        color: #000;
                        text-align: left;
                        margin-top: 30px;
                    }
                    .footer img {
                        width: 120px;
                        margin-bottom: 10px;
                        display: inline-block;
                    }
                    .footer p {
                        margin: 5px 0;
                    }
                    .footer .contact-info {
                        font-size: 10px;
                        line-height: 1.5;
                    }
                    .footer a {
                        color: #1a73e8;
                        text-decoration: underline;
                        font-size: 12px;
                    }
                    .section-header {
                        font-size: 18px;
                        color: #2a3d66;
                        margin-bottom: 10px;
                        border-bottom: 2px solid #4CAF50;
                        padding-bottom: 5px;
                    }
                    .info {
                        background-color: #f5f5f5;
                        padding: 15px;
                        border-radius: 5px;
                        margin-bottom: 20px;
                    }
                    .info strong {
                        color: #2a3d66;
                    }
                    .urgency-high {
                        background-color: #ffe6e6;
                        border-left: 4px solid #ff4444;
                        padding: 10px;
                        margin: 10px 0;
                    }
                    .urgency-urgent {
                        background-color: #ffe0e0;
                        border-left: 4px solid #cc0000;
                        padding: 10px;
                        margin: 10px 0;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>Nueva solicitud de empresa recibida</h2>
                    <p><strong>Fecha de solicitud:</strong> ' . (new \DateTime())->format('d-m-Y H:i:s') . '</p>
                    
                    ' . ($request->input('urgencia') === 'alta' ? '<div class="urgency-high"><strong>⚠️ PROYECTO DE ALTA URGENCIA</strong></div>' : '') . '
                    ' . ($request->input('urgencia') === 'urgente' ? '<div class="urgency-urgent"><strong>🚨 PROYECTO URGENTE</strong></div>' : '') . '
                    
                    <div class="section-header">Información de la Empresa:</div>
                    <div class="info">
                        <p><strong>Empresa:</strong> ' . $request->input('nombre_empresa') . '</p>
                        <p><strong>RUC:</strong> ' . $request->input('ruc') . '</p>
                        <p><strong>Sector:</strong> ' . $request->input('sector_empresa') . '</p>
                        <p><strong>Tamaño:</strong> ' . ucfirst($request->input('tamaño_empresa')) . '</p>
                    </div>
                    
                    <div class="section-header">Persona de Contacto:</div>
                    <div class="info">
                        <p><strong>Nombre:</strong> ' . $request->input('persona_contacto') . '</p>
                        <p><strong>Cargo:</strong> ' . $request->input('cargo') . '</p>
                        <p><strong>Correo:</strong> ' . $request->input('correo') . '</p>
                        <p><strong>Teléfono:</strong> ' . $request->input('telefono') . '</p>
                    </div>
                    
                    <div class="section-header">Detalles del Proyecto:</div>
                    <div class="info">
                        <p><strong>Servicio Requerido:</strong> ' . $request->input('servicio') . '</p>
                        <p><strong>Presupuesto Estimado:</strong> ' . $request->input('presupuesto_estimado') . '</p>
                        <p><strong>Urgencia:</strong> ' . ucfirst($request->input('urgencia')) . '</p>
                        <p><strong>Descripción del Proyecto:</strong></p>
                        <p>' . $request->input('consulta') . '</p>
                    </div>
                    
                    <div class="footer">
                        <img src="https://img.freepik.com/vector-premium/kick-logo-vector-descargar-kick-streaming-icono-logo-vector-eps_691560-10815.jpg" alt="Logo de IBSTREAM.AGENCY">
                        <p><strong>SERVICIOS DE STREAMERS (IBSTREAM.AGENCY)</strong></p>
                        <p class="contact-info">
                            <strong>Unidad de Negocio de servicios de Streamers</strong>
                        </p>          
                        <p>
                            <a href="https://www.corporacionibgroup.pe">www.corporacionibgroup.pe</a>
                        </p>
                    </div>
                </div>
            </body>
        </html>';
    }

    /**
     * Generar template de email para personas (mantiene el original)
     */
    private function generatePersonEmailTemplate($request)
    {
        return '
        <html>
            <head>
                <style>
                    body {
                        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f7f7f7;
                        color: #000;
                    }
                    .container {
                        width: 100%;
                        max-width: 650px;
                        margin: 0 auto;
                        padding: 30px;
                        background-color: #ffffff;
                        border-radius: 8px;
                        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    }
                    h2 {
                        color: #2a3d66;
                        font-size: 24px;
                        margin-bottom: 15px;
                    }
                    p {
                        font-size: 16px;
                        color: #000;
                        line-height: 1.6;
                        margin-bottom: 20px;
                    }
                    .footer {
                        font-size: 12px;
                        color: #000;
                        text-align: left;
                        margin-top: 30px;
                    }
                    .footer img {
                        width: 120px;
                        margin-bottom: 10px;
                        display: inline-block;
                    }
                    .footer p {
                        margin: 5px 0;
                    }
                    .footer .contact-info {
                        font-size: 10px;
                        line-height: 1.5;
                    }
                    .footer a {
                        color: #1a73e8;
                        text-decoration: underline;
                        font-size: 12px;
                    }
                    .section-header {
                        font-size: 18px;
                        color: #2a3d66;
                        margin-bottom: 10px;
                        border-bottom: 2px solid #4CAF50;
                        padding-bottom: 5px;
                    }
                    .info {
                        background-color: #f5f5f5;
                        padding: 15px;
                        border-radius: 5px;
                        margin-bottom: 20px;
                    }
                    .info strong {
                        color: #2a3d66;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>Nuevo contacto recibido desde el formulario de persona</h2>
                    <p><strong>Fecha de solicitud:</strong> ' . (new \DateTime())->format('d-m-Y H:i:s') . '</p>
                    <div class="section-header">Detalles del contacto:</div>
                    <div class="info">
                        <p><strong>Nombres:</strong> ' . $request->input('nombre_completo') . '</p>
                        <p><strong>Correo electrónico:</strong> ' . $request->input('correo') . '</p>
                        <p><strong>Telefono:</strong> ' . $request->input('telefono') . '</p>
                        <p><strong>Servicio Requerido:</strong> ' . $request->input('servicio') . '</p>
                        <p><strong>Consulta:</strong> ' . $request->input('consulta') . '</p>
                    </div>
                    <div class="footer">
                        <img src="https://img.freepik.com/vector-premium/kick-logo-vector-descargar-kick-streaming-icono-logo-vector-eps_691560-10815.jpg" alt="Logo de IBSTREAM.AGENCY">
                        <p><strong>SERVICIOS DE STREAMERS (IBSTREAM.AGENCY)</strong></p>
                        <p class="contact-info">
                            <strong>Unidad de Negocio de servicios de Streamers</strong>
                        </p>          
                        <p>
                            <a href="https://www.corporacionibgroup.pe">www.corporacionibgroup.pe</a>
                        </p>
                    </div>
                </div>
            </body>
        </html>';
    }

    /**
     * Generar template de confirmación para empresas
     */
    private function generateCompanyConfirmationTemplate($request)
    {
        return '
        <html>
            <head>
                <style>
                    body {
                        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f7f7f7;
                        color: #000;
                    }
                    .container {
                        width: 100%;
                        max-width: 650px;
                        margin: 0 auto;
                        padding: 30px;
                        background-color: #ffffff;
                        border-radius: 8px;
                        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    }
                    h2 {
                        color: #2a3d66;
                        font-size: 24px;
                        margin-bottom: 15px;
                    }
                    p {
                        font-size: 16px;
                        color: #000;
                        line-height: 1.6;
                        margin-bottom: 20px;
                    }
                    .footer {
                        font-size: 12px;
                        color: #000;
                        text-align: left;
                        margin-top: 30px;
                    }
                    .footer img {
                        width: 120px;
                        margin-bottom: 10px;
                        display: inline-block;
                    }
                    .footer p {
                        margin: 5px 0;
                    }
                    .footer .contact-info {
                        font-size: 10px;
                        line-height: 1.5;
                    }
                    .footer a {
                        color: #1a73e8;
                        text-decoration: underline;
                        font-size: 12px;
                    }
                    .btn {
                        display: inline-block;
                        padding: 12px 25px;
                        background-color: #4CAF50;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 5px;
                        font-weight: bold;
                        margin-top: 20px;
                        text-align: center;
                    }
                    .btn:hover {
                        background-color: #45a049;
                    }
                    .highlight-box {
                        background-color: #e8f5e8;
                        border-left: 4px solid #4CAF50;
                        padding: 15px;
                        margin: 20px 0;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>¡Gracias por contactarnos, ' . $request->input('nombre_empresa') . '!</h2>
                    <p>
                        Estimado/a ' . $request->input('persona_contacto') . ',
                    </p>
                    <p>
                        Hemos recibido su solicitud de proyecto para <strong>' . $request->input('servicio') . '</strong>. 
                        Nuestro equipo especializado revisará los detalles proporcionados y un consultor se pondrá en contacto 
                        con usted para coordinar una reunión inicial.
                    </p>
                    
                    <div class="highlight-box">
                        <p><strong>Próximos pasos:</strong></p>
                        <p>• Revisión técnica de su proyecto (24-48 horas)<br>
                        • Contacto telefónico para agendar reunión<br>
                        • Presentación de propuesta personalizada</p>
                    </div>
                    
                    <p>
                        Dado que su proyecto tiene una urgencia <strong>' . $request->input('urgencia') . '</strong>, 
                        priorizaremos su solicitud según corresponda.
                    </p>
                    
                    <p>
                        Si tiene alguna pregunta adicional o necesita información urgente, no dude en contactarnos 
                        directamente.
                    </p>
                    
                    <a href="mailto:cm.outplacement.coaching@corpibgroup.com" class="btn">Contacto Directo</a>

                    <div class="footer">
                        <img src="https://img.freepik.com/vector-premium/kick-logo-vector-descargar-kick-streaming-icono-logo-vector-eps_691560-10815.jpg" alt="Logo de IBSTREAM.AGENCY">
                        <p><strong>SERVICIOS DE STREAMERS (IBSTREAM.AGENCY)</strong></p>
                        <p class="contact-info">
                            <strong>Unidad de Negocio de servicios de Streamers</strong>
                        </p>          
                        <p>
                            <a href="https://www.corporacionibgroup.pe">www.corporacionibgroup.pe</a>
                        </p>
                    </div>
                </div>
            </body>
        </html>';
    }

    /**
     * Generar template de confirmación para personas (mantiene el original)
     */
    private function generatePersonConfirmationTemplate($request)
    {
        return '
        <html>
            <head>
                <style>
                    body {
                        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f7f7f7;
                        color: #000;
                    }
                    .container {
                        width: 100%;
                        max-width: 650px;
                        margin: 0 auto;
                        padding: 30px;
                        background-color: #ffffff;
                        border-radius: 8px;
                        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    }
                    h2 {
                        color: #2a3d66;
                        font-size: 24px;
                        margin-bottom: 15px;
                    }
                    p {
                        font-size: 16px;
                        color: #000;
                        line-height: 1.6;
                        margin-bottom: 20px;
                    }
                    .footer {
                        font-size: 12px;
                        color: #000;
                        text-align: left;
                        margin-top: 30px;
                    }
                    .footer img {
                        width: 120px;
                        margin-bottom: 10px;
                        display: inline-block;
                    }
                    .footer p {
                        margin: 5px 0;
                    }
                    .footer .contact-info {
                        font-size: 10px;
                        line-height: 1.5;
                    }
                    .footer a {
                        color: #1a73e8;
                        text-decoration: underline;
                        font-size: 12px;
                    }
                    .btn {
                        display: inline-block;
                        padding: 12px 25px;
                        background-color: #4CAF50;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 5px;
                        font-weight: bold;
                        margin-top: 20px;
                        text-align: center;
                    }
                    .btn:hover {
                        background-color: #45a049;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>¡Gracias por tu consulta, ' . $request->input('nombre_completo') . '!</h2>
                    <p>
                        Hemos recibido tu solicitud de contacto. Nuestro equipo revisará la información proporcionada y
                        se pondrá en contacto contigo en breve para ofrecerte una solución personalizada.
                    </p>
                    <p>
                        Si tienes alguna pregunta o necesitas más información, no dudes en responder a este correo o
                        llamarnos.
                    </p>
                    <a href="mailto:cm.outplacement.coaching@corpibgroup.com" class="btn">Contactar con nosotros</a>

                    <div class="footer">
                        <img src="https://img.freepik.com/vector-premium/kick-logo-vector-descargar-kick-streaming-icono-logo-vector-eps_691560-10815.jpg" alt="Logo de IBSTREAM.AGENCY">
                        <p><strong>SERVICIOS DE STREAMERS (IBSTREAM.AGENCY)</strong></p>
                        <p class="contact-info">
                            <strong>Unidad de Negocio de servicios de Streamers</strong>
                        </p>          
                        <p>
                            <a href="https://www.corporacionibgroup.pe">www.corporacionibgroup.pe</a>
                        </p>
                    </div>
                </div>
            </body>
        </html>';
    }

    /**
     * Enviar email de notificación (opcional)
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    private function sendNotificationEmail($contact)
    {
        // Aquí puedes implementar el envío de email
    }

    /**
     * Mostrar todas las consultas (opcional - para admin)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }
}