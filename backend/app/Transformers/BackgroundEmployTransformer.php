<?php

namespace App\Transformers;

use App\Models\BackgroundEmploy;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class BackgroundEmployTransformer extends TransformerAbstract
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
     * @param  \App\Models\BackgroundEmploy $backgroundemploy
     * @return  array
     */
    public function transform(BackgroundEmploy $backgroundemploy)
    {
        $payload = [
            'id' => (int) $backgroundemploy->id, 
            'employer_name' => $backgroundemploy->employer_name,
            'employ_occupation' => $backgroundemploy->employ_occupation,
            'start_date' => $backgroundemploy->start_date,
            'end_date' => $backgroundemploy->end_date,
            // ...
            'created' => $backgroundemploy->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.backgroundEmploys.show', $backgroundemploy->id),
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
     * @param  \App\Models\BackgroundEmploy $backgroundemploy
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeClient(BackgroundEmploy $backgroundemploy, ParamBag $params = null)
    {
        return $this->item($backgroundemploy->client, new \App\Transformers\ClientTransformer($params));
    }  }
