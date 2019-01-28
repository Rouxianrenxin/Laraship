<?php


namespace Corals\Modules\Directory\Http\Controllers;

use Corals\Modules\Utility\Http\Controllers\InviteFriends\InviteFriendsBaseController;

class InviteFriendsController extends InviteFriendsBaseController
{
    protected function setCommonVariables()
    {
        $this->redirectUrl = user()->getDashboardURL();
        $this->invitationResourceURL = 'directory/user/invite-friends';
        $this->invitationTextSettingKey = 'directory_invitation_text';
        $this->invitationSubjectSettingKey = 'directory_invitation_subject';
    }
}
