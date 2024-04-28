@php($id= uniqid())
<div id="{{$id}}">
    @if($inline)
        <div class="d-flex flex-wrap">
    @endif
            @foreach($options as $k => $label)
                <div class="vs-radio-con vs-radio-{{ $style }}" style="margin-right: {{ $right }}">
                    <input {!! in_array($k, $disabled) ? 'disabled' : '' !!} value="{{$k}}" {!! $attributes !!} {!! \Dcat\Admin\Support\Helper::equal($checked, $k) ? 'checked' : '' !!}>
                    <span class="vs-radio vs-radio-{{ $size }}">
                      <span class="vs-radio--border"></span>
                      <span class="vs-radio--circle"></span>
                    </span>
                    @if($label !== null && $label !== '')
                        <span>{!! $label !!}</span>
                    @endif
                </div>
            @endforeach

            @if($readOnly && !empty($name))
                <input type="hidden" name="{{ $name }}" value="{{ $checked }}">
            @endif
    @if($inline)
        </div>
    @endif
</div>

@if($cancelable)
    <script>
        Dcat.ready(function () {
            let input_{{$id}} = '';
            $('#{{$id}} input').on('click', function () {
                if (input_{{$id}} === $(this).val()) {
                    $(this).prop('checked', false);
                    input_{{$id}} = '';
                } else {
                    input_{{$id}} = $(this).val();
                }
            });
        });
    </script>
@endif
