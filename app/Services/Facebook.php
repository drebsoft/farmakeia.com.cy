<?php

namespace App\Services;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook as FacebookSDK;

class Facebook
{
    private FacebookSDK $service;
    private mixed $page_id;

    public function __construct()
    {
        $this->service = new FacebookSDK([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => config('facebook.default_graph_version'),
            'default_access_token' => config('facebook.default_access_token'),
        ]);
        $this->page_id = config('facebook.page_id');
    }

    public function postToPage(string $message): array
    {
        try {
            $response = $this->service->post('/' . $this->page_id . '/feed', ['message' => $message]);
        } catch(FacebookResponseException $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'type' => 'FacebookResponseException',
            ];
        } catch(FacebookSDKException $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'type' => 'FacebookSDKException',
            ];
        }

        $body = $response->getDecodedBody();
        $post_id = $body['id'] ?? null;

        if ($post_id === null) {
            return [
                'status' => 'error',
                'message' => 'Post ID is missing from the response',
                'type' => 'InternalException',
            ];
        }

        return [
            'status' => 'success',
            'post_id' => $post_id,
        ];
    }
}
