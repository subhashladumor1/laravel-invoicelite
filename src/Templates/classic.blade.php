<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('invoicelite::invoice.invoice') }} {{ $invoice_no }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
            color: #000000;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
        }
        .header {
            text-align: center;
            padding: 20px;
            border-bottom: 2px solid #000;
        }
        .header h1 {
            margin: 0;
            font-size: 2em;
            text-transform: uppercase;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        .company-info, .client-info {
            width: 45%;
        }
        .section-title {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
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
            border: 1px solid #000;
            text-align: left;
            padding: 8px;
            background-color: #f0f0f0;
        }
        td {
            border: 1px solid #000;
            padding: 8px;
        }
        .summary {
            width: 300px;
            margin-left: auto;
            padding: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .summary-label {
            font-weight: bold;
        }
        .total {
            font-size: 1.1em;
            font-weight: bold;
            border-top: 2px solid #000;
            margin-top: 10px;
            padding-top: 10px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #000;
            font-size: 0.9em;
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
                    <th>{{ __('invoicelite::invoice.item') }}</th>
                    <th>{{ __('invoicelite::invoice.qty') }}</th>
                    <th>{{ __('invoicelite::invoice.unit_price') }}</th>
                    <th>{{ __('invoicelite::invoice.line_total') }}</th>
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
                <span class="summary-label">{{ __('invoicelite::invoice.invoice_total') }}:</span>
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