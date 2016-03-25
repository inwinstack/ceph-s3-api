<?php


class AuthLoginTest extends TestCase
{

    /**
     * The base Headers to use while testing the AuthLoginTest Class.
     *
     * @var array
     */
    protected $headers = [
        'HTTP_Accept' => 'application/json'
    ];

    /**
     * The base PostData to use while testing the AuthLoginTest Class.
     *
     * @var array
     */
    protected $postData = [
        'name' => 'example',
        'email' => 'example@example.com',
        'password' => 'test1234',
        'password_confirmation' => 'test1234'
    ];


    /**
     *Testing User is Login Success
     */
    public function testLoginSuccess()
    {
        $this->createUser($this->postData['email'], $this->postData['password']);
        $this->post('api/v1/auth/login', $this->postData, $this->headers)
            ->seeStatusCode(200)
            ->seeJsonStructure(['uid', 'token']);
    }

    /**
     *Testing User is Login Failed
     */
    public function testLoginFailed()
    {
        $toValidateData = ['message' => 'verify_error'];
        $this->post('api/v1/auth/login', $this->postData, $this->headers)
            ->seeStatusCode(401)
            ->seeJsonContains($toValidateData);
    }

}