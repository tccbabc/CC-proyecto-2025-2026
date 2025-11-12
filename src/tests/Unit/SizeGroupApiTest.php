<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\SizeGroup;
use App\Models\Size;
use App\Models\SizeRelation;

class SizeGroupApiTest extends TestCase
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

    /** @test */
    public function it_can_add_a_new_size_group()
    {
        $response = $this->postJson('/api/size-groups', [
            'sizeGroupCode' => 'NEW',
            'sizeGroupName' => 'New Group',
            'sizeGroupStatus' => true,
        ]);

        $response->assertStatus(201)
            ->assertJson(['sizeGroupCode' => 'NEW']);

        $this->assertDatabaseHas('size_groups', ['sizeGroupCode' => 'NEW']);
    }

    /** @test */
    public function it_can_list_all_size_groups()
    {
        SizeGroup::create([
            'sizeGroupCode' => 'A',
            'sizeGroupName' => 'Alpha',
            'sizeGroupStatus' => true,
        ]);

        $response = $this->getJson('/api/size-groups');
        $response->assertStatus(200)
            ->assertJsonFragment(['sizeGroupCode' => 'A']);
    }

    /** @test */
    public function it_can_edit_a_size_group()
    {
        SizeGroup::create([
            'sizeGroupCode' => 'EDIT',
            'sizeGroupName' => 'Old Name',
            'sizeGroupStatus' => true,
        ]);

        $response = $this->putJson('/api/size-groups/EDIT', [
            'sizeGroupName' => 'Updated Name',
            'sizeGroupStatus' => false,
        ]);

        $response->assertStatus(200)
            ->assertJson(['sizeGroupName' => 'Updated Name']);

        $this->assertDatabaseHas('size_groups', [
            'sizeGroupCode' => 'EDIT',
            'sizeGroupStatus' => false,
        ]);
    }

    /** @test */
    public function it_can_delete_a_size_group_and_its_relations()
    {
        $group = SizeGroup::create([
            'sizeGroupCode' => 'DEL',
            'sizeGroupName' => 'ToDelete',
            'sizeGroupStatus' => true,
        ]);

        SizeRelation::create([
            'sizeGroupCode' => 'DEL',
            'sizeCode' => 'S',
        ]);

        $response = $this->deleteJson('/api/size-groups/DEL');
        $response->assertStatus(200);

        $this->assertDatabaseMissing('size_groups', ['sizeGroupCode' => 'DEL']);
        $this->assertDatabaseMissing('size_relations', ['sizeGroupCode' => 'DEL']);
    }

    /** @test */
    public function it_throws_error_when_deleting_nonexistent_group()
    {
        $response = $this->deleteJson('/api/size-groups/NOEXISTE');
        $response->assertStatus(400)
            ->assertJson(['error' => 'Este sizeGroupCode no existe']);
    }

    /** @test */
    public function it_can_change_size_group_status()
    {
        $group = SizeGroup::create([
            'sizeGroupCode' => 'STATUS',
            'sizeGroupName' => 'StatusTest',
            'sizeGroupStatus' => true,
        ]);

        $response = $this->patchJson('/api/size-groups/STATUS/status', [
            'sizeGroupStatus' => false,
        ]);

        $response->assertStatus(200)
            ->assertJson(['sizeGroupStatus' => false]);

        $this->assertDatabaseHas('size_groups', [
            'sizeGroupCode' => 'STATUS',
            'sizeGroupStatus' => false,
        ]);
    }

    /** @test */
    public function it_can_append_a_size_to_group()
    {
        $group = SizeGroup::create([
            'sizeGroupCode' => 'APPEND',
            'sizeGroupName' => 'Append Group',
            'sizeGroupStatus' => true,
        ]);

        $size = Size::create([
            'sizeCode' => 'S',
            'sizeName' => 'Small',
            'sizeGroup' => 'APPEND',
            'sizeStatus' => true,
        ]);

        $response = $this->postJson('/api/size-groups/APPEND/append-size/S');
        $response->assertStatus(200)
            ->assertJson(['message' => 'Size agregado correctamente al grupo']);

        $this->assertDatabaseHas('size_relations', [
            'sizeGroupCode' => 'APPEND',
            'sizeCode' => 'S',
        ]);
    }

    /** @test */
    public function it_cannot_append_a_size_with_status_zero()
    {
        $group = SizeGroup::create([
            'sizeGroupCode' => 'GRP',
            'sizeGroupName' => 'Test Group',
            'sizeGroupStatus' => true,
        ]);

        $size = Size::create([
            'sizeCode' => 'X',
            'sizeName' => 'Inactive',
            'sizeGroup' => 'GRP',
            'sizeStatus' => false,
        ]);

        $response = $this->postJson('/api/size-groups/GRP/append-size/X');
        $response->assertStatus(400)
            ->assertJson(['error' => 'El sizeCode no está activo (status != 1)']);
    }

    /** @test */
    public function it_can_remove_a_size_from_group()
    {
        $group = SizeGroup::create([
            'sizeGroupCode' => 'G1',
            'sizeGroupName' => 'Group1',
            'sizeGroupStatus' => true,
        ]);

        $size = Size::create([
            'sizeCode' => 'S',
            'sizeName' => 'Small',
            'sizeGroup' => 'G1',
            'sizeStatus' => true,
        ]);

        SizeRelation::create([
            'sizeGroupCode' => 'G1',
            'sizeCode' => 'S',
        ]);

        $response = $this->deleteJson('/api/size-groups/G1/remove-size/S');
        $response->assertStatus(200)
            ->assertJson(['message' => 'Size eliminado del grupo correctamente']);

        $this->assertDatabaseMissing('size_relations', [
            'sizeGroupCode' => 'G1',
            'sizeCode' => 'S',
        ]);
    }

    /** @test */
    public function it_throws_error_when_removing_nonexistent_relation()
    {
        $group = SizeGroup::create([
            'sizeGroupCode' => 'G2',
            'sizeGroupName' => 'Group2',
            'sizeGroupStatus' => true,
        ]);

        $size = Size::create([
            'sizeCode' => 'Z',
            'sizeName' => 'Zeta',
            'sizeGroup' => 'G2',
            'sizeStatus' => true,
        ]);

        $response = $this->deleteJson('/api/size-groups/G2/remove-size/Z');
        $response->assertStatus(400)
            ->assertJson(['error' => 'No existe relación entre este size y el grupo']);
    }
}
