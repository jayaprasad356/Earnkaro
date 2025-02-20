@extends('layouts.admin')

@section('page-title')
    {{ __('Edit Settings') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Settings') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Edit Settings') }}</h5>
            </div>
            <div class="card-body">
        <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="telegram_link">Telegram Link</label>
                <input type="text" class="form-control" id="telegram_link" name="telegram_link" value="{{ $news->telegram_link }}" required>
            </div>

            <div class="form-group">
                <label for="support_mail">Customer Support Number</label>
                <input type="number" class="form-control" id="customer_support_number" name="customer_support_number" value="{{ $news->customer_support_number }}" required>
            </div>

            <div class="form-group">
                <label for="minimum_withdrawals">Minimum Withdrawals</label>
                <input type="number" class="form-control" id="minimum_withdrawals" name="minimum_withdrawals" value="{{ $news->minimum_withdrawals }}" required>
            </div>

            <div class="form-group">
                <label for="whatsapp_status_income">Whatsapp Status Income</label>
                <input type="number" class="form-control" id="whatsapp_status_income" name="whatsapp_status_income" value="{{ $news->whatsapp_status_income }}" required>
            </div>

            <div class="form-group">
                <label for="download_today_image">Download Today Image</label>
                @if($news->download_today_image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/app/public/' . $news->download_today_image) }}" alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                @endif
                <input type="file" class="form-control" id="download_today_image" name="download_today_image">
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
<script src="//cdn.ckeditor.com/4.21.0/full-all/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        CKEDITOR.replace('privacy_policy', {
            extraPlugins: 'colorbutton'
        });
    });
</script>
@endsection
