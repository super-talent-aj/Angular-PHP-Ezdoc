<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PrintController extends Controller
{
  public function printHtml(Request $request)
  {
    $doc_name = $request->input('doc_name');
    if (Storage::exists($doc_name)) {
      Storage::delete($doc_name);
    }
    $doc_file = \PDF::loadView('print', $request->all())
      ->setPaper('letter')
      ->setOrientation('portrait')
      ->setOptions([
        'margin-top' => 8,
        'margin-right' => 12,
        'margin-bottom' => 0,
        'margin-left' => 13,
      ])
      ->inline();
    Storage::put($doc_name, $doc_file);

    return json()->success('Created');
  }

  public function download(Request $request)
  {
    $doc_name = $request->input('doc_name');
    $file_name = pathinfo($doc_name, PATHINFO_BASENAME);
    $contents = Storage::get($doc_name);
    return new Response(
      $contents,
      200,
      array(
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => "attachment; filename=$file_name"
      )
    );
  }

  public function test()
  {
    $html = '<div style="border: 1px solid black; width: 1100px; height: 1480px;">I love you!</div>';
    $pdf = \PDF::loadHTML($html);
    $pdf->setPaper('letter')
      ->setOrientation('portrait')
      ->setOptions([
        'margin-top' => 8,
        'margin-right' => 13,
        'margin-bottom' => 0,
        'margin-left' => 11,
      ]);

    return $pdf->download('test.pdf');
  }

  public function hello() 
  {
    return "Hello world!";
  }
}
