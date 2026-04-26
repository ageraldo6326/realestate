<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Zonas;
use App\Models\Enfoque;
use App\Models\Portada;
use App\Models\Propiedad;
use Faker\Provider\Lorem;
use App\Models\Testimonio;
use App\Models\Inmobiliaria;
use App\Models\Disponible_para;
use App\Models\Estados;
use App\Models\provincia;
use Illuminate\Database\Seeder;
use App\Models\TiposDePropiedad;
use App\Models\ToDoEstatus;
use App\Models\ToDoTipo;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //Propiedad::factory(10)->create();
        // Testimonio::factory(3)->create();
        // Post::factory(10)->create();

        $zona = new Zonas();
        $zona->zona = "Santo Domingo Este";
        $zona->save();

        $zona2 = new Zonas();
        $zona2->zona = "Santo Domingo Norte";
        $zona2->save();

        $zona3 = new Zonas();
        $zona3->zona = "Bavaro";
        $zona3->save();

        $zona4 = new Zonas();
        $zona4->zona = "Punta Cana";
        $zona4->save();


        $disponible_para1 = new Disponible_para();
        $disponible_para1->disponible_para = "En Venta";
        $disponible_para1->save();

        $disponible_para2 = new Disponible_para();
        $disponible_para2->disponible_para = "En Alquiler";
        $disponible_para2->save();

        $disponible_para3 = new Disponible_para();
        $disponible_para3->disponible_para = "En Compra";
        $disponible_para3->save();


        $tipodepropiedades1 = new TiposDePropiedad();
        $tipodepropiedades1->tipo = "Apartamento";
        $tipodepropiedades1->save();

        $tipodepropiedades2 = new TiposDePropiedad();
        $tipodepropiedades2->tipo = "Casa";
        $tipodepropiedades2->save();

        $tipodepropiedades3 = new TiposDePropiedad();
        $tipodepropiedades3->tipo = "Solar";

        $tipodepropiedades3 = new TiposDePropiedad();
        $tipodepropiedades3->tipo = "Turistica";

        $tipodepropiedades3 = new TiposDePropiedad();
        $tipodepropiedades3->tipo = "Local comercial";

        $tipodepropiedades3->save();


        $estados = new Estados();
        $estados->estado = "Nueva";
        $estados->save();

        $estados = new Estados();
        $estados->estado = "Usada";
        $estados->save();

        $estados = new Estados();
        $estados->estado = "En plano";
        $estados->save();

        $estados = new Estados();
        $estados->estado = "Mejora";
        $estados->save();


        $provincias = new provincia();
        $provincias->provincia = 'AZUA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'BAHORUCO';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'BARAHONA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'DAJABON';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'DISTRITO NACIONAL';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'DUARTE';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'EL SEYBO';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'ELIAS PIÑA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'ESPAILLAT';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'HATO MAYOR';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'HERMANAS MIRABAL';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'INDEPENDENCIA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'LA ALTAGRACIA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'LA ROMANA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'LA VEGA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'MARIA TRINIDAD SANCHEZ';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'MONSEÑOR NOUEL';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'MONTE PLATA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'MONTECRISTI';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'PEDERNALES';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'PERAVIA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'PUERTO PLATA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'SAMANA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'SAN CRISTOBAL';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'SAN JOSE DE OCOA';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'SAN JUAN';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'SAN PEDRO DE MACORIS';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'SANCHEZ RAMIREZ';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'SANTIAGO';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'SANTIAGO RODRIGUEZ';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'SANTO DOMINGO';
        $provincias->save();
        $provincias = new provincia();
        $provincias->provincia = 'VALVERDE';
        $provincias->save();

        $inmobiliaria = new Inmobiliaria();

        $inmobiliaria->nombre = "Inmobiliaria Merkel";
        $inmobiliaria->correo = "Info@Merkel.com.do";
        $inmobiliaria->direccion = "El Rosal 201, Plaza Wilmart";
        $inmobiliaria->telefono = "809-555-6666";
        $inmobiliaria->metadescription = "Inmobiliaria Merkel";
        $inmobiliaria->facebook = "https://www.facebook.com/merkel";
        $inmobiliaria->instagram = "https://www.instragram.com/merkel";
        $inmobiliaria->tiktok = "https://www.tiktok.com/merkel";
        $inmobiliaria->whatsapp = "https://wa.me/18297639977";
        $inmobiliaria->titulo = "Inmobiliaria de Casa y Apartamentos en Santo Domingo Este";
        $inmobiliaria->metadescription = "Inmobiliaria especializada en Santo Domingo Este, con proyectos inmobiliarios economicos y de alta calidad";

        $inmobiliaria->save();

        $todoestatus = new ToDoEstatus();
        $todoestatus->todo_estatus = "Pendiente";
        $todoestatus->save();

        $todoestatus = new ToDoEstatus();
        $todoestatus->todo_estatus = "En proceso";
        $todoestatus->save();

        $todoestatus = new ToDoEstatus();
        $todoestatus->todo_estatus = "Finalizada";
        $todoestatus->save();

        $todoestatus = new ToDoEstatus();
        $todoestatus->todo_estatus = "Cancelada";
        $todoestatus->save();

        $todotipo = new ToDoTipo();
        $todotipo->todo_tipo = "Primer Contacto";
        $todotipo->save();

        $todotipo = new ToDoTipo();
        $todotipo->todo_tipo = "Presentación";
        $todotipo->save();

        $todotipo = new ToDoTipo();
        $todotipo->todo_tipo = "Cita";
        $todotipo->save();

        $todotipo = new ToDoTipo();
        $todotipo->todo_tipo = "Cierre";
        $todotipo->save();





        $estatus = new ToDoEstatus();
        $estatus->todo_estatus = "Cierre";
        $estatus->save();




        // Meses del año (requerido por DashboardAsesor)
        $this->call(MesesSeeder::class);

        // Datos necesarios para visualizar el home del portal
        $this->call(HomeDataSeeder::class);
    }
}
