<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    // public function test_user_can_get_all_category()
    // {
    //     $categories = Category::factory()->count(5)->create();

    //     $response = $this->actingAs($this->admin)->get(route('category.index'));

    //     $response->assertStatus(200)
    //             ->assertViewIs('category.index')
    //             ->assertSee($categories->first()->name);
    // }

    public function test_user_can_get_ajax_category()
    {
        $total = Category::count()+5;

        Category::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)->get(route('category.index').'?ajax=true');

        $response->assertStatus(200)
                 ->assertJsonPath('recordsTotal', $total)
                 ->assertJsonCount($total, 'data');
    }

    public function test_user_can_see_add_category()
    {
        $response = $this->actingAs($this->admin)->get(route('category.create'));

        $response->assertStatus(200)
                ->assertViewIs('category.create')
                ->assertSee('Tambah Kategori');
    }

    public function test_user_can_add_category()
    {
        $input = Category::factory()->make()->only('name');

        $response = $this->actingAs($this->admin)
                         ->post(route('category.store'),$input);

        $response->assertRedirectToRoute('category.index');

        $this->assertDatabaseHas('categories', [
            'name' => $input['name'],
        ]);
    }

    public function test_user_can_see_edit_category()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('category.edit', $category->id));

        $response->assertStatus(200)
                ->assertViewIs('category.edit')
                ->assertViewHas('category')
                ->assertSee($category->name);
    }

    public function test_user_can_edit_category()
    {
        $category = Category::factory()->create();
        $category->name = "New name";

        $response = $this->actingAs($this->admin)->put(route('category.update', $category->id), $category->toArray());

        $response->assertRedirectToRoute('category.index');

        $this->assertDatabaseHas('categories', [
            'name' => $category->name,
        ]);
    }

    public function test_user_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('category.destroy', $category->id));

        $response->assertRedirectToRoute('category.index');

        $this->assertDatabaseMissing('categories', [
            'id'=>$category->id
        ]);
    }
}
