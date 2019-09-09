<?php

namespace App\Transformers;

use App\User;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class UserTransformer extends TransformerAbstract
{
  /**
   * List of resources possible to include using url query string.
   * e.g. collection case -> ?include=comments:limit(5|1):order(created_at|desc)
   *      item case       -> ?include=author
   *
   * @var  array
   */
  protected $availableIncludes = ['profile'];

  /**
   * List of resources to be included always.
   *
   * @var  array
   */
  /**
   * Transform single resource.
   *
   * @param  \App\User $user
   * @return  array
   */
  public function transform(User $user)
  {
    $payload = [
      'id' => (int)$user->id,
      'email' => $user->email,
      'first_name' => $user->profile->first_name,
      'status' => $user->status,
      'password' => $user->getAuthPassword(),
      'created' => $user->created_at->toIso8601String(),
      'link' => [
        'rel' => 'self',
        'href' => route('api.v1.users.show', $user->id),
      ],
    ];

    if ($fields = $this->getPartialFields()) {
      $payload = array_only($payload, $fields);
    }

    return $payload;
  }

  /**
   * Include profile.
   *
   * @param  \App\User $user
   * @param  \League\Fractal\ParamBag|null $params
   * @return  \League\Fractal\Resource\Item
   */
  public function includeProfile(User $user, ParamBag $params = null)
  {
    return $this->item($user->profile, new \App\Transformers\ProfileTransformer($params));
  }

  /**
   * Include clients.
   *
   * @param  \App\User $user
   * @param  \League\Fractal\ParamBag|null $params
   * @return  \League\Fractal\Resource\Collection
   */
  public function includeClients(User $user, ParamBag $params = null)
  {
    $transformer = new \App\Transformers\ClientTransformer($params);

    $parsed = $transformer->getParsedParams();

    $clients = $user->clients()->limit($parsed['limit'])->offset($parsed['offset'])->orderBy($parsed['sort'], $parsed['order'])->get();

    return $this->collection($clients, $transformer);
  }
  /**
   * Include client.
   *
   * @param  \App\\User $user
   * @param  \League\Fractal\ParamBag|null $params
   * @return  \League\Fractal\Resource\Item
   */
}
