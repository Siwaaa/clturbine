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

        $response = file_get_contents("https://www.instagram.com/{$page->instagram}/?__a=1");
        $account = json_decode($response, true);

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
