<?php

/**
 * Web Scraping with Simple HTML PHP Parser Library
 * #CekCokQODR 16 May 2017
 * Script by @acidopal
 * @author @andynur
 */
class Scraping
{
    
    public function __construct()
    {
        require('simple_html_dom.php');
    }

    public function scraping($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Googlebot/2.1 (http://www.googlebot.com/bot.html)");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        if (!$site = curl_exec($ch)) {
            return 'offline';
        } else {
            return $site;
        }
    }

    public function show($url)
    {
        $result = [];

        $curl = $this->scraping($url);

        if ($curl == "offline") {
            $result['status'] = "error";
        } else {
            $html = str_get_html($curl);
            
            if ($html->find('div[class=edgtf-post-text-inner]')) {
                $result['status'] = "success";
                
                foreach ($html->find('div[class=edgtf-post-text-inner]') as $value) {
                    $title = $value->find('a', 0);
                    $author = $value->find('a[class=edgtf-post-info-author-link]', 0);                    
                    $content = $value->find('p[class=edgtf-post-excerpt]', 0);

                    $result['data'][] = array(
                        'title' => $title->innertext,
                        'author' => $author->innertext,
                        'content' => $content->innertext
                    );
                }
            }
        }
        
        return $result;        
    }

}
