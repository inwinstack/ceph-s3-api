<?php

class ListBucketTest extends TestCase
{
    /**
     * Testing the user list bucket is successfully.
     *
     * @return void
     */
    public function testListBucketSuccess()
    {
        $init = $this->initBucket();
        $headers = $this->headers;
        $headers['HTTP_Authorization'] = "Bearer {$init['token']}";
        $response = $this->get('/api/v1/bucket/list', $headers)
           ->seeStatusCode(200)
           ->seeJsonStructure(['Buckets' => ['*' => ['Name', 'CreationDate']]]);
    }
}
