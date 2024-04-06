<?php

namespace App\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use App\Models\Post;

class scrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapes posts from Hacker News.';

    private function formatScore(string $score): int
    {
        $splitScore = explode(' ', $score);
        $score = $splitScore[0];

        if (isset($score)) {
            return (int)$score;
        }
    }

    private function displayError(string $errorMessage = "Error fetching data."): void
    {
        $this->error($errorMessage);
    }


    private function scrapeHackerNews(): void
    {

        $url = 'https://news.ycombinator.com/';
        $htmlContent = @file_get_contents($url);
        $existingOriginIds = Post::whereNull('deleted_at')->pluck('origin_id')->toArray();

        if (!$htmlContent) {
            $this->displayError();
            return;
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($htmlContent);

        $postsTableId = 'hnmain';
        $postsTable = $dom->getElementById($postsTableId);

        if (!$postsTable) {
            $this->displayError("No posts table found. You might be in the incorrect page.");
            return;
        }

        $xpath = new \DOMXPath($dom);
        $postPath = '//tr[@class="athing"]';
        $posts = $xpath->query($postPath);

        foreach ($posts as $post) {
            $originId = $post->getAttribute('id');

            $aElementPath = ".//span[@class='titleline']/a";
            $aElement = $xpath->query($aElementPath, $post)->item(0);

            if (!$aElement) {
                $this->displayError();
                return;
            }

            $title = $aElement->textContent;

            // Had to use type-hinting here because Intelephense was acting up.
            /** @var \DOMElement|null $aElement */
            $link = $aElement->getAttribute('href');

            $sublinePath = "following-sibling::tr[1]//td[@class='subtext']";
            $subline = $xpath->query($sublinePath, $post)->item(0);

            if (!$subline) {
                $this->displayError("No subline found, check formatting.");
                return;
            }

            $scorePath = ".//span[@class='score']";
            $scoreElement = $xpath->query($scorePath, $subline);
            $points = 0;

            if ($scoreElement) {
                $score = $scoreElement->item(0)->textContent;
                $points = $this->formatScore($score);
            }


            $datePath = ".//span[@class='age']";
            /** @var \DOMElement|null $dateElement */
            $dateElement = $xpath->query($datePath, $subline)->item(0);
            $date = $dateElement->getAttribute('title');
            $originDate = new DateTime($date);

            if (!in_array($originId, $existingOriginIds)) {
                Post::create([
                    'title' => $title,
                    'link' => $link,
                    'points' => $points,
                    'origin_date' => $originDate,
                    'origin_id' => $originId,
                ]);
            }
        }

        if ($posts->length === 0 || $posts->length < 30) {
        }
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scraping has started. Please be patient.');
        $this->scrapeHackerNews();
        $this->info('Scraping complete!');
    }
}
