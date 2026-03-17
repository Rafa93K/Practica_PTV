<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Factura {{ date('d/m/Y', strtotime($factura->fecha_inicio)) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .container {
            width: 100%;
        }

        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .empresa {
            float: left;
        }

        .factura-info {
            float: right;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        .cliente {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #f2f2f2;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .total {
            margin-top: 20px;
            width: 300px;
            float: right;
        }

        .total td {
            border: none;
            padding: 6px;
        }

        .total .precio {
            text-align: right;
        }

        .total-final {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid black;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="empresa">
                <h2>Telecomanager</h2>
                <p>Empresa de Telecomunicaciones</p>
                <p>Córdoba, España</p>
            </div>

            <div class="factura-info">
                <h2>FACTURA</h2>
                <p><strong>Nº:</strong> {{ $factura->id }}</p>
                <p><strong>Fecha:</strong> {{ date('d/m/Y', strtotime($factura->fecha_inicio)) }}</p>
            </div>

            <div class="clear"></div>
        </div>

        <div class="cliente">
            <h3>Datos del Cliente</h3>

            <p><strong>Nombre:</strong> {{ $cliente->nombre }} {{ $cliente->apellido }}</p>
            <p><strong>DNI:</strong> {{ $cliente->dni }}</p>
            <p><strong>Email:</strong> {{ $cliente->email }}</p>
            <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Fecha</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Servicio de telecomunicaciones</td>
                    <td>{{ date('d/m/Y', strtotime($factura->fecha_inicio)) }}</td>
                    <td>{{ number_format($factura->precio, 2) }} €</td>
                </tr>
            </tbody>
        </table>

        <table class="total">
            <tr>
                <td>Subtotal</td>
                <td class="precio">{{ number_format($factura->precio, 2) }} €</td>
            </tr>
            <tr class="total-final">
                <td>Total</td>
                <td class="precio">{{ number_format($factura->precio, 2) }} €</td>
            </tr>
        </table>
    </div>
</body>

</html>