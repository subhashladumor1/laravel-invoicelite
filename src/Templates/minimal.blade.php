<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('invoicelite::invoice.invoice') }} {{ $invoice_no }}</title>
    <style>
        /* ---------- GLOBAL ---------- */
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'DejaVu Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size:14px; color:#000; background:#fff;
            line-height:1.5; padding:30px;
        }
        .container {
            max-width:800px; margin:0 auto;
        }

        /* ---------- HEADER ---------- */
        .header {
            display:table; width:100%; padding-bottom:20px;
            border-bottom:1px solid #eee;
        }
        .header .company, .header .meta {
            display:table-cell; vertical-align:top;
        }
        .header .company { width:55%; }
        .header .meta { width:45%; text-align:right; }
        .header h1 { font-size:1.8em; font-weight:600; margin-bottom:10px; }
        .header h2 { font-size:1.5em; margin-bottom:10px; color:#333; }

        /* ---------- ADDRESS (FROM / BILL TO) ---------- */
        .parties {
            display:table; width:100%; margin:30px 0;
        }
        .party {
            display:table-cell; width:50%; padding:0 15px;
        }
        .party:first-child { padding-left:0; }
        .party:last-child { padding-right:0; }
        .party-title {
            font-weight:600; text-transform:uppercase;
            font-size:0.9em; color:#666; margin-bottom:10px;
        }

        /* ---------- TABLE ---------- */
        .items-table {
            width:100%; border-collapse:collapse; margin:30px 0;
        }
        .items-table th {
            text-align:left; padding:12px 8px;
            border-bottom:2px solid #000; font-weight:600;
        }
        .items-table td {
            padding:12px 8px; border-bottom:1px solid #eee;
        }
        .items-table th:nth-child(2), .items-table td:nth-child(2) { width:80px; }
        .items-table th:nth-child(3), .items-table td:nth-child(3) { width:100px; }
        .items-table th:nth-child(4), .items-table td:nth-child(4) { width:120px; }

        /* ---------- SUMMARY (right-aligned) ---------- */
        .summary {
            width:300px; margin-left:auto; margin-top:20px;
        }
        .summary-row {
            display:table; width:100%; padding:8px 0;
        }
        .summary-label, .summary-value {
            display:table-cell;
        }
        .summary-label { font-weight:500; }
        .summary-value { text-align:right; }
        .total {
            border-top:2px solid #000; margin-top:10px; padding-top:10px;
            font-size:1.1em; font-weight:600;
        }

        /* ---------- NOTES / TERMS ---------- */
        .section {
            margin:30px 0; padding-top:20px;
            border-top:1px solid #eee;
        }
        .section-title {
            font-weight:600; margin-bottom:10px;
        }
        .terms-section { font-size:0.9em; }

        /* ---------- FOOTER ---------- */
        .footer {
            margin-top:40px; padding-top:20px;
            border-top:1px solid #eee; font-size:0.9em; color:#666;
        }
        .footer table { width:100%; border-collapse:collapse; margin-bottom:20px; }
        .footer .col-left   { width:50%; text-align:left; }
        .footer .col-right  { width:50%; text-align:right; }
        .footer .signature img { max-width:180px; max-height:90px; }
        .footer .qr-wrapper {
            text-align:center; margin-top:20px; padding-top:20px;
            border-top:1px solid #ddd;
        }
        .footer .qr img { width:90px; height:90px; }
        .footer .qr-note { margin-top:8px; font-size:11px; color:#888; }
    </style>
</head>
<body>
<div class="container">

    <!-- ==================== HEADER ==================== -->
    <div class="header">
        <div class="company">
            <h1>{{ $company['name'] }}</h1>
            <div>{{ $company['address'] }}</div>
        </div>
        <div class="meta">
            <h2>{{ __('invoicelite::invoice.invoice') }}</h2>
            <div>{{ $invoice_no }}</div>
            <div>{{ __('invoicelite::invoice.date') }}: {{ $date }}</div>
            <div>{{ __('invoicelite::invoice.due_date') }}: {{ $due_date }}</div>
        </div>
    </div>

    <!-- ==================== FROM / BILL TO ==================== -->
    <div class="parties">
        <div class="party">
            <div class="party-title">{{ __('invoicelite::invoice.from') }}</div>
            <div><strong>{{ $company['name'] }}</strong></div>
            <div>{{ $company['email'] }}</div>
            <div>{{ $company['phone'] }}</div>
            <div>{{ $company['website'] }}</div>
        </div>
        <div class="party">
            <div class="party-title">{{ __('invoicelite::invoice.bill_to') }}</div>
            <div><strong>{{ $customer['name'] }}</strong></div>
            <div>{{ $customer['address'] }}</div>
            <div>{{ $customer['email'] }}</div>
            <div>{{ $customer['phone'] }}</div>
        </div>
    </div>

    <!-- ==================== ITEMS ==================== -->
    <table class="items-table">
        <thead>
            <tr>
                <th>{{ __('invoicelite::invoice.description') }}</th>
                <th>{{ __('invoicelite::invoice.quantity') }}</th>
                <th>{{ __('invoicelite::invoice.price') }}</th>
                <th>{{ __('invoicelite::invoice.amount') }}</th>
            </tr>
        </thead>
        <tbody>{!! $itemsHtml !!}</tbody>
    </table>

    <!-- ==================== SUMMARY ==================== -->
    <div class="summary">
        <div class="summary-row">
            <span class="summary-label">{{ __('invoicelite::invoice.subtotal') }}:</span>
            <span class="summary-value">{{ $subtotal }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">{{ __('invoicelite::invoice.tax') }} ({{ $tax }}%):</span>
            <span class="summary-value">{{ $tax_amount }}</span>
        </div>
        <div class="summary-row total">
            <span class="summary-label">{{ __('invoicelite::invoice.total') }}:</span>
            <span class="summary-value">{{ $formatted_total }}</span>
        </div>
    </div>

    <!-- ==================== NOTES ==================== -->
    @if(!empty($notes))
    <div class="section">
        <div class="section-title">{{ __('invoicelite::invoice.notes') }}</div>
        <div>{!! nl2br(e($notes)) !!}</div>
    </div>
    @endif

    <!-- ==================== TERMS ==================== -->
    @if(!empty($terms))
    <div class="section terms-section">
        <div class="section-title">{{ __('invoicelite::invoice.terms') }}</div>
        <div>{!! nl2br(e($terms)) !!}</div>
    </div>
    @endif

    <!-- ==================== FOOTER ==================== -->
    <div class="footer">
        <!-- TWO COLUMNS: Signature (Left) + Thank You (Right) -->
        <table>
            <tr>
                <td class="col-left">
                    <div class="signature">
                        @if(!empty($signature))
                            <img src="{{ $signature }}" alt="Signature">
                        @else
                            <div style="width:180px; height:1px; background:#ddd; margin:20px 0 8px;"></div>
                        @endif
                        <div style="margin-top:8px;">{{ __('invoicelite::invoice.paid') }}</div>
                    </div>
                </td>
                <td class="col-right">
                    <div style="text-align:right; line-height:1.6;">
                        <div>{{ __('invoicelite::invoice.thank_you') }}</div>
                        <div style="margin-top:4px; color:#888;">{{ __('invoicelite::invoice.footer_note') }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- FULL-WIDTH BELOW: QR Code (Centered) -->
        @if(!empty($qr_code))
        <div class="qr-wrapper">
            <img src="data:image/png;base64,{{ $qr_code }}" alt="QR Code">
            <div class="qr-note">{{ __('invoicelite::invoice.invoice') }} QR</div>
        </div>
        @endif
    </div>
</div>
</body>
</html>