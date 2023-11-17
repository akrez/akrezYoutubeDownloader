<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Http\Requests\StoreDownloadRequest;
use App\Http\Requests\ThumbnailDownloadRequest;
use App\Http\Requests\UpdateDownloadRequest;
use Illuminate\Support\Facades\Http;
use ReflectionFunction;
use YouTube\YouTubeDownloader;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('download.index', [
            'downloads' => Download::query()->where('user_id', auth()->id())->latest()->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDownloadRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        Download::create($request->all());
        return response()->redirectToRoute('downloads.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Download $download)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Download $download)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDownloadRequest $request, Download $download)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Download $download)
    {
        //
    }

    public function info(Download $download)
    {
        if ($download->user_id != auth()->id()) {
            abort(403);
        }

        $youtube = new YouTubeDownloader();
        try {
            $download->response = serialize($youtube->getDownloadLinks($download->key));
            $download->save();
        } catch (\Throwable $th) {
        }

        return response()->redirectToRoute('downloads.index');
    }

    public function thumbnail(Download $download, ThumbnailDownloadRequest $request)
    {
        if ($download->response) {
            $response = Http::get('https://img.youtube.com/vi/' . $download->key . '/' . $request->quality . '.jpg');
            return response($response->body(), $response->status(), [
                'content-type' => $response->header('content-type')
            ]);
        }
        return response()->file(public_path('assets\images\no-image.svg'));
    }
}
