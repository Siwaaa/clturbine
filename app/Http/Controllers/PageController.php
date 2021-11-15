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
                'cookie' => 'mid=YVoPfgAEAAHYoY7plVWgEpxPNzqF; ig_did=D2A2D631-D7CE-4374-8B1B-D181A133C6B0; ig_nrcb=1; ds_user_id=4780859332; fbm_124024574287414=base_domain=.instagram.com; datr=8J91YceEqinlyL5RaQCNqSnW; csrftoken=HLPTf9ctlpucxgJdBu1rxJfc4uZ0oasc; sessionid=4780859332:sTbiRpLgjFqZKf:26; shbid="357\0544780859332\0541668513823:01f7f44a18574f6e3b0ee87ae77c6f53fd74a0c7973696c46f5fc5fdc1c7a1793a639e2a"; shbts="1636977823\0544780859332\0541668513823:01f7449d7d7088d300135c10667fa2acb4004e40ca53c2c2287c65bf56b00220db3b2c34"; fbsr_124024574287414=LFOlfSE8uZtU_XlQDfALMZOc0t3kB0XPT7qpDMlYkYM.eyJ1c2VyX2lkIjoiMTAwMDA3NDMzOTc4MjU3IiwiY29kZSI6IkFRQVUxU2x4R190cDVYbnlkSUxQeEViaEdVbTZmVVNhdHV5UUo1NDQ0Tl9MaUZWVGRhQjN2NjZIc0M4ZWk4RlJ3TGc0Tlg5YW5oNVVnSmlLX3AtMUpMeEhRVkdCNjVpa18wd2wxZkRKYWtxanFtRFdyNkFRVlVaZGlqMXdSM1FXb1Y2cll3VUNWQm5zZklCVnAyc2dyZW4yc05HeFk3dl9qV3pEWHVrUzNNQzVUbF9SNTJwQ29SMWxBZTByVnZIUEh6RkZTZk1EWWotOXBUQ3NaOUxMX1NNMUxaY2NCTk13RFFaS2lMQ0V5bnB2d2liVmd1c2tKQkxwZEZtV1lIdVM5X2l3U3RtejdpeGZJOWdkT3AxT1ViejN2YjFvLTBGeXRhbzBqTEgtYzctS3hxbDhFSTRIWEJvQkZMdDlybFVOc3ZPNW9YNGVKLVZaQk1aZzJUd1M0X19mIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQUt6YnBVaE0yQThzTVc3c2NqYzRzU1pCdUl4YzJVYzFWaWZSWkF2bWhUbU9URE05WGUyb3RZbmNtdnNQcmUxeGtjSG9Jck1sV0lmelFrWXFNR0s4UWVtbkxja2JRSnd0SDBnRFRsWkM1N21vMXh6OElYUjNodzVMZVNzY0JibENORFRVeTZSZWhaQjFuTnRBWkFkcVBVR3NnSThOeEdUd3gxMHNNTnZDRiIsImFsZ29yaXRobSI6IkhNQUMtU0hBMjU2IiwiaXNzdWVkX2F0IjoxNjM2OTk2MzMyfQ; rur="FRC\0544780859332\0541668532337:01f74474a271ddf73d0810b678e4f08c15a079910718e5088a92d58bf509aba90741d558"',
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
