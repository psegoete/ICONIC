{{-- <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
        <meta charset="utf-8">
        <title>Bill</title>
        <style>
            body{
                width: 100%;
                padding: 1.5%;
            },
            table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 20px;
            },
            .table thead {
                background: #415164;
                color: #fff;
                border: 0;
            },.table {
                width: 100%;
                margin-bottom: 1rem;
                background-color: transparent;
            },
            .bold, b, strong {
                font-weight: 500;
            },
            table {
                border-collapse: collapse;
            },
            table {
                display: table;
                border-collapse: separate;
                box-sizing: border-box;
                border-spacing: 0px;
                border-color: grey;
            },
            .table th {
                height: 30px;
                border-top: 0px solid #a4b7c1;
            }
        </style>
</head>
<body>
<div class="body">
    <div width="100%; display: inline;">
        <div style="float: left;background-color: black">
        </div>
        <div style="float: right;" >
            <table class="table text-right">
                <tbody>
                   <tr id="subtotal">
                       <td width="60%"></td>
                       <td></td>
                       <td class="subtotal" align="right"><h2 style="margin: 0;">{{ $company->company_name }}</h2></td>
                    </tr>
                    <tr>
                        <td width="60%"></td>
                        <td></td>
                        <td class="total" align="right"><p style="margin: 0;">{{ $company->address1 }}</p></td>
                    </tr>
                    <tr>
                        <td width="60%"></td>
                        <td></td>
                        <td class="total" align="right"><p style="margin: 0;">{{ $company->address2 }}</p></td>
                    </tr>
                    <tr>
                        <td width="60%"></td>
                        <td></td>
                        <td class="total" align="right"><p style="margin: 0;">{{ $company->country }}</p></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

   

    <div style="text-align: right; padding-top: 100px">
        <h4 style="margin: 0;">Bill To</h4>
        <p style="margin: 0;">{{ $customer }}</p>
    </div>

    <div style="text-align: right; padding-top: 20px">
        <div >
            <table class="table text-right">
                <tbody>
                   <tr id="subtotal">
                       <td width="40%"></td>
                       <td>ORDER DATE</td>
                       <td class="subtotal" align="right"><p style="margin: 0;">INVOICE DATE</p></td>
                    </tr>
                    <tr>
                        <td width="40%"></td>
                        <td>{{\Carbon\Carbon::parse($order->created_at)->format('yy-m-d') }}</td>
                        <td class="total" align="right"><p style="margin: 0;">{{ \Carbon\Carbon::parse($invoice->created_at)->format('yy-m-d') }}</p></td>
                    </tr>
                    <tr >
                        <td width="40%"></td>
                        <td>ORDER REFERENCE</td>
                        <td class="total" align="right"><p style="margin: 0;">INVOICE NUMBER</p></td>
                    </tr>
                    <tr>
                        <td width="40%"></td>
                        <td>{{ $order->order_reference }}</td>
                        <td class="total" align="right"><p style="margin: 0;">{{ $invoice->invoice_no }}<</p></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="text-align: right; padding-top: 20px">
        <div class="table-responsive">
           <table class="table items items-preview invoice-items-preview" data-type="invoice">
               <thead>
                   <tr>
                       <th align="center">{{ '#' }}</th>
                        <th class="description" width="38%" align="left">Item</th>
                        <th align="right">Qty</th>
                        <th align="right">Rate</th>
                        <th align="right">Tax</th>
                        <th align="center">Amount</th>
                    </tr></thead><tbody><tr>
                        <td align="center" width="5%">1</td>
                        <td class="description" align="left;" width="33%">{{ $order->description }}</td>
                        <td align="right" width="9%">1</td>
                        <td align="right" width="9%">{{ $order->amount }}</td>
                        <td align="right" width="9%">0%</td>
                        <td class="amount" align="center" width="9%">{{ $order->amount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
     </div>

     <div style="text-align: right; padding-top: 20">
        <table class="table text-right">
            <tbody>
               <tr id="subtotal">
                   <td width="60%"></td>
                   <td><span class="bold" align="right">Sub Total</span></td>
                   <td class="subtotal" align="right">R{{ $order->amount }}</td>
                </tr>
                <tr>
                    <td width="60%"></td>
                    <td><span class="bold" align="right">Total</span></td>
                    <td class="total" align="right">R{{ $order->amount }}</td>
                </tr>
                <tr>
                    <td width="60%"></td>
                    <td><span class="bold" align="right">Total Paid</span></td>
                    <td align="right">-R{{ $order->amount }}</td>
                </tr>
                <tr>
                    <td width="60%"></td>
                    <td><span class="bold" align="right">Amount Due</span></td>
                    <td align="right"><span align="right">R0.00</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html> --}}

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style type="text/css">


      .wrapper {
            font-family: Tahoma, Verdana, sans-serif;
            font-size: medium;
            line-height: 1.6;
        }

        .header {
            width: 100%;
            height: 20%;
        }

        .logo {
            width: 30%;
            height: 20%;
            float: left;

        }

        .address {
            width: 70%;
            height: 20%;
            float: left;
        }

        .invoice-heading {
            width: 100%;
            height: 3.5%;
        }

        body {
            margin:0;
            padding:0;
        }

        .information {
            width: 100%;
            height: 25%;
        }

        .customer {
            width: 33.3%;
            height: 35%;
            float: left;
        }

        .order-details {
            width: 33.3%;
            height: 35%;
            float: left;
        }

        .invoice-details {
            width: 33.3%;
            height: 35%;
            float: left;
        }

        .order-date {
            height:15%;
            width: 100%;
        }

        .order-reference {
            height:15%;
            width: 100%;
        }

        .invoice-date {
            height:15%;
            width: 100%;
        }

        .invoice-number {
            height:15%;
            width: 100%;
        }

        .invoice-information {
            width: 90%;
            margin-left: 5%;
            margin-right: 5%;
        }

        img {
            margin-top: 7%;
            margin-bottom: 2%;
            margin-left: 15%;
            width:63%;
        }

        .address-para {
            margin-top: 2.5%;
            margin-left: 4%;
            line-height: 1.6;
        }

/* eks hier */
        .invoice-para {
            font-size: xx-large;
            text-align: right;
            margin-right: 5%;
            padding: 0;
            color: grey;
            line-height: 1;
        }

        .customer-para {
            margin-left: 15%;
            margin-top: 0;
        }

        .order-date-para {
            margin-top: 0;
        }

        .order-reference-para {
            margin-top: 0;
        }

        .invoice-date-para{
            margin-top: 0;
            text-align: right;
            margin-right: 15%;
        }
        .invoice-number-para {
            margin-top: 0;
            text-align: right;
            margin-right: 15%;
        }

        .table-header-description {
            padding: 5px;
        }

        .table-header-price {
            padding: 5px;
        }

        .table-header-quantity {
            padding: 5px;
        }

        .table-header-total {
            text-align: right;
            padding: 5px;
        }

        .table-data-description {
            padding: 5px;
        }

        .table-data-price {
            padding: 5px;
        }

        .table-data-quantity {
            padding: 5px;
        }

        .table-data-total {
            padding: 5px;
        }

        .subtotal {
            padding: 5px;
        }

        .VAT {
            padding: 5px;
        }

        .total {
            padding: 5px;
        }

        .inv-info-table {
            width: 100%;

        }

        tr.row-double td {
            border-bottom: double grey;
        }

        tr.row-solid td {
            border-bottom: solid rgb(214, 214, 214);
        }

        tr.row-double th {
            border-bottom: double grey;
        }

        .total-col {
            text-align: right;
            padding: 5px;
        }
        .table-header-quantity {
            text-align: right;
            padding: 5px;
        }

        .table-header-total, .table-header-price, .table-header-quantity {
            width:15%;
        }

        .table-header-description {
            width:55%;
            text-align: left;
        }

        .subtotal, .VAT, .total {
            text-align: right;
            padding-right: 1%;
        }

        .table-header-price, .table-header-quantity, .price-col,  .quantity-col{
            text-align: center;
        }

        .subtotal, .VAT, .total {
          padding-right: 7%;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        <div class="header">
            <div class="logo">
                <img src="{{ $logo }}" alt="Eagle Eye Logo">
            </div>
            <div class="address">
                <p class="address-para">
                    <b>{{ $company->company_name }}<br/>
                    {{ $company->address1 }}<br/>
                    {{ $company->address2 }}<br/>
                    {{ $company->zipcode }} {{ $company->city }}<br/>
                    {{ $company->province }} {{ $company->country }}<br/>
                </p>
            </div>
        </div>

        <div class="invoice-heading">
            <p class="invoice-para">Invoice</p>
        </div>

        <div class="information">

            <div class="customer">
                <p class="customer-para">
                    <b>CUSTOMER</b><br/>
                    {{ $customer->name }} <br/>
                    {{ $customer->address1 }} <br/>
                    {{ $customer->address2 }}<br/>
                    {{ $customer->zipcode }} {{ $customer->city }}<br/>
                    {{ $customer->province }} {{ $customer->country }}
                </p>
            </div>

            <div class="order-details">

                <div class="order-date">
                    <p class="order-date-para">
                        <b>ORDER DATE</b><br/>
                        {{\Carbon\Carbon::parse($order->created_at)->format('yy-m-d') }}
                    </p>
                </div>

                <div class="order-reference">
                    <p class="order-reference-para">
                        <b>ORDER REFERENCE</b><br/>
                        {{ $order->order_reference }}
                    </p>
                </div>

            </div>

            <div class="invoice-details">

                <div class="invoice-date">
                    <p class="invoice-date-para">
                        <b>INVOICE DATE</b><br/>
                        {{ \Carbon\Carbon::parse($invoice->created_at)->format('yy-m-d') }}
                    </p>
                </div>

                <div class="invoice-number">
                    <p class="invoice-number-para">
                        <b>INVOICE NUMBER</b><br/>
                        {{ $invoice->invoice_no }}
                    </p>
                </div>

            </div>

        </div>

        <div class="invoice-information">
            <table class="inv-info-table" cellspacing=0>
                <tr class="row-double">
                    <th class="table-header-description">
                        <b>Description<br/>
                    </th>
                    <th class="table-header-price">
                        <b>Price<br/>
                    </th>
                    <th class="table-header-quantity">
                        <b>Quantity<br/>
                    </th>
                    <th class="table-header-total">
                        <b>Total<br/>
                    </th>
                </tr>

                <tr class="row-double">
                    <td class="table-data-description">
                        1 {{ $order->description }}
                    </td>
                    <td class="price-col">
                        {{ $order->amount }}
                    </td>
                    <td class="quantity-col">
                        1
                    </td>
                    <td class="total-col">
                        {{ $order->amount }}
                    </td>
                </tr>

                <tr class="row-solid">
                    <td class="subtotal">
                        Subtotal
                    </td>
                    <td></td>
                    <td></td>
                    <td class="total-col">
                        {{ $order->amount }}
                    </td>
                </tr>
                <tr class="row-double">
                    <td class="VAT">
                        VAT(0%)
                    </td>
                    <td></td>
                    <td></td>
                    <td class="total-col">
                        R 0.00
                    </td>
                </tr>
                <tr class="row-solid">
                    <td class="total">
                        <b>Total<br/>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="total-col">
                        <b>{{ $order->amount }}<br/>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>
