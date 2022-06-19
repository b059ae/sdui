<?php

namespace App\Http\Controllers;

use App\Events\NewsCreated;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json($request->user()->news()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNewsRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(StoreNewsRequest $request): JsonResponse
    {
        $news = new News($request->validated());
        $news->user()->associate($request->user());
        $news->saveOrFail();
        NewsCreated::dispatch($news);

        return response()->json($news->only('id'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param News $news
     * @return JsonResponse
     */
    public function show(Request $request, News $news): JsonResponse
    {
        if ($request->user()->cannot('view', $news)) {
            abort(403);
        }
        return response()->json($news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNewsRequest $request
     * @param News $news
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(UpdateNewsRequest $request, News $news): JsonResponse
    {
        if ($request->user()->cannot('update', $news)) {
            abort(403);
        }
        $news->updateOrFail($request->validated());
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param News $news
     * @return JsonResponse
     */
    public function destroy(Request $request, News $news): JsonResponse
    {
        if ($request->user()->cannot('delete', $news)) {
            abort(403);
        }
        $news->delete();
        return response()->json();
    }
}
