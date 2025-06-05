<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo Presupuesto Web - Tabiplast</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #c87800;
            color: #fff;
            padding: 30px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .section-title {
            color: #c87800;
            font-size: 18px;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        .data-row {
            display: flex;
            margin-bottom: 12px;
        }

        .data-label {
            font-weight: bold;
            width: 120px;
            color: #555;
        }

        .data-value {
            flex: 1;
        }

        .footer {
            background: #f0f0f0;
            padding: 20px;
            text-align: center;
            color: #777;
            font-size: 14px;
        }

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
            <h1>Nuevo Pedido de Presupuesto</h1>
        </div>
        <div class="content">
            <div>
                <div class="section-title">Datos de Contacto</div>
                <div class="data-row">
                    <div class="data-label">Nombre:</div>
                    <div class="data-value">{{ $datos['nombre'] }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Email:</div>
                    <div class="data-value">{{ $datos['email'] }}</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Teléfono:</div>
                    <div class="data-value">{{ $datos['telefono'] }}</div>
                </div>
                @if (!empty($datos['empresa']))
                    <div class="data-row">
                        <div class="data-label">Empresa:</div>
                        <div class="data-value">{{ $datos['empresa'] }}</div>
                    </div>
                @endif
            </div>
            <div style="margin-top:30px;">
                <div class="section-title">Consulta</div>
                @if (!empty($datos['producto']))
                    <div class="data-row">
                        <div class="data-label">Producto:</div>
                        <div class="data-value">
                            @php
                                $producto = \App\Models\Producto::find($datos['producto']);
                            @endphp
                            {{ $producto ? $producto->titulo : 'Producto eliminado' }}
                        </div>
                    </div>
                @endif
                @if (!empty($datos['cantidad']))
                    <div class="data-row">
                        <div class="data-label">Cantidad:</div>
                        <div class="data-value">{{ $datos['cantidad'] }}</div>
                    </div>
                @endif
                <div class="data-row">
                    <div class="data-label">Mensaje:</div>
                    <div class="data-value" style="white-space: pre-line;">{{ $datos['mensaje'] }}</div>
                </div>
                @if (!empty($datos['archivo']))
                    <div class="data-row">
                        <div class="data-label">Archivo:</div>
                        <div class="data-value">
                            Se adjuntó un archivo a este mensaje.
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Tabiplast. Todos los derechos reservados.</p>
            <p>Este es un correo automático, por favor no responda a este mensaje.</p>
        </div>
    </div>
</body>

</html>
