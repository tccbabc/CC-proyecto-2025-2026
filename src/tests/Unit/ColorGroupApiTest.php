<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ColorGroup;
use App\Models\Color;
use App\Models\ColorRelation;
use PHPUnit\Framework\Attributes\Test;

class ColorGroupApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        ColorGroup::create([
            'colorGroupCode' => 'BSC',
            'colorGroupName' => 'Basic',
            'colorGroupStatus' => true,
        ]);
    }

    #[Test]
    public function it_can_add_a_new_color_group()
    {
        $response = $this->postJson('/api/color-groups', [
            'colorGroupCode' => 'NEW',
            'colorGroupName' => 'New Group',
            'colorGroupStatus' => true,
        ]);

        $response->assertStatus(201)
            ->assertJson(['colorGroupCode' => 'NEW']);

        $this->assertDatabaseHas('color_groups', ['colorGroupCode' => 'NEW']);
    }

    #[Test]
    public function it_can_list_all_color_groups()
    {
        ColorGroup::create([
            'colorGroupCode' => 'A',
            'colorGroupName' => 'Alpha',
            'colorGroupStatus' => true,
        ]);

        $response = $this->getJson('/api/color-groups');
        $response->assertStatus(200)
            ->assertJsonFragment(['colorGroupCode' => 'A']);
    }

    #[Test]
    public function it_can_edit_a_color_group()
    {
        ColorGroup::create([
            'colorGroupCode' => 'EDIT',
            'colorGroupName' => 'Old Name',
            'colorGroupStatus' => true,
        ]);

        $response = $this->putJson('/api/color-groups/EDIT', [
            'colorGroupName' => 'Updated Name',
            'colorGroupStatus' => false,
        ]);

        $response->assertStatus(200)
            ->assertJson(['colorGroupName' => 'Updated Name']);

        $this->assertDatabaseHas('color_groups', [
            'colorGroupCode' => 'EDIT',
            'colorGroupStatus' => false,
        ]);
    }

    #[Test]
    public function it_can_delete_a_color_group_and_its_relations()
    {
        ColorGroup::create([
            'colorGroupCode' => 'DEL',
            'colorGroupName' => 'ToDelete',
            'colorGroupStatus' => true,
        ]);

        Color::create([
            'colorCode' => 'RED',
            'colorName' => 'Red',
            'colorGroup' => 'DEL',
            'colorStatus' => true,
        ]);

        ColorRelation::create([
            'colorGroupCode' => 'DEL',
            'colorCode' => 'RED',
        ]);

        $response = $this->deleteJson('/api/color-groups/DEL');
        $response->assertStatus(200);

        $this->assertDatabaseMissing('color_groups', ['colorGroupCode' => 'DEL']);
        $this->assertDatabaseMissing('color_relations', ['colorGroupCode' => 'DEL']);
    }

    #[Test]
    public function it_throws_error_when_deleting_nonexistent_group()
    {
        $response = $this->deleteJson('/api/color-groups/NOEXISTE');
        $response->assertStatus(400)
            ->assertJson(['error' => 'Este colorGroupCode no existe']);
    }

    #[Test]
    public function it_can_append_a_color_to_group()
    {
        ColorGroup::create([
            'colorGroupCode' => 'APPEND',
            'colorGroupName' => 'Append Group',
            'colorGroupStatus' => true,
        ]);

        Color::create([
            'colorCode' => 'BLU',
            'colorName' => 'Blue',
            'colorGroup' => 'APPEND',
            'colorStatus' => true,
        ]);

        $response = $this->postJson('/api/color-groups/APPEND/append-color/BLU');
        $response->assertStatus(200)
            ->assertJson(['message' => 'Color agregado correctamente al grupo']);

        $this->assertDatabaseHas('color_relations', [
            'colorGroupCode' => 'APPEND',
            'colorCode' => 'BLU',
        ]);
    }

    #[Test]
    public function it_cannot_append_a_color_with_status_zero()
    {
        ColorGroup::create([
            'colorGroupCode' => 'GRP',
            'colorGroupName' => 'Test Group',
            'colorGroupStatus' => true,
        ]);

        Color::create([
            'colorCode' => 'X',
            'colorName' => 'Inactive',
            'colorGroup' => 'GRP',
            'colorStatus' => false,
        ]);

        $response = $this->postJson('/api/color-groups/GRP/append-color/X');
        $response->assertStatus(400)
            ->assertJson(['error' => 'El colorCode no está activo (status != 1)']);
    }

    #[Test]
    public function it_can_remove_a_color_from_group()
    {
        ColorGroup::create([
            'colorGroupCode' => 'G1',
            'colorGroupName' => 'Group1',
            'colorGroupStatus' => true,
        ]);

        Color::create([
            'colorCode' => 'R',
            'colorName' => 'Red',
            'colorGroup' => 'G1',
            'colorStatus' => true,
        ]);

        ColorRelation::create([
            'colorGroupCode' => 'G1',
            'colorCode' => 'R',
        ]);

        $response = $this->deleteJson('/api/color-groups/G1/remove-color/R');
        $response->assertStatus(200)
            ->assertJson(['message' => 'Color eliminado del grupo correctamente']);

        $this->assertDatabaseMissing('color_relations', [
            'colorGroupCode' => 'G1',
            'colorCode' => 'R',
        ]);
    }

    #[Test]
    public function it_throws_error_when_removing_nonexistent_relation()
    {
        ColorGroup::create([
            'colorGroupCode' => 'G2',
            'colorGroupName' => 'Group2',
            'colorGroupStatus' => true,
        ]);

        Color::create([
            'colorCode' => 'Z',
            'colorName' => 'Zeta',
            'colorGroup' => 'G2',
            'colorStatus' => true,
        ]);

        $response = $this->deleteJson('/api/color-groups/G2/remove-color/Z');
        $response->assertStatus(400)
            ->assertJson(['error' => 'No existe relación entre este color y el grupo']);
    }
}
