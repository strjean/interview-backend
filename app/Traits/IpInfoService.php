<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait IpInfoService
{
    /**
     * MSC-2471
     * Retrieve the country ISO code from the IpInfo.io service
     *
     * @param  Request  $request
     * @return string
     */
    public function getCountryFromIp(Request $request): string
    {
        return  $request?->ipinfo?->country ?? '';
    }
}
