<?php

class LoginTest extends TestCase
{
    /**
     * Testing the user login is failed.
     *
     * @return void
     */
    public function testLoginFailed()
    {
        $this->post('api/v1/auth/login', [
            'email' => str_random(5) . "@imac.com",
            'password' => str_random(10)
        ], $this->headers)
        ->seeStatusCode(401)
        ->seeJsonContains([
          "message" => "The email is not exist"
        ]);
    }

    /**
     * Testing the user login is successfully.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $email = str_random(5) . "@imac.com";
        $password = str_random(10);
        $user = $this->initUser($email, $password);
        $this->post('api/v1/auth/login', [
            'email' => $email,
            'password' => $password
        ], $this->headers)
        ->seeStatusCode(200)
        ->seeJsonStructure(['id', 'uid', 'name', 'role', 'email', 'access_key', 'secret_key', 'created_at', 'updated_at', 'token']);
    }
}
