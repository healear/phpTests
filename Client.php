<?php
namespace App\Client;

use Exception;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

Class Client
{
    private HttpClientInterface $client;
    private string $url;
    private string $geturl;
    private string $posturl;
    public function __construct(HttpClientInterface $client, string $url)
    {
        $this->client = $client;
        $this->url = $url;
    }

    public function set_post_url(string $posturl)
    {
        $this->posturl=$posturl;
    }

    public function set_get_url(string $geturl)
    {
        $this->geturl=$geturl;
    }

/*
 * HTTP Methods
 */
    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function get_comments()
    {
        $response = $this->client->request
        (
            'GET',
            $this->url.'/'.$this->geturl,
            [
                'headers' =>
                [
                    'Content-Type'=>'application/json'
                ]
            ]
        );
        try
        {
            $responseJson = $response->getContent();
            $responseData = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);
            return $responseData;
        }
        catch (ClientException  $e)
        {
            return new Exception($e->getMessage(), $e->getCode());
        }
    }


    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function post_comment(string $name, $text)
    {
        $response = $this->client->request(
            'POST',
            $this->url.'/'.$this->posturl,
            [
                'json'=>[
                    'name' => $name,
                    'text'=>$text
                    ]
            ]
        );
        try
        {
            $responseJson = $response->getContent();
            $responseData = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);
            return $responseData;
        }
        catch (ClientException  $e)
        {
            return new Exception($e->getMessage(), $e->getCode());
        }
    }


    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function put_comment(int $id, string $name, $text)
    {
        $response = $this->client->request(
            'PUT',
            $this->url.'/'.$this->posturl.'/'.$id,
            [
                'json'=>[
                    'name'=>$name,
                    'text'=>$text
                ]
            ]
        );
        try
        {
            $responseJson = $response->getContent();
            $responseData = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);
            return $responseData;
        }
        catch (ClientException  $e)
        {
            return new Exception($e->getMessage(), $e->getCode());
        }
    }
}