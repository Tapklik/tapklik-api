<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Creative;
use Aws\S3\S3Client;

Route::get(
    '/',
    function () {

        dd(database_path());
    }
);

Route::get(
    'test',
    function () {

        $creative = Creative::findByUuId('8acb7f8a-da72-11e7-a48b-f40f2429ffc5');

        $client = S3Client::factory(
            ['region'      => getenv('AWS_REGION'),
             'version'     => '2006-03-01',
             'credentials' => ['key'    => getenv('AWS_ACCESS_KEY'),
                               'secret' => getenv('AWS_SECRET_KEY')]]
        );


        try {
            $segments = collect(explode('/', $creative->iurl));
            $bucket   = $segments->offsetGet(3);
            $object   = $segments->last();
            $key      = $segments->each(
                function ($segment, $index) use ($segments) {

                    if ($index <= 3) {
                        $segments->offsetUnset($index);
                    }

                    return $segment;
                }
            )->implode('/');

            return ['url'      => $creative->iurl,
                    'bucket'   => $bucket,
                    'key'      => $key,
                    'fileName' => $object,];

            $awsObj = ['url'    => implode('/', $url),
                       'bucket' => $bucket,
                       'key'    => $key,
                       'object' => $object];


            try {

                $html = $client->getObject(
                    ['Bucket' => $bucket,
                     'Key'    => $key,
                     'SaveAs' => public_path('./'.$object)]
                );
            } catch (\Exception $e) {
                \Log::info($e->getMessage());

                return;
            }

            // Replace string
            $html = file_get_contents(public_path('./'.$object));
            $patt = '/clickTag ?= ?+[\'"](.*)+[\'"]/';

            preg_match($patt, $html, $matches);

            $ctrurl = isset($creative->campaign->ctrurl) ? $creative->campaign->ctrurl : $creative->ctrurl;

            $replaced = str_replace($matches[0], "clickTag = '{$ctrurl}'", $html);

            file_put_contents(public_path($object), $replaced);

            try {

                $response = $client->putObject(
                    ['ACL'    => 'public-read',
                     'Bucket' => $bucket,
                     'Key'    => $key,
                     'Body'   => $replaced]
                );
            } catch (\Exception $e) {

                \Log::error($e->getMessage());
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
);
