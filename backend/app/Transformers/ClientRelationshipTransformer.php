<?php

namespace App\Transformers;

use App\Models\ClientRelationship;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class ClientRelationshipTransformer extends TransformerAbstract
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
     * @param  \App\Models\ClientRelationship $clientrelationship
     * @return  array
     */
    public function transform(ClientRelationship $clientrelationship)
    {
        $payload = [
            'id' => (int) $clientrelationship->id,
            'relation_type' => $clientrelationship->relation_type,
            'alien_reg_num' => $clientrelationship->alien_reg_num,
            'passport_num' => $clientrelationship->passport_num,
            'us_social_security_num' => $clientrelationship->us_social_security_num,
            'first_name' => $clientrelationship->first_name,
            'middle_name' => $clientrelationship->middle_name,
            'last_name' => $clientrelationship->last_name,
            'maiden_aliase_name' => $clientrelationship->maiden_aliase_name,
            'birth_date' => $clientrelationship->birth_date,
            'birth_city_country' => $clientrelationship->birth_city_country,
            'nationality' => $clientrelationship->nationality,
            'race_ethnic_tribal_group' => $clientrelationship->race_ethnic_tribal_group,
            'gender' => $clientrelationship->gender,
            'us_person' => $clientrelationship->us_person,
            'location' => $clientrelationship->location,
            'entry_date' => $clientrelationship->entry_date,
            'entry_place' => $clientrelationship->entry_place,
            'entry_status' => $clientrelationship->entry_status,
            'i94_num' => $clientrelationship->i94_num,
            'last_admitted_status' => $clientrelationship->last_admitted_status,
            'entry_status_expires' => $clientrelationship->entry_status_expires,
            'immigration_court_proceeding' => $clientrelationship->immigration_court_proceeding,
            'include_application' => $clientrelationship->include_application,
            'marriage_date' => $clientrelationship->marriage_date,
            'marriage_place' => $clientrelationship->marriage_place,
            'previous_arrival_date' => $clientrelationship->previous_arrival_date,
            'marital_status' => $clientrelationship->marital_status,
            // ...
            'created' => $clientrelationship->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.clientRelationships.show', $clientrelationship->id),
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
     * @param  \App\Models\ClientRelationship $clientrelationship
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeClient(ClientRelationship $clientrelationship, ParamBag $params = null)
    {
        return $this->item($clientrelationship->client, new \App\Transformers\ClientTransformer($params));
    }  }
