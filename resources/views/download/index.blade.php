@extends('app')

@section('content')
    @include('download._form')
    @if ($downloads->hasPages())
        {{ $downloads->onEachSide(5)->links() }}
    @endif
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Key</th>
                <th>Created At</th>
                <th>Deleted At</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($downloads as $download)
                <tr>
                    <td>{{ $download->key }}</td>
                    <td>{{ $download->created_at }}</td>
                    <td>{{ $download->deleted_at }}</td>
                    <td>
                        <a class="btn btn-primary w-100" href="{{ route('downloads.info', ['download' => $download]) }}">Info</a>
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
