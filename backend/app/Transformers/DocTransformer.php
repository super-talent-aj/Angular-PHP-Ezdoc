<?php

namespace App\Transformers;

use App\Models\Doc;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class DocTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include using url query string.
     * e.g. collection case -> ?include=comments:limit(5|1):order(created_at|desc)
     *      item case       -> ?include=author
     *
     * @var  array
     */
    protected $availableIncludes = ['client', 'form'];

    /**
     * List of resources to be included always.
     *
     * @var  array
     */
    // protected $defaultIncludes = ['client', 'form'];
    /**
     * Transform single resource.
     *
     * @param  \App\Models\Doc $doc
     * @return  array
     */
    public function transform(Doc $doc)
    {
        $payload = [
            'id' => (int) $doc->id,
            'client_id' => (int) $doc->client_id,
            'form_id' => (int) $doc->form_id,
            'user_id' => (int) $doc->user_id,
            'page_count' => (int) $doc->form->page_count,
            'form_type' => (string) $doc->form->type,
            'form_name' => (string) $doc->form->name,
            'data' => (string) $doc->data,
            'approved' => (boolean) $doc->approved,
            'created' => $doc->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.docs.show', $doc->id),
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
     * @param  \App\Models\Doc $doc
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeClient(Doc $doc, ParamBag $params = null)
    {
        return $this->item($doc->client, new \App\Transformers\ClientTransformer($params));
    }        /**
     * Include form.
     *
     * @param  \App\Models\Doc $doc
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeForm(Doc $doc, ParamBag $params = null)
    {
        return $this->item($doc->form, new \App\Transformers\FormTransformer($params));
    }  }
