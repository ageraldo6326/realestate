<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DemoAdvisorSeeder extends Seeder
{
    public function run(): void
    {
        $advisorRole = Role::firstOrCreate([
            'name' => 'asesor',
            'guard_name' => 'web',
        ]);

        $advisors = [
            [
                'name' => 'Kelly Lamarche',
                'email' => 'kelly@realestate.local',
                'titulo' => 'Asesora inmobiliaria',
                'telefono' => '809-802-8585',
                'descripcion' => 'Asesora enfocada en propiedades residenciales y acompanamiento integral para compradores e inversionistas.',
                'metadescription' => 'Asesora inmobiliaria especializada en propiedades residenciales e inversion.',
                'foto' => 'https://dummyimage.com/320x320/e8f1f8/35536b&text=KL',
                'orden' => 2,
            ],
            [
                'name' => 'Lavinia Castro',
                'email' => 'lavinia@realestate.local',
                'titulo' => 'Asesora de inversiones',
                'telefono' => '809-555-0133',
                'descripcion' => 'Especialista en propiedades de inversion, proyectos en planos y oportunidades de valorizacion en zonas urbanas y turisticas.',
                'metadescription' => 'Asesora de inversiones inmobiliarias y proyectos en planos.',
                'foto' => 'https://dummyimage.com/320x320/f3efe4/6b5b3e&text=LC',
                'orden' => 3,
            ],
            [
                'name' => 'Mario Fernandez',
                'email' => 'mario@realestate.local',
                'titulo' => 'Asesor comercial',
                'telefono' => '809-555-0144',
                'descripcion' => 'Asesor comercial orientado a propiedades corporativas, locales y oportunidades de renta con enfoque consultivo.',
                'metadescription' => 'Asesor comercial para propiedades corporativas y oportunidades de renta.',
                'foto' => 'https://dummyimage.com/320x320/eef4ea/46634d&text=MF',
                'orden' => 4,
            ],
        ];

        foreach ($advisors as $advisorData) {
            $advisor = User::updateOrCreate(
                ['email' => $advisorData['email']],
                [
                    'name' => $advisorData['name'],
                    'password' => Hash::make('Asesor12345'),
                    'titulo' => $advisorData['titulo'],
                    'metadescription' => $advisorData['metadescription'],
                    'descripcion' => $advisorData['descripcion'],
                    'telefono' => $advisorData['telefono'],
                    'foto' => $advisorData['foto'],
                    'activo' => 1,
                    'rol' => 0,
                    'mostrar' => 1,
                    'orden' => $advisorData['orden'],
                    'whatsapp' => $advisorData['telefono'],
                    'requiere_aprobacion_propiedades' => false,
                ]
            );

            $advisor->syncRoles([$advisorRole->name]);
        }
    }
}
