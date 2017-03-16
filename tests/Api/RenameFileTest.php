<?php

class RenameFileTest extends TestCase
{
    /**
     * Testing the user rename the file but the bucket is not exist.
     *
     * @return void
     */
    public function testRenameFileButBucketIsNotExist()
    {
        $user = $this->initUser();
        $token = \JWTAuth::fromUser($user);
        $headers = $this->headers;
        $headers['HTTP_Authorization'] = "Bearer $token";
        $this->post("api/v1/file/rename/", [
              'bucket' => str_random(10),
              'old' => 'old',
              'new' => 'new'
            ], $headers)
            ->seeStatusCode(403)
            ->seeJsonContains([
                "message" => "The bucket is not exist"
            ]);
    }

    /**
     * Testing the user rename the file but the file of old is not exist.
     *
     * @return void
     */
    public function testRenameFileButOldFileIsNotExist()
    {
        $user = $this->initUser();
        $token = \JWTAuth::fromUser($user);
        $headers = $this->headers;
        $headers['HTTP_Authorization'] = "Bearer $token";
        $bucket = str_random(10);
        $this->createBucket($user, $bucket);
        $this->post("api/v1/file/rename/", [
              'bucket' => $bucket,
              'old' => 'old',
              'new' => 'new'
            ], $headers)
            ->seeStatusCode(403)
            ->seeJsonContains([
                "message" => "The file of old name is not exist"
            ]);
    }

    /**
     * Testing the user rename the file but the file of new is exist.
     *
     * @return void
     */
    public function testRenameFileButNewFileIsExist()
    {
        $user = $this->initUser();
        $token = \JWTAuth::fromUser($user);
        $headers = $this->headers;
        $headers['HTTP_Authorization'] = "Bearer $token";
        $bucket = str_random(10);
        $this->createBucket($user, $bucket);
        $this->uploadFile($bucket, $headers);
        $this->post("api/v1/file/rename/", [
              'bucket' => $bucket,
              'old' => 'test.jpg',
              'new' => 'test.jpg'
            ], $headers)
            ->seeStatusCode(403)
            ->seeJsonContains([
                "message" => "The file of new name is exist"
            ]);
    }

    /**
     * Testing the user rename the file is successfully.
     *
     * @return void
     */
    public function testRenameFileSuccess()
    {
        $user = $this->initUser();
        $token = \JWTAuth::fromUser($user);
        $headers = $this->headers;
        $headers['HTTP_Authorization'] = "Bearer $token";
        $bucket = str_random(10);
        $this->createBucket($user, $bucket);
        $this->uploadFile($bucket, $headers);
        $this->post("api/v1/file/rename/", [
              'bucket' => $bucket,
              'old' => 'test.jpg',
              'new' => 'test2.jpg'
            ], $headers)
            ->seeStatusCode(200)
            ->seeJsonContains([
                "message" => "Rename file is Successfully"
            ]);
    }
}
