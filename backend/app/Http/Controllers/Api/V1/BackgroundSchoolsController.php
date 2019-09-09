<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BackgroundSchool;
use App\Transformers\BackgroundSchoolTransformer;

class BackgroundSchoolsController extends Controller
{
    public function index()
    {
        return json()->withCollection(
            BackgroundSchool::all(),
            new BackgroundSchoolTransformer
        );
    }

    public function store(Request $request)
    {
        // Assumes that validation is done by a Form Request
        return json()->created(
            $request->backgroundSchool()->create($request->all())
        );
    }

    public function show($id)
    {
        return json()->withItem(
            BackgroundSchool::findOrFail($id),
            new BackgroundSchoolTransformer
        );
    }

    public function update(Request $request, $id)
    {
        $backgroundSchool = BackgroundSchool::findOrFail($id);

        return ($backgroundSchool->update($request->all()))
            ? json()->success('Updated')
            : json()->error('Failed to update');
    }

    public function destroy($id)
    {
        $backgroundSchool = BackgroundSchool::findOrFail($id);

        return ($backgroundSchool->delete())
            ? json()->success('Deleted')
            : json()->error('Failed to delete');
    }
}
