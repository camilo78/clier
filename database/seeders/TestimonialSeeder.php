<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'María González',
                'client_position' => 'Directora de Operaciones',
                'content' => 'Excelente servicio de limpieza. El equipo es muy profesional y siempre dejan nuestras oficinas impecables. Altamente recomendado.',
                'image' => 'img/testimonial-1.jpg',
                'rating' => 5,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'client_name' => 'Carlos Rodríguez',
                'client_position' => 'Gerente General',
                'content' => 'Llevamos años trabajando con ellos y siempre superan nuestras expectativas. Su atención al detalle es excepcional.',
                'image' => 'img/testimonial-2.jpg',
                'rating' => 5,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'client_name' => 'Ana Martínez',
                'client_position' => 'Propietaria de Hogar',
                'content' => 'El mejor servicio de limpieza que he contratado. Son puntuales, confiables y muy cuidadosos con mis pertenencias.',
                'image' => 'img/testimonial-3.jpg',
                'rating' => 5,
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}