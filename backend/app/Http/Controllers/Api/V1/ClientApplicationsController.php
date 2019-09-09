<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ClientApplication;
use App\Transformers\ClientApplicationTransformer;

class ClientApplicationsController extends Controller
{
    public function index()
    {
        return json()->withCollection(
            ClientApplication::all(),
            new ClientApplicationTransformer
        );
    }

    public function store(Request $request)
    {
        // Assumes that validation is done by a Form Request
        return json()->created(
            $request->clientApplication()->create($request->all())
        );
    }

    public function show($id)
    {
        return json()->withItem(
            ClientApplication::findOrFail($id),
            new ClientApplicationTransformer
        );
    }

    public function update(Request $request, $id)
    {
        $clientApplication = ClientApplication::findOrFail($id);

        return ($clientApplication->update($request->all()))
            ? json()->success('Updated')
            : json()->error('Failed to update');
    }

    public function destroy($id)
    {
        $clientApplication = ClientApplication::findOrFail($id);

        return ($clientApplication->delete())
            ? json()->success('Deleted')
            : json()->error('Failed to delete');
    }
}
