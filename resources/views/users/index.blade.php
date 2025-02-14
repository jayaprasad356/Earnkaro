@extends('layouts.admin')

@section('page-title')
    {{ __('Manage users') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('users') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
            <form action="{{ route('users.index') }}" method="GET" class="mb-3">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label for="filter_date">{{ __('Filter by Date') }}</label>
                    <input type="date" name="filter_date" id="filter_date" class="form-control" value="{{ request()->get('filter_date') }}" onchange="this.form.submit()">
                </div>
            </div>
            </form>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Actions') }}</th>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Mobile') }}</th>
                                <th>{{ __('Password') }}</th>
                                <th>{{ __('Recharge') }}</th>
                                <th>{{ __('Total Recharge') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Age') }}</th>
                                <th>{{ __('City') }}</th>
                                <th>{{ __('State') }}</th>
                                <th>{{ __('Refer Code') }}</th>
                                <th>{{ __('Referred By') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th>{{ __('Total Income') }}</th>
                                <th>{{ __('Today Income') }}</th>
                                <th>{{ __('Earning Wallet') }}</th>
                                <th>{{ __('Bonus Wallet') }}</th>
                                <th>{{ __('Device ID') }}</th>
                                <th>{{ __('Account Number') }}</th>
                                <th>{{ __('Holder Name') }}</th>
                                <th>{{ __('Bank') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('IFSC') }}</th>
                                <th>{{ __('Total Assets') }}</th>
                                <th>{{ __('Total Withdrawals') }}</th>
                                <th>{{ __('Team Income') }}</th>
                                <th>{{ __('Registered Datetime') }}</th>
                                <!-- <th>{{ __('Profile') }}</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="Action">
                                        <!-- <div class="action-btn bg-info ms-2">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div> -->
                                        <div class="action-btn bg-danger ms-2">
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm align-items-center bs-pass-para" 
                                                        data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                        onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class="ti ti-trash text-white"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ ucfirst($user->name) }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>{{ $user->password }}</td>
                                    <td>{{ $user->recharge }}</td>
                                    <td>{{ $user->total_recharge }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->age }}</td>
                                    <td>{{ $user->city }}</td>
                                    <td>{{ $user->state }}</td>
                                    <td>{{ $user->refer_code }}</td>
                                    <td>{{ $user->referred_by }}</td>
                                    <td>{{ $user->balance }}</td>
                                    <td>{{ $user->total_income }}</td>
                                    <td>{{ $user->today_income }}</td>
                                    <td>{{ $user->earning_wallet }}</td>
                                    <td>{{ $user->bonus_wallet }}</td>
                                    <td>{{ $user->device_id }}</td>
                                    <td>{{ $user->account_num }}</td>
                                    <td>{{ $user->holder_name }}</td>
                                    <td>{{ $user->bank }}</td>
                                    <td>{{ $user->branch }}</td>
                                    <td>{{ $user->ifsc }}</td>
                                    <td>{{ $user->total_assets }}</td>
                                    <td>{{ $user->total_withdrawal }}</td>
                                    <td>{{ $user->team_income }}</td>
                                    <td>{{ $user->registered_datetime }}</td>
                                    <!-- <td>
                                        @if($user->avatar && $user->avatar->image)
                                            <a href="{{ asset('storage/app/public/' . $user->avatar->image) }}" data-lightbox="image-{{ $user->avatar->id }}">
                                                <img class="user-img img-thumbnail img-fluid" 
                                                    src="{{ asset('storage/app/public/' . $user->avatar->image) }}" 
                                                    alt="Avatar Image" 
                                                    style="max-width: 100px; max-height: 100px;">
                                            </a>
                                        @else
                                            {{ __('No Avatar') }}
                                        @endif
                                    </td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#pc-dt-simple').DataTable();
    });
</script>
@endsection
