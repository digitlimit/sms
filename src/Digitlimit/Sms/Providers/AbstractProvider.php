<?php

namespace Digitlimit\Sms\Providers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

abstract class AbstractProvider
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * The message type.
     *
     * @var string
     */
    public $type = 'text';

    /**
     * Response type.
     *
     * @var string
     */
    protected $output = 'json';

    /**
     * Complete API response
     *
     * @var
     */
    protected $response;

    /**
     * Search results
     *
     * @var array
     */
    protected $results = [];

    /**
     * The HTTP request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * The query string.
     *
     * @var string
     */
    protected $query;

    /**
     * The client ID.
     *
     * @var string
     */
    protected $client_id;

    /**
     * The custom parameters to be sent with the request.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * The custom Guzzle configuration options.
     *
     * @var array
     */
    protected $guzzle_options = [];

    /**
     * Create a new provider instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $client_id
     * @param  array  $guzzle
     * @return void
     */
    public function __construct(Request $request, $client_id, $guzzle = [])
    {
        $this->guzzle_options = $guzzle;
        $this->request = $request;
        $this->client_id = $client_id;
    }

    /**
     * Get Base Url.
     *
     * @return string
     */
    abstract protected function getBaseUrl() : string;


    /**
     * Set the message content.
     *
     * @param  string  $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Set the phone number the message should be sent from.
     *
     * @param  string  $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Set the message type.
     *
     * @return $this
     */
    public function unicode()
    {
        $this->type = 'unicode';
        return $this;
    }

    /**
     * Get the query from the request.
     *
     * @return string
     */
    protected function getQuery() : string
    {
        $query = $this->query ? $this->query :
            $this->request->input('query');

        return $query ? $query : '';
    }

    /**
     * Get a instance of the Guzzle HTTP client.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new Client($this->guzzle_options);
        }

        return $this->httpClient;
    }

    /**
     * Set the Guzzle HTTP client instance.
     *
     * @param  \GuzzleHttp\Client  $client
     * @return $this
     */
    public function setHttpClient(Client $client)
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * Set the request instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Set the custom parameters of the request.
     *
     * @param  array  $parameters
     * @return $this
     */
    public function with(array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }

    public function responseHas($parameter) : bool {

        if(is_array($this->response) && isset($this->response[$parameter])){
            return true;
        }

        return false;
    }

    public function getResponse($parameter=null){

        if(is_array($this->response) && isset($this->response[$parameter])){
            return $this->response[$parameter];
        }

        return $this->response;
    }

    protected function buildQuery(array $parameters)
    {
        if($parameters){
            $this->with($parameters);
        }

        return $this->parameters;
    }
}