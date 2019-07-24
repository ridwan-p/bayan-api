<?php

namespace App\Http\Controllers;

use App\Quran;
use Illuminate\Http\Request;

class QuranController extends Controller
{
	/**
	 * List data qur'an
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function index()
    {
    	$qurans = Quran::with('reciter')
    		->paginate();

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

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'reciter_id' => 'required|exists:reciters,id',
    		'surah' => 'required|max:45',
    		'player' => 'required|file|mimes:mp3',
    		'category' => 'nullable|max:21',
    		'tags' => 'array',
    		'tags.*' => 'nullable|max:45'
    	]);

    	$quran = DB::transaction(function () use ($request) {
    		$quran = new Quran();
    		$quran->fill($request->except('tags'));
    		$quran->storeHasMany($request->only('tags'));
    		return $quran;
    	});

    	return $this->response($quran);
    }
}
