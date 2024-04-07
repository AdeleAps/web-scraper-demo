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


    private function scrapeHackerNews(int $pageNumber, array $originIds): int
    {

        $url = 'https://news.ycombinator.com/?p=' . $pageNumber;
        $htmlContent = @file_get_contents($url);

        if (!$htmlContent) {
            $this->displayError();
            return 0;
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($htmlContent);

        $postsTableId = 'hnmain';
        $postsTable = $dom->getElementById($postsTableId);

        if (!$postsTable) {
            $this->displayError("No posts table found. You might be in the incorrect page.");
            return 0;
        }

        $xpath = new \DOMXPath($dom);
        $postPath = '//tr[@class="athing"]';
        $posts = $xpath->query($postPath);

        if ($posts->length === 0) {
            return 0;
        }

        foreach ($posts as $post) {
            $originId = $post->getAttribute('id');

            $aElementPath = ".//span[@class='titleline']/a";
            $aElement = $xpath->query($aElementPath, $post)->item(0);

            if (!$aElement) {
                $this->displayError();
                return 0;
            }

            $title = $aElement->textContent;

            // Had to use type-hinting here because Intelephense was acting up.
            /** @var \DOMElement|null $aElement */
            $link = $aElement->getAttribute('href');

            $sublinePath = "following-sibling::tr[1]//td[@class='subtext']";
            $subline = $xpath->query($sublinePath, $post)->item(0);

            if (!$subline) {
                $this->displayError("No subline found.");
                return 0;
            }

            $scorePath = ".//span[@class='score']";
            $scoreElement = $xpath->query($scorePath, $subline)->item(0);
            $points = 0;

            if ($scoreElement) {
                $score = $scoreElement->textContent;
                $points = $this->formatScore($score);
            }


            $datePath = ".//span[@class='age']";
            /** @var \DOMElement|null $dateElement */
            $dateElement = $xpath->query($datePath, $subline)->item(0);
            $date = $dateElement->getAttribute('title');
            $originDate = new DateTime($date);

            if (!in_array($originId, $originIds)) {
                Post::create([
                    'title' => $title,
                    'link' => $link,
                    'points' => $points,
                    'origin_date' => $originDate,
                    'origin_id' => $originId,
                ]);
            } else {
                $existingPost = Post::where('origin_id', $originId)->first();

                if ($existingPost && !$existingPost->trashed()) {
                    $existingPost->points = $points;
                    $existingPost->save();
                }
            }
        }

        return $posts->length;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $existingOriginIds = Post::withTrashed()->pluck('origin_id')->toArray();
        $currentPage = 1;
        $postCount = 0;

        $this->info('Scraping has started. Please be patient.');

        while (($postsScraped = $this->scrapeHackerNews($currentPage, $existingOriginIds)) > 0) {
            $postCount += $postsScraped;
            $currentPage++;
            $this->info("Posts scraped: $postCount");
        }

        $this->info("Scraping complete! Please refresh the page. $postCount posts were scraped.");
    }
}
