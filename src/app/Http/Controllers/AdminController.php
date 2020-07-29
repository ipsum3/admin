<?php

namespace Ipsum\Admin\app\Http\Controllers;

use Gate;


class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    protected $acces;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin');
        if ($this->acces !== null) {
            // Pas de session dans le constructeur
            // https://laravel-news.com/controller-construct-session-changes-in-laravel-5-3
            $this->middleware(function ($request, $next) {
                $this->authorize('admin-acces', $this->acces);
                return $next($request);
            });
        }
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (view()->exists('IpsumAdmin::dashboard')) {
            return view('IpsumAdmin::dashboard');
        }

        // TODO à refactoriser
        // Récupère le premier lien du menu
        foreach(config('ipsum.menu') as $group) {
            foreach($group['sections'] as $section) {
                if (!isset($section['submenus'])) {
                    if (!isset($section['route']) or $section['route'] != ['admin.dashboard']) {
                        return !empty($section['route']) ? redirect()->route($section['route'][0], (isset($section['route'][1]) ? $section['route'][1] : null)) : redirect($section['url']);
                    }
                } else {
                    foreach($section['submenus'] as $submenu_key => $submenu) {
                        if ((!empty($submenu['gate']) and !\Gate::allows($submenu['gate'])) or (!empty($submenu['can']) and !auth()->user()->can($submenu['can'][0], $submenu['can'][1]))) {

                        } else {
                            return !empty($submenu['route']) ? redirect()->route($submenu['route'][0], (isset($submenu['route'][1]) ? $submenu['route'][1] : null)) : redirect($submenu['url']);
                        }
                    }
                }
            }
        }
    }

}
