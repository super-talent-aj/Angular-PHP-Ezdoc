<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ClientSignature;
use App\Transformers\ClientSignatureTransformer;

class ClientSignaturesController extends Controller
{
    public function index()
    {
        return json()->withCollection(
            ClientSignature::all(),
            new ClientSignatureTransformer
        );
    }

    public function store(Request $request)
    {
        // Assumes that validation is done by a Form Request
        return json()->created(
            $request->clientSignature()->create($request->all())
        );
    }

    public function show($id)
    {
        return json()->withItem(
            ClientSignature::findOrFail($id),
            new ClientSignatureTransformer
        );
    }

    public function update(Request $request, $id)
    {
        $clientSignature = ClientSignature::findOrFail($id);

        return ($clientSignature->update($request->all()))
            ? json()->success('Updated')
            : json()->error('Failed to update');
    }

    public function destroy($id)
    {
        $clientSignature = ClientSignature::findOrFail($id);

        return ($clientSignature->delete())
            ? json()->success('Deleted')
            : json()->error('Failed to delete');
    }
}
