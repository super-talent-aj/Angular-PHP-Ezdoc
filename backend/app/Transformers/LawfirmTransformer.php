<?php

namespace App\Transformers;

use App\Models\Invite;
use App\Models\Lawfirm;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class LawfirmTransformer extends TransformerAbstract
{
  /**
   * List of resources possible to include using url query string.
   * e.g. collection case -> ?include=comments:limit(5|1):order(created_at|desc)
   *      item case       -> ?include=author
   *
   * @var  array
   */
  protected $availableIncludes = ['profiles', 'invites', 'clients'];

  /**
   * List of resources to include automatically/always.
   *
   * @var  array
   */
  // protected $defaultIncludes = ['author', 'comments'];

  /**
   * Transform single resource.
   *
   * @param  \App\\Models\\Lawfirm $lawfirm
   * @return  array
   */
  public function transform(Lawfirm $lawfirm)
  {
    $payload = [
      'id' => (int)$lawfirm->id,
      'name' => $lawfirm->name,
      'password' => $lawfirm->password,
      'street' => $lawfirm->street,
      'country' => $lawfirm->country,
      'state' => $lawfirm->state,
      'province' => $lawfirm->province,
      'city' => $lawfirm->city,
      'apartment' => $lawfirm->apartment,
      'suite' => $lawfirm->suite,
      'floor' => $lawfirm->floor,
      'apt_number' => $lawfirm->apt_number,
      'zip_code' => $lawfirm->zip_code,
      'postal_code' => $lawfirm->postal_code,
      'created' => $lawfirm->created_at->toIso8601String(),
      'link' => [
        'rel' => 'self',
        'href' => route('api.v1.lawfirms.show', $lawfirm->id),
      ],
    ];

    if ($fields = $this->getPartialFields()) {
      $payload = array_only($payload, $fields);
    }

    return $payload;
  }

  /**
   * Include profiles.
   *
   * @param  \App\Lawfirm $lawfirm
   * @param  \League\Fractal\ParamBag|null $params
   * @return  \League\Fractal\Resource\Collection
   */
  public function includeProfiles(Lawfirm $lawfirm, ParamBag $params = null)
  {
    $transformer = new \App\Transformers\ProfileTransformer($params);

    $parsed = $transformer->getParsedParams();

    $profiles = $lawfirm->profiles()->limit($parsed['limit'])->offset($parsed['offset'])->orderBy($parsed['sort'], $parsed['order'])->get();

    return $this->collection($profiles, $transformer);
  }

  /**
   * Include invites.
   *
   * @param  \App\Lawfirm $lawfirm
   * @param  \League\Fractal\ParamBag|null $params
   * @return  \League\Fractal\Resource\Collection
   */
  public function includeInvites(Lawfirm $lawfirm, ParamBag $params = null)
  {
    $transformer = new \App\Transformers\InviteTransformer($params);

    $parsed = $transformer->getParsedParams();

    $invites = $lawfirm->invites()->limit($parsed['limit'])->offset($parsed['offset'])->orderBy($parsed['sort'], $parsed['order'])->get();

    return $this->collection($invites, $transformer);
  }

  /**
   * Include clients.
   *
   * @param  \App\Lawfirm $lawfirm
   * @param  \League\Fractal\ParamBag|null $params
   * @return  \League\Fractal\Resource\Collection
   */
  public function includeClients($lawfirm, ParamBag $params = null)
  {
    $transformer = new \App\Transformers\ClientTransformer($params);

    $parsed = $transformer->getParsedParams();

    $clients = $lawfirm->clients()->limit($parsed['limit'])->offset($parsed['offset'])->orderBy($parsed['sort'], $parsed['order'])->get();

    return $this->collection($clients, $transformer);
  }
}
