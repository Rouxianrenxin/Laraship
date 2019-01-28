<?php

namespace Corals\Modules\Messaging\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Messaging\Models\Message;

class MessageTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('messaging.models.message.resource_url');

        parent::__construct();
    }

    /**
     * @param Message $message
     * @return array
     * @throws \Throwable
     */
    public function transform(Message $message)
    {
        return [
            'id' => $message->id,
            'author' => $message->author->full_name,
            'body' => $message->body ? str_limit(strip_tags($message->body), 50, '&nbsp;<a href="'. url('messaging/messages/'.$message->hashed_id.'/get_message_body') .'"  data-action="post" data-page_action="appendMessageBody">' . trans('Messaging::labels.message.read_more') . '</a>') : '',
            'created_at' => format_date_time($message->created_at),
            'updated_at' => format_date_time($message->updated_at),
        ];
    }
}