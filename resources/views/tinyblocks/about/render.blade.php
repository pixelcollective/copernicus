<div class="{!! $class !!}">
  <div class="md:flex justify-evenly">
    <div class="flex-1">
      <div class="p-16 pt-0">
        <img src="@blockAsset(/svg/demo.svg)" />
      </div>
    </div>
    <div class="flex-1">
      <div class="p-16 pt-0">
        <h2 class="{!! $tailwind->heading !!}">{!! $attr->heading !!}</h2>
        <div class="font-serif leading-relaxed">
          {!! $content !!}
        </div>
      </div>
    </div>
  </div>
</div>
