<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_user_can_get_all_ticket()
    {
        $tickets = Ticket::factory()->count(5)->create();

        $response = $this->actingAs($this->user)->get(route('ticket.index'));

        $response->assertStatus(200)
                ->assertViewIs('ticket.index')
                ->assertViewHas('tickets')
                ->assertSee($tickets->first()->title);
    }

    public function test_user_can_see_add_ticket()
    {
        $response = $this->actingAs($this->user)->get(route('ticket.create'));

        $response->assertStatus(200)
                ->assertViewIs('ticket.create')
                ->assertSee('Tambah Tiket');
    }

    public function test_user_can_add_ticket()
    {
        $input = Ticket::factory()->make()->toArray();

        $response = $this->actingAs($this->user)
                         ->post(route('ticket.store'),$input);

        $response->assertRedirectToRoute('ticket.index');

        $this->assertDatabaseHas('tickets', [
            'title' => $input['title'],
        ]);
    }

    public function test_user_can_see_edit_ticket()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($this->user)->get(route('ticket.edit', $ticket->id));

        $response->assertStatus(200)
                ->assertViewIs('ticket.edit')
                ->assertViewHas('ticket')
                ->assertSee($ticket->title);
    }

    public function test_user_can_edit_ticket()
    {
        $ticket = Ticket::factory()->create();
        $ticket->title = "New name";

        $response = $this->actingAs($this->user)->put(route('ticket.update', $ticket->id), $ticket->toArray());

        $response->assertRedirectToRoute('ticket.index');

        $this->assertDatabaseHas('tickets', [
            'title' => $ticket->title,
        ]);
    }

    public function test_user_can_see_detail_ticket()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($this->user)->get(route('ticket.show', $ticket->id));

        $response->assertStatus(200)
                ->assertViewIs('ticket.show')
                ->assertViewHas('ticket')
                ->assertSee($ticket->title);
    }

    public function test_user_can_comment_detail_ticket()
    {

    }

    public function test_user_can_update_status_ticket()
    {
        $ticket = Ticket::factory()->create(['status'=>'open']);

        $response = $this->actingAs($this->user)->put(route('ticket.status', $ticket->id));

        $response->assertRedirectToRoute('ticket.show',$ticket->id);

        $this->assertDatabaseHas('tickets', [
            'id'    => $ticket->id,
            'status'=> 'close',
        ]);
    }

    public function test_user_can_delete_ticket()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('ticket.destroy', $ticket->id));

        $response->assertRedirectToRoute('ticket.index');

        $this->assertDatabaseMissing('tickets', [
            'id'=>$ticket->id
        ]);
    }
}
