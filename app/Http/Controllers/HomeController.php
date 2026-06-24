<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function welcome(Request $request)
    {
        // if (Auth::check()) {
        //     return redirect()->route('dashboard');
        // }

        // return redirect()->route('login');

        // return view('welcome');

        return view('auth.login');
    }

    public function aboutUs()
    {
        return view('home.about');
    }

    public function contactUs()
    {
        return view('home.contact');
    }

    public function ourService()
    {
        return view('home.service');
    }

    public function youthClub()
    {
        return view('home.youth-club');
    }

    public function newsEvent()
    {
        return view('home.news-event');
    }

    public function newsEventetails()
    {
        // $event = NewsEvent::findOrFail($id);
        return view('news-event.details', compact('event'));
    }

    public function joditUpload(Request $request)
    {
        if ($request->hasFile('files')) {
            // get first uploaded file (if multiple sent)
            $uploadedFile = $request->file('files')[0];

            $path = $uploadedFile->store('uploads', 'public');
            $url = Storage::url($path);

            // Convert relative URL to absolute URL
            $fullUrl = asset($url);

            return response()->json([
                'success' => true,
                'file' => [
                    'url' => $fullUrl,
                ],
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    public function joditBrowse()
    {
        $files = Storage::disk('public')->files('uploads/jodit');

        $response = array_map(function ($file) {
            return [
                'file' => asset('storage/' . $file),
                'name' => basename($file)
            ];
        }, $files);

        return response()->json($response);
    }

    /**
     * Generate a collection of committee members.
     *
     * @return \Illuminate\Support\Collection
     */
    private function generateCommittees()
    {
        $committees = new Collection();

        $members = [
            'PRESIDENT' => [
                ['name' => 'Md Monir Hossain', 'position' => 'PRESIDENT', 'photo' => 'monir_hossain.jpg'],
            ],
            'VICE PRESIDENT' => [
                ['name' => 'Md Nasir Uddin', 'position' => 'VICE PRESIDENT', 'photo' => 'nasir_uddin.jpg'],
                ['name' => 'Md Abul Hossain Mojumder', 'position' => 'VICE PRESIDENT', 'photo' => 'abul_hoassain_mojumder.jpg'],
                ['name' => 'Advocate Billal Hossain', 'position' => 'VICE PRESIDENT', 'photo' => 'billal_hossain.jpg'],
            ],
            'GENERAL SECRETARY' => [
                ['name' => 'Md Mahmudul Hasan Shahin', 'position' => 'SECRETARY', 'photo' => 'mahmudul_shahin.jpg'],
            ],
            'SECRETARIAL TEAM' => [
                ['name' => 'Md Rafy Hossain', 'position' => 'JOINT SECRETARY', 'photo' => 'rafy_hossain.jpg'],
                ['name' => 'AZM Shah Alam', 'position' => 'OFFICE SECRETARY', 'photo' => 'azm_shah_alam.jpg'],
                ['name' => 'Md Zakir Hossain', 'position' => 'ORGANIZING SECRETARY', 'photo' => 'zakir_hossain.jpg'],
                ['name' => 'MD RIAZUL AMIN', 'position' => 'TREASURER', 'photo' => 'riazul_amin.jpg'],
                ['name' => 'Md Jahedul Haque (Sumon)', 'position' => 'PUBLICITY SECRETARY', 'photo' => 'jahedul_haque.jpg'],
                ['name' => 'Advocate Md Baborul Amin', 'position' => 'LAW SECRETARY', 'photo' => 'baborul_amin.jpg'],
                ['name' => 'Advocate Md Didarul Islam', 'position' => 'ADDITIONAL LAW SECRETARY', 'photo' => 'didarul_islam.jpg'],
                ['name' => 'Md Hasan Ali Khan', 'position' => 'RELIGIOUS AFFAIRS SECRETARY', 'photo' => 'hasan_ali_khan.jpg'],
                ['name' => 'ABM Siddik', 'position' => 'SPORTS SECRETARY', 'photo' => 'abm_siddik.jpg'],
            ],
            'MEMBERS' => [
                ['name' => 'Md Mainuddin', 'position' => 'MEMBER', 'photo' => 'mainuddin.jpg'],
                ['name' => 'Advocate A. Halim', 'position' => 'MEMBER', 'photo' => 'a_halim.jpg'],
                ['name' => 'Md Masum', 'position' => 'MEMBER', 'photo' => 'masum.jpg'],
                ['name' => 'Md Joynal Abedin Anis', 'position' => 'MEMBER', 'photo' => 'joynal_abis.jpg'],
                ['name' => 'Md Shahbuddin', 'position' => 'MEMBER', 'photo' => 'shahbuddin.jpg'],
                ['name' => 'Md Jalil', 'position' => 'MEMBER', 'photo' => 'jalil.jpg'],
                ['name' => 'Md Rafiqul Islam Ripon', 'position' => 'MEMBER', 'photo' => 'rafiqul_islam.jpg'],
                ['name' => 'Md Mujibur Rahman', 'position' => 'MEMBER', 'photo' => 'mujibur_rahman.jpg'],
                ['name' => 'Md Faruk Hossain', 'position' => 'MEMBER', 'photo' => 'faruk_hossain.jpg'],
                ['name' => 'Md Mizanur Rahman Miron', 'position' => 'MEMBER', 'photo' => 'mizanur_rahman.jpg'],
                ['name' => 'Md Shahidul Islam', 'position' => 'MEMBER', 'photo' => 'shahidul_islam.jpg'],
                ['name' => 'Md Mahfuzur Rahman', 'position' => 'MEMBER', 'photo' => 'mahfuzur_rahman.jpg'],
                ['name' => 'Md Abul Kalam Mridha', 'position' => 'MEMBER', 'photo' => 'abul_kalam_mridha.jpg'],
            ]
        ];

        // Flatten the members into a collection and add position info for each member
        foreach ($members as $category => $membersList) {
            $committees->push((object)[
                'category' => $category,
                'members' => collect($membersList)->map(function ($member) {
                    return (object)[
                        'name' => $member['name'],
                        'position' => $member['position'],  // Add position here
                        'photo' => $member['photo']
                    ];
                })
            ]);
        }

        return $committees;
    }
}
