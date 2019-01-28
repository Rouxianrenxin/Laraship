<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>@lang('Payment::labels.invoice.title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #fff;
            background-image: none;
            font-size: 12px;
        }

        address {
            margin-top: 15px;
        }

        h2 {
            font-size: 28px;
            color: #cccccc;
        }

        .container {
            padding-top: 30px;
        }

        .invoice-head td {
            padding: 0 8px;
        }

        .invoice-body {
            background-color: transparent;
        }

        .logo {
            padding-bottom: 10px;
        }

        .table th {
            vertical-align: bottom;
            font-weight: bold;
            padding: 8px;
            line-height: 20px;
            text-align: left;
        }

        .table td {
            padding: 8px;
            line-height: 20px;
            text-align: left;
            vertical-align: top;
            border-top: 1px solid #dddddd;
        }

        .well {
            margin-top: 15px;
        }
    </style>
</head>

<body>
<div class="container">
    <table style="margin-left: auto; margin-right: auto" width="550">
        <tr>
            <td width="160">
                &nbsp;<p style="font-size:28px;color:#cccccc;">@lang('Payment::labels.invoice.title')</p>
                <strong>@lang('Payment::labels.invoice.address')</strong><br/>
                {!!   $invoice->user->display_address('billing') !!}<br/>

                @if (isset($invoice->user->phone))
                    <strong>@lang('Payment::labels.invoice.phone')</strong><br/>
                    {{ $invoice->user->phone }}<br>
                @endif
            </td>

            <!-- Organization Name / Image -->
            <td align="right">
                <img src="{{ \Settings::get('site_logo') }}" width="200"/>
            </td>
        </tr>
        <tr valign="top">


            <td>
                <br><br>
                <strong>@lang('Payment::labels.invoice.to')</strong> {{ $invoice->user->full_name }}
                <br/>
                <strong>@lang('Payment::labels.invoice.email')</strong> {{ $invoice->user->email }}
                <br>
                <strong>@lang('Payment::labels.invoice.date')</strong> {{ format_date($invoice->due_date) }}
            </td>
            <td>
                <p>
                    {{$invoice->invoicable ? $invoice->invoicable->getInvoiceReference('pdf') : '-' }}
                    <strong>@lang('Payment::labels.invoice.number')</strong> {{ $invoice->code }}<br>
                </p>
            </td>
            <!-- Organization Name / Date -->
        </tr>
        <tr valign="top">
            <!-- Organization Details -->
            <td style="font-size:9px;">

            </td>
            <td>
                <!-- Invoice Table -->
                <table width="100%" class="table" border="0">
                    <tr>
                        <th align="left">@lang('Payment::labels.invoice.description')</th>
                        <th align="right"><!-- Date --></th>
                        <th align="right">@lang('Payment::labels.invoice.amount')</th>
                    </tr>

                    <!-- Display The Invoice Items -->
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td colspan="2">{{ $item->description }}</td>
                            <td>{{ \Payments::currency($item->amount) }}</td>
                        </tr>
                    @endforeach

                    <tr style="border-top:2px solid #000;">
                        <td>&nbsp;</td>
                        <td style="text-align: right;"><strong>@lang('Payment::labels.invoice.sub_total')</strong></td>
                        <td>
                            <strong>{{ \Payments::currency($invoice->sub_total ) }}</strong>
                        </td>
                    </tr>
                    <!-- Display The Final Total -->
                    <tr style="border-top:2px solid #000;">
                        <td>&nbsp;</td>
                        <td style="text-align: right;"><strong>@lang('Payment::labels.invoice.total')</strong></td>
                        <td>
                            <strong>{{ \Payments::currency($invoice->total) }}</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
