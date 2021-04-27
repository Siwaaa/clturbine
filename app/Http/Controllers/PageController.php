<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;


class PageController extends Controller
{
    public function start($url)
    {
        $page = Page::where('url', $url)->first();
        $template = Template::where('id', $page->template_id)->first();

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
                'cookie' => 'ig_did=094CD26D-2704-454A-9C2D-2B47678C752F; mid=XqKxYwAEAAGRm0dt2zTb5E3c9l0E; fbm_124024574287414=base_domain=.instagram.com; shbid=357; ig_nrcb=1; ds_user_id=4780859332; csrftoken=NHbQiMmxlBBWp7j3m9mqnjkyMHlgK1C8; sessionid=4780859332:R2pQp6Jr666rhL:3; ig_direct_region_hint=ASH; shbts=1619464506.9977283; rur=ATN; fbsr_124024574287414=PJ5opHaLRdFyPqVY6-uESQdtVcAXdPTHOBaWP3qFcWs.eyJ1c2VyX2lkIjoiMTAwMDA3NDMzOTc4MjU3IiwiY29kZSI6IkFRQWtpUGJTczZLMm1EQ0NNM1pJMnRkVHZ6Y2Y0bzQ5V2MyX1AwY3l4YmtrTUl1dnBUU1R3VzZGT0NseExFb3pVY3NMc082RENkM3JGWDdaWmtKdHI2QkczOG5zOHkxN2ZmbzBacXVNMDdsalgxa3BsZE8wNUVLRlJWbGhOSFJWN05WTzNtd3djUUJnQXNoQllUbWRXa1VjUzdIcW5xY0QwaXltQUZ3ODA4SWFReWFYclRTWHFKQ3RWN2NVX1ExdXRZWVI0VXBkVXhvMFRsdGplendNdmRQaUN4azhkYU9fWGtfWUdoR09LV3BqV293NllpNkVkaTN0aGU3UGtFUUQzcEh1MjhpMnpJLTJQZW5HUGdMT1k4dDkxVXRtdWJrd01nTW1kRE0xMGJFNU1XS2VFTnktd3FkSVkwV0tGUzhqVWxYajV1cjR4ei1tdmF5Y2VfUFR5YWhEIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQU5VY2ptT3J2b2FKTDE0em1jV09rdzZXMWxCWkJ4b0Jkc254c1czUU5FNzdlQUtqWVdlUXdqZ1F5NEdKWkN6Z1Z3ZHRNc2EyS1J5b0t3QXlWWkNNMVYyMnZkQnN6aUZnQ2tXcGFUWkJXRXU4bHVXZzFrd0lTTkJGbUl2RHFUSXRZekJTUk1icHRteE9GYzdWYUtqcmRueFF2QVZNV3VTN3JjZHdoYU11IiwiYWxnb3JpdGhtIjoiSE1BQy1TSEEyNTYiLCJpc3N1ZWRfYXQiOjE2MTk0NjUwNTB9',
                'accept-encoding' => 'gzip, deflate, br',
                'cache-control' => 'max-age=0',
                'sec-fetch-dest' => 'document',
                'sec-fetch-mode' => 'navigate',
                'sec-fetch-site' => 'none',
                'sec-fetch-user' => '?1',
                'upgrade-insecure-requests' => '1',
                'Cross-Origin-Resource-Policy' => 'cross-origin'
            ]
        ])->get("https://www.instagram.com/{$page->instagram}/?__a=1");
        $account = $response->json();

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

        if (isset($page) && isset($_COOKIE['url'])) {
            if(!isset($_COOKIE["v3-{$page->id}"])) {
                $page->count_podpis += 1;
                $page->save();

                Cookie::queue("v3-{$page->id}", 'true', 60 * 24 * 30);
            }

            return view('finish', compact('page', 'template'));
        } else {
            return redirect()->intended();
        }

    }
}
