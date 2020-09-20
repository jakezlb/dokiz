<?php
namespace App\Security;

use App\Security\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class SecuritySocietyAuthenticator implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        
        if (!empty($user->getId())) { 
            throw new CustomUserMessageAccountStatusException('Your user account no longer exists.');
        }        
        
        if ($user->isDeleted()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException('Your user account no longer exists.');
        }
        if (empty($user->getSocietyId())) { 
            throw new CustomUserMessageAccountStatusException('Your user account no longer exists.');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
       
        if (!empty($user->getId())) { 
            throw new CustomUserMessageAccountStatusException('Your user account no longer exists.');
        } 
        // user account is expired, the user may be notified
        if ($user->isExpired()) {
            throw new AccountExpiredException('...');
        }
        
        if (empty($user->getSocietyId())) { 
            throw new CustomUserMessageAccountStatusException('Your user account no longer exists.');
        }
    }
}
