<?php
namespace App\Tests;

include 'Client.php';
use App\Client\Client;
use PHPUnit\Framework\TestCase;

use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientTests extends TestCase
{
    public function testGetMethod()
    {
        $expectedResponse = [
            'id' => 1,
            'name'=>"TestName",
            'Text'=>"TestText"];
        $mockResponseJson = json_encode($expectedResponse, JSON_THROW_ON_ERROR);
        $mockResponse = new MockResponse($mockResponseJson,
        [
            'http_code'=>200,
            'response_headers'=>['Content-Type: application/json']
        ]);
        $mockClient = new MockHttpClient($mockResponse);
        $client = new Client($mockClient, "http://example.com");
        $client->set_get_url("comments");
        $responseData = $client->get_comments();

        self::assertSame('GET', $mockResponse->getRequestMethod());
        self::assertSame('http://example.com/comments', $mockResponse->getRequestUrl());
        self::assertContains(
            'Content-Type: application/json',
            $mockResponse->getRequestOptions()['headers']
        );
        self::assertSame($responseData, $expectedResponse);
    }

    public function testPostMethod()
    {
        $requestName = "NewName";
        $requestText = "NewText";
        $requestData = ['name'=>$requestName, 'text'=>$requestText];
        $expectedRequestData = json_encode($requestData, JSON_THROW_ON_ERROR);

        $expectedResponse = ['id' => 1];
        $mockResponseJson = json_encode($expectedResponse, JSON_THROW_ON_ERROR);
        $mockResponse = new MockResponse($mockResponseJson,
            [
                'http_code'=>201,
                'response_headers'=>['Content-Type: application/json']
            ]);

        $mockClient = new MockHttpClient($mockResponse);
        $client = new Client($mockClient, "http://example.com");
        $client->set_post_url("comment");
        $responseData = $client->post_comment($requestName, $requestText);


        self::assertSame('POST', $mockResponse->getRequestMethod());
        self::assertSame('http://example.com/comment', $mockResponse->getRequestUrl());
        self::assertContains(
            'Content-Type: application/json',
            $mockResponse->getRequestOptions()['headers']
        );

        self::assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
        self::assertSame($responseData, $expectedResponse);
    }

    public function testPutMethod()
    {
        $requestId = 1;
        $requestName = "PutName";
        $requestText = "PutText";
        $requestData = ['name'=>$requestName, 'text'=>$requestText];
        $expectedRequestData = json_encode($requestData, JSON_THROW_ON_ERROR);

        $expectedResponse = "Well Done?";
        $mockResponseJson = json_encode($expectedResponse, JSON_THROW_ON_ERROR);
        $mockResponse = new MockResponse($mockResponseJson,
            [
                'http_code'=>200,
                'response_headers'=>['Content-Type: application/json']
            ]);

        $mockClient = new MockHttpClient($mockResponse);
        $client = new Client($mockClient, "http://example.com");
        $client->set_post_url("comment");
        $responseData = $client->put_comment($requestId, $requestName, $requestText);


        self::assertSame('PUT', $mockResponse->getRequestMethod());
        self::assertSame('http://example.com/comment/'.$requestId, $mockResponse->getRequestUrl());
        self::assertContains(
            'Content-Type: application/json',
            $mockResponse->getRequestOptions()['headers']
        );

        self::assertSame($expectedRequestData, $mockResponse->getRequestOptions()['body']);
    }

}