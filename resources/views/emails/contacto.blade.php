<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Mensaje de Contacto - Tabiplast</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Encabezado */
        .header {
            background-color: #c87800;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        /* Contenido */
        .content {
            padding: 30px;
        }

        .content p {
            margin-bottom: 20px;
        }

        .message-intro {
            font-size: 16px;
            margin-bottom: 25px;
            color: #555555;
        }

        /* Datos de contacto */
        .contact-data {
            background-color: #f5f5f5;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .contact-data h2 {
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 15px;
            color: #c87800;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .data-row {
            display: flex;
            margin-bottom: 12px;
        }

        .data-label {
            font-weight: bold;
            width: 120px;
            color: #555555;
        }

        .data-value {
            flex: 1;
        }

        /* Mensaje */
        .message-container {
            background-color: #f5f5f5;
            border-radius: 8px;
            padding: 20px;
        }

        .message-container h2 {
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 15px;
            color: #c87800;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .message-text {
            line-height: 1.7;
            white-space: pre-line;
        }

        /* Pie de página */
        .footer {
            background-color: #f0f0f0;
            padding: 20px;
            text-align: center;
            color: #777777;
            font-size: 14px;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                border-radius: 0;
            }

            .header,
            .content,
            .footer {
                padding: 20px;
            }

            .data-row {
                flex-direction: column;
            }

            .data-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Nuevo Mensaje de Contacto</h1>
        </div>

        <div class="content">
            <p class="message-intro">Se ha recibido un nuevo mensaje a través del formulario de contacto de la página
                web.</p>

            <div class="contact-data">
                <h2>Datos de Contacto</h2>

                <div class="data-row">
                    <div class="data-label">Nombre:</div>
                    <div class="data-value">{{ $datos['nombre'] }} {{ $datos['apellido'] }}</div>
                </div>

                <div class="data-row">
                    <div class="data-label">Email:</div>
                    <div class="data-value">{{ $datos['email'] }}</div>
                </div>

                @if (!empty($datos['celular']))
                    <div class="data-row">
                        <div class="data-label">Celular:</div>
                        <div class="data-value">{{ $datos['celular'] }}</div>
                    </div>
                @endif
            </div>

            <div class="message-container">
                <h2>Mensaje</h2>
                <div class="message-text">{{ $datos['mensaje'] }}</div>
            </div>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Tabiplast. Todos los derechos reservados.</p>
            <p>Este es un correo automático, por favor no responda a este mensaje.</p>
        </div>
    </div>
</body>

</html>
