<?php

namespace App\Console\Commands;

use Botble\Newsletter\Models\NewsLetterEmailLog;
use Illuminate\Console\Command;
use Twilio\Rest\Client;
use Botble\Base\Facades\EmailHandler;
use Botble\Contact\Models\Contact;
use Botble\Ecommerce\Models\Customer;
use Botble\Newsletter\Models\EmailTemplate;
use Exception;
use Log;
use Illuminate\Support\Facades\Storage;


class EmailLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletteremails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for send news letter email send';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            $news_letter_email_logs = NewsLetterEmailLog::where('status', '=', 'In-progress')->first();

            if ($news_letter_email_logs) {

                $news_letter_email_logs->status = 'in_process';
                $news_letter_email_logs->save();
                $type = $news_letter_email_logs['type'];
                $contacttag = $news_letter_email_logs['tagged_contact'];
               
                

                $email_template = EmailTemplate::find($news_letter_email_logs['template_id']);
                $template = $email_template->slug;
                $subject = $email_template->subject;
                
                
                
                if ($contacttag) {
                    
                        $contacts = \DB::table("contacts")->select("contacts.*")->whereRaw("find_in_set('".$contacttag."',contacts.contactTag)")->get();
                      
                        
                       
                   
                }else{
                   
                    $contacts = Contact::whereNotNull('email')->whereNotNull('name')->get();
                }
                
                
                    
                if($contacts){
                    foreach ($contacts as $contact) {

                        try {
                            if($type == 'sms_template'){
                                $content = $email_template->description;
                            }else{
                                $path = Storage::disk('local')->path('/email-templates/newsletter/' . $template . ".tpl");
                                $content = file_get_contents($path);
                                $variables = [
                                    'name' => $contact->name,
                                    'email' => $contact->email,
                                ];
                                foreach ($variables as $key => $value) {
                                    $content = str_replace("{{ " . $key . " }}", $value, $content);
                                }
                                
                                $arr = ['{{ header }}', '{{ footer }}', '{{ site_logo }}'];
                                
                                foreach ($arr as $key => $value) {
                                    $content = str_replace($value, '', $content);
                                }
                            }
                            
                            

                            $str = $content;
                            

                                $receiverNumber = $contact->phone;
                                $message = $str;
                                
                                if($type == 'sms_template'){
                                    try {

                                        if ($receiverNumber != null) {

                                            Log::info('SMS sending to ' . $receiverNumber);
                                            $account_sid = getenv("TWILIO_SID");
                                            $auth_token = getenv("TWILIO_TOKEN");
                                            $twilio_number = getenv("TWILIO_FROM");

                                            $client = new Client($account_sid, $auth_token);
                                            $client->messages->create($receiverNumber, [
                                                'from' => $twilio_number,
                                                'body' => $message
                                            ]);

                                            Log::info('SMS sent Succesfully to ' . $receiverNumber);
                                        }
                                    } catch (Exception $e) {
                                        Log::error('Error  ' . $e->getMessage());
                                    }
                                }
                                
                                    if($type == 'email_template'){
                                       // mail("devexpert1991@gmail.com","My subject1","test");
                                       
                                        EmailHandler::send(
                                            $content,
                                            $subject,
                                            $contact->email,
                                            [],
                                            true
                                        );
                                    }
                            } catch (Exception $e) {
                                Log::error($e->getMessage());
                            }
                    }
                }
               // }
                // if ($news_letter_email_logs->customer == 1) {

                //     $customers = Customer::whereNotNull('email')->whereNotNull('name')->get();
                //     foreach ($customers as $customer) {

                //         if($type == 'sms_template'){
                //             $content = $email_template->description;
                //         }else{
                //             $path = Storage::disk('local')->path('/email-templates/newsletter/' . $template . ".tpl");
                //             $content = file_get_contents($path);
                //         }
                //         $variables = [
                //             'name' => $customer->name,
                //             'email' => $customer->email,
                //         ];
                //         foreach ($variables as $key => $value) {
                //             $content = str_replace("{{ " . $key . " }}", $value, $content);
                //         }

                //         $arr = ['{{ header }}', '{{ footer }}', '{{ site_logo }}'];

                //         foreach ($arr as $key => $value) {
                //             $content = str_replace($value, '', $content);
                //         }

                //         $str = strip_tags(trim($content));

                //         $receiverNumber = $customer->phone;
                //         $message = $str;

                //         if($type == 'sms_template'){
                //                 try {

                //                     if ($receiverNumber != null) {

                //                         Log::info('SMS sending to ' . $receiverNumber);
                //                         $account_sid = getenv("TWILIO_SID");
                //                         $auth_token = getenv("TWILIO_TOKEN");
                //                         $twilio_number = getenv("TWILIO_FROM");

                //                         $client = new Client($account_sid, $auth_token);
                //                         $client->messages->create($receiverNumber, [
                //                             'from' => $twilio_number,
                //                             'body' => $message
                //                         ]);

                //                         Log::info('SMS sent Succesfully to ' . $receiverNumber);
                //                     }
                //                 } catch (Exception $e) {
                //                     Log::error('Error  ' . $e->getMessage());
                //                 }
                //         }
                //         if($type == 'email_template'){  
                //             //mail("devexpert1991@gmail.com","My subject2","test");
                //             EmailHandler::send(
                //                 $content,
                //                 $subject,
                //                 $customer->email,
                //                 [],
                //                 true
                //             );
                //         }
                //     }
                // }
                $news_letter_email_logs->status = 'Sent';
                $news_letter_email_logs->save();
            }

            return Command::SUCCESS;
        } catch (Exception $e) {

            Log::error($e->getMessage());
            return $e->getMessage();
            $this->error($e->getMessage());
        }
    }
}
