<?php
namespace Varz62\Socialiteproviders\Autodesk;

use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\User;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;

class Provider extends AbstractProvider implements ProviderInterface
{
    const IDENTIFIER = 'AUTODESK';

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://developer.api.autodesk.com/authentication/v1/authorize', $state
        );
    }

    protected function getTokenUrl()
    {
        return 'https://developer.api.autodesk.com/authentication/v1/gettoken';
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            'https://developer.api.autodesk.com/userprofile/v1/users/@me', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function mapUserToObject(array $user)
    {
        //dd($user);
        return (new User())->setRaw($user)->map([
            'id' => $user['userId'],
            'nickname' => $user['userName'],
            'name' => array_get($user, 'firstName').' '.array_get($user, 'lastName'),
            'email' => array_get($user, 'emailId'),
            'avatar' => array_get($user, 'profileImages["sizeX50"]'),
        ]);
    }

    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }


}