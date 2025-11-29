<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Color;
use App\Models\ColorGroup;
use App\Models\ColorRelation;
use App\Models\Size;
use App\Models\SizeGroup;
use App\Models\SizeRelation;
use App\Models\MaterialDesignRequirement;

use PHPUnit\Framework\Attributes\Test;

class MaterialDesignRequirementApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear datos base de colores
        ColorGroup::create([
            'colorGroupCode' => 'CG1',
            'colorGroupName' => 'Group1',
            'colorGroupStatus' => true,
        ]);

        Color::create([
            'colorCode' => 'RED',
            'colorName' => 'Red',
            'colorGroup' => 'CG1',
            'colorStatus' => true,
        ]);

        ColorRelation::create([
            'colorGroupCode' => 'CG1',
            'colorCode' => 'RED',
        ]);

        // Crear datos base de tamaños
        SizeGroup::create([
            'sizeGroupCode' => 'SG1',
            'sizeGroupName' => 'Group1',
            'sizeGroupStatus' => true,
        ]);

        Size::create([
            'sizeCode' => 'L',
            'sizeName' => 'Large',
            'sizeGroup' => 'SG1',
            'sizeStatus' => true,
        ]);

        SizeRelation::create([
            'sizeGroupCode' => 'SG1',
            'sizeCode' => 'L',
        ]);
    }

    #[Test]
    public function it_can_add_a_new_material_design_requirement()
    {
        $response = $this->postJson('/api/material-design-requirements', [
            'colorCode' => 'RED',
            'colorGroupCode' => 'CG1',
            'sizeCode' => 'L',
            'sizeGroupCode' => 'SG1',
            'status' => true,
            'providerCode' => 'P001',
            'providerName' => 'Proveedor Test'
        ]);

        $response->assertStatus(201)
            ->assertJson(['colorCode' => 'RED']);

        $this->assertDatabaseHas('material_design_requirements', [
            'colorCode' => 'RED',
            'sizeCode' => 'L'
        ]);
    }

    #[Test]
    public function it_can_list_all_material_design_requirements()
    {
        MaterialDesignRequirement::create([
            'colorCode' => 'RED',
            'colorGroupCode' => 'CG1',
            'sizeCode' => 'L',
            'sizeGroupCode' => 'SG1',
            'status' => true
        ]);

        $response = $this->getJson('/api/material-design-requirements');

        $response->assertStatus(200)
            ->assertJsonFragment(['colorCode' => 'RED']);
    }

    #[Test]
    public function it_can_edit_a_material_design_requirement()
    {
        $item = MaterialDesignRequirement::create([
            'colorCode' => 'RED',
            'colorGroupCode' => 'CG1',
            'sizeCode' => 'L',
            'sizeGroupCode' => 'SG1',
            'status' => true
        ]);

        $response = $this->putJson("/api/material-design-requirements/{$item->id}", [
            'providerName' => 'Updated Provider'
        ]);

        $response->assertStatus(200)
            ->assertJson(['providerName' => 'Updated Provider']);
    }

    #[Test]
    public function it_can_delete_a_material_design_requirement()
    {
        $item = MaterialDesignRequirement::create([
            'colorCode' => 'RED',
            'colorGroupCode' => 'CG1',
            'sizeCode' => 'L',
            'sizeGroupCode' => 'SG1',
            'status' => true
        ]);

        $response = $this->deleteJson("/api/material-design-requirements/{$item->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('material_design_requirements', [
            'id' => $item->id
        ]);
    }

    #[Test]
    public function it_throws_error_if_color_does_not_match_group()
    {
        ColorGroup::create([
            'colorGroupCode' => 'CG2',
            'colorGroupName' => 'Group2',
            'colorGroupStatus' => true,
        ]);

        $response = $this->postJson('/api/material-design-requirements', [
            'colorCode' => 'RED',
            'colorGroupCode' => 'CG2',
            'sizeCode' => 'L',
            'sizeGroupCode' => 'SG1'
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'El colorCode no pertenece al colorGroupCode']);
    }

    #[Test]
    public function it_throws_error_if_size_does_not_match_group()
    {
        SizeGroup::create([
            'sizeGroupCode' => 'SG2',
            'sizeGroupName' => 'Group2',
            'sizeGroupStatus' => true,
        ]);

        $response = $this->postJson('/api/material-design-requirements', [
            'colorCode' => 'RED',
            'colorGroupCode' => 'CG1',
            'sizeCode' => 'L',
            'sizeGroupCode' => 'SG2',
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'El sizeCode no pertenece al sizeGroupCode']);
    }

    #[Test]
    public function it_throws_error_if_color_or_colorgroup_does_not_exist()
    {
        $response = $this->postJson('/api/material-design-requirements', [
            'colorCode' => 'NOEXISTE',
            'colorGroupCode' => 'CG1',
            'sizeCode' => 'L',
            'sizeGroupCode' => 'SG1'
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'El colorCode no existe']);
    }

    #[Test]
    public function it_throws_error_if_size_or_sizegroup_does_not_exist()
    {
        $response = $this->postJson('/api/material-design-requirements', [
            'colorCode' => 'RED',
            'colorGroupCode' => 'CG1',
            'sizeCode' => 'XXX',
            'sizeGroupCode' => 'SG1'
        ]);

        $response->assertStatus(400)
            ->assertJson(['error' => 'El sizeCode no existe']);
    }
}
