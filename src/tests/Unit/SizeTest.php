<?php

namespace Tests\Unit;

use App\Models\Size;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SizeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_add_a_size()
    {
        $size = Size::addSize([
            'sizeCode' => 'S',
            'sizeName' => 'Small',
            'sizeGroup' => 'Standard',
            'sizeStatus' => true,
        ]);

        $this->assertDatabaseHas('sizes', [
            'sizeCode' => 'S',
            'sizeName' => 'Small',
        ]);
    }

    #[Test]
    public function it_can_edit_a_size()
    {
        $size = Size::factory()->create([
            'sizeCode' => 'M',
            'sizeName' => 'Medium',
        ]);

        $size->editSize(['sizeName' => 'Mid']);
        $this->assertDatabaseHas('sizes', [
            'sizeCode' => 'M',
            'sizeName' => 'Mid',
        ]);
    }

    #[Test]
    public function it_can_delete_a_size()
    {
        $size = Size::factory()->create(['sizeCode' => 'L']);
        $size->delSize();

        $this->assertDatabaseMissing('sizes', ['sizeCode' => 'L']);
    }
}
