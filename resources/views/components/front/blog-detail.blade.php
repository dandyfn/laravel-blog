<x-front.layout>
      <x-slot name="pageHeader">
        {{ $data->title }}
    </x-slot>
    <x-slot name="pageSubheading">
        {{ $data->description }}
    </x-slot>
    <x-slot name="pageBackground">
        {{ asset(getenv('CUSTOM_THUMBNAIL_LOCATION')."/".$data->thumbnail
        )}}
    </x-slot>
    <x-slot name="pageHeaderLink">
        {{ route('blog-detail',['slug'=>$data->slug]) }}
    </x-slot>
    <x-slot name="pageUser">
        {{$data->user->name }}
    </x-slot> 
     <x-slot name="pageDate">
        {{$data->created_at->isoFormat('dddd, D MMMM Y') }}
    </x-slot> 
    <x-slot name="pageTitle">
        {{$data->title }}
    </x-slot> 
    <!-- Main Content-->
         <article class="mb-4">
         <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
               {!! $data->content !!}
              {{-- @foreach ($data as $key => $value)
                <!-- Post preview-->
                <x-front.blog-list title='{{ $value->title }}' description='{{ $value->description }}' 
                    date="{{ $value->created_at->isoFormat('dddd, D MMMM Y') }}" user='{{ $value->user->name }}' 
                    link="{{ route('blog-detail',['slug'=>$value->slug]) }}" />    
              @endforeach --}}
                    <!-- Pager-->
                    <div class="d-flex justify-content-between mb-4 mt-4">
                        <div> 
                            {{-- @if (!$data->onFirstPage())
                                <a class="btn btn-primary text-uppercase" href="{{ $data->previousPageUrl() }}"> &larr; Newer Posts →</a>
                            @endif --}}
                            @if ($pagination['next'])
                                <a href="{{ route('blog-detail',['slug'=>$pagination['next']->slug]) }}">&larr;
                                    {{ $pagination['next']->title }}
                                </a>
                            @else
                                <span></span>
                            @endif
                        </div>
                        <div> 
                            {{-- @if ($data->hasMorePages())
                                 <a class="btn btn-primary text-uppercase" href="{{ $data->nextPageUrl() }}">Older Posts→ &rarr;</a>
                            @endif --}}
                             @if ($pagination['prev'])
                                <a href="{{ route('blog-detail',['slug'=>$pagination['prev']->slug]) }}">
                                    {{ $pagination['prev']->title }}&rarr;
                                </a>
                            @else
                                <span></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
         </article>
        
        <!-- Footer-->
</x-front.layout>    
      
      