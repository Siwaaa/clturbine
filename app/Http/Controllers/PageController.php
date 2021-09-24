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
                'cookie' => 'ig_did=094CD26D-2704-454A-9C2D-2B47678C752F; mid=XqKxYwAEAAGRm0dt2zTb5E3c9l0E; fbm_124024574287414=base_domain=.instagram.com; ig_nrcb=1; ds_user_id=4780859332; csrftoken=VsLKFejPigJf48OkYb7DDJF5RgAHDmYv; sessionid=4780859332:I1PUgbonIncZm9:24; shbid="357\0544780859332\0541662477506:01f7c4bb635ef09d2fc7b8f07ab23b11d508c6dbb5e170c05ffc4baf1babdde141d96754"; shbts="1630941506\0544780859332\0541662477506:01f7af5667ee261d765b8b29d9c2f2d1fd0fc62b149d573b9f32a371048eea98c83ab776"; fbsr_124024574287414=5_hOTInrrINgyHfAT9niqUmIgq680IIGBYv89UNUxjs.eyJ1c2VyX2lkIjoiMTAwMDA3NDMzOTc4MjU3IiwiY29kZSI6IkFRQThXQzk4NFRBLUxzbHZ4Uk1FLXJVZy1FRlRHSW9UdlJCbVlMUGV6R0J0clZTeHByVUY0UXJUaTd1aUU5T3dvUWoxSHN1akNmdzVyT0tUNjc3NFBMNXoxZ05Hbk4tTU9FWkhwTkxhZXRjbUZkLWdIYjMtX3RMOXhrODBRTy1IYjYwX3ZqZkFCTlJ3NEluQ2oyUnI0Q1V3VUpiNG5CSzFyR1FmWG95MzZubUVKZDlBVXIwSnlVQXJpN1FIVlBVbkxrRWV3WTFwdVB1em55RjROZUdkYjNGZTVES0trcDk2MzZ5d3pneUdBcnY2dnZ4QmVfZnZsQnE3LXhFLVc3UGZUZXR6QVpSMGI4dVRGLWotdkI1Mi1xRGh6UzJxd1BwQzRTcU1TLV9RQUJVRGxlNWtzNW5LdG92Y2tnQnk4dnJVRDNxMkZwREZpZkhYTmY1OWFxTXNySW9yIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQUlBYWhuaEJzU2p4UVhtT3VyWkN4TGpUd3Z1WGc1UWxwdHlxT0U2bmtSS2tJOXdDWFVMV1pDdFNUOVpDU0ZCZHhUTEtocndaQmZjb1J4MWNPdmE2MWx0ZmczV1g1T1pDZjQzV3VzTTF4bVEyZnRSeE14S0Q5cWNnNWxQV3IwR3AyMEhUOEl6WVhvT0E5WkMxdE1sTFJ6Q29qS2l1dW5lM2NxdnExZU5nSHQiLCJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImlzc3VlZF9hdCI6MTYzMTExMzE2MX0; rur="CLN\0544780859332\0541662649633:01f7be3e216be63d25aa9e67cc0d50757fd6a06ae2a219b42ee5e472f7791c2de76b69b9"',
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
