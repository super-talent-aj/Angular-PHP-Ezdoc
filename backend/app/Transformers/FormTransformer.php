<?php

namespace App\Transformers;

use App\Models\Form;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class FormTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include using url query string.
     * e.g. collection case -> ?include=comments:limit(5|1):order(created_at|desc)
     *      item case       -> ?include=author
     *
     * @var  array
     */
    protected $availableIncludes = ['clients'];

    /**
     * List of resources to be included always.
     *
     * @var  array
     */
    // protected $defaultIncludes = ['clients'];
    /**
     * Transform single resource.
     *
     * @param  \App\Models\Form $form
     * @return  array
     */
    public function transform(Form $form)
    {
        $payload = [
            'id' => (int) $form->id,
            'type' => (string) $form->type,
            'name' => (string) $form->name,
            'description' => (string) $form->description,
            'template' => (string) $form->template,
            'page_count' => (int) $form->page_count,
            'created' => $form->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.forms.show', $form->id),
            ],
        ];

        if ($fields = $this->getPartialFields()) {
            $payload = array_only($payload, $fields);
        }

        return $payload;
    }

      /**
     * Include clients.
     *
     * @param  \App\Models\Form $form
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Collection
     */
    public function includeDocs(Form $form, ParamBag $params = null)
    {
        $transformer = new \App\Transformers\DocTransformer($params);

        $parsed = $transformer->getParsedParams();

        $clients = $form->docs()->limit($parsed['limit'])->offset($parsed['offset'])->orderBy($parsed['sort'], $parsed['order'])->get();

        return $this->collection($clients, $transformer);
    }  }
