<?php

/*
 * Library for the CloudFlare API
 *
 * @author Tobias Moser
 * @version 0.1
 *
 */
namespace Joomunited\WPSOLADDON;

/**
 * Class CloudFlare
 */
class CloudFlare
{
    /**
     * Init email
     *
     * @var string
     */
    public $email;
    /**
     * Init token
     *
     * @var string
     */
    public $token;
    /**
     * Init api link
     *
     * @var string
     */
    public $api = 'https://api.cloudflare.com/client/v4/zones';

    /**
     * CloudFlare constructor.
     *
     * @param string $email Email input
     * @param string $token Token input
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Get list zones
     *
     * @param string $zone Zone information
     *
     * @return mixed
     */
    public function getListZone($zone)
    {
        if (empty($zone)) {
            return null;
        }

        $headers = array(
            'X-Auth-Email: '.$this->email,
            'X-Auth-Key: '.$this->token,
            'Content-Type: application/json'
        );

        // start with curl and prepare accordingly
        $ch = curl_init($this->api . '?name='.$zone . '&status=active&match=all');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        // make the request
        $output = curl_exec($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if (!empty($curl_error)) {
            return null;
        }

        return json_decode($output);
    }

    /**
     * Purge cloud flare cache
     *
     * @param string $domain Zone information
     * @param array  $urls   List urls
     *
     * @return mixed
     */
    public function purge($domain, $urls)
    {
        $urls = $this->filterCustomUrl($domain, $urls);
        if (!empty($urls)) {
            $data = array('files' => $urls);
        } else {
            $data = array('purge_everything' => true);
        }

        $list_zones = $this->getListZone($domain);
        if (empty($list_zones) || empty($list_zones->result)) {
            return 'Domain ' . $domain . ' error : Not found cloudflare zones';
        }

        $headers = array(
            'X-Auth-Email: '.$this->email,
            'X-Auth-Key: '.$this->token,
            'Content-Type: application/json'
        );

        $json_output = array();
        foreach ($list_zones->result as $zone) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->api .'/'. $zone->id . '/purge_cache');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // set curl timeout
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            // make the request
            $response = curl_exec($ch);
            $curl_error = curl_error($ch);
            curl_close($ch);

            if (!empty($curl_error)) {
                $json_output[] = 'Domain '. $domain . ' error: ' . $curl_error;
                continue;
            }

            $result = json_decode($response);

            if (!empty($result->errors)) {
                $error_arr = array();
                foreach ($result->errors as $error) {
                    $error_arr[] = $error->code;
                }
                $json_output[] = 'Domain '. $domain . ' error code: ' . implode(',', array_unique($error_arr));
            }
        }

        if (!empty($json_output)) {
            return implode('<br>', $json_output);
        }

        return true;
    }

    /**
     * Filter custom urls
     *
     * @param string $domain Domain
     * @param string $urls   Urls
     *
     * @return mixed
     */
    public function filterCustomUrl($domain, $urls)
    {
        if (empty($urls)) {
            return $urls;
        }

        foreach ($urls as $key => $url) {
            if (strpos($url, $domain) === false) {
                unset($urls[$key]);
            }
        }

        return $urls;
    }
}
