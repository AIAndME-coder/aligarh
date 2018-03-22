@extends('admin.layouts.printable')
@section('title', 'Fee Receipts Statment | ')

@section('head')

	<style type="text/css">
		.invoice-title h2, .invoice-title h3 {
			display: inline-block;
		}

		.table > tbody > tr > .no-line {
			border-top: none;
		}

		.table > thead > tr > .no-line {
			border-bottom: none;
		}

		.table > tbody > tr > .thick-line {
			border-top: 1px solid;
		}


    body {
      padding: 0px 10px;
      margin: 0px;
      font-size: 12px;
      }
    .table-bordered th,
    .table-bordered td {
      border: 1px solid black !important;
      padding: 0px;
    }   

  .table > tbody > tr > td {
      padding: 1px;
    }
    a[href]:after {
      content: none;
/*      content: " (" attr(href) ")";*/
    }


@media print{
	table > thead {
		background: blue;
		color: white;
	}
}


	</style>

@endsection

@section('content')
<div class="container-fluid">

	<div class="row">
	<h3>Daily Fee Collection Report</h3>
	<h4>Between: ( {{ Carbon\Carbon::createFromFormat('Y-m-d', $betweendates['start'])->Format('M-Y') }} TO {{ Carbon\Carbon::createFromFormat('Y-m-d', $betweendates['end'])->Format('M-Y') }} )</h3>
		
		@foreach($daily_fee_collection AS $date => $fee_collection)
		<hr>
		<h4>{{ Carbon\Carbon::createFromFormat('Y-m-d', $date)->Format('D, M d, Y') }}</h4>
		<table id="rpt-att" class="table table-bordered">
			<thead>
			  <tr>
			  	<th>Fee Description / Mode of Payment</th>
			  	<th>Cash</th>
			  	<th>Bank</th>
			  	<th>Total</th>
			  </tr>
			</thead>
			<tbody>
				@foreach($fee_collection AS $collection)
				<tr>
					<td>{{ $collection->fee_name }}</td>
					<td>{{ $collection->cash }}</td>
					<td>{{ $collection->chalan }}</td>
					<td>{{ $collection->amount }}</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th class="text-right">Total</th>
					<th>{{ $fee_collection->sum('cash') }}/=</th>
					<th>{{ $fee_collection->sum('chalan') }}/=</th>
					<th>{{ $fee_collection->sum('amount') }}/=</th>
				</tr>
			</tfoot>
		</table>
		@endforeach
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Total</th>
					<th>{{ $total_cash_amount }}/=</th>
					<th>{{ $total_chalan_amount }}/=</th>
					<th>{{ $net_total_amount }}/=</th>
				</tr>
			</thead>
		</table>
	</div>

</div>

@include('admin.includes.footercopyright')

@endsection


@section('script')
<script type="text/javascript">

	window.print();

</script>

@endsection

@section('vue')


@endsection