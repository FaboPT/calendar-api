<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class EventTest extends TestCase
{
    private function user()
    {
        return User::firstWhere('email', 'user_interviewer@example.com');
    }

    private function getEventID()
    {
        return Event::firstWhere('user_id', $this->user()->id)->id;
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
            "day_date" => Carbon::create(2021, 12, 27)->format('Y-m-d'),
            "start_time" => Carbon::createFromTime(7)->format('H:i'),
            "end_time" => Carbon::createFromTime(8)->format('H:i'),
            "users" => [1, 2, 3, 4, 5],
        ];
    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function dataPostError(): array
    {
        return [
            "day_date" => Carbon::create(2021, 12, 27)->format('Y-m-d'),
            "start_time" => Carbon::createFromTime(7)->format('H:i'),
            "end_time" => Carbon::createFromTime(8)->format('H:i'),
            "users" => [1, 2],
        ];
    }

    public function testCreateNewEvent()
    {
        $this->actingAs($this->user());
        $response = $this->post(route('event.store'), $this->dataPost(), $this->headers());

        $response->assertJson([
            "message" => "Event successfully created",
            "success" => true
        ])->assertCreated();

        $this->deleteTokens();
    }

    public function testErrorCreateNewEvent()
    {
        $this->actingAs($this->user());
        $data = $this->dataPostError();
        $response = $this->post(route('event.store'), $data, $this->headers());

        $response->assertJson([
            "message" => "Not possible create a event, because there is already an event at that time, please change the event",
            "success" => false
        ])->assertStatus(Response::HTTP_CONFLICT);

        $this->deleteTokens();
    }

    public function testUpdateEvent()
    {
        $this->actingAs($this->user());
        $data = [
            "users" => [1, 2, 3, 4]
        ];

        $response = $this->put(route('event.update', $this->getEventID()), $data, $this->headers());

        $response->assertJson([
            "message" => "Event successfully updated",
            "success" => true,
        ])->assertOk();

        $this->deleteTokens();
    }

    public function testDeleteEvent()
    {
        $this->actingAs($this->user());

        $response = $this->delete(route('event.destroy', $this->getEventID()), [], $this->headers());

        $response->assertJson([
            "message" => "Event successfully deleted",
            "success" => true,
        ])->assertOk();

        $this->deleteTokens();
    }


}

