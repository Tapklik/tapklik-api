<?php namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Publisher;
use App\Transformers\PublisherTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class PublishersController extends Controller
{

    public function index()
    {
        $publishers = Publisher::all();

        return $this->collection($publishers, new PublisherTransformer);
    }

    public function show($id) {

        try {

            $publisher = Publisher::findById($id);

            return $this->item($publisher, new PublisherTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Publisher not found.');
        }
    }
}
