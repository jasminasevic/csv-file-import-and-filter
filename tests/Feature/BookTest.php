<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_get_all_books()
    {
        $response = $this->get('api/book');
        $response->assertStatus(200);
    }

    public function test_get_specific_book()
    {
        $response = $this->get('api/book/1');
        $response->assertStatus(200);
    }

    public function test_get_books_filtered_by_title()
    {
        $response = $this->get('api/book?title=anna');
        $response->assertStatus(200);
    }

    public function test_get_books_filtered_by_issue_year()
    {
        $response = $this->get('api/book?year=greater_than_ten');
        $response->assertStatus(200);
    }

    public function test_get_books_filtered_by_title_and_issue_year()
    {
        $response = $this->get('api/book?year=less_than_ten&title=anna');
        $response->assertStatus(200);
    }

    public function test_invalid_issue_year(){
        $response = $this->get('api/book?year=wrong_issue_year&title=anna');
        $response->assertStatus(404);
    }
}
