<?php

namespace App\Services\i18nServices\Import;

use App\Repositories\i18n\i18nImportRepository;
use App\Repositories\i18n\i18nKeysRepository;
use App\Repositories\i18n\i18nModuleRepository;
use App\Services\i18nServices\Import\Exceptions\i18nAlreadyStarted;
use Carbon\Carbon;

class Generic
{
    const GITHUB_USER = 'businessin';
    const GITHUB_TOKEN = '68a1a79302dd44f2ecfdea5168c6e4e0a32ca997';

    const SCAN_JS_REGEX = '/\$t\( *[\\\'"]([^\\\'"]+)[\\\'"][^)]*\)/m';
    const SCAN_BLADE_REGEX = '/trans\( *[\\\'"]([^\\\'"]+)[\\\'"][^)]*\)/m';

    /** @var i18nKeysRepository */
    protected $i18nKeysRepository;

    /** @var i18nModuleRepository */
    protected $i18nModulesRepository;

    /** @var array */
    protected $keys;

    public function __construct()
    {
        $this->i18nKeysRepository = app()->make(i18nKeysRepository::class);
        $this->i18nModulesRepository = app()->make(i18nModuleRepository::class);

        $this->keys = [];
    }

    /**
     * Get all files in direcotry based on filters.
     *
     * @param string $path
     * @param arary $filters
     * @return array
     */
    public function getFiles($path, $filters)
    {
        foreach($filters['ext'] as &$filter) {
            $filter = '.+\.'.$filter;
        }

        $f = implode('|', $filters['ext']);
        $extMatch = '/^('.$f.')$/i';
        $directory = new \RecursiveDirectoryIterator($path);
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = new \RegexIterator($iterator, $extMatch, \RecursiveRegexIterator::GET_MATCH);
        $out = [];
        foreach($files as $file) {
            $out[] = $file[0];
        }

        if (isset($filters['includeDir']) && count($filters['includeDir']) > 0) {
            $return = [];
            foreach($out as $item) {
                foreach($filters['includeDir'] as $dir) {
                    if (strpos($item, $dir) > 0) {
                        $return[] = $item;
                    }
                }
            }
            $out = $return;
        }

        return $out;
    }

    /**
     * Process all keys.
     */
    protected function processKeys()
    {
        foreach($this->keys as $key) {
            $this->processKey($key);
        }
    }

    /**
     * Process 'module.key' string.
     *
     * @param string $key
     */
    private function processKey($key)
    {
        $e = explode('.', $key);
        $module = $e[0];
        unset($e[0]);
        $key = implode('.', $e);

        if (!$key || strpos($key, ' ') !== false) {
            return;
        }

        $module = $this->i18nModulesRepository->query()->firstOrCreate([
            'name' => $module
        ]);
        $this->i18nKeysRepository->query()->firstOrCreate([
            'module_id' => $module->id,
            'key' => $key
        ]);
    }

    protected function uniqueKeys()
    {
        $this->keys = array_unique($this->keys);
    }

    // thx to: https://github.com/jakiestfu/Repo-Downloader
    private function execRedirects($ch, &$redirects)
    {
        $data = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 301 || $httpCode == 302) {
            list($header) = explode("\r\n\r\n", $data, 2);

            $matches = [];
            preg_match("/(Location:|URI:)[^(\n)]*/", $header, $matches);
            $url = trim(str_replace($matches[1], '', $matches[0]));

            $url_parsed = parse_url($url);
            if (isset($url_parsed)) {
                curl_setopt($ch, CURLOPT_URL, $url);
                $redirects++;
                return $this->execRedirects($ch, $redirects);
            }
        }

        list(, $body) = explode("\r\n\r\n", $data, 2);
        return $body;
    }

    /**
     * Download repo and save as zip file.
     *
     * @param string $repo
     * @param string $saveAs
     */
    public function downloadRepository($repo, $saveAs)
    {
        $endpoint = 'https://api.github.com/repos/'.self::GITHUB_USER.'/'.$repo.'/zipball/master';

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: token '.self::GITHUB_TOKEN, 'User-Agent: RepoDownloader'));
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = $this->execRedirects($ch, $out);
        curl_close($ch);

        file_put_contents($saveAs, $data);
    }
}
