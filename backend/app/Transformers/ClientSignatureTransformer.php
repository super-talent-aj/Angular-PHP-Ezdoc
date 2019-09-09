<?php

namespace App\Transformers;

use App\Models\ClientSignature;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class ClientSignatureTransformer extends TransformerAbstract
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
     * @param  \App\Models\ClientSignature $clientsignature
     * @return  array
     */
    public function transform(ClientSignature $clientsignature)
    {
        $payload = [
            'id' => (int) $clientsignature->id,
            'complete_name' => $clientsignature->complete_name,
            'native_name_alphabet' => $clientsignature->native_name_alphabet,
            'relation_assist_me' => $clientsignature->relation_assist_me,
            'assist_1_name' => $clientsignature->assist_1_name,
            'assist_1_relationship' => $clientsignature->assist_1_relationship,
            'assist_2_name' => $clientsignature->assist_2_name,
            'assist_2_relationship' => $clientsignature->assist_2_relationship,
            'other_assist_me' => $clientsignature->other_assist_me,
            'application_counsel' => $clientsignature->application_counsel,
            // ...
            'created' => $clientsignature->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.clientSignatures.show', $clientsignature->id),
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
     * @param  \App\Models\ClientSignature $clientsignature
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeClient(ClientSignature $clientsignature, ParamBag $params = null)
    {
        return $this->item($clientsignature->client, new \App\Transformers\ClientTransformer($params));
    }  }
