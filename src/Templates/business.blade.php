<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('invoicelite::invoice.invoice') }} {{ $invoice_no }}</title>
    <style>
        /* ---------- GLOBAL RESET ---------- */
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:DejaVu Sans, sans-serif; font-size:14px; color:#333; background:#f8f9fa; }

        /* ---------- WRAPPER (adds outer padding) ---------- */
        .wrapper {
            max-width:900px;
            margin:40px auto;          /* bigger top/bottom margin */
            background:#fff;
            padding:30px;              /* outer padding on every side */
            border-radius:4px;
        }

        /* ---------- HEADER ---------- */
        .header { background:#2c3e50; color:#fff; padding:30px; border-radius:4px 4px 0 0; }
        .header .company { font-size:28px; font-weight:700; margin-bottom:12px; }
        .header .info { font-size:14px; opacity:0.9; margin-bottom:5px; }
        .header .invoice-title { font-size:32px; font-weight:700; text-transform:uppercase; margin-bottom:12px; }
        .header .invoice-meta { font-size:16px; margin-bottom:8px; }

        /* ---------- BILL-TO ---------- */
        .bill-to { padding:30px 0; }                     /* vertical spacing */
        .bill-to h3 {
            font-size:18px; font-weight:600; color:#2c3e50;
            border-bottom:2px solid #3498db; padding-bottom:10px;
            margin-bottom:20px;
        }
        .bill-to p { margin-bottom:6px; }

        /* ---------- TABLE ---------- */
        .items-table { width:100%; border-collapse:collapse; margin:30px 0; }
        .items-table th {
            background:#3498db; color:#fff; text-align:left;
            padding:15px; font-weight:600;
        }
        .items-table th:nth-child(1){width:40%;}
        .items-table th:nth-child(2){width:15%;}
        .items-table th:nth-child(3){width:20%;}
        .items-table th:nth-child(4){width:25%;}
        .items-table td { padding:12px 15px; border-bottom:1px solid #eee; }
        .items-table tbody tr:nth-child(even){background:#f9f9f9;}

        /* ---------- TOTALS (right-aligned block) ---------- */
        .totals-wrapper { margin-top:50px; }               /* extra space before totals */
        .totals {
            float:right; width:45%; max-width:380px;
            border:1px solid #eee; border-radius:4px;
            background:#fafafa; padding:20px;
        }
        .totals .row { display:table; width:100%; padding:10px 0; }
        .totals .label { display:table-cell; text-align:right; padding-right:20px; }
        .totals .value { display:table-cell; text-align:right; font-weight:600; }
        .totals .total-row {
            border-top:2px solid #3498db; border-bottom:2px solid #3498db;
            font-size:18px; padding-top:15px; margin-top:8px;
        }

        /* ---------- NOTES / TERMS ---------- */
        .section { padding:30px 0; border-top:1px solid #eee; }
        .section h3 { font-size:18px; font-weight:600; color:#2c3e50; margin-bottom:15px; }
        .section p { font-size:14px; line-height:1.6; color:#555; }

        /* ---------- FOOTER ---------- */
        .footer {
            background:#2c3e50; color:#fff; padding:30px; text-align:center;
            border-radius:0 0 4px 4px; margin-top:40px;
        }
        .footer .signature { margin-bottom:20px; }
        .footer .signature img { max-width:200px; max-height:100px; }
        .footer .qr { margin:20px 0; }
        .footer .qr img { width:100px; height:100px; }
        .footer .note { font-size:13px; color:#95a5a6; margin-top:8px; }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- ==================== HEADER ==================== -->
    <div class="header">
        <table width="100%">
            <tr>
                <td valign="top">
                    <div class="company">{{ $company['name'] }}</div>
                    <div class="info">{{ $company['address'] }}</div>
                    <div class="info">{{ $company['email'] }}</div>
                    <div class="info">{{ $company['phone'] }}</div>
                    <div class="info">{{ $company['website'] }}</div>
                </td>
                <td valign="top" align="right">
                    <div class="invoice-title">{{ __('invoicelite::invoice.invoice') }}</div>
                    <div class="invoice-meta"><strong>{{ __('invoicelite::invoice.invoice_no') }}:</strong> {{ $invoice_no }}</div>
                    <div class="invoice-meta"><strong>{{ __('invoicelite::invoice.date') }}:</strong> {{ $date }}</div>
                    <div class="invoice-meta"><strong>{{ __('invoicelite::invoice.due_date') }}:</strong> {{ $due_date }}</div>
                </td>
            </tr>
        </table>
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
    <div class="section" style="background:#fff;">
        <h3>{{ __('invoicelite::invoice.terms') }}</h3>
        <p style="font-size:13px; color:#666;">{!! nl2br(e($terms)) !!}</p>
    </div>
    @endif

    <!-- ==================== FOOTER ==================== -->
    <div class="footer">
        <div class="signature">
            @if(!empty($signature))
                <img src="{{ $signature }}" alt="Signature">
            @else
                <div style="width:200px;height:1px;background:#95a5a6;margin:30px auto 10px;"></div>
            @endif
            <div class="note">{{ __('invoicelite::invoice.paid') }}</div>
        </div>

        @if(!empty($qr_code))
        <div class="qr">
            <img src="data:image/png;base64,{{ $qr_code }}" alt="QR Code">
            <div class="note">{{ __('invoicelite::invoice.invoice') }} QR</div>
        </div>
        @endif

        <div class="note">{{ __('invoicelite::invoice.thank_you') }}</div>
        <div class="note">{{ __('invoicelite::invoice.footer_note') }}</div>
    </div>
</div>
</body>
</html>