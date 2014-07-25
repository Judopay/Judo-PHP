<?php

namespace Judopay;

use Guzzle\Plugin\Log\LogPlugin;

class Request
{
	protected $configuration;
	protected $client;

	public function __construct(\Judopay\Configuration $configuration)
	{
		$this->configuration = $configuration;
	}

	public function setClient(\Guzzle\Http\Client $client)
	{
		$this->client = $client;

		// Set headers
		$this->client->setDefaultOption(
			'headers',
			array(
				'API-Version' => $this->configuration->get('api_version'),
        		'Accept' => 'application/json; charset=utf-8',
        		'Content-Type' => 'application/json'
			)
		);

		// Debug logging
		//$this->client->addSubscriber(LogPlugin::getDebugPlugin());
	}

	public function get($resourcePath)
	{
		$endpointUrl = $this->configuration->get('endpoint_url');
		$request = $this->client->get($endpointUrl.'/'.$resourcePath);
		$request = $this->setRequestAuthentication($request);

		try {
			$guzzleResponse = $request->send();
		} catch (\Guzzle\Http\Exception\BadResponseException $e) {
			// Guzzle throws an exception when it encounters a 4xx or 5xx error
			// Rethrow the exception so we can raise our custom exception classes
			$responseValidator = new \Judopay\ResponseValidator($e->getResponse());
			$responseValidator->check();
		}

		return $guzzleResponse;
	}

	public function setRequestAuthentication(\Guzzle\Http\Message\Request $request)
	{
		$oauthAccessToken = $this->configuration->get('oauth_access_token');

		// Do we have an oAuth2 access token?
		if (!empty($oauthAccessToken)) {
			$request->setHeader('Authorization', 'Bearer '.$oauthAccessToken);
		} else {
			// Otherwise, use basic authentication
			$request->setAuth(
				$this->configuration->get('api_token'),
				$this->configuration->get('api_secret')
			);
		}

		return $request;
	}
}