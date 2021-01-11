<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ArticleTest extends DuskTestCase
{
    /**
     * A Dusk test login.
     *
     * @return void
     */
    public function testLogin()
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

    /**
     * A Dusk test index.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/articles')
                ->assertSee('Articles')
                ->assertSee('Show')
                ->assertSee('Showing')
                ->assertSee('Search:')
                ->assertSee('Previous')
                ->assertSee('Next');
        });
    }

    /**
     * A Dusk test create.
     *
     * @return void
     */
    public function testCreate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/articles')
                ->clickLink('Add New')
                ->waitForText('Save Changes')
                ->assertSee('Title')
                ->assertSee('Body')
                ->type('title', 'title test')
                ->type('body', 'body test')
                ->press('#btn-save')
                ->waitForText('saved successfully.');
        });
    }

    /**
     * A Dusk test edit.
     *
     * @return void
     */
    public function testEdit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/articles')
                ->waitForText('title test')
                ->click('a.edit-product')
                ->waitForText('Save Changes')
                ->assertSee('Body')
                ->type('title', 'title test 2')
                ->type('body', 'body test 2')
                ->press('#btn-save')
                ->waitForText('saved successfully.');
        });
    }

    /**
     * A Dusk test delete.
     *
     * @return void
     */
    public function testDelete()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/articles')
                ->waitForText('title test 2')
                ->click('a.delete-product')
                ->waitForDialog(1)
                ->assertDialogOpened('Are You sure want to delete !')
                ->acceptDialog()
                ->waitForText('deleted successfully.');
        });
    }

}
