<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Laravel')
                ->clickLink('Login')
                ->assertPathIs('/login')
                ->type('email', 'harout.itology@gmail.com')
                ->type('password', '12345678')
                ->press('Login')
                ->assertPathIs('/home')
                ->assertSee('Dashboard');
        });
    }
}
