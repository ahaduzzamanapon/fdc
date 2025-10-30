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

    <p><strong>Film Application Details:</strong></p>
    <p>Film Title: {{ $filmPackage->filmApplication->film_title ?? 'N/A' }}</p>
    <p>Applicant: {{ $filmPackage->filmApplication->applicant_name ?? 'N/A' }}</p>
    <p>Phone: {{ $filmPackage->filmApplication->phone_number ?? 'N/A' }}</p>
    <p>Email: {{ $filmPackage->filmApplication->email ?? 'N/A' }}</p>
    <p>Organization: {{ $filmPackage->filmApplication->organization_name ?? 'N/A' }}</p>
    <p>Org. Phone: {{ $filmPackage->filmApplication->organization_phone ?? 'N/A' }}</p>
    <p>Film Serial No: {{ $filmPackage->filmApplication->film_serial_no ?? 'N/A' }}</p>
    <p>Film Type: {{ $filmPackage->filmApplication->film_type ?? 'N/A' }}</p>
    <p>Production Start: {{ $filmPackage->filmApplication->production_start_date ?? 'N/A' }}</p>
    <p>Film Duration: {{ $filmPackage->filmApplication->film_duration ?? 'N/A' }}</p>
    <p>-----------------------------------</p>

    <p><strong>Payment Details:</strong></p>
    <p>Package: {{ $filmPackage->package->name ?? 'N/A' }}</p>
    <p>Package Type: {{ $filmPackage->package->type ?? 'N/A' }}</p>
    <p>Package Desc: {{ $filmPackage->package->description ?? 'N/A' }}</p>
    <p>Amount: {{ $filmPackage->amount ?? 'N/A' }}</p>
    <p>Transaction ID: {{ $filmPackage->trn_id ?? 'N/A' }}</p>
    <p>Status: {{ $filmPackage->status ?? 'N/A' }}</p>
    <p>Paid At: {{ $filmPackage->updated_at ? $filmPackage->updated_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
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