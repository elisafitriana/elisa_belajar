<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_get_ajax_ticket()
    {
        $total = Ticket::where('user_id', $this->user->id)->count()+5;

        Ticket::factory()->count(5)->create(['user_id'=>$this->user->id]);

        $response = $this->actingAs($this->user)->get(route('ticket.index').'?ajax=true');

        $response->assertStatus(200)
                 ->assertJsonPath('recordsTotal', $total)
                 ->assertJsonCount($total, 'data');
    }

    public function test_admin_can_get_ajax_ticket()
    {
        $total = Ticket::count()+5;

        Ticket::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)->get(route('ticket.index').'?ajax=true');

        $response->assertStatus(200)
                 ->assertJsonPath('recordsTotal', $total)
                 ->assertJsonCount($total, 'data');
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
        $input['file'] = UploadedFile::fake()->image('file.jpg');
        $input['categories'] = Category::factory()->count(1)->create()->pluck('id')->toArray();

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
        $ticket->categories = Category::factory()->count(1)->create()->pluck('id')->toArray();
        unset($ticket->file);

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
        $ticket = Ticket::factory()->create(['status'=>'open']);

        
        $response = $this->actingAs($this->user)->post(route('ticket.comment', $ticket->id), ['comment'=>'Appantuh!']);

        $response->assertRedirectToRoute('ticket.show',$ticket->id);

        $this->assertDatabaseHas('comments', [
            'ticket_id'=> $ticket->id,
            'comment' => 'Appantuh!',
        ]);
    }

    public function test_user_can_update_status_ticket()
    {
        $ticket = Ticket::factory()->create(['status'=>'open']);

        $response = $this->actingAs($this->user)->post(route('ticket.status', $ticket->id),['status'=>'waiting']);

        $response->assertRedirectToRoute('ticket.show',$ticket->id);

        $this->assertDatabaseHas('tickets', [
            'id'    => $ticket->id,
            'status'=> 'waiting',
        ]);
    }

    public function test_user_can_update_close_ticket()
    {
        $ticket = Ticket::factory()->create(['status'=>'waiting']);

        $response = $this->actingAs($this->user)->post(route('ticket.status', $ticket->id),['status'=>'close']);

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
