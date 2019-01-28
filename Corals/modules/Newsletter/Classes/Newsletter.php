<?php

namespace Corals\Modules\Newsletter\Classes;

use Corals\Modules\Newsletter\Models\EmailLogger;
use Corals\Modules\Newsletter\Models\Subscriber;
use Corals\Modules\Newsletter\Mail\NewsletterEmail;
use Jenssegers\Agent\Agent;
use Corals\Modules\Newsletter\Models\Email;
use Corals\Modules\Newsletter\Models\MailList;
use Illuminate\Support\Facades\Mail;

class Newsletter
{
    public function getVisitorDetails()
    {
        $details = [];

        return rescue(function () use ($details) {
            $agent = new Agent();
            $details['browser'] = $agent->browser();
            $details['browser_version'] = $agent->version($details['browser']);
            $details['device_type'] = $agent->isPhone() ? 'Phone' : ($agent->isTablet() ? 'Tablet' : 'Desktop');
            $details['device'] = $agent->device();
            $details['platform'] = $agent->platform();
            $details['platform_version'] = $agent->version($details['platform']);
            $details['languages'] = $agent->languages();

            return $details;
        }, function () use ($details) {
            return $details;
        });
    }

    /**
     * @param Email $email
     * @param EmailLogger|null $emailLogger
     */
    public function sendEmail(Email $email, EmailLogger $emailLogger = null)
    {
        try {
            $emailLoggersStatus = [];

            if (!is_null($emailLogger)) {
                $subscribers = $email->subscribers()->where('newsletter_email_logger.id', $emailLogger->id)->get();
            } else {
                $subscribers = $email->subscribers()->where('newsletter_email_logger.status', 'draft')->get();
            }

            foreach ($subscribers as $subscriber) {
                try {
                    Mail::to($subscriber->email)
                        ->queue(new NewsletterEmail($email, $subscriber->pivot->api_call_id));

                    $emailLoggersStatus[$subscriber->id] = [
                        'status' => 'sent',
                    ];

                } catch (\Exception $e) {
                    $emailLoggersStatus[$subscriber->id] = [
                        'status' => 'failed',
                        'failure_message' => $e->getMessage(),
                    ];

                    logger($e->getMessage());
                }
            }

            if (is_null($emailLogger)) {
                $email->subscribers()->sync($emailLoggersStatus);
                $email->update(['status' => 'sent']);
            } else {
                $emailLogger->update($emailLoggersStatus[$emailLogger->subscriber_id]);
            }
        } catch (\Exception $exception) {
            log_exception($exception, Newsletter::class, 'sendEmail');
        }
    }

    /**
     * @return array
     */
    public function getAllSubscribers()
    {
        return Subscriber::query()
            ->pluck('email', 'id')
            ->toArray();
    }

    /**
     * @return array
     */
    public function getAllMailLists()
    {
        return MailList::query()
            ->pluck('name', 'id')
            ->toArray();
    }
}