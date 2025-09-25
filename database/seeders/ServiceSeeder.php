<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Instalación de Aire Acondicionado',
                'description' => 'Instalación profesional de sistemas de aire acondicionado',
                'image' => 'img/service-1.jpg',
                'icon' => 'img/icon/icon-01-light.png',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Mantenimiento de Refrigeración',
                'description' => 'Mantenimiento y reparación de sistemas de refrigeración',
                'image' => 'img/service-2.jpg',
                'icon' => 'img/icon/icon-02-light.png',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Refrigeración Industrial',
                'description' => 'Instalación y mantenimiento de Aires Acondicionados Industriales',
                'image' => 'img/service-3.jpg',
                'icon' => 'img/icon/icon-03-light.png',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Mantenimiento y Reparación',
                'description' => 'Servicios completos de mantenimiento preventivo y correctivo',
                'image' => 'img/service-4.jpg',
                'icon' => 'img/icon/icon-04-light.png',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Calidad del Aire Interior',
                'description' => 'Mejora de la calidad del aire en espacios interiores',
                'image' => 'img/service-5.jpg',
                'icon' => 'img/icon/icon-05-light.png',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Inspecciones Anuales',
                'description' => 'Inspecciones periódicas para mantener el óptimo funcionamiento',
                'image' => 'img/service-6.jpg',
                'icon' => 'img/icon/icon-06-light.png',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}