<?php

namespace Tests\Unit;

use Tests\AppTest;
use App\Models\Admin;

class TeamTest extends AppTest
{
    /** @test */
    public function it_knows_if_it_is_a_super_admin()
    {
        $this->assertTrue(Admin::factory()->superAdmin()->create()->isSuperAdmin());
    }

    /** @test */
    public function it_knows_if_it_is_a_musician()
    {
        $this->assertTrue(Admin::factory()->musician()->create()->isMusician());
    }

    /** @test */
    public function it_knows_if_it_is_a_sub()
    {
        $this->assertTrue(Admin::factory()->sub()->create()->isSub());
    }
}
