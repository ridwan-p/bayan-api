<?php

namespace App\Http\Controllers;

use App\Quran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuranController extends Controller
{
	/**
	 * List data qur'an
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function index()
    {
    	$qurans = Quran::with('reciter')
    		->paginate()
            ->map(function ($item) {
                $tmp = [];
                foreach ($item->tags as $tag) {
                    $tmp[] = $tag->slug;
                }
                $item->tags = $tmp;
                // dd($item);
                return $item;
            });

    	return $this->response($qurans);
    }

    /**
     * Show specific data qur'an
     * @param  integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
    	$quran = Quran::findOrFail($id);
    	$quran->load('reciter');

    	return $this->response($quran);
    }

    /**
     * Save data qur'an
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'reciter_id' => 'required|exists:reciters,id',
            'surah' => 'required|max:45',
            'is_file' => 'required|boolean',
            'player_file' => 'required_if:is_file,1|file|mimetypes:audio/mpeg',
            'player_url' => 'required_if:is_file,0|url',
            'category' => 'nullable|max:21',
            'tags' => 'array',
            'tags.*.slug' => 'required|max:45'
        ]);

        $quran = DB::transaction(function () use ($request) {
            $quran = new Quran();
            $data = $request->except('tags');
            $data['player'] = $request->is_file ? $request->player_file->store('players') : $request->player_url;

            $quran->fill($data);
            $quran->storeHasMany($request->only('tags'));
            return $quran;
        });

        $quran->load('tags', 'reciter');

        return $this->response($quran);
    }

    /**
     * Update data qur'an
     * @param  Request $request
     * @param  integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $quran = Quran::findOrFail($id);

        $this->validate($request, [
            'reciter_id' => 'required|exists:reciters,id',
            'surah' => 'required|max:45',
            'category' => 'nullable|max:21',
            'is_file' => 'nullable|boolean',
            'player_file' => 'required_if:is_file,1|file|mimetypes:audio/mpeg',
            'player_url' => 'required_if:is_file,0|url',
            'tags' => 'array',
            'tags.*.slug' => 'required|max:45'
        ]);

        $quran = DB::transaction(function () use ($request, $quran) {
            $data = $request->except('tags');
            if($request->has('is_file')) {
                $data['player'] = $request->is_file ? $request->player_file->store('players') : $request->player_url;
            }
            $quran->fill($data);
            $quran->updateHasMany($request->only('tags'));
            return $quran;
        });

        $quran->load('tags', 'reciter');

        return $this->response($quran);
    }

    /**
     * Delete data qur'an
     * @param  integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $quran = Quran::findOrFail($id);

        $quran->delete();

        return $this->response($quran);
    }
}
