@extends('layouts.admin')

@section('page-title')
    {{ __('Dashboard') }}
@endsection

@php
    $setting = App\Models\Utility::settings();
@endphp

@section('content')
    <div class="row">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="col-xxl-12">
            <div class="row">

                <!-- Total Income Box -->
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-success">
                                            <i class="ti ti-wallet"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Total') }}</small>
                                            <h6 class="m-0">{{ __('Income') }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-success">{{ number_format($total_income, 2) }}</h4>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a  class="btn btn-success">
                                    {{ __('Enter Amount') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Balance Box -->
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-info">
                                            <i class="ti ti-credit-card"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Current') }}</small>
                                            <h6 class="m-0">{{ __('Balance') }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-info">{{ number_format($balance, 2) }}</h4>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a class="btn btn-info">
                                    {{ __('Enter Amount') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recharge Value Box -->
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-warning">
                                            <i class="ti ti-receipt"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Total') }}</small>
                                            <h6 class="m-0">{{ __('Recharges') }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-warning">{{ number_format($recharge_value, 2) }}</h4>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a  class="btn btn-warning">
                                    {{ __('Enter Amount') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
