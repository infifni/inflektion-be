<?php

namespace App\Actions;

use App\Http\Requests\CreateSuccessfulEmailRequest;
use App\Models\SuccessfulEmail;
use App\Utils\HtmlParser;
use Carbon\Carbon;

class CreateSuccessfulEmailAction
{
    public function execute(CreateSuccessfulEmailRequest $request): SuccessfulEmail
    {
        $rawText = (new HtmlParser)->getRawText($request->email);

        return SuccessfulEmail::create([
            'email' => $request->email,
            'raw_text' => $rawText,
            'processed_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
