<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_user_can_get_ajax_user()
    {
        $total = User::count()+5;

        User::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)->get(route('user.index').'?ajax=true');

        $response->assertStatus(200)
                 ->assertJsonPath('recordsTotal', $total)
                 ->assertJsonCount($total, 'data');
    }

    public function test_user_can_see_add_user()
    {
        $response = $this->actingAs($this->admin)->get(route('user.create'));

        $response->assertStatus(200)
                ->assertViewIs('user.create')
                ->assertSee('Tambah User');
    }

    public function test_user_can_add_user()
    {
        $input = User::factory()->make()->toArray();
        $input['password'] = 'password';

        $response = $this->actingAs($this->admin)
                         ->post(route('user.store'),$input);

        $response->assertRedirectToRoute('user.index');

        $this->assertDatabaseHas('users', [
            'name' => $input['name'],
        ]);
    }

    public function test_user_can_see_edit_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('user.edit', $user->id));

        $response->assertStatus(200)
                ->assertViewIs('user.edit')
                ->assertViewHas('user')
                ->assertSee($user->name);
    }

    public function test_user_can_edit_user()
    {
        $user = User::factory()->create();
        $user->name = "New name";

        $response = $this->actingAs($this->admin)->put(route('user.update', $user->id), $user->toArray());

        $response->assertRedirectToRoute('user.index');

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
        ]);
    }

    public function test_user_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('user.destroy', $user->id));

        $response->assertRedirectToRoute('user.index');

        $this->assertDatabaseMissing('users', [
            'id'=>$user->id
        ]);
    }
}
