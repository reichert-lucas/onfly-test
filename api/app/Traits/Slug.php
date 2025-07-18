<?php

namespace App\Traits;

trait Slug
{
    private function slugify(string $string): string
    {
        $slug = preg_replace(
            array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/", "/( )/"),
            explode(" ","a A e E i I o O u U n N -"), 
            $string
        );

        return strtolower($slug);
    }
}