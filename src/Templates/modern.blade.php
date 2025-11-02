<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('invoicelite::invoice.invoice') }} {{ $invoice_no }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f7fa;
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
            font-weight: 300;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            padding: 30px;
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
        }
        .company-info, .client-info {
            width: 45%;
        }
        .section-title {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #667eea;
        }
        .info-item {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #667eea;
            color: white;
            text-align: left;
            padding: 12px;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .summary {
            width: 300px;
            margin-left: auto;
            padding: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .summary-label {
            font-weight: bold;
        }
        .total {
            font-size: 1.2em;
            font-weight: bold;
            border-top: 2px solid #667eea;
            margin-top: 10px;
            padding-top: 10px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
            color: #666;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .invoice-container {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <h1>{{ __('invoicelite::invoice.invoice') }}</h1>
            <p>{{ $invoice_no }}</p>
        </div>

        <div class="invoice-details">
            <div class="company-info">
                <div class="section-title">{{ __('invoicelite::invoice.from') }}</div>
                <div class="info-item"><strong>{{ config('invoicelite.company.name') }}</strong></div>
                <div class="info-item">{{ config('invoicelite.company.address') }}</div>
                <div class="info-item">{{ config('invoicelite.company.email') }}</div>
                <div class="info-item">{{ config('invoicelite.company.phone') }}</div>
            </div>

            <div class="client-info">
                <div class="section-title">{{ __('invoicelite::invoice.bill_to') }}</div>
                <div class="info-item"><strong>{{ $customer['name'] }}</strong></div>
                <div class="info-item">{{ $customer['email'] }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>{{ __('invoicelite::invoice.description') }}</th>
                    <th>{{ __('invoicelite::invoice.quantity') }}</th>
                    <th>{{ __('invoicelite::invoice.price') }}</th>
                    <th>{{ __('invoicelite::invoice.amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @itemsTable
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-row">
                <span class="summary-label">{{ __('invoicelite::invoice.subtotal') }}:</span>
                <span>{{ $subtotal }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">{{ __('invoicelite::invoice.tax') }}:</span>
                <span>{{ $tax_amount }}</span>
            </div>
            <div class="summary-row total">
                <span class="summary-label">{{ __('invoicelite::invoice.total') }}:</span>
                <span>{{ $formatted_total }}</span>
            </div>
        </div>

        <div class="footer">
            <p>{{ __('invoicelite::invoice.thank_you') }}</p>
            <p>{{ __('invoicelite::invoice.footer_note') }}</p>
        </div>
    </div>
</body>
</html>