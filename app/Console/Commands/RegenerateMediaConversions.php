<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bilta\HomeIntro;
use App\Models\Bilta\OurTeam;
use App\Models\Bilta\ChairmanMessage;
use App\Models\Bilta\Sponsor;
use App\Models\Bilta\News;
use App\Models\Bilta\Projects;

class RegenerateMediaConversions extends Command
{
    protected $signature = 'media:regenerate-home
                            {--model= : Specific model to regenerate (HomeIntro, OurTeam, ChairmanMessage, Sponsor, News, Projects)}';

    protected $description = 'Regenerate optimized image conversions for home page models';

    private array $models = [
        'HomeIntro'        => HomeIntro::class,
        'OurTeam'          => OurTeam::class,
        'ChairmanMessage'  => ChairmanMessage::class,
        'Sponsor'          => Sponsor::class,
        'News'             => News::class,
        'Projects'         => Projects::class,
    ];

    public function handle(): int
    {
        $specific = $this->option('model');

        $modelsToProcess = $specific
            ? [$specific => $this->models[$specific] ?? null]
            : $this->models;

        foreach ($modelsToProcess as $name => $class) {
            if (!$class) {
                $this->error("Unknown model: {$name}");
                continue;
            }

            $items = $class::has('media')->with('media')->get();
            $count = $items->count();

            if ($count === 0) {
                $this->info("[{$name}] No items with media found — skipping.");
                continue;
            }

            $this->info("[{$name}] Regenerating conversions for {$count} items...");
            $bar = $this->output->createProgressBar($count);

            foreach ($items as $item) {
                foreach ($item->media as $media) {
                    try {
                        $media->model_type = $class;
                        $item->registerMediaConversions($media);

                        foreach ($item->mediaConversions as $conversion) {
                            $media->markAsConversionGenerated($conversion->getName(), false);
                        }

                        $item->processMediaConversions($media);
                    } catch (\Throwable $e) {
                        $this->newLine();
                        $this->warn("  Failed media #{$media->id}: {$e->getMessage()}");
                    }
                }
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
        }

        $this->info('Done! Remember to clear the home page cache:');
        $this->info('  php artisan cache:clear');

        return self::SUCCESS;
    }
}
