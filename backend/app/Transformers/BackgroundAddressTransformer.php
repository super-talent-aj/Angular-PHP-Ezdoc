<?php

namespace App\Transformers;

use App\Models\BackgroundAddress;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class BackgroundAddressTransformer extends TransformerAbstract
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
     * @param  \App\Models\BackgroundAddress $backgroundaddress
     * @return  array
     */
    public function transform(BackgroundAddress $backgroundaddress)
    {
        $payload = [
            'id' => (int) $backgroundaddress->id,
            'address_type' => $backgroundaddress->address_type,
            'street_num' => $backgroundaddress->street_num,
            'city_town' => $backgroundaddress->city_town,
            'department_province_state' => $backgroundaddress->department_province_state,
            'country' => $backgroundaddress->country,
            'start_date' => $backgroundaddress->start_date,
            'end_date' => $backgroundaddress->end_date,
            // ...
            'created' => $backgroundaddress->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.backgroundAddresses.show', $backgroundaddress->id),
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
     * @param  \App\Models\BackgroundAddress $backgroundaddress
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeClient(BackgroundAddress $backgroundaddress, ParamBag $params = null)
    {
        return $this->item($backgroundaddress->client, new \App\Transformers\ClientTransformer($params));
    }  }
