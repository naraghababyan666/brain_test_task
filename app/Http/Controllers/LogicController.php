<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Finder\Finder;

class LogicController extends Controller
{
    public function phpFilesFinder(){
        $phpFiles = [];
        $folderPath = storage_path();
        $finder = Finder::create()->in($folderPath)->files();
        foreach ($finder as $file) {
            if(strtolower(pathinfo($file->getPathname(), PATHINFO_EXTENSION)) === 'php'){
                array_push($phpFiles,$file->getPathname() );
            }
        }
        return json_encode($phpFiles);
    }

    public function findPhpExtension($filename){
        return pathinfo($filename, PATHINFO_EXTENSION);
    }
}
