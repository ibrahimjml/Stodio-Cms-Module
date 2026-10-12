<?php

namespace Modules\Acl\Exceptions;

use Exception;

class LoginException extends Exception
{
    public static function invalidCredentials(): self
    {
        return new self(__('Wrong credentials.'));
    }

    public static function notAuthorized(): self
    {
        return new self(__('You are not authorized to access this page.'));
    }
}
