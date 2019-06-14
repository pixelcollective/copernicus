@php($uid = uniqid())
<div class="wp-block-tinyblocks-author wp-block-{!! $uid !!} @isset($attr->align)align{!! $attr->align !!}@endisset">
  <div class="h-auto max-w-md w-full max-w-full sm:flex grow">
    <div class="h-64 sm:h-auto w-auto sm:w-48 flex-none bg-cover bg-center rounded-t rounded-t-none rounded-l text-center overflow-hidden" style="background-image: url({!! $attr->media['url'] !!})" title="{!! $attr->name !!}"></div>
    <div class="border-r border-b border-l border-gray-400 border-l-0 border-t border-gray-400 bg-white rounded-b rounded-b-none rounded-r px-8 flex py-4 flex-col justify-between leading-normal">
      <span class="text-sm text-gray-600 flex items-center font-sans mb-1">
        <div class="mb-0 mt-4">
          {!! isset($attr->cardLabel) ? $attr->cardLabel : 'About the author' !!}
        </div>
      </span>
      <div class="inline-block text-gray-900 font-bold text-3xl pb-0 mb-1 font-display uppercase">{!! $attr->name !!}</div>
      <div class="inline-block text-gray-700 text-base text-sm mb-12">{!! $content !!}</div>
    </div>
  </div>
</div>