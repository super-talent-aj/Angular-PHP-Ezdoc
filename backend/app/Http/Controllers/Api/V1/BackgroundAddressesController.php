<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BackgroundAddress;
use App\Transformers\BackgroundAddressTransformer;

class BackgroundAddressesController extends Controller
{
    public function index()
    {
        return json()->withCollection(
            BackgroundAddress::all(),
            new BackgroundAddressTransformer
        );
    }

    public function store(Request $request)
    {
        // Assumes that validation is done by a Form Request
        return json()->created(
            $request->backgroundAddress()->create($request->all())
        );
    }

    public function show($id)
    {
        return json()->withItem(
            BackgroundAddress::findOrFail($id),
            new BackgroundAddressTransformer
        );
    }

    public function update(Request $request, $id)
    {
        $backgroundAddress = BackgroundAddress::findOrFail($id);

        return ($backgroundAddress->update($request->all()))
            ? json()->success('Updated')
            : json()->error('Failed to update');
    }

    public function destroy($id)
    {
        $backgroundAddress = BackgroundAddress::findOrFail($id);

        return ($backgroundAddress->delete())
            ? json()->success('Deleted')
            : json()->error('Failed to delete');
    }
}
