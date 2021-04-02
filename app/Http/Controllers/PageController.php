<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Template;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function start($url)
    {
        $page = Page::where('url', $url)->first();
        $template = Template::where('id', $page->template_id)->first();
        return view('start', compact('page', 'template'));
    }

    public function inst($url)
    {
        $page = Page::where('url', $url)->first();
        $template = Template::where('id', $page->template_id)->first();

        $response = Http::withOptions([
            'proxy' => 'http://v9z6Wo:L2DXU0@217.29.62.223:24003',
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.41 YaBrowser/21.2.0.2458 Yowser/2.5 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'accept-language' => 'ru,en;q=0.9,la;q=0.8',
                'cookie' => 'ig_did=094CD26D-2704-454A-9C2D-2B47678C752F; mid=XqKxYwAEAAGRm0dt2zTb5E3c9l0E; fbm_124024574287414=base_domain=.instagram.com; shbid=357; ig_nrcb=1; csrftoken=B5gazmLMtSoUVolbRml6Jv6dt2XGdh6d; ds_user_id=4780859332; sessionid=4780859332:aLLU4PFW27BWae:29; shbts=1617291999.3824177; rur=ATN; fbsr_124024574287414=hOOepCJ4YK2JX83AaXAdvqvveI_3N7h7bdVsDuH24Qg.eyJ1c2VyX2lkIjoiMTAwMDA3NDMzOTc4MjU3IiwiY29kZSI6IkFRRFV1ckdjWGdVY0lNM0hpZHVTaVhkcHh0d0dZSDdaNVEzeXlSek1iZTNwdFU5RHRvUFBmMTR1S1ZPQ3ZrckdCbzg2NVpnNmhFZkMxb0xtNFpsSWhGc2dZa1VKZ1YxMGpuVWg4akZkUVRtSjUzRXAzbk8zTVhkUjdVWGpSQm9iS0xmdjJ6SDNSeGVTZWRqWWdYaWc5d241N002VTBuWjlZeTFyUFJuM2U2UlFxRGY0SWxiUlZsOENua3pNTG1fT21qbXBQN1hrcDhObmU1QlpKTXpqY1lnYTJSeVpyUGpEd3Z5TVdBM0JkZUwxank0YmdpbjJjOXA1VkRJd0liaU1udXBqTVpXMlpoVHVmRUxYMWU2cUtaZmhzM3BSVkpOWHFZSWFadmlJdGVub0Z4S05JRkpzX0N6T1pCbEJiNHY1NTlna3V6QWN1dWNsRFFBTlhHNERuRWRnIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQU81Z0QwU2lTd01zVFJoZUhpN1pDOFVnNEpWTTJUWHdqQ0c5Y0VzUlh5RFpDcjZGWkJxWHQyWWJKVFhCM3dWYkkya1F0TGFSaGF2dFpCSWlzQTd5VzN5WkM5aThaQU02dGFQcGp4NGRTc0xSSGNBcGdMc052dXBWOTdTcE5aQmlEOXhha1FVb2FGb1NKMGh2dWV1a3p4UmNTUDg5aXpEdjJTUm1Ma3BSTzlKIiwiYWxnb3JpdGhtIjoiSE1BQy1TSEEyNTYiLCJpc3N1ZWRfYXQiOjE2MTczNTYwMTB9',
            ]
        ])->get("https://www.instagram.com/{$page->instagram}/?__a=1");
        $account = $response->json();

        $profile_url = $account['graphql']['user']['profile_pic_url'];
        $full_name = $account['graphql']['user']['full_name'];
        $instinfo['profile_url'] = $profile_url;
        $instinfo['full_name'] = $full_name;

        return view('inst', compact('page', 'template', 'instinfo'));
    }

    public function finish($url)
    {
        $page = Page::where('url', $url)->first();
        $template = Template::where('id', $page->template_id)->first();

        if (isset($page) && isset($_COOKIE['url'])) {
            return view('finish', compact('page', 'template'));
        } else {
            return redirect()->intended();
        }

    }
}
