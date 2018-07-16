<?php
namespace Varz62\Socialiteproviders\Autodesk;

use SocialiteProviders\Manager\SocialiteWasCalled;

class AutodeskExtendSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('autodesk', __NAMESPACE__.'\Provider');
    }
}