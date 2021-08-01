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
                'cookie' => 'ig_did=094CD26D-2704-454A-9C2D-2B47678C752F; mid=XqKxYwAEAAGRm0dt2zTb5E3c9l0E; fbm_124024574287414=base_domain=.instagram.com; ig_nrcb=1; ds_user_id=4780859332; fbsr_124024574287414=MksTjDHDeLcw-2hkt8biPqVt5HvgfbQ-gsRVDe8GeSU.eyJ1c2VyX2lkIjoiMTAwMDA3NDMzOTc4MjU3IiwiY29kZSI6IkFRQW5JMGVhZVBvVFF1c05KOG53RkNoVUdGOUtlNFZkbHo5MHl6Z0RTbVlfdUNOVmo2ZW1aQUgyTlFNdF9OZFo1UXdrdGFGSVpTcE1QRlNFMUF1ZVhhV3l4RWk4NzhCc29ZVm5COVlDVFowd19HSmRORlhiUF85elBQelNNVWFVYW82ZW9XSEthQUF0RFVzMnE0M1lySDRGcnBRN0ZJdm1IbTVWMGg3NllJQ3hRRk1TVzN5TGRFVXZXMUFKSVZ4QkdYV0VudFNCN3RQY05JZDRONEctZFItVnR0WFlvSDd3Z25mUU90b19LSzZva0xNOUFrMnlsYW1QeHdxajVQZEdEbnRLbldUdTJCUVNSa0dBMlNIOE9EQW94cWE4bkR1OUNldmNTUW5PbmdvMGp0UmtKRWxYUVg2MFFrMWJNUVd1bEVqOHh3bEMwZ0NJWjJhdEZ6WmNiUHdwIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQUxXYUpHR3JIZks1R1pBMzlGTGxCV1pBTEdsUEVQZGUzc04yM0ZZQ0RDMFJmbnFnWEFOdDliWkNueXhzVHA2Nk9HSEpRcURaQnJlb1dRRG43SGZlMVhOeXloYVhaQVJsSFpCeFNHTVViRGs2d3gyMkJlaW51MTlNOFIwRXpiSWVCQkhLTkg2OXJsdVpCa2I4a0c4TGFic2NqS05ORTJTbkdFNjJraTBBM2cyIiwiYWxnb3JpdGhtIjoiSE1BQy1TSEEyNTYiLCJpc3N1ZWRfYXQiOjE2Mjc4MzI1Nzd9; csrftoken=7oNbDFGBhCVXbNu9oZgJ6JvliL82bCxW; sessionid=4780859332:X2OlagFtzq1j8O:4; shbid="357\0544780859332\0541659368579:01f7bfc4b174b97d8ed7ed1b4dbc97dbef72d53cbdadb32299ad813a1302ecbf988ca660"; shbts="1627832579\0544780859332\0541659368579:01f78e8628a775e0b80166d0b9b4507924f3d9760ca7591537e89f4049c09455dd2343de"; fbsr_124024574287414=MksTjDHDeLcw-2hkt8biPqVt5HvgfbQ-gsRVDe8GeSU.eyJ1c2VyX2lkIjoiMTAwMDA3NDMzOTc4MjU3IiwiY29kZSI6IkFRQW5JMGVhZVBvVFF1c05KOG53RkNoVUdGOUtlNFZkbHo5MHl6Z0RTbVlfdUNOVmo2ZW1aQUgyTlFNdF9OZFo1UXdrdGFGSVpTcE1QRlNFMUF1ZVhhV3l4RWk4NzhCc29ZVm5COVlDVFowd19HSmRORlhiUF85elBQelNNVWFVYW82ZW9XSEthQUF0RFVzMnE0M1lySDRGcnBRN0ZJdm1IbTVWMGg3NllJQ3hRRk1TVzN5TGRFVXZXMUFKSVZ4QkdYV0VudFNCN3RQY05JZDRONEctZFItVnR0WFlvSDd3Z25mUU90b19LSzZva0xNOUFrMnlsYW1QeHdxajVQZEdEbnRLbldUdTJCUVNSa0dBMlNIOE9EQW94cWE4bkR1OUNldmNTUW5PbmdvMGp0UmtKRWxYUVg2MFFrMWJNUVd1bEVqOHh3bEMwZ0NJWjJhdEZ6WmNiUHdwIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQUxXYUpHR3JIZks1R1pBMzlGTGxCV1pBTEdsUEVQZGUzc04yM0ZZQ0RDMFJmbnFnWEFOdDliWkNueXhzVHA2Nk9HSEpRcURaQnJlb1dRRG43SGZlMVhOeXloYVhaQVJsSFpCeFNHTVViRGs2d3gyMkJlaW51MTlNOFIwRXpiSWVCQkhLTkg2OXJsdVpCa2I4a0c4TGFic2NqS05ORTJTbkdFNjJraTBBM2cyIiwiYWxnb3JpdGhtIjoiSE1BQy1TSEEyNTYiLCJpc3N1ZWRfYXQiOjE2Mjc4MzI1Nzd9; rur="CLN\0544780859332\0541659368687:01f7901959a3bd2a3ef8873bb842b499760b399fb29445e9b4085a7f73c2f37331814d68"',
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
