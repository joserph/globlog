<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Invoice #{{ $invoice->num_invoice }}</title>

		<style>
			.invoice-box {
				width: 100%;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 11px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}
			footer table {
				width: 100%;
				line-height: inherit;
			}
			footer table tr td:nth-child(2) {
				text-align: right;
			}
			.invoice-box table td {
				/* padding: 5px; */
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

            .invoice-box table tr.special td:nth-child(2) {
				text-align: left;
                width: 56%;
			}

            .invoice-box table tr.special td:nth-child(1) {
				text-align: left;
                width: 1%;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
				line-height: 16px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

            .invoice-box table tr.top table td.title2 {
				font-size: 16px;
				line-height: 16px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
				line-height: 16px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 2px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
            /* .muy_corto {
                width: 1px;
            }
            .corto {
                width: 10px;
            }
            .largo {
                width: 15px;
            } */
            /* .izq {
                text-align: left;
            } */
			footer {
				position: fixed;
				bottom: -50px;
				left: 0px;
				right: 0px;
				height: 50px;
				font-size: 10px;
				
			}
			span {
				text-align: right;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="6">
						<table>
							<tr>
								<td class="title2">
									{{-- <img
										src="https://sparksuite.github.io/simple-html-invoice-template/images/logo.png"
										style="width: 100%; max-width: 300px"
									/> --}}
                                    {{ $my_company->name }}<br /><br />
									{{ $my_company->address }}<br />
									{{ $my_company->state }}<br />
									{{ $my_company->city }} {{ $my_company->zip_code }}
								</td>

								<td>
									Invoice #: <strong>{{ $invoice->num_invoice }}</strong><br />
									Date: {{ date('d-M-Y', strtotime($invoice->date)) }}<br />
                                    @if ($invoice->load_id)
                                        BL: {{ $load }}<br />
                                    @else
                                        AWB: {{ $load }}<br />
                                    @endif
                                    Type: {{ Str::of($invoice->type)->upper() }}<br />
                                    Terms: {{ Str::of($invoice->terms)->upper() }}
									{{-- Due: February 1, 2023 --}}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="6">
						<table>
							<tr>
								<td>
									
								</td>

								<td>
                                    <strong>Bill To:</strong> <br />
									{{ $client->name }}<br />
									{{ $client->address }}<br />
									{{ $client->state }} <br />
									{{ $client->city }} {{ $client->zip_code }}<br />
									{{ $client->email }}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				{{-- <tr class="heading">
					<td>Payment Method</td>

					<td>Check #</td>
				</tr>

				<tr class="details">
					<td>Check</td>

					<td>1000</td>
				</tr> --}}
                @php
                    $total_pieces = 0;
                    $total_quantity = 0;
                    $total_amount = 0;
                @endphp
				<tr class="heading special">
					<td class="muy_corto">#</td>
                    <td class="largo izq">Description</td>
                    <td class="corto">Pieces</td>
                    <td class="corto">Quantity</td>
                    <td class="corto">Rate</td>
					<td class="corto">Amount</td>
				</tr>
                @foreach ($itemsInvoice as $key => $item)
                    @php
                        $total_pieces += $item->pieces;
                        $total_quantity += $item->quantity;
                        $total_amount += $item->amount;
                    @endphp
                    <tr class="item special">
                        <td>{{ ($key + 1) }}</td>
                        <td>{{ $item->description->name }}</td>
                        <td>{{ number_format($item->pieces, 2, '.','') }}</td>
                        <td>{{ number_format($item->quantity, 3, '.','') }}</td>
                        <td>{{ number_format($item->rate, 3, '.','') }}</td>
                        <td>${{ number_format($item->amount, 3, '.','') }}</td>
                    </tr>
                @endforeach
				{{-- <tr class="item last">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
				</tr> --}}

				<tr class="total special">
					<td></td>
                    <td>Grand Total:</td>
                    <td><strong>{{ number_format($total_pieces, 2, '.','') }}</strong></td>
                    <td><strong>{{ number_format($total_quantity, 2, '.','') }}</strong></td>
                    <td></td>
                    <td><strong>${{ number_format($total_amount, 2, '.','') }}</strong></td>
				</tr>
			</table>
            
		</div>
		<footer>
			<hr>
			@php
				date_default_timezone_set('America/Bogota');
			@endphp
			<table>
				<tr>
					<td>{{ date("d/m/Y h:i:s a") }}</td>
					<td>Record# {{ $invoice->num_invoice }}</td>
				</tr>
			</table>
		</footer>
	</body>
</html>