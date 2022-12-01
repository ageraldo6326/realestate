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
use Illuminate\Database\Seeder;
use App\Models\TiposDePropiedad;
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

        Propiedad::factory(10)->create();
        Testimonio::factory(3)->create();
        Post::factory(10)->create();

        $zona = New Zonas();
        $zona->zona = "Santo Domingo Este";
        $zona->save();

        $zona2 = New Zonas();
        $zona2->zona = "Santo Domingo Norte";
        $zona2->save();

        $zona3 = New Zonas();
        $zona3->zona = "Bavaro";
        $zona3->save();

        $zona4 = New Zonas();
        $zona4->zona = "Punta Cana";
        $zona4->save();

        $enfoque = New Enfoque();
        $enfoque->titulo = "Vender Propiedadades";
        $enfoque->enfoque = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius, facilis. Nesciunt accusantium deleniti voluptas quis modi reiciendis, aspernatur provident exercitationem facilis expedita in illo voluptates nihil repellendus incidunt suscipit earum!";
        $enfoque->foto = "/img/icons/icon-img/21.png";
        $enfoque->save();

        $enfoque = New Enfoque();
        $enfoque->titulo = "Alquilar Propiedadades";
        $enfoque->enfoque = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius, facilis. Nesciunt accusantium deleniti voluptas quis modi reiciendis, aspernatur provident exercitationem facilis expedita in illo voluptates nihil repellendus incidunt suscipit earum!";
        $enfoque->foto = "/img/icons/icon-img/22.png";
        $enfoque->save();
        
        $enfoque = New Enfoque();
        $enfoque->titulo = "Comprar Propiedadades";
        $enfoque->enfoque = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius, facilis. Nesciunt accusantium deleniti voluptas quis modi reiciendis, aspernatur provident exercitationem facilis expedita in illo voluptates nihil repellendus incidunt suscipit earum!";
        $enfoque->foto = "/img/icons/icon-img/23.png";        

        $enfoque->save();


        $disponible_para1 = New Disponible_para();
        $disponible_para1->disponible_para = "En Venta";
        $disponible_para1->save();

        $disponible_para2 = New Disponible_para();
        $disponible_para2->disponible_para = "En Alquiler";
        $disponible_para2->save();

        $disponible_para3 = New Disponible_para();
        $disponible_para3->disponible_para = "En Compra";
        $disponible_para3->save();


        $tipodepropiedades1 = New TiposDePropiedad();
        $tipodepropiedades1->tipo = "Apartamento";
        $tipodepropiedades1->save();

        $tipodepropiedades2 = New TiposDePropiedad();
        $tipodepropiedades2->tipo = "Casa";
        $tipodepropiedades2->save();
        
        $tipodepropiedades3 = New TiposDePropiedad();
        $tipodepropiedades3->tipo = "Turistica";
        $tipodepropiedades3->save();
        
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

        $inmobiliaria->save();

        $portada = New Portada();
        $portada->minititulo = "Hermosa casa en el centro de la ciudad";
        $portada->titulo = "La casa que siempre soñaste puede ser tuya";
        $portada->descripcion = "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Harum eligendi laudantium, reprehenderit a, mollitia fugiat unde nemo molestiae reiciendis architecto vero expedita velit aperiam iure. Possimus perferendis numquam quia assumenda.";
        $portada->enlace1 = "Ver más...";
        $portada->url1 = "http://prueba.php";
        $portada->foto = "http://127.0.0.1/img/portada/imagen1.png";
        $portada->video = "https://www.youtube.com/embed/RsrvO2CF-3s";
        $portada->save();
    }
}
