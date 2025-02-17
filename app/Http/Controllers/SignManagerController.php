<?php

namespace App\Http\Controllers;

use App\Services\SignManager\SignManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignManagerController extends Controller
{
    public function __construct(protected SignManagerInterface $signManager)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'xml' => ['required', 'mimes:xml']
        ]);

        $cert_content = Storage::get(/** Cert path */);
        $cert_pass = config('sign-manager.cert_pass');
        $xml = $request->file('xml')->getContent();
        $signed_xml = $this->signManager->sign($cert_content, $cert_pass, $xml);

        return response($signed_xml);
    }
}
