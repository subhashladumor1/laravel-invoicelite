<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('invoicelite::invoice.invoice') }} {{ $invoice_no }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin: 0;
            padding: 30px;
            background-color: #ffffff;
            color: #000000;
            font-size: 14px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .company-details h1 {
            margin: 0 0 10px 0;
            font-size: 1.8em;
            font-weight: 600;
        }
        .invoice-meta {
            text-align: right;
        }
        .invoice-meta h2 {
            margin: 0 0 10px 0;
            font-size: 1.5em;
            color: #333;
        }
        .parties {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
        }
        .party {
            width: 45%;
        }
        .party-title {
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 0.9em;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        th {
            text-align: left;
            padding: 12px 8px;
            border-bottom: 1px solid #000;
            font-weight: 600;
        }
        td {
            padding: 12px 8px;
            border-bottom: 1px solid #eee;
        }
        .summary {
            width: 300px;
            margin-left: auto;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .summary-label {
            font-weight: 500;
        }
        .total {
            font-size: 1.1em;
            font-weight: 600;
            border-top: 1px solid #000;
            margin-top: 10px;
            padding-top: 10px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="company-details">
                <h1>{{ config('invoicelite.company.name') }}</h1>
                <div>{{ config('invoicelite.company.address') }}</div>
            </div>
            <div class="invoice-meta">
                <h2>{{ __('invoicelite::invoice.invoice') }}</h2>
                <div>{{ $invoice_no }}</div>
            </div>
        </div>

        <div class="parties">
            <div class="party">
                <div class="party-title">{{ __('invoicelite::invoice.from') }}</div>
                <div><strong>{{ config('invoicelite.company.name') }}</strong></div>
                <div>{{ config('invoicelite.company.email') }}</div>
                <div>{{ config('invoicelite.company.phone') }}</div>
            </div>

            <div class="party">
                <div class="party-title">{{ __('invoicelite::invoice.bill_to') }}</div>
                <div><strong>{{ $customer['name'] }}</strong></div>
                <div>{{ $customer['email'] }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>{{ __('invoicelite::invoice.description') }}</th>
                    <th width="80">{{ __('invoicelite::invoice.quantity') }}</th>
                    <th width="100">{{ __('invoicelite::invoice.price') }}</th>
                    <th width="120">{{ __('invoicelite::invoice.amount') }}</th>
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
        </div>
    </div>
</body>
</html>