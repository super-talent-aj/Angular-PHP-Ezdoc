<?php

namespace App\Transformers;

use App\Models\BackgroundFamily;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class BackgroundFamilyTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include using url query string.
     * e.g. collection case -> ?include=comments:limit(5|1):order(created_at|desc)
     *      item case       -> ?include=author
     *
     * @var  array
     */
    protected $availableIncludes = ['client'];

    /**
     * List of resources to be included always.
     *
     * @var  array
     */
    // protected $defaultIncludes = ['client'];
    /**
     * Transform single resource.
     *
     * @param  \App\Models\BackgroundFamily $backgroundfamily
     * @return  array
     */
    public function transform(BackgroundFamily $backgroundfamily)
    {
        $payload = [
            'id' => (int) $backgroundfamily->id,
            'family_type' => $backgroundfamily->family_type,
            'family_name' => $backgroundfamily->family_name,
            'family_birth_city_country' => $backgroundfamily->family_birth_city_country,
            'deceased' => $backgroundfamily->deceased,
            'location' => $backgroundfamily->location,
            // ...
            'created' => $backgroundfamily->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.backgroundFamilies.show', $backgroundfamily->id),
            ],
        ];

        if ($fields = $this->getPartialFields()) {
            $payload = array_only($payload, $fields);
        }

        return $payload;
    }

      /**
     * Include client.
     *
     * @param  \App\Models\BackgroundFamily $backgroundfamily
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeClient(BackgroundFamily $backgroundfamily, ParamBag $params = null)
    {
        return $this->item($backgroundfamily->client, new \App\Transformers\ClientTransformer($params));
    }  }
