<?php

namespace App\Services;

interface AIServiceInterface
{
    /**
     * @param  array<string, string>  $profile
     * @param  list<array{slug:string,name:string,description:string,level:string,zone:string}>  $competences
     * @return list<array{slug:string,name:string,description:string,reason:string}>
     */
    public function proposeCatalogue(array $profile, array $competences): array;

    /**
     * @param  array<string, string>  $profile
     * @param  list<array{slug:string,name:string,description:string,level:string,zone:string}>  $competences
     * @param  list<array{id:int,competence_slug:string,title:string,location:string,eligibility:string,deadline:string,source:string,verified_at:string,status:string}>  $opportunities
     * @return array{competence_slug?:string,opportunity_ids?:list<int>,profile_summary?:string,strengths?:list<string>,skills_to_develop?:list<string>,compatible_roles?:list<string>,reason?:string,next_action?:string,local_structures?:list<array{name:string,sector:string,region:string,url:string,evidence:string}>,web_sources?:list<array{title:string,url:string,publisher:string,published_at:?string,reason:string}>}
     */
    public function analyzeProfile(array $profile, array $competences, array $opportunities): array;
}
