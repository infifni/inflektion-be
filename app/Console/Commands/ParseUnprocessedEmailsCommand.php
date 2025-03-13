<?php

namespace App\Console\Commands;

use App\Actions\UpdateSuccessfulEmailAction;
use App\Http\Requests\UpdateSuccessfulEmailRequest;
use App\Models\SuccessfulEmail;
use Illuminate\Console\Command;

class ParseUnprocessedEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-unprocessed-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all unprocessed emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $unprocessedEmails = SuccessfulEmail::whereNull('processed_at')->get();

        foreach ($unprocessedEmails as $email) {
            $request = new UpdateSuccessfulEmailRequest;
            $request->merge([
                'id' => $email->id,
                'email' => $email->email,
            ]);
            (new UpdateSuccessfulEmailAction)->execute(
                $request,
                $email,
            );
        }

        $this->info('All unprocessed emails have been processed.');
    }
}
