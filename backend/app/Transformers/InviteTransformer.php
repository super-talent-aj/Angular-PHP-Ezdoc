<?php

namespace App\Transformers;

use App\Models\Invite;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class InviteTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include using url query string.
     * e.g. collection case -> ?include=comments:limit(5|1):order(created_at|desc)
     *      item case       -> ?include=author
     *
     * @var  array
     */
    protected $availableIncludes = ['lawfirm'];

    /**
     * List of resources to be included always.
     *
     * @var  array
     */
    // protected $defaultIncludes = ['lawfirm'];
    /**
     * Transform single resource.
     *
     * @param  \App\Models\Invite $invite
     * @return  array
     */
    public function transform(Invite $invite)
    {
        $payload = [
            'id' => (int) $invite->id,
            'lawfirm_id' => (int) $invite->lawfirm_id,
            'email' => (string) $invite->email,
            'created' => $invite->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.invites.show', $invite->id),
            ],
        ];

        if ($fields = $this->getPartialFields()) {
            $payload = array_only($payload, $fields);
        }

        return $payload;
    }

      /**
     * Include lawfirm.
     *
     * @param  \App\Models\Invite $invite
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeLawfirm(Invite $invite, ParamBag $params = null)
    {
        return $this->item($invite->lawfirm, new \App\Transformers\LawfirmTransformer($params));
    }  }
