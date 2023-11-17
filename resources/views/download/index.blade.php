@extends('app')

@section('content')
    @include('download._form')
    @if ($downloads->hasPages())
        {{ $downloads->onEachSide(5)->links() }}
    @endif
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Video</th>
                <th>Description</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($downloads as $download)
                <tr>
                    <td>
                        {{ $download->key }}
                        <img src="{{ route('downloads.thumbnail', ['download' => $download, 'quality' => 'sddefault']) }}">
                        {{ $download->getResponseInfo('title') }}
                    </td>
                    <td>{{ $download->getResponseInfo('shortDescription') }} {{ $download->getResponseInfo('description') }}
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm w-100"
                            href="{{ route('downloads.info', ['download' => $download]) }}">Info</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No downloads defined.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if ($downloads->hasPages())
        {{ $downloads->onEachSide(5)->links() }}
    @endif
@endsection
