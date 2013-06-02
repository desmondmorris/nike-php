<?php

/*
* Request
* This classes handles the HTTP requests responsible
* for making calls to the Nike API.
*/

class Request
{
    /**
     * Base URL
     */
    const API_URL = 'https://api.nike.com/me/';

    /**
     * API Key
     */
    private $_access_token;

    /**
     * Constructor
     *
     * @param array $base_url
     * @return void
     */
    public function __construct($config)
    {
        //@todo - write test
        if (!is_array($config)) {
            throw new Exception("Configuration:  Missing configuration.");
        }

        //@todo - write test
        if (!isset($config['access_token']) || $config['access_token'] == '') {
            throw new Exception("Configuration: Missing access token.");
        }

        $this->_setAccessToken($config['access_token']);

    }

    /**
     * API Key Setter
     *
     * @param string  $api_key
     * @return void
     */
    private function _setAccessToken($access_token)
    {
        $this->_access_token = $access_token;
    }

    /**
     * API Key Getter
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->_access_token;
    }

     /**
     * Make an api request
     *
     * @param string $resource
     * @param array $params
     * @param string $method
     */
    public function call($resource, $params = array())
    {
        $queryString = 'access_token=' . $this->getAccessToken();

        if (!empty($params) && is_array($params)) {
          $queryString .= http_build_query($params);
        }

        $requestUrl = self::API_URL . $resource . '/?' . $queryString;

        $curl = curl_init();

        $curl_options = array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => $requestUrl,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'appid: nike'
          ),
        );

        curl_setopt_array($curl, $curl_options);
        $response = curl_exec($curl);
        $curl_info = curl_getinfo($curl);

        //@todo test for curl error
        if ($response === FALSE) {
            throw new Exception(curl_error($curl), curl_errno($curl));
        }
        curl_close($curl);

        //@todo test for any non 200 response
        if ($curl_info['http_code'] != 200) {
            throw new Exception("Response: Bad response - HTTP Code:". $curl_info['http_code']);
        }

        $jsonArray = json_decode($response);

        if (!is_object($jsonArray)) {
             throw new Exception("Response: Response was not a valid response");
        }

        return $jsonArray;
    }

}
