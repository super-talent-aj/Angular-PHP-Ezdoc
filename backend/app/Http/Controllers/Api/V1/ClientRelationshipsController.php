<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ClientRelationship;
use App\Transformers\ClientRelationshipTransformer;

class ClientRelationshipsController extends Controller
{
    public function index()
    {
        return json()->withCollection(
            ClientRelationship::all(),
            new ClientRelationshipTransformer
        );
    }

    public function store(Request $request)
    {
        // Assumes that validation is done by a Form Request
        return json()->created(
            $request->clientRelationship()->create($request->all())
        );
    }

    public function show($id)
    {
        return json()->withItem(
            ClientRelationship::findOrFail($id),
            new ClientRelationshipTransformer
        );
    }

    public function update(Request $request, $id)
    {
        $clientRelationship = ClientRelationship::findOrFail($id);

        return ($clientRelationship->update($request->all()))
            ? json()->success('Updated')
            : json()->error('Failed to update');
    }

    public function destroy($id)
    {
        $clientRelationship = ClientRelationship::findOrFail($id);

        return ($clientRelationship->delete())
            ? json()->success('Deleted')
            : json()->error('Failed to delete');
    }
}
