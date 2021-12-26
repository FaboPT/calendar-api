<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AvailabilityTest extends TestCase
{
    private function user()
    {
        return User::firstWhere('email', 'user_interviewer@example.com');
    }

    private function deleteTokens()
    {
        $this->user()->tokens()->delete();
    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function headers(): array
    {
        return [
            "Accept" => "application/json",
            "Authorization" => 'Bearer' . $this->user()->createToken('Test token Interviewer')->plainTextToken
        ];
    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function dataPost(): array
    {
        return [
            "start_date" => Carbon::create(2021, 12, 24)->format('Y-m-d'),
            "end_date" => Carbon::create(2021, 12, 24)->format('Y-m-d'),
            "day" => "Friday",
            "start_time" => Carbon::createFromTime(8)->format('H:i'),
            "end_time" => Carbon::createFromTime(20)->format('H:i')
        ];
    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function dataPostError(): array
    {
        return [
            "start_date" => Carbon::create(2021, 12, 24)->format('Y-d-m'),
            "end_date" => Carbon::create(2021, 12, 24)->format('Y-m-d'),
            "day" => "Friday",
            "start_time" => Carbon::createFromTime(8)->format('H:i'),
            "end_time" => Carbon::createFromTime(20)->format('H:i')
        ];
    }

    public function testCreateNewAvailability()
    {
        $this->actingAs($this->user());
        $data = $this->dataPost();
        $response = $this->post(route('availability.store'), $data, $this->headers());

        $response->assertJsonFragment(["message" => true])->assertCreated();

        $this->deleteTokens();
    }

    public function testErrorCreateNewAvailability()
    {
        $this->actingAs($this->user());
        $data = $this->dataPostError();
        $response = $this->post(route('availability.store'), $data, $this->headers());

        $response->assertJsonValidationErrors(['start_date', 'end_date'])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->deleteTokens();
    }

}
