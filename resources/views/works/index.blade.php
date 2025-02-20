
@extends('layouts.admin')

@section('page-title')
    {{ __('Works List') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Works List') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
              <!-- Default Image Download Button -->
              @if($news && $news->download_today_image)
                <div class="mb-3">
                    <a href="{{ asset('admin/storage/app/public/' . $news->download_today_image) }}" download="news_image_{{ $news->id }}.jpg">
                        <i class="fa fa-download"></i> {{ __('Download Today Image') }}
                    </a>
                </div>
            @endif

         <form action="{{ route('works.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="image">{{ __('Upload Image') }}</label>
                        <input type="file" class="form-control" name="image" id="image" required>
                    </div>
                    
                    <input type="hidden" name="user_id" value="{{ session('user_id', '') }}">
                    <input type="hidden" name="status" value="0">

                    <button type="submit" class="btn btn-success">{{ __('Submit') }}</button>
                </form>
                <br>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('User Name') }}</th>
                                <th>{{ __('Mobile') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Image') }}</th>
                                <!-- <th>{{ __('Download') }}</th> -->
                                <th>{{ __('DateTime') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($works as $work)
                                <tr>
                                    <td>{{ $work['id'] }}</td>
                                    <td>{{ $work->user->name ?? 'N/A' }}</td>
                                    <td>{{ $work->user->mobile ?? 'N/A' }}</td>
                                    <td>
                                        @if($work->status == 0)
                                            <i class="fa fa-clock text-warning"></i> <span class="font-weight-bold">{{ __('Not-Verified') }}</span>
                                        @elseif($work->status == 1)
                                            <i class="fa fa-check-circle text-success"></i> <span class="font-weight-bold">{{ __('Verified') }}</span>
                                        @elseif($work->status == 2)
                                            <i class="fa fa-times-circle text-danger"></i> <span class="font-weight-bold">{{ __('Rejected') }}</span>
                                        @else
                                            <i class="fa fa-question-circle text-secondary"></i> <span class="font-weight-bold">{{ __('Unknown') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($work->image)
                                            <a href="{{ asset('storage/app/public/' . $work->image) }}" data-lightbox="image-{{ $work->id }}">
                                                <img class="user-img img-thumbnail img-fluid" 
                                                    src="{{ asset('storage/app/public/' . $work->image) }}" 
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
                                    <!-- <td>
                                        <a href="{{ asset($work->image ? 'storage/app/public/' . $work->image : 'storage/default.jpg') }}" 
                                           download="work_image_{{ $work->id }}.jpg" 
                                           class="btn btn-primary btn-sm">
                                            {{ __('Download Image') }}
                                        </a>
                                    </td> -->
                                    <td>{{ $work['datetime'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
