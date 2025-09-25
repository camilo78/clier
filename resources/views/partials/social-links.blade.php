@if($companyInfo && ($companyInfo->facebook_url || $companyInfo->twitter_url || $companyInfo->instagram_url || $companyInfo->linkedin_url))
<div class="h-100 d-lg-inline-flex align-items-center d-none">
    @if($companyInfo->facebook_url)
    <a class="btn btn-square rounded-circle bg-light text-primary me-2" href="{{ $companyInfo->facebook_url }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
    @endif
    @if($companyInfo->twitter_url)
    <a class="btn btn-square rounded-circle bg-light text-primary me-2" href="{{ $companyInfo->twitter_url }}" target="_blank"><i class="fab fa-twitter"></i></a>
    @endif
    @if($companyInfo->linkedin_url)
    <a class="btn btn-square rounded-circle bg-light text-primary me-2" href="{{ $companyInfo->linkedin_url }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
    @endif
    @if($companyInfo->instagram_url)
    <a class="btn btn-square rounded-circle bg-light text-primary me-0" href="{{ $companyInfo->instagram_url }}" target="_blank"><i class="fab fa-instagram"></i></a>
    @endif
</div>
@endif