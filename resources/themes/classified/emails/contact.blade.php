{{ trans('corals-classified-master::email.body.received_message',['text' => $name]) }}

<p>
    {{ trans('corals-classified-master::email.body.name',['text' => $name]) }}
</p>

<p>
    {{ trans('corals-classified-master::email.body.email',['text' => $email]) }}
</p>

<p>
    {{ trans('corals-classified-master::email.body.phone',['text' => $phone]) }}
</p>

<p>
    {{ trans('corals-classified-master::email.body.company',['text' => $company]) }}
</p>

<p>
    {{ trans('corals-classified-master::email.body.subject',['text' => $subject]) }}
</p>

<p>
    {{ trans('corals-classified-master::email.body.message',['text' =>  $user_message]) }}
</p>