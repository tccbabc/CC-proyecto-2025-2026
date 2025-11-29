<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Size;
use App\Models\SizeGroup;
use PHPUnit\Framework\Attributes\Test;

class SizeApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        SizeGroup::create([
            'sizeGroupCode' => 'STD',
            'sizeGroupName' => 'Standard',
            'sizeGroupStatus' => true,
        ]);
    }

    // aqui el @test ha sido eliminado, porque en la ultima version de test
    // ya no usa @test, sino #[test]. Pero eso no influye la prueba

    #[Test]
    public function it_can_add_a_new_size()
    {
        $response = $this->postJson('/api/sizes', [
            'sizeCode' => 'S',
            'sizeName' => 'Small',
            'sizeGroup' => 'STD',
            'sizeStatus' => true,
        ]);

        $response->assertStatus(201)
            ->assertJson(['sizeCode' => 'S']);

        $this->assertDatabaseHas('sizes', ['sizeCode' => 'S']);
    }

    #[Test]
    public function it_can_list_all_sizes()
    {
        Size::create([
            'sizeCode' => 'M',
            'sizeName' => 'Medium',
            'sizeGroup' => 'STD',
            'sizeStatus' => true,
        ]);

        $response = $this->getJson('/api/sizes');
        $response->assertStatus(200)
            ->assertJsonFragment(['sizeCode' => 'M']);
    }

    #[Test]
    public function it_can_edit_a_size()
    {
        Size::create([
            'sizeCode' => 'L',
            'sizeName' => 'Large',
            'sizeGroup' => 'STD',
            'sizeStatus' => true,
        ]);

        $response = $this->putJson('/api/sizes/L', [
            'sizeName' => 'Large Updated',
            'sizeGroup' => 'STD',
        ]);

        $response->assertStatus(200)
            ->assertJson(['sizeName' => 'Large Updated']);
    }


    #[Test]
    public function it_can_delete_a_size()
    {
        $size = Size::create([
            'sizeCode' => 'D',
            'sizeName' => 'Delete Me',
            'sizeGroup' => 'STD',
            'sizeStatus' => true,
        ]);

        $response = $this->deleteJson('/api/sizes/D');
        $response->assertStatus(200);

        $this->assertDatabaseMissing('sizes', ['sizeCode' => 'D']);
    }

    #[Test]
    public function it_throws_error_when_group_does_not_exist()
    {
        $response = $this->postJson('/api/sizes', [
            'sizeCode' => 'X',
            'sizeName' => 'Unknown',
            'sizeGroup' => 'NOEXISTE',
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'El sizeGroupCode no existe']);
    }
}
