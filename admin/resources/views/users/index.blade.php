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
                 <!-- <div class="col-md-3 ms-auto">
                            <label for="search">{{ __('Search All Users') }}</label>
                            <input type="text" name="search" id="search" class="form-control"
                             value="{{ request()->get('search') }}" placeholder="Enter Name, Mobile">
                        </div>
                 </div> -->
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
                                <th>{{ __('Age') }}</th>
                                <th>{{ __('Gender') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th>{{ __('Refer Code') }}</th>
                                <th>{{ __('Level 1 refer') }}</th>
                                <th>{{ __('Level 2 refer') }}</th>
                                <th>{{ __('Level 3 refer') }}</th>
                                <th>{{ __('Level 1 refer4') }}</th>
                                <th>{{ __('Registered DateTime') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                <td class="Action">
                                <div class="action-btn bg-info ms-2">
                                            <!-- Direct Link to Edit user Page -->
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm align-items-center" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
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
                                    <td>{{ $user->age }}</td>
                                    <td>{{ ucfirst($user->gender) }}</td>
                                    <td>{{ $user->balance }}</td>
                                    <td>{{ $user->refer_code }}</td>
                                    <td>{{ $user->level_1_refer }}</td>
                                    <td>{{ $user->level_2_refer }}</td>
                                    <td>{{ $user->level_3_refer }}</td>
                                    <td>{{ $user->level_4_refer }}</td>
                                    <td>{{ $user->registered_datetime }}</td>
                                    <td>
                                        <!-- Display Status with values 0, 1, and 2 -->
                                        @if($user->status == 0)
                                            <i class="fa fa-clock text-warning"></i> <span class="font-weight-bold">{{ __('Pending') }}</span>
                                        @elseif($user->status == 1)
                                            <i class="fa fa-check-circle text-success"></i> <span class="font-weight-bold">{{ __('Verified') }}</span>
                                        @elseif($user->status == 2)
                                            <i class="fa fa-times-circle text-danger"></i> <span class="font-weight-bold">{{ __('Cancelled') }}</span>
                                        @else
                                            <i class="fa fa-question-circle text-secondary"></i> <span class="font-weight-bold">{{ __('Unknown') }}</span>
                                        @endif
                                    </td>
                              
                                    <!-- Avatar Image -->
                                    <!-- Actions -->
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
