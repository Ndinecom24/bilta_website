<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\AudioFile;
use App\Models\Bilta\HomeIntro;
use App\Models\Bilta\News;
use App\Models\Bilta\OurTeam;
use App\Models\Bilta\OurValues;
use App\Models\Bilta\Projects;
use App\Models\Bilta\Testimonial;
use App\Models\Bilta\ChairmanMessage;
use App\Models\Bilta\Sponsor;
use Livewire\Component;

class ShowHome extends Component
{
    public $search;
    public $successMessage;

    /**
     * Cache duration in seconds (6 hours).
     */
    private const CACHE_TTL = 6 * 60 * 60;

    /**
     * Get the optimized URL for a media item, falling back to original.
     */
    private static function optimizedUrl($media): ?string
    {
        if (!$media) {
            return null;
        }

        return $media->hasGeneratedConversion('optimized')
            ? $media->getUrl('optimized')
            : $media->getUrl();
    }

    public function render()
    {
        $testimonials = cache()->remember('home_testimonials', self::CACHE_TTL, function () {
            return Testimonial::select('id', 'testimonial', 'title', 'status_id', 'name')
                ->whereHas('status', function ($query) {
                    $query->where('name', 'like', '%Active%');
                })
                ->take(10)->get();
        });

        $our_teams = cache()->remember('home_our_teams', self::CACHE_TTL, function () {
            return OurTeam::select('id', 'name', 'phone', 'email', 'details', 'position', 'display_order')
                ->with('media') // eager-load media to avoid N+1
                ->orderBy('display_order')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($team) {
                    $team->team_image_url = self::optimizedUrl($team->getFirstMedia('team_images'));
                    $team->unsetRelation('media'); // drop heavy relation before caching
                    return $team;
                });
        });

        $our_values = cache()->remember('home_our_values', self::CACHE_TTL, function () {
            return OurValues::get();
        });

        // Cache HomeIntro with pre-resolved media URLs
        $homeIntroData = cache()->remember('home_intro_data', self::CACHE_TTL, function () {
            $home_intro = HomeIntro::first();
            if (!$home_intro) {
                return [
                    'model' => null,
                    'hero_image_url' => null,
                    'mission_slider_images' => [],
                ];
            }

            $home_intro->load('media');

            return [
                'model' => $home_intro,
                'hero_image_url' => self::optimizedUrl($home_intro->getFirstMedia('home_intro_images')),
                'mission_slider_images' => $home_intro
                    ->getMedia('mission_slider_images')
                    ->map(fn($m) => self::optimizedUrl($m))
                    ->filter()
                    ->values()
                    ->all(),
            ];
        });

        $home_intro = $homeIntroData['model'];
        $heroImageUrl = $homeIntroData['hero_image_url'] ?? asset('assets/img/bilta-hero.jpg');
        $missionSliderImages = $homeIntroData['mission_slider_images'];

        // Cache chairman with pre-resolved photo URL
        $chairmanData = cache()->remember('chairman_data', self::CACHE_TTL, function () {
            $chairman = ChairmanMessage::with('media')->latest()->first();
            if (!$chairman) {
                return ['model' => null, 'photo_url' => null];
            }
            $media = $chairman->getFirstMedia('chairman_photo');
            $photoUrl = self::optimizedUrl($media);
            $chairman->unsetRelation('media');
            return ['model' => $chairman, 'photo_url' => $photoUrl];
        });
        $chairman = $chairmanData['model'];
        $chairmanPhotoUrl = $chairmanData['photo_url'];

        // Cache sponsors with pre-resolved image URLs
        $sponsors = cache()->remember('sponsors', self::CACHE_TTL, function () {
            return Sponsor::with('media')
                ->orderBy('display_order')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($sponsor) {
                    $sponsor->sponsor_image_url = self::optimizedUrl($sponsor->getFirstMedia('sponsor_image'));
                    $sponsor->unsetRelation('media');
                    return $sponsor;
                });
        });

        $projects = cache()->remember('projects', self::CACHE_TTL, function () {
            return Projects::with('myCategory')
                ->orderBy('display_order')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        });

        // Cache latest news with pre-resolved image URLs
        $latestNews = cache()->remember('latest_news_home', self::CACHE_TTL, function () {
            return News::query()
                ->where('status_id', config('constants.status.active'))
                ->with('media') // eager-load media
                ->orderBy('display_order')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get()
                ->map(function ($news) {
                    $news->news_image_url = self::optimizedUrl($news->getFirstMedia('news_images'));
                    $news->unsetRelation('media');
                    return $news;
                });
        });

        $searchKey = $this->search;
        $page = request()->get('page', 1);
        $cacheKey = 'audio_files_' . md5($searchKey . '_page_' . $page);

        $audioFiles = cache()->remember($cacheKey, self::CACHE_TTL, function () use ($searchKey) {
            return AudioFile::query()
                ->where('status_id', config('constants.status.active'))
                ->where(function ($query) use ($searchKey) {
                    $query->where('title', 'like', '%' . $searchKey . '%')
                        ->orWhereHas('project', function ($query) use ($searchKey) {
                            $query->where('title', 'like', '%' . $searchKey . '%');
                        })
                        ->orWhereHas('project.myCategory', function ($query) use ($searchKey) {
                            $query->where('name', 'like', '%' . $searchKey . '%');
                        });
                })
                ->paginate(10);
        });

        return view('livewire.site.show-home-page')->with(compact(
            'testimonials', 'our_teams', 'our_values', 'home_intro',
            'audioFiles', 'chairman', 'projects', 'sponsors', 'latestNews',
            'missionSliderImages', 'heroImageUrl', 'chairmanPhotoUrl'
        ));
    }





}
