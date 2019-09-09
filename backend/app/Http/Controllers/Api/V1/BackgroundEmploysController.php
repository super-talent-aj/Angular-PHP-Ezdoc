<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BackgroundEmploy;
use App\Transformers\BackgroundEmployTransformer;

class BackgroundEmploysController extends Controller
{
    public function index()
    {
        return json()->withCollection(
            BackgroundEmploy::all(),
            new BackgroundEmployTransformer
        );
    }

    public function store(Request $request)
    {
        // Assumes that validation is done by a Form Request
        return json()->created(
            $request->backgroundEmploy()->create($request->all())
        );
    }

    public function show($id)
    {
        return json()->withItem(
            BackgroundEmploy::findOrFail($id),
            new BackgroundEmployTransformer
        );
    }

    public function update(Request $request, $id)
    {
        $backgroundEmploy = BackgroundEmploy::findOrFail($id);

        return ($backgroundEmploy->update($request->all()))
            ? json()->success('Updated')
            : json()->error('Failed to update');
    }

    public function destroy($id)
    {
        $backgroundEmploy = BackgroundEmploy::findOrFail($id);

        return ($backgroundEmploy->delete())
            ? json()->success('Deleted')
            : json()->error('Failed to delete');
    }
}
