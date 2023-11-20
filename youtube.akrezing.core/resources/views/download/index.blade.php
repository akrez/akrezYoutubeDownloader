@extends('app')

@section('content')
    @include('download._form')
    @if ($downloads->hasPages())
        {{ $downloads->onEachSide(5)->links() }}
    @endif
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Video</th>
                <th>Quality Label</th>
                <th>width X height</th>
                <th>Content Length</th>
                <th>Audio Quality</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            @forelse($downloads as $download)
                @foreach ($download->getResponseAllFormats() as $formatIndex => $format)
                    <tr>
                        @if ($formatIndex == 0)
                            <td scope="row" rowspan="{{ count($download->getResponseAllFormats()) }}">
                                <a class="btn btn-primary w-100"
                                    href="{{ route('downloads.info', ['download' => $download]) }}">Info</a>
                                {{ $download->key }}
                                <img class="rounded mx-auto d-block img-fluid"
                                    src="{{ route('downloads.thumbnail', ['download' => $download, 'quality' => 'sddefault']) }}">
                                {{ $download->getResponseInfo('title') }}
                                {{ $download->getResponseInfo('description') ? $download->getResponseInfo('description') : $download->getResponseInfo('shortDescription') }}

                            </td>
                        @endif
                        <td scope="row">
                            {{ $format['qualityLabel'] }}
                            <span class="badge rounded-pill bg-secondary">{{ $format['quality'] }}</span>
                        </td>
                        <td>
                            {{ $format['width'] && $format['height'] ? $format['width'] . ' X ' . $format['height'] : '' }}
                        </td>
                        <td>
                            {{ App\Models\Download::getHumanReadableSize($format['contentLength']) }}
                        </td>
                        <td>
                            {{ $format['audioSampleRate'] ?? '' }}
                            @if ($format['audioQuality'])
                                <span class="badge rounded-pill bg-secondary">
                                    {{ $format['audioQuality'] }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-success"
                                href="{{ route('downloads.stream', [
                                    'url' => base64_encode($format['url']),
                                    'download' => $download,
                                ]) }}">
                                {{ $format['mimeType'] }}
                            </a>
                        </td>
                    </tr>
                @endforeach
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
