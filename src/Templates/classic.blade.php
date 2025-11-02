<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ __('invoicelite::invoice.invoice') }} {{ $invoice_no }}</title>
    <style>
        /* ---------- GLOBAL ---------- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Serif', 'Times New Roman', Times, serif;
            font-size: 14px;
            color: #000;
            background: #fff;
            padding: 20px;
        }

        /* ---------- MAIN CONTAINER ---------- */
        .invoice-box {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            background: #fff;
        }

        /* ---------- HEADER ---------- */
        .header {
            text-align: center;
            padding: 20px;
            border-bottom: 2px solid #000;
        }

        .header h1 {
            font-size: 28px;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }

        .header .inv-no {
            font-size: 16px;
            margin-top: 8px;
        }

        /* ---------- FROM / BILL TO (two columns) ---------- */
        .party-info {
            padding: 20px;
            border-bottom: 1px solid #000;
            display: table;
            width: 100%;
        }

        .party-col {
            display: table-cell;
            width: 50%;
            padding: 0 15px;
            border-right: 1px solid #000;
        }

        .party-col:last-child {
            border-right: none;
        }

        .party-col h3 {
            font-size: 15px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 10px;
        }

        .party-col p {
            margin-bottom: 4px;
        }

        /* ---------- ITEMS TABLE ---------- */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th {
            border: 1px solid #000;
            background: #f0f0f0;
            text-align: left;
            padding: 10px;
            font-weight: bold;
        }

        .items-table td {
            border: 1px solid #000;
            padding: 10px;
            vertical-align: top;
        }

        .items-table th:nth-child(1),
        .items-table td:nth-child(1) {
            width: 40%;
        }

        .items-table th:nth-child(2),
        .items-table td:nth-child(2) {
            width: 15%;
        }

        .items-table th:nth-child(3),
        .items-table td:nth-child(3) {
            width: 20%;
        }

        .items-table th:nth-child(4),
        .items-table td:nth-child(4) {
            width: 25%;
        }

        /* ---------- TOTALS (right-aligned box) ---------- */
        .totals-wrapper {
            margin: 30px 20px 20px;
        }

        .totals {
            float: right;
            width: 45%;
            max-width: 380px;
            border: 1px solid #000;
            background: #fff;
            padding: 15px;
            font-size: 14px;
        }

        .totals .row {
            display: table;
            width: 100%;
            padding: 6px 0;
        }

        .totals .label {
            display: table-cell;
            text-align: right;
            padding-right: 15px;
        }

        .totals .value {
            display: table-cell;
            text-align: right;
            font-weight: bold;
        }

        .totals .total-row {
            border-top: 2px solid #000;
            margin-top: 8px;
            padding-top: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        /* ---------- NOTES / TERMS ---------- */
        .section {
            padding: 20px;
            border-top: 1px solid #000;
        }

        .section h3 {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 15px;
        }

        .section p {
            line-height: 1.5;
        }

        /* ---------- FOOTER ---------- */
        .footer {
            padding: 20px;
            border-top: 1px solid #000;
            text-align: center;
            font-size: 13px;
        }

        .footer .signature {
            margin-bottom: 15px;
        }

        .footer .signature img {
            max-width: 180px;
            max-height: 90px;
        }

        .footer .qr {
            margin: 15px 0;
        }

        .footer .qr img {
            width: 90px;
            height: 90px;
        }

        .footer .note {
            margin-top: 8px;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="invoice-box">

        <!-- ==================== HEADER ==================== -->
        <div class="header">
            <h1>{{ __('invoicelite::invoice.invoice') }}</h1>
            <div class="inv-no">{{ $invoice_no }}</div>
        </div>

        <!-- ==================== FROM / BILL TO ==================== -->
        <div class="party-info">
            <div class="party-col">
                <h3>{{ __('invoicelite::invoice.from') }}</h3>
                <p><strong>{{ $company['name'] }}</strong></p>
                <p>{{ $company['address'] }}</p>
                <p>{{ $company['email'] }}</p>
                <p>{{ $company['phone'] }}</p>
                <p>{{ $company['website'] }}</p>
            </div>
            <div class="party-col">
                <h3>{{ __('invoicelite::invoice.bill_to') }}</h3>
                <p><strong>{{ $customer['name'] }}</strong></p>
                <p>{{ $customer['address'] }}</p>
                <p>{{ $customer['email'] }}</p>
                <p>{{ $customer['phone'] }}</p>
            </div>
        </div>

        <!-- ==================== ITEMS ==================== -->
        <div style="padding:0 20px;">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>{{ __('invoicelite::invoice.item') }}</th>
                        <th>{{ __('invoicelite::invoice.qty') }}</th>
                        <th>{{ __('invoicelite::invoice.unit_price') }}</th>
                        <th>{{ __('invoicelite::invoice.line_total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    {!! $itemsHtml !!}
                </tbody>
            </table>
        </div>

        <!-- ==================== TOTALS ==================== -->
        <div class="totals-wrapper">
            <div class="totals">
                <div class="row"><span class="label">{{ __('invoicelite::invoice.subtotal') }}:</span><span
                        class="value">{{ $subtotal }}</span></div>
                <div class="row"><span class="label">{{ __('invoicelite::invoice.tax') }}
                        ({{ $tax }}%):</span><span class="value">{{ $tax_amount }}</span></div>
                <div class="row total-row"><span
                        class="label">{{ __('invoicelite::invoice.invoice_total') }}:</span><span
                        class="value">{{ $formatted_total }}</span></div>
            </div>
        </div>
        <div style="clear:both;"></div>

        <!-- ==================== NOTES ==================== -->
        @if (!empty($notes))
            <div class="section">
                <h3>{{ __('invoicelite::invoice.notes') }}</h3>
                <p>{!! nl2br(e($notes)) !!}</p>
            </div>
        @endif

        <!-- ==================== TERMS ==================== -->
        @if (!empty($terms))
            <div class="section" style="background:#f9f9f9;">
                <h3>{{ __('invoicelite::invoice.terms') }}</h3>
                <p>{!! nl2br(e($terms)) !!}</p>
            </div>
        @endif

        <!-- ==================== FOOTER ==================== -->
        <div class="footer">
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <!-- LEFT: Signature -->
                    <td style="width:50%; text-align:center; vertical-align:top; padding:15px 0;">
                        <div class="signature">
                            @if (!empty($signature))
                                <img src="{{ $signature }}" alt="Signature"
                                    style="max-width:180px; max-height:90px;">
                            @else
                                <div style="width:180px; height:1px; background:#000; margin:20px 0 8px;"></div>
                            @endif
                            <div style="font-size:13px; color:#000;">{{ __('invoicelite::invoice.paid') }}</div>
                        </div>
                    </td>

                    <!-- RIGHT: QR Code -->
                    <td style="width:50%; text-align:center; vertical-align:top; padding:15px 0;">
                        @if (!empty($qr_code))
                            <div class="qr">
                                <img src="data:image/png;base64,{{ $qr_code }}" alt="QR Code"
                                    style="width:90px; height:90px;">
                                <div style="font-size:11px; color:#555; margin-top:6px;">
                                    {{ __('invoicelite::invoice.invoice') }} QR</div>
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
            <!-- CENTER: Thank you + note -->
            <div style="text-align:center; vertical-align:middle;">
                <div style="font-size:13px; color:#555;">
                    <div>{{ __('invoicelite::invoice.thank_you') }}</div>
                    <div style="margin-top:4px;">{{ __('invoicelite::invoice.footer_note') }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
