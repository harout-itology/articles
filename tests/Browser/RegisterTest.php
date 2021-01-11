<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
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
                ->clickLink('Register')
                ->assertPathIs('/register')
                ->type('name', 'Harotioun KoujaOghlanian')
                ->type('email', 'harout.itology@gmail.com')
                ->type('password', '12345678')
                ->type('password_confirmation', '12345678')
                ->press('Register')
                ->assertPathIs('/email/verify')
                ->assertSee('Verify Your Email Address');
        });
    }
}
