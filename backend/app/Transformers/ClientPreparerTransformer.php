<?php

namespace App\Transformers;

use App\Models\ClientPreparer;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class ClientPreparerTransformer extends TransformerAbstract
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
     * @param  \App\Models\ClientPreparer $clientpreparer
     * @return  array
     */
    public function transform(ClientPreparer $clientpreparer)
    {
        $payload = [
            'id' => (int) $clientpreparer->id,
            'name' => $clientpreparer->name,
            'state_bar_num' => $clientpreparer->state_bar_num,
            'USCIS_account_num' => $clientpreparer->USCIS_account_num,
            'G28' => $clientpreparer->G28,
            'street_num' => $clientpreparer->street_num,
            'apt_num' => $clientpreparer->apt_num,
            'city' => $clientpreparer->city,
            'state' => $clientpreparer->state,
            'zip_code' => $clientpreparer->zip_code,
            'telephone_num' => $clientpreparer->telephone_num,
            // ...
            'created' => $clientpreparer->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.clientPreparers.show', $clientpreparer->id),
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
     * @param  \App\Models\ClientPreparer $clientpreparer
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeClient(ClientPreparer $clientpreparer, ParamBag $params = null)
    {
        return $this->item($clientpreparer->client, new \App\Transformers\ClientTransformer($params));
    }  }
