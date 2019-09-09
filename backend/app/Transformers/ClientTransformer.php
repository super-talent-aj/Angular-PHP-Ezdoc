<?php

namespace App\Transformers;

use App\Models\Client;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class ClientTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include using url query string.
     * e.g. collection case -> ?include=comments:limit(5|1):order(created_at|desc)
     *      item case       -> ?include=author.
     *
     * @var array
     */
    protected $availableIncludes = ['user', 'docs', 'backgroundAddresses', 'backgroundEmploys', 'backgroundFamilies', 'backgroundSchools', 'clientApplication', 'clientPreparer', 'clientProfile', 'clientRelationship', 'clientSignature', 'lawfirm'];

    /**
     * List of resources to be included always.
     *
     * @var array
     */
//    protected $defaultIncludes = ['user', 'docs', 'backgroundAddresses', 'backgroundEmploys', 'backgroundFamilies', 'backgroundSchools', 'clientApplication', 'clientPreparer', 'clientProfile', 'clientRelationship', 'clientSignature'];

    /**
     * Transform single resource.
     *
     * @param \App\Models\Client $client
     *
     * @return array
     */
    public function transform(Client $client)
    {
        $payload = [
      'id' => (int) $client->id,
      'alien_reg_num' => $client->alien_reg_num,
      'us_social_security_num' => $client->us_social_security_num,
      'USCIS_account_num' => $client->USCIS_account_num,
      'first_name' => $client->first_name,
      'middle_name' => $client->middle_name,
      'last_name' => $client->last_name,
      'maiden_aliase_name' => $client->maiden_aliase_name,
      'residence_street_num' => $client->residence_street_num,
      'residence_apt_type' => $client->residence_apt_type,
      'residence_apt_num' => $client->residence_apt_num,
      'residence_city' => $client->residence_city,
      'residence_state' => $client->residence_state,
      'residence_county' => $client->residence_county,
      'residence_province' => $client->residence_province,
      'residence_postal_code' => $client->residence_postal_code,
      'residence_country' => $client->residence_country,
      'residence_zip_code' => $client->residence_zip_code,
      'residence_telephone_num' => $client->residence_telephone_num,
      'residence_mobile_num' => $client->residence_mobile_num,
      'residence_email_address' => $client->residence_email_address,
      'gender' => $client->gender,
      'marital_status' => $client->marital_status,
      'birth_date' => $client->birth_date,
      'birth_city' => $client->birth_city,
      'birth_country' => $client->birth_country,
      'photo' => $client->photo,
      'created' => $client->created_at->toIso8601String(),
      'link' => [
        'rel' => 'self',
        'href' => route('api.v1.clients.show', $client->id),
      ],
    ];

        if ($fields = $this->getPartialFields()) {
            $payload = array_only($payload, $fields);
        }

        return $payload;
    }

    /**
     * Include user.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Client $client, ParamBag $params = null)
    {
        return $this->item($client->user, new \App\Transformers\UserTransformer($params));
    }

    /**
     * Include forms.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeDocs(Client $client, ParamBag $params = null)
    {
        $transformer = new \App\Transformers\DocTransformer($params);

        $parsed = $transformer->getParsedParams();

        $docs = $client->docs()->orderBy($parsed['sort'], $parsed['order'])->get();

        return $this->collection($docs, $transformer);
    }

    /**
     * Include backgroundAddresses.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBackgroundAddresses(Client $client, ParamBag $params = null)
    {
        $transformer = new \App\Transformers\BackgroundAddressTransformer($params);

        $parsed = $transformer->getParsedParams();

        $backgroundAddresses = $client->backgroundAddresses()->limit($parsed['limit'])->offset($parsed['offset'])->orderBy($parsed['sort'], $parsed['order'])->get();

        return $this->collection($backgroundAddresses, $transformer);
    }

    /**
     * Include backgroundEmploys.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBackgroundEmploys(Client $client, ParamBag $params = null)
    {
        $transformer = new \App\Transformers\BackgroundEmployTransformer($params);

        $parsed = $transformer->getParsedParams();

        $backgroundEmploys = $client->backgroundEmploys()->limit($parsed['limit'])->offset($parsed['offset'])->orderBy($parsed['sort'], $parsed['order'])->get();

        return $this->collection($backgroundEmploys, $transformer);
    }

    /**
     * Include backgroundFamilies.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBackgroundFamilies(Client $client, ParamBag $params = null)
    {
        $transformer = new \App\Transformers\BackgroundFamilyTransformer($params);

        $parsed = $transformer->getParsedParams();

        $backgroundFamilies = $client->backgroundFamilies()->limit($parsed['limit'])->offset($parsed['offset'])->orderBy($parsed['sort'], $parsed['order'])->get();

        return $this->collection($backgroundFamilies, $transformer);
    }

    /**
     * Include backgroundSchools.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBackgroundSchools(Client $client, ParamBag $params = null)
    {
        $transformer = new \App\Transformers\BackgroundSchoolTransformer($params);

        $parsed = $transformer->getParsedParams();

        $backgroundSchools = $client->backgroundSchools()->limit($parsed['limit'])->offset($parsed['offset'])->orderBy($parsed['sort'], $parsed['order'])->get();

        return $this->collection($backgroundSchools, $transformer);
    }

    /**
     * Include clientApplication.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeClientApplication(Client $client, ParamBag $params = null)
    {
        return $this->item($client->clientApplication, new \App\Transformers\ClientApplicationTransformer($params));
    }

    /**
     * Include clientPreparer.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeClientPreparer(Client $client, ParamBag $params = null)
    {
        return $this->item($client->clientPreparer, new \App\Transformers\ClientPreparerTransformer($params));
    }

    /**
     * Include clientProfile.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeClientProfile(Client $client, ParamBag $params = null)
    {
        return $this->item($client->clientProfile, new \App\Transformers\ClientProfileTransformer($params));
    }

    /**
     * Include clientRelationship.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeClientRelationship(Client $client, ParamBag $params = null)
    {
        return $this->item($client->clientRelationship, new \App\Transformers\ClientRelationshipTransformer($params));
    }

    /**
     * Include clientSignature.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeClientSignature(Client $client, ParamBag $params = null)
    {
        return $this->item($client->clientSignature, new \App\Transformers\ClientSignatureTransformer($params));
    }

    /**
     * Include lawfirm.
     *
     * @param \App\Models\Client            $client
     * @param \League\Fractal\ParamBag|null $params
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeLawfirm(Client $client, ParamBag $params = null)
    {
        return $this->item($client->lawfirm, new \App\Transformers\ClientSignatureTransformer($params));
    }
}
