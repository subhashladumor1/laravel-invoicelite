<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('invoicelite::invoice.invoice') }} {{ $invoice_no }}</title>

    <style>
        @page { margin:0; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size:14px; line-height:1.5; color:#333;
            background:#f5f7fa;
        }
        .container {
            max-width:800px; margin:20px auto;
            background:#fff; border-radius:10px;
            box-shadow:0 0 20px rgba(0,0,0,.1);
            overflow:hidden;
        }

        /* ---------- SIMPLE SOLID HEADER ---------- */
        .header-table { width:100%; height:110px; border-collapse:collapse; }
        .header-td {
            background:#667eea;               /* solid colour */
            color:#fff; text-align:center;
            vertical-align:middle;
        }
        .header-td h1 { margin:0; font-size:2.5em; font-weight:300; }
        .header-td .inv-no {
            margin-top:6px; font-size:1.4em; font-weight:600;
        }

        /* ---------- FROM / BILL TO ---------- */
        .meta-table { width:100%; border-collapse:collapse; background:#f8f9fa; }
        .meta-td { padding:30px 20px; vertical-align:top; }
        .meta-td:first-child { padding-left:30px; }
        .meta-td:last-child  { padding-right:30px; }
        .section-title { font-size:1.2em; font-weight:bold; color:#667eea; margin-bottom:12px; }
        .info-item { margin-bottom:6px; font-size:13px; }

        /* ---------- ITEMS ---------- */
        .details { padding:30px; }
        .items-table { width:100%; border-collapse:collapse; margin:20px 0; }
        .items-table th { background:#667eea; color:#fff; padding:12px; text-align:left; font-weight:600; font-size:13px; }
        .items-table td { padding:12px; border-bottom:1px solid #eee; }
        .items-table tbody tr:nth-child(even) { background:#f8f9fa; }

        /* ---------- SUMMARY ---------- */
        .summary {
            float:right; width:300px; margin-top:20px;
            padding:15px; background:#fafafa;
            border:1px solid #eee; border-radius:6px;
        }
        .summary-row { display:table; width:100%; padding:8px 0; }
        .summary-label, .summary-value { display:table-cell; }
        .summary-label { font-weight:600; }
        .summary-value { text-align:right; }
        .total-row { border-top:2px solid #667eea; margin-top:10px; padding-top:12px; font-size:1.2em; font-weight:bold; }

        /* ---------- NOTES / TERMS ---------- */
        .notes-section, .terms-section { padding:30px; border-top:1px solid #eee; }
        .notes-section { background:#f8f9fa; }
        .terms-section { background:#f0f0f0; }
        .section-title-sm { font-size:1.1em; font-weight:bold; color:#667eea; margin-bottom:12px; }

        /* ---------- FOOTER ---------- */
        .footer { background:#2c3e50; color:#bdc3c7; padding:30px; font-size:13px; }
        .footer table { width:100%; border-collapse:collapse; margin-bottom:20px; }
        .footer .col-left  { width:50%; text-align:left; }
        .footer .col-right { width:50%; text-align:right; }
        .footer .signature img { max-width:200px; max-height:100px; }
        .footer .qr-wrapper { text-align:center; margin-top:20px; padding-top:20px; border-top:1px solid #34495e; }
        .footer .qr img { width:100px; height:100px; }
        .footer .qr-note { margin-top:8px; font-size:12px; color:#95a5a6; }
        .footer .note { line-height:1.6; }
    </style>
</head>
<body>
<div class="container">

    <!-- ==================== SIMPLE HEADER ==================== -->
    <table class="header-table">
        <tr>
            <td class="header-td">
                <h1>{{ __('invoicelite::invoice.invoice') }}</h1>
                <div class="inv-no">{{ $invoice_no }}</div>
            </td>
        </tr>
    </table>

    <!-- ==================== FROM / BILL TO ==================== -->
    <table class="meta-table" style="border-bottom:1px solid #eee;">
        <tr>
            <td class="meta-td">
                <div class="section-title">{{ __('invoicelite::invoice.from') }}</div>
                <div class="info-item"><strong>{{ $company['name'] }}</strong></div>
                <div class="info-item">{{ $company['address'] }}</div>
                <div class="info-item">{{ $company['email'] }}</div>
                <div class="info-item">{{ $company['phone'] }}</div>
                <div class="info-item">{{ $company['website'] }}</div>
            </td>
            <td class="meta-td">
                <div class="section-title">{{ __('invoicelite::invoice.bill_to') }}</div>
                <div class="info-item"><strong>{{ $customer['name'] }}</strong></div>
                <div class="info-item">{{ $customer['address'] }}</div>
                <div class="info-item">{{ $customer['email'] }}</div>
                <div class="info-item">{{ $customer['phone'] }}</div>
            </td>
        </tr>
    </table>

    <!-- ==================== ITEMS ==================== -->
    <div class="details">
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
            <div class="summary-row total-row">
                <span class="summary-label">{{ __('invoicelite::invoice.total') }}:</span>
                <span class="summary-value">{{ $formatted_total }}</span>
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>

    <!-- ==================== NOTES ==================== -->
    @if(!empty($notes))
    <div class="notes-section">
        <div class="section-title-sm">{{ __('invoicelite::invoice.notes') }}</div>
        <div>{!! nl2br(e($notes)) !!}</div>
    </div>
    @endif

    <!-- ==================== TERMS ==================== -->
    @if(!empty($terms))
    <div class="terms-section">
        <div class="section-title-sm">{{ __('invoicelite::invoice.terms') }}</div>
        <div>{!! nl2br(e($terms)) !!}</div>
    </div>
    @endif

    <!-- ==================== FOOTER ==================== -->
    <div class="footer">
        <table>
            <tr>
                <td class="col-left">
                    <div class="signature">
                        @if(!empty($signature))
                            <img src="{{ $signature }}" alt="Signature">
                        @else
                            <div style="width:200px;height:1px;background:#95a5a6;margin:30px 0 10px;"></div>
                        @endif
                        <div class="note">{{ __('invoicelite::invoice.paid') }}</div>
                    </div>
                </td>
                <td class="col-right">
                    <div class="note" style="text-align:right;">
                        <div>{{ __('invoicelite::invoice.thank_you') }}</div>
                        <div style="margin-top:4px;">{{ __('invoicelite::invoice.footer_note') }}</div>
                    </div>
                </td>
            </tr>
        </table>

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