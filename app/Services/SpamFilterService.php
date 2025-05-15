<?php

namespace App\Services;

class SpamFilterService
{
    protected $spam_keywords;
    protected $blacklist_domains;
    protected $blacklist_emails;

    public function __construct()
    {
        $this->spam_keywords = config('spamfilter.keywords');
        $this->blacklist_domains = config('spamfilter.blacklist_domains');
        $this->blacklist_emails = config('spamfilter.blacklist_emails') ;
    }

    public function isSpam($email, $subject, $message): bool
    {
        $content = strtolower($subject . ' ' . $message);
        $score = 0;

        //score type one - find if message contains key words
        foreach ($this->spam_keywords as $keyword) {
            if (strpos($content, strtolower($keyword)) !== false) {
                $score++;
            }
        }

        //score type two - see if message is too short
        if (str_word_count($message) < 10) {
            $score++;
        }

          //score type three - see if message contains links
        if (preg_match('/http(s)?:\/\//', $content)) {
            $score++;
        }

        // score type four - see if sender is part of the blocked list
        $domain = substr(strrchr($email, "@"), 1);
        if (in_array($domain, $this->blacklist_domains)) {
            $score += 2;
        }

        $emailToCheck = strtolower($email );
        if (  in_array($emailToCheck, $this->blacklist_emails ) ) {
            $score += 2;
        }


        return $score >= 3;
    }
}
