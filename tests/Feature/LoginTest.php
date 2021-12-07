<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function headers(): array
    {
        return [
            "Accept" => "application/json"
        ];
    }

    public function testLoginInterviewer()
    {
        $user = $this->userInterviewerLogin();
        $response = $this->post(route('login'), $user, $this->headers());
        $response->assertJsonFragment(['success' => true]);
        $response->assertJsonFragment(['token_type' => 'Bearer']);
        $response->assertOk();

    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function userInterviewerLogin(): array
    {
        return [
            'email' => 'user_interviewer@example.com',
            'password' => 'password'
        ];
    }

    public function testLoginCandidate()
    {
        $user = $this->userCandidateLogin();
        $response = $this->post(route('login'), $user, $this->headers());
        $response->assertJsonFragment(['success' => true]);
        $response->assertJsonFragment(['token_type' => 'Bearer']);
        $response->assertOk();

    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function userCandidateLogin(): array
    {
        return [
            'email' => 'user_candidate@example.com',
            'password' => 'password'
        ];
    }

    public function testErrorLogin()
    {
        $response = $this->post(route('login'), [], $this->headers());
        $response->assertJsonValidationErrorFor("email");
        $response->assertJsonValidationErrorFor("password");
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testErrorPasswordLogin()
    {
        $userError = $this->userError();
        $response = $this->post(route('login'), $userError, $this->headers());
        $response->assertJsonValidationErrorFor("message");
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function userError(): array
    {
        return [
            'email' => 'user_candidate@example.com',
            'password' => 'password12'
        ];
    }


}
