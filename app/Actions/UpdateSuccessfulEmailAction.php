<?php

namespace App\Actions;

use App\Http\Requests\UpdateSuccessfulEmailRequest;
use App\Models\SuccessfulEmail;
use App\Utils\HtmlParser;
use Carbon\Carbon;

class UpdateSuccessfulEmailAction
{
    public function execute(
        UpdateSuccessfulEmailRequest $request,
        SuccessfulEmail $model,
    ): SuccessfulEmail {
        $rawText = (new HtmlParser)->getRawText($request->email);

        $model->email = $request->email;
        $model->raw_text = $rawText;
        $model->processed_at = Carbon::now()->toDateTimeString();

        $model->save();

        return $model;
    }
}
