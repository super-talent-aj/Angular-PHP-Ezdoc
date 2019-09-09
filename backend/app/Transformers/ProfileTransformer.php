<?php

namespace App\Transformers;

use App\Models\Profile;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class ProfileTransformer extends TransformerAbstract
{
  /**
   * List of resources possible to include using url query string.
   * e.g. collection case -> ?include=comments:limit(5|1):order(created_at|desc)
   *      item case       -> ?include=author
   *
   * @var  array
   */
  protected $availableIncludes = ['user', 'lawfirm'];

  /**
   * List of resources to be included always.
   *
   * @var  array
   */
  // protected $defaultIncludes = ['user', 'lawfirm'];
  /**
   * Transform single resource.
   *
   * @param  \App\Models\Profile $profile
   * @return  array
   */
  public function transform(Profile $profile)
  {
    $payload = [
      'id' => (int)$profile->id,
      'first_name' => $profile->first_name,
      'middle_name' => $profile->middle_name,
      'last_name' => $profile->last_name,
      'telephone_number' => $profile->telephone_number,
      'mobile_number' => $profile->mobile_number,
      'fax_number' => $profile->fax_number,
      'street' => $profile->street,
      'apartment' => $profile->apartment,
      'suite' => $profile->suite,
      'floor' => $profile->floor,
      'apt_number' => $profile->apt_number,
      'city' => $profile->city,
      'state' => $profile->state,
      'zip_code' => $profile->zip_code,
      'province' => $profile->province,
      'country' => $profile->country,
      'uscis_account_number' => $profile->uscis_account_number,
      'accereditation_expires_date' => $profile->accereditation_expires_date,
      'is_attorney' => $profile->is_attorney,
      'licensing_authority' => $profile->licensing_authority,
      'bar_number' => $profile->bar_number,
      'is_subject_to_any' => $profile->is_subject_to_any,
      'subject_explaination' => $profile->subject_explaination,
      'preparer_signature' => $profile->preparer_signature,
      'avatar' => $profile->avatar,
      'lawfirm_id' => $profile->lawfirm_id,
      'user_id' => $profile->user_id,
      'created' => $profile->created_at->toIso8601String(),
      'link' => [
        'rel' => 'self',
        'href' => route('api.v1.profiles.show', $profile->id),
      ],
    ];

    if ($fields = $this->getPartialFields()) {
      $payload = array_only($payload, $fields);
    }

    return $payload;
  }

  /**
   * Include user.
   *
   * @param  \App\Models\Profile $profile
   * @param  \League\Fractal\ParamBag|null $params
   * @return  \League\Fractal\Resource\Item
   */
  public function includeUser(Profile $profile, ParamBag $params = null)
  {
    return $this->item($profile->user, new \App\Transformers\UserTransformer($params));
  }

  /**
   * Include lawfirm.
   *
   * @param  \App\Models\Profile $profile
   * @param  \League\Fractal\ParamBag|null $params
   * @return  \League\Fractal\Resource\Item
   */
  public function includeLawfirm(Profile $profile, ParamBag $params = null)
  {
    return $this->item($profile->lawfirm, new \App\Transformers\LawfirmTransformer($params));
  }
}
