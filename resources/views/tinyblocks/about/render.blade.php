<div class="{!! $class !!}">
  <div class="md:flex justify-evenly">
    <div class="flex-1">
      <div class="p-16 pt-0">
        <img src="@blockAsset(/svg/demo.svg)" />
      </div>
    </div>
    <div class="flex-1">
      <div class="p-16 pt-0">
        @include('BlockComponents::heading.one', [
          'content' => $attr->heading,
        ])
        @include('BlockComponents::heading.two', [
          'content' => strip_tags($content),
        ])
      </div>
    </div>
  </div>
</div>
