<?php

namespace Tustin\CallOfDuty\Api;

use Tustin\CallOfDuty\Api\Model\News\BlogPost;
use Tustin\CallOfDuty\Api\Model\News\FeedPost;
use Tustin\CallOfDuty\Api\Model\News\MobilePost;
use Tustin\CallOfDuty\Api\Model\News\AbstractNewsPost;

class News extends Api
{
    /**
     * Gets all blog posts.
     *
     * @param string $language
     * @param integer|null $limit
     * @return \Generator
     */
    public function blogPosts(string $language = 'en', ?int $limit = null) : \Generator
    {
        return $this->postsOf(BlogPost::class, $language, $limit);
    }

    /**
     * Gets all feed posts.
     *
     * @param string $language
     * @param integer|null $limit
     * @return \Generator
     */
    public function feedPosts(string $language = 'en', ?int $limit = null) : \Generator
    {
        return $this->postsOf(FeedPost::class, $language, $limit);
    }

    /**
     * Gets all mobile posts.
     *
     * @param string $language
     * @param integer|null $limit
     * @return \Generator
     */
    public function mobilePosts(string $language = 'en', ?int $limit = null) : \Generator
    {
        return $this->postsOf(MobilePost::class, $language, $limit);
    }

    /**
     * Gets all posts of a specific \Tustin\CallOfDuty\Api\Model\News\AbstractNewsPost class.
     *
     * @param string $className
     * @param string $language
     * @param int|null $limit
     * @return \Generator
     */
    public function postsOf(string $className, string $language = 'en', ?int $limit = null) : \Generator
    {
        if ($limit != null && $limit <= 0)
        {
            throw new \InvalidArgumentException("$limit must be more than zero, or null if you want no limit.");
        }

        $testClass = new \ReflectionClass($className);

        if ($testClass->isAbstract())
        {
            throw new \RuntimeException("'$className' is abstract and cannot be used.");
        }

        if (!$testClass->isSubclassOf(AbstractNewsPost::class))
        {
            throw new \RuntimeException("'$className' is not a valid news post");
        }

        $posts = $this->raw();

        switch ($className)
        {
            case BlogPost::class:
                $posts = $posts->blog;
            break;
            case FeedPost::class:
                $posts = $posts->feed;
            break;
            case MobilePost::class:
                $posts = $posts->mobileMotd;
            break;
            default:
                throw new \RuntimeException("No type of news post '$className' exists.");
        }

        foreach ($posts as $post)
        {
            yield new $className($post);

            if ($limit != null && --$limit <= 0)
            {
                break;
            }
        }
    }

    /**
     * Get the latest news article.
     *
     * @return object
     */
    public function latest(string $language = 'en') : object
    {
        return $this->all($language)[0];
    }

    /**
     * Gets the raw news object.
     *
     * @param string $language
     * @return object
     */
    public function raw(string $language = 'en') : object
    {
        return $this->cache ??= $this->get("/site/cod/franchiseFeed/$language");
    }
}