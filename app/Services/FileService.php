<?php

namespace App\Services;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception as S3Exception;
class FileService extends S3Service
{
    protected $s3;

    public function __construct($accessKey, $secretKey)
    {
        $this->s3 = $this->connect($accessKey, $secretKey);
    }

    public function listFile($bucket, $prefix)
    {
        try {
            $objects = $this->s3->listObjects([
                'Bucket' => $bucket,
                'Prefix' => $prefix,
            ]);
            return $objects;
        } catch (S3Exception $e) {
            return false;
        }
    }

    public function uploadFile($bucket, $file, $fileName, $prefix)
    {

        try {
            $this->s3->headBucket(['Bucket' => $bucket]);
            if ($this->s3->doesObjectExist($bucket, $prefix.$fileName)) {
                return 'Upload File Exist';
            }
        } catch (S3Exception $e) {
            return 'Bucket not Exist';
        }

        try {
            $result = $this->s3->putObject([
                'Bucket'     => $bucket,
                'Key'        => "$prefix$fileName",
                'SourceFile' => $file,
            ]);
            return false;
        } catch (S3Exception $e) {
            return 'Upload File Error';
        }

    }
}
