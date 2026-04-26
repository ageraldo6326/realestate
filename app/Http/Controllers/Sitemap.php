<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Zonas;
use App\Models\Propiedad;
use Illuminate\Support\Str;
use App\Models\Inmobiliaria;
use Illuminate\Http\Request;
use App\Models\TiposDePropiedad;

class Sitemap extends Controller
{
    //
    public function sitemap() {

        $inmo = Inmobiliaria::first();

        $myfile = fopen("sitemap.xml", "w");
        $txt = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        fwrite($myfile, $txt);        

        fwrite($myfile, '<url>');
        fwrite($myfile, '<loc>' . $inmo->dominio .'</loc>');
        //fwrite($myfile, '<lastmod>' . Carbon::parse($inmo->updated_at)->format('Y-m-d') . 'T15:24:45+00:00</lastmod>');
        fwrite($myfile, '<lastmod>' . date("Y-m-d") . 'T15:24:45+00:00</lastmod>');
        fwrite($myfile, '<priority>1</priority>');
        fwrite($myfile, '</url>');    
        
        fwrite($myfile, '<url>');
        fwrite($myfile, '<loc>' . $inmo->dominio . 'propiedades' .'</loc>');
        //fwrite($myfile, '<lastmod>' . Carbon::parse($inmo->updated_at)->format('Y-m-d') . 'T15:24:45+00:00</lastmod>');
        fwrite($myfile, '<lastmod>' . date("Y-m-d") . 'T15:24:45+00:00</lastmod>');
        fwrite($myfile, '<priority>0.9</priority>');
        fwrite($myfile, '</url>');       

        fwrite($myfile, '<url>');
        fwrite($myfile, '<loc>' . $inmo->dominio . 'blog' .'</loc>');
        //fwrite($myfile, '<lastmod>' . Carbon::parse($inmo->updated_at)->format('Y-m-d') . 'T15:24:45+00:00</lastmod>');
        fwrite($myfile, '<lastmod>' . date("Y-m-d") . 'T15:24:45+00:00</lastmod>');
        fwrite($myfile, '<priority>0.9</priority>');
        fwrite($myfile, '</url>');  

        fwrite($myfile, '<url>');
        fwrite($myfile, '<loc>' . $inmo->dominio . 'contacto' .'</loc>');
        //fwrite($myfile, '<lastmod>' . Carbon::parse($inmo->updated_at)->format('Y-m-d') . 'T15:24:45+00:00</lastmod>');
        fwrite($myfile, '<lastmod>' . date("Y-m-d") . 'T15:24:45+00:00</lastmod>');
        fwrite($myfile, '<priority>0.9</priority>');
        fwrite($myfile, '</url>');  


        $propiedades = Propiedad::where('activa',1)->get();

        foreach ($propiedades as $propiedad) {
            fwrite($myfile, '<url>');
            fwrite($myfile, '<loc>' . $inmo->dominio . 'propiedad/' . $propiedad->slug .'</loc>');
            //fwrite($myfile, '<lastmod>' . Carbon::parse($propiedad->updated_at)->format('Y-m-d') . 'T15:24:45+00:00</lastmod>');
            fwrite($myfile, '<lastmod>' . date("Y-m-d") . 'T15:24:45+00:00</lastmod>');
            fwrite($myfile, '<priority>0.6</priority>');
            fwrite($myfile, '</url>'); 
        }

        $zonas = Zonas::all();

        foreach ($zonas as $zona) {
            fwrite($myfile, '<url>');
            fwrite($myfile, '<loc>' . $inmo->dominio .  Str::slug($zona->zona) .'</loc>');
            //fwrite($myfile, '<lastmod>' . Carbon::parse($zona->updated_at)->format('Y-m-d') . 'T15:24:45+00:00</lastmod>');
            fwrite($myfile, '<lastmod>' . date("Y-m-d") . 'T15:24:45+00:00</lastmod>');
            fwrite($myfile, '<priority>0.8</priority>');
            fwrite($myfile, '</url>'); 
        }

        $tipos_propiedades = TiposDePropiedad::all();

        foreach ($tipos_propiedades as $tipo_propiedad) {
            fwrite($myfile, '<url>');
            fwrite($myfile, '<loc>' . $inmo->dominio . 'venta/' . Str::slug($tipo_propiedad->tipo) .'</loc>');
            //fwrite($myfile, '<lastmod>' . Carbon::parse($tipo_propiedad->updated_at)->format('Y-m-d') . 'T15:24:45+00:00</lastmod>');
            fwrite($myfile, '<lastmod>' . date("Y-m-d") . 'T15:24:45+00:00</lastmod>');
            fwrite($myfile, '<priority>0.8</priority>');
            fwrite($myfile, '</url>'); 
        }

        $posts = Post::all();

        foreach ($posts as $post) {
            fwrite($myfile, '<url>');
            fwrite($myfile, '<loc>' . $inmo->dominio . 'post/' . $post->slug.'</loc>');
            fwrite($myfile, '<lastmod>' . date("Y-m-d") . 'T15:24:45+00:00</lastmod>');
            fwrite($myfile, '<priority>0.8</priority>');
            fwrite($myfile, '</url>'); 
        }

        


        $txt = '</urlset>';
        fwrite($myfile, $txt);
        fclose($myfile);

        return $inmo->dominio . 'sitemap.xml';


    }
}
