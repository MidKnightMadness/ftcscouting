<?php

namespace App\Http\Middleware;

use App\Response;
use Closure;

class Csp {

    private $policies;

    public function __construct() {
        $this->policies = array();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $response = $next($request);
        if ($response instanceof \Illuminate\Http\Response) {
            $this->addPolicies();
            if(env('CSP_REPORT_URL') != null){
                $this->report(env('CSP_REPORT_URL'));
            }
            $header = $this->constructHeader();
            $response->header('Content-Security-Policy', $header);
        }
        return $response;
    }

    private function addPolicies() {
        $this->defaultDenyAll();
        $this->self(['script','img','style', 'font']);

        $this->set(['font', 'script', 'style'], 'https://cdnjs.cloudflare.com');
        $this->set('font', ['https://fonts.gstatic.com']);
        $this->set('style', ['https://fonts.googleapis.com', "'unsafe-inline'", 'https://cdn.datatables.net']);
        $this->set('script', ['https://cdn.datatables.net', "'unsafe-inline'"]);
        $this->set('img',['https://placeholdit.imgix.net/','http://placehold.it', 'https://www.gravatar.com']);
    }

    private function defaultDenyAll() {
        $this->policies['default-src'][] = "'none'";
    }

    private function self($type){
        if(is_array($type)){
            foreach($type as $t){
                $this->self($t);
            }
        } else {
            $this->set($type, "'self'");
        }
    }

    private function report($reportUrl){
        $this->policies['report-uri'][] = $reportUrl;
    }

    private function set($type, $site){
        if(is_array($type)){
            foreach ($type as $tp){
                $this->set($tp, $site);
            }
            return;
        }
        if(!ends_with($type, '-src')){
            $type .= '-src';
        }
        if(is_array($site)){
            foreach($site as $t){
                $this->set($type, $t);
            }
        } else {
            $this->policies[$type][] = $site;
        }
    }

    private function constructHeader() {
        $header = '';
        foreach ($this->policies as $key => $value) {
            $header .= $key . ' ';
            if (is_array($value)) {
                foreach ($value as $key) {
                    $header .= $key . ' ';
                }
            } else {
                $header .= $value . ' ';
            }
            $header = substr($header, 0, strlen($header) - 1) . "; ";
        }
        $header = substr($header, 0, strlen($header) - 2);
        return $header;
    }

}
