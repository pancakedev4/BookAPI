<?php
namespace App\Providers\ViewComposers;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\View\View;
use App\Models\OpenGraph;

class BaseComposer {

public function compose (View $view) {
    $og_type = 'product';
    $og_title = 'Name of company, name of service';
    $og_url = '/';
    $og_image = '/img/my_logo_small.svg';
    $og_description = 'Description of service';
    $product_plural_title = 'Servicess';
    $url_arr = explode('/', $_SERVER['REQUEST_URI']);
    $open_graph = OpenGraph::where('url', $_SERVER['REQUEST_URI'])->first();
    if($open_graph) {
        $og_type = $open_graph->og_type;
        $og_title = $open_graph->og_title;
        $og_url = $open_graph->og_url;
        $og_image = $open_graph->og_image;
        $og_description = $open_graph->og_description;
        $product_plural_title = $open_graph->product_plural_title;
        }
        $view->with('url', $_SERVER['REQUEST_URI'])
        ->with('og_type', $og_type)
        ->with('og_title', $og_title)
        ->with('og_url', $og_url)
        ->with('og_image', $og_image)
        ->with('og_description', $og_description)
        ->with('product_plural_title', $product_plural_title);
    }
}