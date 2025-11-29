<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Color;
use App\Models\ColorGroup;
use PHPUnit\Framework\Attributes\Test;

class ColorApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        ColorGroup::create([
            'colorGroupCode' => 'BASIC',
            'colorGroupName' => 'Basic Colors',
            'colorGroupStatus' => true,
        ]);
    }

    #[Test]
    public function it_can_add_a_new_color()
    {
        $response = $this->postJson('/api/colors', [
            'colorCode' => 'RED',
            'colorName' => 'Red',
            'colorGroup' => 'BASIC',
            'colorStatus' => true,
        ]);

        $response->assertStatus(201)
            ->assertJson(['colorCode' => 'RED']);

        $this->assertDatabaseHas('colors', ['colorCode' => 'RED']);
    }

    #[Test]
    public function it_can_list_all_colors()
    {
        Color::create([
            'colorCode' => 'BLU',
            'colorName' => 'Blue',
            'colorGroup' => 'BASIC',
            'colorStatus' => true,
        ]);

        $response = $this->getJson('/api/colors');
        $response->assertStatus(200)
            ->assertJsonFragment(['colorCode' => 'BLU']);
    }

    #[Test]
    public function it_can_edit_a_color()
    {
        Color::create([
            'colorCode' => 'GRN',
            'colorName' => 'Green',
            'colorGroup' => 'BASIC',
            'colorStatus' => true,
        ]);

        $response = $this->putJson('/api/colors/GRN', [
            'colorName' => 'Green Updated',
            'colorGroup' => 'BASIC',
        ]);

        $response->assertStatus(200)
            ->assertJson(['colorName' => 'Green Updated']);
    }

    #[Test]
    public function it_can_delete_a_color()
    {
        Color::create([
            'colorCode' => 'DEL',
            'colorName' => 'Delete Me',
            'colorGroup' => 'BASIC',
            'colorStatus' => true,
        ]);

        $response = $this->deleteJson('/api/colors/DEL');
        $response->assertStatus(200);

        $this->assertDatabaseMissing('colors', ['colorCode' => 'DEL']);
    }

    #[Test]
    public function it_throws_error_when_group_does_not_exist()
    {
        $response = $this->postJson('/api/colors', [
            'colorCode' => 'XXX',
            'colorName' => 'Unknown',
            'colorGroup' => 'NOEXISTE',
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'El colorGroupCode no existe']);
    }
}

