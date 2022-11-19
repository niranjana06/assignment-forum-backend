<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface
{
    public function getAllApprovedPosts();
    public function getPostById($id);
    public function getAllPendingPosts();
    public function approve(array $data);
    public function reject(array $data);
}
