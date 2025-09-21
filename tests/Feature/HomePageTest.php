<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
    }

    public function test_home_page_contains_basic_elements(): void
    {
        $response = $this->get('/');
        
        $response->assertSee('AirCon'); // Nombre por defecto
        $response->assertSee('Carousel'); // Elemento del carousel
    }
}