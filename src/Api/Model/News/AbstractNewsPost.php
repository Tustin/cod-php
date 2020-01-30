<?php
namespace Tustin\CallOfDuty\Api\Model\News;

use Carbon\Carbon;
use Tustin\CallOfDuty\Api\Model\Model;

abstract class AbstractNewsPost extends Model
{
    protected string $title;
    
    protected ?string $author;

    protected ?string $url;

    protected ?Carbon $publishedDate = null;

    protected ?string $subTitle;

    protected ?string $imageUrl;

    public function __construct(object $post)
    {
        $this->cache = $post;

        $this->author = $post->author ?? '';
        $this->title = $post->title ?? '';
        $this->url = $post->url ?? '';
        $publishedDate = $post->publishedDate;

        if ($publishedDate)
        {
            $this->publishedDate = Carbon::create(
                $publishedDate->year,
                $publishedDate->month,
                $publishedDate->dayOfMonth,
                $publishedDate->hourOfDay,
                $publishedDate->minute,
                $publishedDate->second
            );
        }

        $this->subTitle = $post->subTitle ?? '';
        $this->imageUrl = $post->dimg ?? '';
    }

    public function title() : string
    {
        return $this->title;
    }

    public function publishedDate() : ?Carbon
    {
        return $this->publishedDate;
    }

    public function url() : ?string
    {
        return $this->url;
    }

    public function subTitle() : ?string
    {
        return $this->subTitle;
    }

    public function author() : ?string
    {
        return $this->author;
    }

    public function imageUrl() : ?string
    {
        return $this->imageUrl;
    }

    public function raw() : object
    {
        return $this->cache;
    }
}