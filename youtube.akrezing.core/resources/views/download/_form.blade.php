@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="m-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form enctype="multipart/form-data" action="{{ route('downloads.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="input-group my-3">
                <button class="btn btn-success" type="submit">{{ __('Add') }}</button>
                <input name="key" class="form-control" value="{{ old('key') }}" />
                <span class="input-group-text" dir="ltr">https://www.youtube.com/watch?v=</span>
            </div>
        </div>
    </div>
</form>
