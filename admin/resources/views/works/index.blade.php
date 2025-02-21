@extends('layouts.admin')

@section('page-title')
    {{ __('Whatsapp Status List') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Whatsapp Status List') }}</li>
@endsection

@section('content')
<div class="row">
    
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- Filter by Type Form -->
                <form action="{{ route('works.index') }}" method="GET" class="mb-3">
                    <div class="row align-items-end">
                        <!-- Existing Status Filter -->
                        <div class="col-md-3">
                            <label for="status">{{ __('Filter by Status') }}</label>
                            <select name="status" id="status" class="form-control status-filter" onchange="this.form.submit()">
                                <option value="">{{ __('All') }}</option>
                                <option value="0" {{ request()->get('status') == '0' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="1" {{ request()->get('status') == '1' ? 'selected' : '' }}>{{ __('Verified') }}</option>
                                <option value="2" {{ request()->get('status') == '2' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filter_date">{{ __('Filter by Date') }}</label>
                            <input type="date" name="filter_date" id="filter_date" class="form-control" value="{{ request()->get('filter_date') }}" onchange="this.form.submit()">
                        </div>


                    </div>
                </form>

                <form action="{{ route('works.bulkUpdateStatus') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3 d-flex align-items-center">
                        <!-- Select All Checkbox -->
                        <div class="mr-3">
                            <input type="checkbox" id="select-all">
                            <label for="select-all">{{ __('Select All') }}</label>
                        </div>


                        <!-- Paid Button -->
                        <button type="submit" name="new_status" value="1" class="btn btn-success ml-3"
                            onclick="return confirm('{{ __('Are you sure you want to mark selected as verified?') }}')">
                            {{ __('Verified') }}
                        </button>

                        <!-- Cancel Button -->
                        <button type="submit" name="new_status" value="2" class="btn btn-danger ml-2"
                            onclick="return confirm('{{ __('Are you sure you want to cancel selected ID?') }}')">
                            {{ __('Cancel') }}
                        </button>
                    </div>

                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>{{ __('Select') }}</th> 
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Mobile') }}</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Datetime') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($works as $work)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="works_ids[]" value="{{ $work->id }}">
                                        </td>
                                      
                                        <td>{{ $work->id }}</td>
                                        <td>{{ ucfirst($work->users->name ?? '') }}</td>
                                        <td>{{ $work->users->mobile ?? '' }}</td>
                                        <td>
                                        @if($work->image)
                                            <a href="{{ ('https://greenkaro.jiyoapp.in/storage/app/public/' . $work->image) }}" data-lightbox="image-{{ $work->id }}">
                                                <img class="user-img img-thumbnail img-fluid" 
                                                    src="{{('https://greenkaro.jiyoapp.in/storage/app/public/' . $work->image) }}" 
                                                    alt="Image" 
                                                    style="max-width: 100px; max-height: 100px;">
                                            </a>
                                        @else
                                            <img class="user-img img-thumbnail img-fluid" 
                                                src="{{ asset('storage/default.jpg') }}" 
                                                alt="Default Image" 
                                                style="max-width: 100px; max-height: 100px;">
                                        @endif
                                    </td>
                                        <td>
                                            @if($work->status == 0)
                                                <i class="fa fa-clock text-warning"></i> <span class="font-weight-bold">{{ __('Pending') }}</span>
                                            @elseif($work->status == 1)
                                                <i class="fa fa-check-circle text-success"></i> <span class="font-weight-bold">{{ __('Verified') }}</span>
                                            @elseif($work->status == 2)
                                                <i class="fa fa-times-circle text-danger"></i> <span class="font-weight-bold">{{ __('Cancelled') }}</span>
                                            @else
                                                <i class="fa fa-question-circle text-secondary"></i> <span class="font-weight-bold">{{ __('Unknown') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $work->datetime }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
@endsection

        <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
        <script>
         $(document).ready(function () {
    // Handle "Select All" checkbox
    $('#select-all').change(function() {
        // Get the state of the "Select All" checkbox
        var isChecked = $(this).prop('checked');

        // Select or deselect all individual checkboxes
        $('input[name="works_ids[]"]').prop('checked', isChecked);
    });

    // Handle individual checkboxes
    $('input[name="works_ids[]"]').change(function() {
        // If any individual checkbox is unchecked, uncheck the "Select All" checkbox
        if ($('input[name="works_ids[]"]:not(:checked)').length > 0) {
            $('#select-all').prop('checked', false); // Uncheck "Select All" checkbox
        } else {
            $('#select-all').prop('checked', true); // Check "Select All" checkbox if all are selected
        }
    });
});

        </script>