@extends('layouts.admin')

@section('page-title')
    {{ __('Withdrawals List') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Withdrawals List') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- Filter by Type Form -->
                <form action="{{ route('withdrawals.index') }}" method="GET" class="mb-3">
                    <div class="row align-items-end">
          

                        <div class="col-md offset-md-3 d-flex justify-content-end">
                        <a href="{{ route('withdrawals.show') }}" class="btn btn-primary">
                                {{ __('Withdrawal Request') }}
                            </a>
                        </div>

                    </div>
                </form>


                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Bank') }}</th>
                                    <th>{{ __('Branch') }}</th>
                                    <th>{{ __('Ifsc Code') }}</th>
                                    <th>{{ __('Account Number') }}</th>
                                    <th>{{ __('Holder Name') }}</th>
                                    <th>{{ __('Datetime') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawals as $withdrawal)
                                    <tr>
                                       
                                        <td>{{ $withdrawal->amount }}</td>
                                        <td>
                                            @if($withdrawal->status == 0)
                                                <i class="fa fa-clock text-warning"></i> <span class="font-weight-bold">{{ __('Pending') }}</span>
                                            @elseif($withdrawal->status == 1)
                                                <i class="fa fa-check-circle text-success"></i> <span class="font-weight-bold">{{ __('Paid') }}</span>
                                            @elseif($withdrawal->status == 2)
                                                <i class="fa fa-times-circle text-danger"></i> <span class="font-weight-bold">{{ __('Cancelled') }}</span>
                                            @else
                                                <i class="fa fa-question-circle text-secondary"></i> <span class="font-weight-bold">{{ __('Unknown') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $withdrawal->users->bank ?? '' }}</td>
                                        <td>{{ $withdrawal->users->branch ?? '' }}</td>
                                        <td>{{ $withdrawal->users->ifsc ?? '' }}</td>
                                        <td>{{ $withdrawal->users->account_num ?? '' }}</td>
                                        <td>{{ $withdrawal->users->holder_name ?? '' }}</td>
                                        <td>{{ $withdrawal->datetime }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
@endsection
