<?php namespace App\Http\Controllers;

use App\Attribute;
use App\Creative;
use App\Transformers\CreativeTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreativeAttributesController extends Controller
{
    public function store(Request $request, string $uuid)
    {

        try {
            $creative = Creative::findByUuId($uuid);

            collect($request->input())->each(function ($attr) use ($creative) {
                $attribute = new Attribute(['attr' => $attr]);

                $creative->attributes()->save($attribute);
            });

            return $this->item($creative, new CreativeTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND,'Creative not found.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }

    }
}
