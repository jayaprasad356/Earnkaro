@extends('layouts.admin')

@section('page-title')
    {{ __('Edit user') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('users') }}</a></li>
@endsection
<style>
    /* Style for Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch label {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 34px;
    }

    .switch label:before {
        content: "";
        position: absolute;
        left: -3px;
        top: 4px;
        width: 26px;
        height: 26px;
        background-color: white;
        border-radius: 50%;
        transition: 0.4s;
    }

    /* When checked, move the slider */
    .switch input:checked + label {
        background-color: #4CAF50;
    }

    .switch input:checked + label:before {
        transform: translateX(26px);
    }

    /* Disabled state */
    .switch input:disabled + label {
        background-color: #e0e0e0;
    }

    .switch input:disabled + label:before {
        background-color: #bdbdbd;
    }

    .form-group .switch-container {
        display: flex;
        align-items: center;
    }

    .form-group .switch-container label {
        margin-left: 10px;
    }
</style>
@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                 <!-- Open Modal for Add Coins -->
                 <a href="#" data-bs-toggle="modal" data-bs-target="#addRechargeModal" class="btn btn-primary ms-auto">{{ __('Add Recharge') }}</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#addBalanceModal" class="btn btn-success ms-auto">{{ __('Add Balance') }}</a>
            </div>

            <div class="card-body">
                {{ Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}

                <div class="modal-body">
                    <div class="row">
                        <!-- Avatar Dropdown -->
                        <div class="form-group col-md-6">
                            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                            {{ Form::text('name', null, ['class' => 'form-control', 'required']) }}
                        </div>

                        <!-- Mobile Number -->
                        <div class="form-group col-md-6">
                            {{ Form::label('mobile', __('Mobile'), ['class' => 'form-label']) }}
                            {{ Form::text('mobile', null, ['class' => 'form-control', 'required']) }}
                        </div>

                        <!-- Age -->
                        <div class="form-group col-md-6">
                            {{ Form::label('age', __('Age'), ['class' => 'form-label']) }}
                            {{ Form::number('age', null, ['class' => 'form-control']) }}
                        </div>


                        <div class="form-group col-md-6">
                        <label for="gender">{{ __('Gender') }}</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">{{ __('Select Gender') }}</option>
                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>{{ __('male') }}</option>
                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>{{ __('female') }}</option>
                        </select>
                        @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-md-6">
                            {{ Form::label('pincode', __('Pincode'), ['class' => 'form-label']) }}
                            {{ Form::number('pincode', null, ['class' => 'form-control']) }}
                        </div>


                        <div class="form-group col-md-6">
                            {{ Form::label('balance', __('Balance'), ['class' => 'form-label']) }}
                            {{ Form::number('balance', null, ['class' => 'form-control']) }}
                        </div>


                        <div class="form-group col-md-6">
                            {{ Form::label('recharge', __('Recharge'), ['class' => 'form-label']) }}
                            {{ Form::number('recharge', null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('Refer Code', __('Refer Code'), ['class' => 'form-label']) }}
                            {{ Form::text('refer_code', null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('Level 1 Refer', __('Level 1 Refer'), ['class' => 'form-label']) }}
                            {{ Form::text('level_1_refer', null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('Level 2 Refer', __('Level 2 Refer'), ['class' => 'form-label']) }}
                            {{ Form::text('level_2_refer', null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('Level 3 Refer', __('Level 3 Refer'), ['class' => 'form-label']) }}
                            {{ Form::text('level_3_refer', null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-md-6">
                            {{ Form::label('Level 4 Refer', __('Level 4 Refer'), ['class' => 'form-label']) }}
                            {{ Form::text('level_4_refer', null, ['class' => 'form-control']) }}
                        </div>

                        <div class="form-group col-md-6">
                            <br>
                            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                            <div class="btn-group" role="group" aria-label="Status">
                                <input type="radio" class="btn-check" name="status" id="status_pending" value="0" {{ $user->status == 0 ? 'checked' : '' }}>
                                <label class="btn btn-outline-warning" for="status_pending">{{ __('Pending') }}</label>

                                <input type="radio" class="btn-check" name="status" id="status_verified" value="1" {{ $user->status == 1 ? 'checked' : '' }}>
                                <label class="btn btn-outline-success" for="status_verified">{{ __('Verified') }}</label>

                                <input type="radio" class="btn-check" name="status" id="status_blocked" value="2" {{ $user->status == 2 ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger" for="status_blocked">{{ __('Cancelled') }}</label>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
                    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add Coins -->
<div class="modal fade" id="addRechargeModal" tabindex="-1" aria-labelledby="addCoinsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRechargeModalLabel">{{ __('Add Recharge to user') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.addRecharge', $user->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="recharge">{{ __('Recharge to Add') }}</label>
                        <input type="number" id="recharge" name="recharge" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">{{ __('Add Recharge') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addBalanceModal" tabindex="-1" aria-labelledby="addBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBalanceModalLabel">{{ __('Add Balance to user') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.addBalance', $user->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="coins">{{ __('Balance to Add') }}</label>
                        <input type="number" id="balance" name="balance" class="form-control" required>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">{{ __('Add Balance') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    
</script>
@endsection
