<?php

namespace App\Services;

class Facebook
{
    private string $access_token;
    private string $page_id;

    public function __construct()
    {
        $this->access_token = config('facebook.default_access_token');
        $this->page_id = config('facebook.page_id');
    }

    public function postToPage(string $message): array
    {
        $url = 'https://graph.facebook.com/' . $this->page_id . '/feed';

        $response = \Http::post($url, [
            'message' => $message,
            'access_token' => $this->access_token
        ]);

        if ($response->failed()) {
            return [
                'status'  => 'error',
                'message' => $response->body(),
            ];
        }

        $body = $response->object();
        $post_id = $body->id ?? null;

        if ($post_id === null) {
            return [
                'status' => 'error',
                'message' => 'Post ID is missing from the response',
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Post created with ID ' . $post_id,
        ];
    }
}
