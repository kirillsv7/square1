<?php

namespace App\Services;

use App\Exceptions\UserNotFoundException;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Http;

class ImportPostsService
{
    public function __construct(
        protected PostRepository $postRepository,
        protected UserRepository $userRepository,
        protected Http $client
    ) {
    }

    /**
     * @throws UserNotFoundException
     */
    public function handle(): void
    {
        $data = $this->client::get('https://sq1-api-test.herokuapp.com/posts')->json('data');

        $admin = $this->userRepository->get(1); // Admin seeded as first user

        if ($admin === null) {
            throw new UserNotFoundException();
        }

        foreach ($data as $post) {
            $post['user_id'] = $admin->id;
            $this->postRepository->store($post);
        }

        cache()->flush();
    }
}