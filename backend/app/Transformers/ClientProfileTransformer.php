<?php

namespace App\Transformers;

use App\Models\ClientProfile;
use Appkr\Api\TransformerAbstract;
use League\Fractal\ParamBag;

class ClientProfileTransformer extends TransformerAbstract
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
     * @param  \App\Models\ClientProfile $clientprofile
     * @return  array
     */
    public function transform(ClientProfile $clientprofile)
    {
        $payload = [
            'id' => (int) $clientprofile->id,
            'mailing_address_care' => $clientprofile->mailing_address_care,
            'mailing_address_street_num' => $clientprofile->mailing_address_street_num,
            'mailing_address_apt_type' => $clientprofile->mailing_address_apt_type,
            'mailing_address_apt_num' => $clientprofile->mailing_address_apt_num,
            'mailing_address_city' => $clientprofile->mailing_address_city,
            'mailing_address_county' => $clientprofile->mailing_address_county,
            'mailing_address_province' => $clientprofile->mailing_address_province,
            'mailing_address_postal_code' => $clientprofile->mailing_address_postal_code,
            'mailing_address_country' => $clientprofile->mailing_address_country,
            'mailing_address_state' => $clientprofile->mailing_address_state,
            'mailing_address_state' => $clientprofile->mailing_address_state,
            'mailing_address_zip_code' => $clientprofile->mailing_address_zip_code,
            'mailing_address_telephone_num' => $clientprofile->mailing_address_telephone_num,
            'nationality_present' => $clientprofile->nationality_present,
            'nationality_birth' => $clientprofile->nationality_birth,
            'race_ethnic_tribal_group' => $clientprofile->race_ethnic_tribal_group,
            'religion' => $clientprofile->religion,
            'immigration_court_proceeding' => $clientprofile->immigration_court_proceeding,
            'leave_country_date' => $clientprofile->leave_country_date,
            'i94_num' => $clientprofile->i94_num,
            'entry_1_date' => $clientprofile->entry_1_date,
            'entry_1_place' => $clientprofile->entry_1_place,
            'entry_1_status' => $clientprofile->entry_1_status,
            'entry_1_status_expires' => $clientprofile->entry_1_status_expires,
            'entry_2_date' => $clientprofile->entry_2_date,
            'entry_2_place' => $clientprofile->entry_2_place,
            'entry_2_status' => $clientprofile->entry_2_status,
            'entry_3_date' => $clientprofile->entry_3_date,
            'entry_3_place' => $clientprofile->entry_3_place,
            'entry_3_status' => $clientprofile->entry_3_status,
            'passport_issued_country' => $clientprofile->passport_issued_country,
            'passport_num' => $clientprofile->passport_num,
            'passport_travel_num' => $clientprofile->passport_travel_num,
            'passport_expiration_date' => $clientprofile->passport_expiration_date,
            'language_native' => $clientprofile->language_native,
            'language_english_fluent' => $clientprofile->language_english_fluent,
            'language_other' => $clientprofile->language_other,
            'lawfirm_permanent_resident' => $clientprofile->lawfirm_permanent_resident,
            'residence_current_address_from' => $clientprofile->residence_current_address_from,
            'residence_current_address_to' => $clientprofile->residence_current_address_to,
            'date_last_entry' => $clientprofile->date_last_entry,
            'place_last_entry' => $clientprofile->place_last_entry,
            'created' => $clientprofile->created_at->toIso8601String(),
            'link' => [
                 'rel' => 'self',
                 'href' => route('api.v1.clientProfiles.show', $clientprofile->id),
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
     * @param  \App\Models\ClientProfile $clientprofile
     * @param  \League\Fractal\ParamBag|null $params
     * @return  \League\Fractal\Resource\Item
     */
    public function includeClient(ClientProfile $clientprofile, ParamBag $params = null)
    {
        return $this->item($clientprofile->client, new \App\Transformers\ClientTransformer($params));
    }

}
