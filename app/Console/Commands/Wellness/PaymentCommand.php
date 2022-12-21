<?php

namespace App\Console\Commands\Wellness;

use App\Models\Wellness\Contact;
use App\Repositories\Wellness\ContactRepository;
use App\Repositories\Wellness\VariableRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


class PaymentCommand extends Command
{
    protected $signature = 'wellness:payment';
    protected $description = 'Check payment status and send webhook';

    const EMAIL_DEFAULT="email@gmail.com";
    const PHONE_DEFAULT="+380631234567";

    const CHAT_BOTS_CHANNEL="tg";

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('Start wellness:payment');
        $contactRepository = new ContactRepository();

        $contacts = $contactRepository->getAllPayments();
        if (empty($contacts)) {
            $this->warn('Empty payments contacts');

            $this->deprecate();
        }

        $this->info('Find ' . $contacts->count() . ' active payments');

        $mostLess1DayUrl = config('wellness.url.rest_one_day');
        $mostLess3DaysUrl = config('wellness.url.rest_three_days');
        $variableRepository = new VariableRepository();

        /** @var Contact $contact */
        foreach ($contacts as $contact) {
            $payment = $contact->payment - 1; //remove one day
            if ($payment == 1) {
                $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($mostLess1DayUrl, [
                    "email"=>self::EMAIL_DEFAULT,
                    "phone"=>self::PHONE_DEFAULT,
                    "chatbots_channel"=>self::CHAT_BOTS_CHANNEL,
                    "chatbots_subscriber_id"=>$contact->contact_id
                ]);
                $this->info($response->body());
            }

            if ($payment == 3) {
                $response = Http::withHeaders(['Content-Type' => 'application/json'])->post($mostLess3DaysUrl, [
                    "email"=>self::EMAIL_DEFAULT,
                    "phone"=>self::PHONE_DEFAULT,
                    "chatbots_channel"=>self::CHAT_BOTS_CHANNEL,
                    "chatbots_subscriber_id"=>$contact->contact_id
                ]);
                $this->info($response->body());
            }

            $this->info('Set payment ' . $payment . ' for ' . $contact->contact_id);
            $contactRepository->update($contact->id, ['payment' => $payment]);

            $variableRepository->updatePaymentByContactId($contact->contact_id, $payment);
        }

    }

    /**
     * @return void
     */
    private function deprecate()
    {
        $this->warn('EXIT');
        $this->line('**********************************');
        dD();
    }
}
