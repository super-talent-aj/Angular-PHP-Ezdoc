<?php

namespace App\Transformers;

use App\Models\BackgroundSchool;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class BackgroundSchoolTransformer extends TransformerAbstract
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
     * @param  \App\Models\BackgroundSchool $backgroundschool
     * @return  array
     */
    public function transform(BackgroundSchool $backgroundschool)
    {
        $payload = [
            'id' => (int) $backgroundschool->id,
            'school_name' => $backgroundschool->school_name,
            'school_type' => $backgroundschool->school_type,
            'school_location' => $backgroundschool->school_location,
            'start_date' => $backgroundschool->start_date,
            'end_date' => $backgroundschool->end_date,
            // ...
            'created' => $backgroundschool->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.backgroundSchools.show', $backgroundschool->id),
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
     * @param  \App\Models\BackgroundSchool $backgroundschool
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeClient(BackgroundSchool $backgroundschool, ParamBag $params = null)
    {
        return $this->item($backgroundschool->client, new \App\Transformers\ClientTransformer($params));
    }  }
