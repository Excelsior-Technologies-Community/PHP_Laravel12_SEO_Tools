<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RobotsController extends Controller
{
    public function generate(Request $request)
    {
        $robotsContent = "User-agent: *\n";
        $robotsContent .= "Allow: /\n";
        $robotsContent .= "Disallow: /admin/\n";
        $robotsContent .= "Disallow: /dashboard/\n\n";
        $robotsContent .= "Sitemap: " . url('/sitemap.xml') . "\n";

        file_put_contents(public_path('robots.txt'), $robotsContent);

        return redirect()->back()
            ->with('success', 'Robots.txt generated successfully.');
    }

    public function view()
    {
        if (!file_exists(public_path('robots.txt'))) {
            $this->generate(request());
        }
        
        return response()->file(public_path('robots.txt'));
    }
}