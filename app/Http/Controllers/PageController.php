<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;


class PageController extends Controller
{
    public function start($url)
    {
        $page = Page::where('url', $url)->first();
        $template = Template::where('id', $page->template_id)->first();
        $user = User::where('id', $page->user_id)->first();

        if($user->balance < 1) {
            return view('notMoney', compact('page'));
        }

        if(isset($page) && !isset($_COOKIE["v1-{$page->id}"])) {
            $page->count_prosmotr += 1;
            $page->save();
            // устанавливаем куки на месяц
            Cookie::queue("v1-{$page->id}", 'true', 60 * 24 * 30);
        }

        return view('start', compact('page', 'template'));
    }

    public function inst($url)
    {
        $page = Page::where('url', $url)->first();
        $template = Template::where('id', $page->template_id)->first();

        $response = Http::withOptions([
            // 'proxy' => 'http://v9z6Wo:L2DXU0@217.29.62.223:24003',
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.41 YaBrowser/21.2.0.2458 Yowser/2.5 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'accept-language' => 'ru,en;q=0.9,la;q=0.8',
                'cookie' => 'mid=YVoPfgAEAAHYoY7plVWgEpxPNzqF; ig_did=D2A2D631-D7CE-4374-8B1B-D181A133C6B0; ig_nrcb=1; csrftoken=h9TnVuSi8LncUzHwG2JDvk9fCJn3GTLx; ds_user_id=4780859332; sessionid=4780859332:68uI0MwEoyz1Xi:1; fbm_124024574287414=base_domain=.instagram.com; shbid="357\0544780859332\0541666342592:01f733b6d91b3b79e7c2cfd96a88a9b3a6e61b259c9af26b809647d12de977652d7fbf5b"; shbts="1634806592\0544780859332\0541666342592:01f74ba795008de7d7db67019a2e20ee55b2d1922068593897570294aefc5c5728ba39ba"; fbsr_124024574287414=bXTCfpnwG6NuRuUW6XEK8-fgu3d9UA7XyvZ095wLP4I.eyJ1c2VyX2lkIjoiMTAwMDA3NDMzOTc4MjU3IiwiY29kZSI6IkFRQU9WekRtcHJsTWV3VEwxcFAxNXAtVVdQZ1Rpb0hrT2ZMWnRlRGRSSXM4OHV2Y1hYUEdYRmp3cGR6MXZrWElzRldNMHF6c3hTYW1seXZRV2poWTlFeVBsNTYzcWQ2NzlyaUVySWk0SjhJODBFUlFLNWN1RWtfNnhDenJGSEhhXzl5Sm9FTmdLanQ1V1EwRkM4VU5pZUU0YUY3OGVzd2htQ3ZDSl90VlFwUVNCc3o2eERTUFFHS2RxRGdydWxiVkQ3cmZuQnhMdVNJY0ZwWEo0U04zcDhPTnd0NEVvRXVIWEpRQTA3QW1pejNHWUJtM2U1SlJJa094ZWFLaGlHRHk3OUZSYmhLUG1paXc3ZkpncFctSGNQUHBqLUJzMHdGbGg5NzNOckhrSEFWWEFLYUtoUzhld0xUSlY5UnNDa3Z4WnAzZ0hoNHVub0NOUlVmeEh6Q2NPSXlFIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQU52WkJkazBETHQ1REh1amRTMzdxcFpDVms3enJXaXNoSmVmM0k3ejg3Q2p6WkJjQjM2cTBGNFpDaXppczJ2Rklqc1Y4MVlkMHBIR2I0YUlnV1pBUHFaQWZYbzVqUm40RGFTbXdoSGhiT3lXYjk5YmlHT0dNWkI4cEo1MEVkRGExdTFiM0RoM1N2WkJ0cElUOG1yNGNXbXN1MXZuQWFzMVpCcnRCTHlBMmRyTDQiLCJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImlzc3VlZF9hdCI6MTYzNDgwOTI0MH0; rur="FRC\0544780859332\0541666345251:01f7c58a537b4ed2b5086bd6cfe9f7a2a1bba8001bfb5a14328e30937f03cc3bedf20011"',
            ]
        ])->get("https://www.instagram.com/{$page->instagram}/?__a=1");
        $account = $response->json();

        // dd($account);

        $profile_url = $account['graphql']['user']['profile_pic_url'];
        $response2 = base64_encode(file_get_contents($profile_url));
        $src = 'data:image:jpeg;base64,'.$response2;
        $full_name = $account['graphql']['user']['full_name'];
        $instinfo['profile_url'] = $src;
        $instinfo['full_name'] = $full_name;

        if(isset($page) && !isset($_COOKIE["v2-{$page->id}"])) {
            $page->count_check += 1;
            $page->save();

            Cookie::queue("v2-{$page->id}", 'true', 60 * 24 * 30);
        }

        return view('inst', compact('page', 'template', 'instinfo'));
    }

    public function finish($url)
    {
        $page = Page::where('url', $url)->first();
        $template = Template::where('id', $page->template_id)->first();
        $user = User::where('id', $page->user_id)->first();

        if (isset($page) && isset($_COOKIE['url'])) {
            if(!isset($_COOKIE["v3-{$page->id}"])) {
                $page->count_podpis += 1;
                $page->save();

                $user->balance -= 1;
                $user->save();

                Cookie::queue("v3-{$page->id}", 'true', 60 * 24 * 30);
            }

            return view('finish', compact('page', 'template'));
        } else {
            return redirect()->intended();
        }

    }
}
