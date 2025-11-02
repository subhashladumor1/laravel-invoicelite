<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('invoicelite::invoice.invoice') }} {{ $invoice_no }}</title>
    <style>
        /* ---------- GLOBAL ---------- */
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size:13px; color:#333; background:#f5f5f5;
            line-height:1.4;
        }
        .wrapper {
            max-width:850px; margin:20px auto;
            background:#fff; border:1px solid #eee;
        }

        /* ---------- HEADER ---------- */
        .header {
            padding:30px; border-bottom:3px solid #e74c3c;
            display:table; width:100%;
        }
        .header .company { display:table-cell; width:55%; vertical-align:top; }
        .header .logo img { max-width:200px; max-height:80px; margin-bottom:15px; display:block; }
        .header .name { font-size:24px; font-weight:700; color:#2c3e50; margin-bottom:10px; }
        .header .info { font-size:13px; color:#7f8c8d; line-height:1.6; }
        .header .info div { margin-bottom:4px; }
        .header .invoice { display:table-cell; width:45%; text-align:right; vertical-align:top; }
        .header .title { font-size:36px; font-weight:700; color:#e74c3c; text-transform:uppercase; margin-bottom:10px; }
        .header .meta { font-size:14px; color:#7f8c8d; }
        .header .meta div { margin-bottom:8px; }

        /* ---------- BILL TO ---------- */
        .bill-to {
            padding:30px; background:#f8f9fa; border-bottom:1px solid #eee;
        }
        .bill-to h3 {
            font-size:16px; font-weight:700; color:#2c3e50;
            text-transform:uppercase; margin-bottom:15px;
        }
        .bill-to p { margin-bottom:5px; font-size:13px; }

        /* ---------- ITEMS TABLE ---------- */
        .items-table {
            width:100%; border-collapse:collapse; margin:20px 0;
        }
        .items-table th {
            background:#34495e; color:#fff; text-align:left;
            padding:15px; font-weight:600; font-size:13px;
            text-transform:uppercase;
        }
        .items-table th:nth-child(1){width:50%;}
        .items-table th:nth-child(2){width:15%;}
        .items-table th:nth-child(3){width:15%;}
        .items-table th:nth-child(4){width:20%;}
        .items-table td {
            padding:12px 15px; border-bottom:1px solid #eee;
        }
        .items-table tbody tr:nth-child(even) { background:#f9f9f9; }

        /* ---------- TOTALS (right-aligned) ---------- */
        .totals-wrapper { padding:0 30px 30px; }
        .totals {
            float:right; width:45%; max-width:380px;
            border:1px solid #ddd; background:#fafafa;
            padding:15px; font-size:13px;
        }
        .totals .row {
            display:table; width:100%; padding:8px 0;
        }
        .totals .label { display:table-cell; text-align:right; padding-right:15px; }
        .totals .value { display:table-cell; text-align:right; font-weight:600; }
        .totals .total-row {
            border-top:2px solid #e74c3c; border-bottom:2px solid #e74c3c;
            margin-top:8px; padding-top:12px;
            font-size:16px; font-weight:700; color:#e74c3c;
        }

        /* ---------- NOTES / TERMS ---------- */
        .section {
            padding:30px; border-top:1px solid #eee;
        }
        .section h3 {
            font-size:16px; font-weight:700; color:#2c3e50;
            text-transform:uppercase; margin-bottom:15px;
        }
        .section p { font-size:13px; line-height:1.6; color:#555; }

        /* ---------- FOOTER (2-column + center) ---------- */
        .footer {
            background:#2c3e50; color:#bdc3c7; padding:30px;
            font-size:13px;
        }
        .footer table { width:100%; border-collapse:collapse; }
        .footer td { vertical-align:top; padding:0; }
        .footer .col-left   { width:40%; text-align:left; }
        .footer .col-center { width:20%; text-align:center; }
        .footer .col-right  { width:40%; text-align:right; }

        .footer .signature img { max-width:180px; max-height:90px; }
        .footer .qr img { width:90px; height:90px; }
        .footer .note { margin-top:8px; font-size:12px; }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- ==================== HEADER ==================== -->
    <div class="header">
        <div class="company">
            @if(!empty($company['logo']))
                <div class="logo"><img src="{{ $company['logo'] }}" alt="Logo"></div>
            @endif
            <div class="name">{{ $company['name'] }}</div>
            <div class="info">
                <div>{{ $company['address'] }}</div>
                <div>{{ $company['email'] }}</div>
                <div>{{ $company['phone'] }}</div>
                <div>{{ $company['website'] }}</div>
            </div>
        </div>
        <div class="invoice">
            <div class="title">{{ __('invoicelite::invoice.invoice') }}</div>
            <div class="meta">
                <div><strong>{{ __('invoicelite::invoice.invoice_no') }}:</strong> {{ $invoice_no }}</div>
                <div><strong>{{ __('invoicelite::invoice.date') }}:</strong> {{ $date }}</div>
                <div><strong>{{ __('invoicelite::invoice.due_date') }}:</strong> {{ $due_date }}</div>
            </div>
        </div>
    </div>

    <!-- ==================== BILL TO ==================== -->
    <div class="bill-to">
        <h3>{{ __('invoicelite::invoice.bill_to') }}</h3>
        <p><strong>{{ $customer['name'] }}</strong></p>
        <p>{{ $customer['address'] }}</p>
        <p>{{ $customer['email'] }}</p>
        <p>{{ $customer['phone'] }}</p>
    </div>

    <!-- ==================== ITEMS ==================== -->
    <table class="items-table">
        <thead>
            <tr>
                <th>{{ __('invoicelite::invoice.description') }}</th>
                <th>{{ __('invoicelite::invoice.quantity') }}</th>
                <th>{{ __('invoicelite::invoice.unit_price') }}</th>
                <th>{{ __('invoicelite::invoice.amount') }}</th>
            </tr>
        </thead>
        <tbody>{!! $itemsHtml !!}</tbody>
    </table>

    <!-- ==================== TOTALS ==================== -->
    <div class="totals-wrapper">
        <div class="totals">
            <div class="row"><span class="label">{{ __('invoicelite::invoice.subtotal') }}:</span><span class="value">{{ $subtotal }}</span></div>
            <div class="row"><span class="label">{{ __('invoicelite::invoice.tax') }} ({{ $tax }}%):</span><span class="value">{{ $tax_amount }}</span></div>
            <div class="row total-row"><span class="label">{{ __('invoicelite::invoice.total') }}:</span><span class="value">{{ $formatted_total }}</span></div>
        </div>
    </div>
    <div style="clear:both;"></div>

    <!-- ==================== NOTES ==================== -->
    @if(!empty($notes))
    <div class="section">
        <h3>{{ __('invoicelite::invoice.notes') }}</h3>
        <p>{!! nl2br(e($notes)) !!}</p>
    </div>
    @endif

    <!-- ==================== TERMS ==================== -->
    @if(!empty($terms))
    <div class="section" style="background:#f8f9fa;">
        <h3>{{ __('invoicelite::invoice.terms') }}</h3>
        <p style="font-size:12px; color:#666;">{!! nl2br(e($terms)) !!}</p>
    </div>
    @endif

        <!-- ==================== FOOTER ==================== -->
    <div class="footer">
        <!-- TWO COLUMNS: Signature (Left) + Thank You (Right) -->
        <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
            <tr>
                <!-- LEFT: Signature -->
                <td style="width:50%; text-align:left; vertical-align:top; padding-right:15px;">
                    <div class="signature">
                        @if(!empty($signature))
                            <img src="{{ $signature }}" alt="Signature" style="max-width:180px; max-height:90px;">
                        @else
                            <div style="width:180px; height:1px; background:#95a5a6; margin:25px 0 10px;"></div>
                        @endif
                        <div style="font-size:13px; color:#bdc3c7; margin-top:8px;">{{ __('invoicelite::invoice.paid') }}</div>
                    </div>
                </td>

                <!-- RIGHT: Thank You + Note -->
                <td style="width:50%; text-align:right; vertical-align:top; padding-left:15px;">
                    <div style="font-size:12px; color:#bdc3c7; line-height:1.6; text-align:right;">
                        <div>{{ __('invoicelite::invoice.thank_you') }}</div>
                        <div style="margin-top:4px;">{{ __('invoicelite::invoice.footer_note') }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- FULL-WIDTH BELOW: QR Code (Centered) -->
        @if(!empty($qr_code))
        <div style="text-align:center; margin-top:20px; padding-top:20px; border-top:1px solid #34495e;">
            <img src="data:image/png;base64,{{ $qr_code }}" alt="QR Code" style="width:90px; height:90px;">
            <div style="margin-top:8px; font-size:11px; color:#95a5a6;">{{ __('invoicelite::invoice.invoice') }} QR</div>
        </div>
        @endif
    </div>
</div>
</body>
</html>