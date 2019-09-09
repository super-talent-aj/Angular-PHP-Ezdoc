<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lawfirm;
use App\Transformers\LawfirmTransformer;
use App\Http\Requests\LawfirmsRequest;
use App\Http\Controllers\Api\Helper\RespondHelper;

class LawfirmsController extends Controller
{
	public function __construct()
	{
		$this->middleware('admin', ['except' => ['index', 'show', 'store']]);
		parent::__construct();
		$this->respond_helper = new RespondHelper();
	}

	public function index()
	{
		$data = Lawfirm::all();
		
		return json()->withCollection(
			$data,
			new LawfirmTransformer()
		);
	}

	public function store(Request $request)
	{
		$input = $request->all();
		if (isset($input['password'])) {
			$input['password'] = base64_encode($input['password']);
		} else {
		  return json()->badRequestError('Set the lawfirm password!');
		}

		$lawfirm = new Lawfirm();
		$lawfirm->name = $input['name'];
		$lawfirm->country = $input['country'];
		$lawfirm->state = $input['state'];
		$lawfirm->province = $input['province'];
		$lawfirm->city = $input['city'];
		$lawfirm->street = $input['street'];
		$lawfirm->apartment = isset($input['apartment']) ? $input['apartment'] : 0;
		$lawfirm->suite = isset($input['suite']) ? $input['suite'] : 0;
		$lawfirm->floor = isset($input['floor']) ? $input['floor'] : 0;
		$lawfirm->apt_number = $input['apt_number'];
		$lawfirm->zip_code = $input['zip_code'];
		$lawfirm->postal_code = $input['postal_code'];
		$lawfirm->password = $input['password'];
		
		return ($lawfirm->save())
			? json()->success('A new lawfirm has been created.')
			: json()->badRequestError('Failed to create a lawfirm.');
	}

	public function show($id)
	{
		return json()->withItem(
			Lawfirm::findOrFail($id),
			new LawfirmTransformer()
		);
	}

	public function update(LawfirmsRequest $request, $id)
	{
		$lawfirm = Lawfirm::findOrFail($id);
		$lawfirm->name = $request->name;
		$lawfirm->country = $request->country;
		$lawfirm->state = $request->state;
		$lawfirm->province = $request->province;
		$lawfirm->city = $request->city;
		$lawfirm->street = $request->street;
		$lawfirm->apartment = $request->apartment;
		$lawfirm->suite = $request->suite;
		$lawfirm->floor = $request->floor;
		$lawfirm->apt_number = $request->apt_number;
		$lawfirm->zip_code = $request->zip_code;
		$lawfirm->postal_code = $request->postal_code;

		// if (isset($request->password)) {
		// 	$lawfirm->password = base64_encode($request->password);
		// }

		return ($lawfirm->save())
			? json()->success('The lawfirm has been updated.')
			: json()->badRequestError('Failed to update the lawfirm.');
	}

	public function destroy($id)
	{
		$lawfirm = Lawfirm::findOrFail($id);

		return ($lawfirm->delete())
			? json()->success('The lawfirm has been deleted.')
			: json()->badRequestError('Failed to delete the lawfirm.');
	}

	public static function getAdmins($lawfirm)
	{
		$profiles = $lawfirm->profiles;
		$admins = [];
		foreach ($profiles as $profile) {
			$user = $profile->user;
			if ($user->is('admin') || $user->is('superadmin')) {
				array_push($admins, $user);
			}
		}

		return $admins;
	}
}
