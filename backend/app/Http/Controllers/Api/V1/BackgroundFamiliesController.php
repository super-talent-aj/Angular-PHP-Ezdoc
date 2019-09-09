<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BackgroundFamily;
use App\Transformers\BackgroundFamilyTransformer;

class BackgroundFamiliesController extends Controller
{
    public function index()
    {
        return json()->withCollection(
            BackgroundFamily::all(),
            new BackgroundFamilyTransformer
        );
    }

    public function store(Request $request)
    {
        // Assumes that validation is done by a Form Request
        return json()->created(
            $request->backgroundFamily()->create($request->all())
        );
    }

    public function show($id)
    {
        return json()->withItem(
            BackgroundFamily::findOrFail($id),
            new BackgroundFamilyTransformer
        );
    }

    public function update(Request $request, $id)
    {
        $backgroundFamily = BackgroundFamily::findOrFail($id);

        return ($backgroundFamily->update($request->all()))
            ? json()->success('Updated')
            : json()->error('Failed to update');
    }

    public function destroy($id)
    {
        $backgroundFamily = BackgroundFamily::findOrFail($id);

        return ($backgroundFamily->delete())
            ? json()->success('Deleted')
            : json()->error('Failed to delete');
    }
}
