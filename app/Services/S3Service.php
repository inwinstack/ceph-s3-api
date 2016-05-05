<?php

namespace App\Services;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception as S3Exception;
class S3Service
{
    public function connect($accessKey, $secretKey)
    {
        $s3 = S3Client::factory([
            'credentials' => [
                'key'    => $accessKey,
                'secret' => $secretKey,
            ],
            'endpoint' => 'http://ceph-s3.imaclouds.com/',

        ]);
        return $s3;
    }

    public function listBucket($accessKey, $secretKey)
    {
        $s3 = $this->connect($accessKey, $secretKey);
        $listResponse = $s3->listBuckets([]);
        return $listResponse;
    }

    public function createBucket($accessKey, $secretKey, $Bucket)
    {
        $s3 = $this->connect($accessKey, $secretKey);

        try {
            $bucketResponse = $s3->createBucket([
                'Bucket' => $Bucket,
            ]);
            return true;
        } catch (S3Exception $e) {
            return false;
        }
    }

    public function listFile($accessKey, $secretKey, $bucket)
    {
        $s3 = $this->connect($accessKey, $secretKey);
        try {
            $objects = $s3->listObjects([
                'Bucket' => $bucket,
            ]);
            return $objects;
        } catch (S3Exception $e) {
            return $e->getMessage() . "\n";
        }

    }
}
