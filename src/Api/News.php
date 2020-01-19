<?php

namespace Tustin\CallOfDuty\Api;

class News extends Api
{
    /**
     * Get all the news posts.
     *
     * @return object
     */
    public function all(string $language = 'en') : object
    {
        return $this->get($language)->feed;
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

    // TODO: Add method for getting article(s) by date.
}