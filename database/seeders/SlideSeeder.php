<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Brindamos los Mejores Servicios de Reparación de Aire Acondicionado',
                'subtitle' => 'Ofrecemos servicios profesionales de climatización con la mejor calidad y atención personalizada para tu hogar o negocio',
                'image' => 'img/carousel-1.jpg',
                'button_text' => 'Contactar Ahora',
                'button_url' => '/contact',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Servicios de Calidad en Aire Acondicionado',
                'subtitle' => 'Especialistas en sistemas de climatización con años de experiencia y compromiso con la excelencia en cada servicio',
                'image' => 'img/carousel-2.jpg',
                'button_text' => 'Contactar Ahora',
                'button_url' => '/contact',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            Slide::create($slide);
        }
    }
}