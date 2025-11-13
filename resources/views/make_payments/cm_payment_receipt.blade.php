@extends('layouts.print')

@section('title')
Payment Receipt @parent
@stop

@section('content')
<div style="width: 300px; margin: 0 auto; padding: 10px; font-family: 'monospace', 'Courier New', Courier, monospace; font-size: 12px;">
    <div style="text-align: center; margin-bottom: 15px;">
        <h3>Payment Receipt</h3>
        <p>-----------------------------------</p>
    </div>

    <p>Package: {{ $package->name ?? 'N/A' }}</p>
    <p>Package Type: {{ $package->type ?? 'N/A' }}</p>
    <p>Package Desc: {{ $package->description ?? 'N/A' }}</p>
    <p>Amount: {{ $package->amount ?? 'N/A' }}</p>
    <p>Transaction ID: {{ $package->trn_id ?? 'N/A' }}</p>
    <p>Status: {{ $package->pay_status ?? 'N/A' }}</p>
    <p>Paid At: {{ $package->updated_at ? $package->updated_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
    <p>-----------------------------------</p>

    <div style="text-align: center; margin-top: 15px;">
        <p>Thank You for your payment!</p>
        <p>-----------------------------------</p>
        <p>Date: {{ date('Y-m-d H:i:s') }}</p>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <button class="btn btn-success" onclick="window.print()">Print Receipt</button>
    </div>
</div>
@endsection
