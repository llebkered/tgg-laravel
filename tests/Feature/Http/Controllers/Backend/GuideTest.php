<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuideTest extends TestCase
{
    use RefreshDatabase;

    public function test_admins_can_read_the_guide()
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('backend.guide'))
            ->assertOk()
            ->assertSee('Unconfirmed card payments')
            ->assertSee('<table>', false);
    }

    public function test_guide_contents_links_lead_to_its_headings()
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('backend.guide'))
            ->assertSee('href="#signing-in"', false)
            ->assertSee('id="signing-in"', false)
            ->assertSee('id="the-home-page-and-its-blocks"', false);
    }

    public function test_guide_is_linked_from_the_backend_menu()
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('backend.index'))
            ->assertSee(route('backend.guide'))
            ->assertSee(route('backend.guide', 'developer'));
    }

    public function test_admins_can_read_the_developer_guide()
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('backend.guide', 'developer'))
            ->assertOk()
            ->assertSee('Developer Guide')
            ->assertSee('Card payments and double-charge protection');
    }

    public function test_developer_guide_links_work_in_the_backend()
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('backend.guide', 'developer'))
            // The link to the staff guide goes to its backend page
            ->assertSee('href="' . route('backend.guide', 'staff') . '"', false)
            // Links to source files, which can't be opened here, become text
            ->assertDontSee('href="../', false)
            ->assertSee('ChargeOrder');
    }

    public function test_unknown_guides_are_not_found()
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get('/backend/guide/nope')->assertNotFound();
    }

    public function test_guide_needs_an_admin()
    {
        $this->get(route('backend.guide'))->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create());

        $this->get(route('backend.guide'))->assertRedirect('/');
    }
}
