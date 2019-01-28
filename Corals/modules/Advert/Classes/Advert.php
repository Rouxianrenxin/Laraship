<?php

namespace Corals\Modules\Advert\Classes;

use Carbon\Carbon;
use Corals\Modules\Advert\Models\Banner;
use Corals\Modules\Advert\Models\Impression;
use Corals\Modules\Advert\Models\Zone;
use Jenssegers\Agent\Agent;

class Advert
{
    /**
     * Advert constructor.
     */
    function __construct()
    {
    }


    public function getDimensionsList()
    {
        $dimensions = array_keys(config('advert.dimensions'));

        return array_combine($dimensions, $dimensions);
    }

    /**
     * @param Zone $zone
     * @return mixed
     */
    public function getZoneActiveBanners(Zone $zone)
    {
        $modulePrefix = 'advert_';

        $bannersTable = $modulePrefix . 'banners';
        $bannerZoneTable = $modulePrefix . 'banner_zone';
        $campaignsTable = $modulePrefix . 'campaigns';
        $advertisersTable = $modulePrefix . 'advertisers';

        $today = Carbon::today();

        $activeBannersQuery = \DB::table($bannersTable)
            ->join($bannerZoneTable, "{$bannerZoneTable}.banner_id", '=', "{$bannersTable}.id")
            ->join($campaignsTable, "{$campaignsTable}.id", '=', "{$bannersTable}.campaign_id")
            ->join($advertisersTable, "{$advertisersTable}.id", '=', "{$campaignsTable}.advertiser_id")
            ->where("{$bannerZoneTable}.zone_id", $zone->id)
            ->where("{$bannersTable}.status", 'active')
            ->where("{$campaignsTable}.status", 'active')
            ->where("{$advertisersTable}.status", 'active')
            ->whereDate("{$campaignsTable}.starts_at", '<=', $today)
            ->where(function ($query) use ($today, $campaignsTable) {
                $query->whereDate("{$campaignsTable}.ends_at", '>=', $today)
                    ->orWhereNull("{$campaignsTable}.ends_at");
            });

        $scopes = [];
        $scopes = \Filters::do_filter('advert_banner_scopes', $scopes, $activeBannersQuery);

        foreach ($scopes as $scope) {
            $scope->apply($activeBannersQuery);
        }
        $activeBannersQuery = $activeBannersQuery->select("{$bannersTable}.*")->get();


        return Banner::hydrate($activeBannersQuery->toArray());
    }

    protected function EmptyZoneHandler()
    {
        return '';
    }

    /**
     * @param Zone $zone
     * @return string
     * @throws \Throwable
     */
    public function getRandomWeightedBanner(Zone $zone)
    {
        return rescue(function () use ($zone) {
            if (!$zone->isValid()) {
                return $this->EmptyZoneHandler();
            }


            $banners = $this->getZoneActiveBanners($zone);

            if ($banners->isEmpty()) {
                return $this->EmptyZoneHandler();
            }
            $bannersWeights = $banners->pluck('weight', 'id')->toArray();

            $weightedArray = [];

            foreach ($bannersWeights as $id => $weight) {
                for ($i = 0; $i < $weight; $i++) {
                    $weightedArray[] = $id;
                }
            }

            $randomWeight = mt_rand(0, (count($weightedArray) - 1));

            // query on collection
            $banner = $banners->where('id', $weightedArray[$randomWeight])->first();

            $bannerSlug = str_random();

            $impression = Impression::updateOrCreate([
                'session_id' => session()->getId(),
                'banner_id' => $banner->id,
                'zone_id' => $zone->id,
                'page_slug' => request()->headers->get('referer') ?? url()->current(),
            ], [
                'impression_slug' => $bannerSlug,
            ]);

            $impression->visitorDetail()->updateOrCreate(['impression_id' => $impression->id], $this->getVisitorDetails());

            return view('Advert::zones.partials.' . $banner->type)->with(compact('zone', 'banner', 'bannerSlug'))->render();
        }, function () {
            return $this->EmptyZoneHandler();
        });

    }

    protected function getVisitorDetails()
    {
        $details = [];

        return rescue(function () use ($details) {
            $agent = new Agent();

            $details['browser'] = $agent->browser();
            $details['browser_version'] = $agent->version($details['browser']);
            $details['is_phone'] = $agent->isPhone();
            $details['is_tablet'] = $agent->isTablet();
            $details['is_desktop'] = $agent->isDesktop();
            $details['is_robot'] = $agent->isRobot();
            $details['robot'] = $agent->robot();
            $details['device'] = $agent->device();
            $details['platform'] = $agent->platform();
            $details['platform_version'] = $agent->version($details['platform']);
            $details['languages'] = $agent->languages();

            return $details;
        }, function () use ($details) {
            return $details;
        });
    }

    /**
     * @param Zone $zone
     * @return mixed
     */
    public function getZoneEmbedCode(Zone $zone)
    {
        $code = '<div data-embed-src="' . url('adverts/' . $zone->hashed_id . '/embed') . '"></div><script type="text/javascript" src="' . asset('assets/corals/plugins/advert/js/embed.js') . '"></script>';

        return '<pre><code id="embed_' . $zone->hashed_id . '">' . htmlentities($code, ENT_COMPAT, 'UTF-8') . '</code> <a href="#" onclick="event.preventDefault();" class="copy-button"data-clipboard-target="#embed_' . $zone->hashed_id . '"><i class="fa fa-clipboard"></i></a></pre>';

    }
}