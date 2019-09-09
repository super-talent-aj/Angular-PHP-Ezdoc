<?php

namespace App\Transformers;

use App\Models\ClientApplication;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class ClientApplicationTransformer extends TransformerAbstract
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
     * @param  \App\Models\ClientApplication $clientapplication
     * @return  array
     */
    public function transform(ClientApplication $clientapplication)
    {
        $payload = [
            'id' => (int) $clientapplication->id,
            'asylum_by_race' => $clientapplication->asylum_by_race,
            'asylum_by_religion' => $clientapplication->asylum_by_religion,
            'asylum_by_nationality' => $clientapplication->asylum_by_nationality,
            'asylum_by_political' => $clientapplication->asylum_by_political,
            'asylum_by_membership' => $clientapplication->asylum_by_membership,
            'asylum_by_torture' => $clientapplication->asylum_by_torture,
            'mistreatment_past_bool' => $clientapplication->mistreatment_past_bool,
            'mistreatment_past_text' => $clientapplication->mistreatment_past_text,
            'mistreatment_return_bool' => $clientapplication->mistreatment_return_bool,
            'mistreatment_return_text' => $clientapplication->mistreatment_return_text,
            'law_imprisoned_bool' => $clientapplication->law_imprisoned_bool,
            'law_imprisoned_text' => $clientapplication->law_imprisoned_text,
            'associated_organization_bool' => $clientapplication->associated_organization_bool,
            'associated_organization_text' => $clientapplication->associated_organization_text,
            'continue_organization_bool' => $clientapplication->continue_organization_bool,
            'continue_organization_text' => $clientapplication->continue_organization_text,
            'torture_return_bool' => $clientapplication->torture_return_bool,
            'torture_return_text' => $clientapplication->torture_return_text,
            'application_before_bool' => $clientapplication->application_before_bool,
            'application_before_text' => $clientapplication->application_before_text,
            'travel_reside_bool' => $clientapplication->travel_reside_bool,
            'lawful_apply_other_bool' => $clientapplication->lawful_apply_other_bool,
            'lawful_apply_other_text' => $clientapplication->lawful_apply_other_text,
            'cause_harm_bool' => $clientapplication->cause_harm_bool,
            'cause_harm_text' => $clientapplication->cause_harm_text,
            'return_country_past_bool' => $clientapplication->return_country_past_bool,
            'return_country_past_text' => $clientapplication->return_country_past_text,
            'apply_more_year_bool' => $clientapplication->apply_more_year_bool,
            'apply_more_year_text' => $clientapplication->apply_more_year_text,
            'lawful_apply_US_bool' => $clientapplication->lawful_apply_US_bool,
            'lawful_apply_US_text' => $clientapplication->lawful_apply_US_text,
            // ...
            'created' => $clientapplication->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.clientApplications.show', $clientapplication->id),
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
     * @param  \App\Models\ClientApplication $clientapplication
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeClient(ClientApplication $clientapplication, ParamBag $params = null)
    {
        return $this->item($clientapplication->client, new \App\Transformers\ClientTransformer($params));
    }  }
