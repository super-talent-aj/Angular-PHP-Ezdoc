<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ClientPreparer;
use App\Transformers\ClientPreparerTransformer;

class ClientPreparersController extends Controller
{
    public function index()
    {
        return json()->withCollection(
            ClientPreparer::all(),
            new ClientPreparerTransformer
        );
    }

    public function store(Request $request)
    {
        // Assumes that validation is done by a Form Request
        return json()->created(
            $request->clientPreparer()->create($request->all())
        );
    }

    public function show($id)
    {
        return json()->withItem(
            ClientPreparer::findOrFail($id),
            new ClientPreparerTransformer
        );
    }

    public function update(Request $request, $id)
    {
        $clientPreparer = ClientPreparer::findOrFail($id);

        return ($clientPreparer->update($request->all()))
            ? json()->success('Updated')
            : json()->error('Failed to update');
    }

    public function destroy($id)
    {
        $clientPreparer = ClientPreparer::findOrFail($id);

        return ($clientPreparer->delete())
            ? json()->success('Deleted')
            : json()->error('Failed to delete');
    }
}
