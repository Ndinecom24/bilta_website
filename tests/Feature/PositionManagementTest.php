<?php

namespace Tests\Feature;

use App\Models\Bilta\Department;
use App\Models\Bilta\Position;
use App\Models\System\Permission;
use App\Models\System\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PositionManagementTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function position_can_be_created_and_linked_to_department()
    {
        $dept = Department::firstOrCreate(
            ['slug' => 'test-dept'],
            ['name' => 'Test Department', 'code' => 'TDEPT', 'status_id' => 1]
        );

        $position = Position::create([
            'name' => 'Lead Specialist',
            'slug' => 'lead-specialist-test',
            'code' => 'LST',
            'department_id' => $dept->id,
            'status_id' => 1,
        ]);

        $this->assertDatabaseHas('positions', [
            'id' => $position->id,
            'name' => 'Lead Specialist',
            'department_id' => $dept->id,
        ]);

        $this->assertEquals($dept->id, $position->department->id);
    }

    /** @test */
    public function user_can_be_mapped_to_a_position()
    {
        $position = Position::create([
            'name' => 'Quality Reviewer',
            'slug' => 'quality-reviewer-test',
            'code' => 'QRT',
            'status_id' => 1,
        ]);

        $user = User::factory()->create([
            'phone' => '+260977000000',
            'status_id' => 1,
            'position_id' => $position->id,
            'position' => $position->name,
        ]);

        $this->assertNotNull($user->positionRelation);
        $this->assertEquals('Quality Reviewer', $user->positionRelation->name);
        $this->assertEquals('Quality Reviewer', $user->position_name);
        $this->assertStringContainsString('Quality Reviewer', $user->display_label);
    }

    /** @test */
    public function position_permissions_are_seeded()
    {
        $this->assertDatabaseHas('permissions', ['slug' => 'manage-positions']);
        $this->assertDatabaseHas('permissions', ['slug' => 'create-positions']);
        $this->assertDatabaseHas('permissions', ['slug' => 'edit-positions']);
        $this->assertDatabaseHas('permissions', ['slug' => 'delete-positions']);
    }
}
