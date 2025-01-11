<div class="react-switch-cate"
     style="position: relative; display: inline-block; text-align: left; opacity: 1; direction: ltr; border-radius: 14px; transition: opacity 0.25s; touch-action: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none; width: {{ $with }}px">
    <div class="react-switch-bg"
         style="height: 28px; display: flex; align-items: center; background: rgb(47, 133, 90); border-radius: 14px; cursor: pointer; transition: background 0.25s; padding: 0 8px;">
        <div class="react-switch-option all-option"
             style="display: flex; justify-content: center; align-items: center; height: 100%; font-size: 12px; color: white; white-space: nowrap; opacity: 1; transition: opacity 0.25s;">
            {{ $viewOnly1 }}
        </div>
        <div class="react-switch-option parent-option ps-4"
             style="display: flex; justify-content: center; align-items: center; height: 100%; font-size: 12px; color: white; white-space: nowrap; opacity: 0; position: absolute; transition: opacity 0.25s;">
            {{ $viewOnly2 }}
        </div>
    </div>
    <div class="react-switch-handle"
         style="height: 26px; width: 26px; background: rgb(255, 255, 255); display: inline-block; cursor: pointer; border-radius: 50%; position: absolute; transform: translateX(88px); top: 1px; outline: 0px; border: 0px; transition: background-color 0.25s, transform 0.25s, box-shadow 0.15s;"></div>
    <input type="checkbox" role="switch" aria-checked="true"
           style="border: 0px; clip: rect(0px, 0px, 0px, 0px); height: 1px; margin: -1px; overflow: hidden; padding: 0px; position: absolute; width: 1px;">
</div>

<script>
    const $btnSwitch = $('.react-switch-cate');
    const $bgSwitch = $btnSwitch.find('.react-switch-bg');
    const $handleSwitch = $btnSwitch.find('.react-switch-handle');
    const $inputSwitch = $btnSwitch.find('input[type="checkbox"]');

    const $divAllSwitch = $bgSwitch.find('.all-option');
    const $divParentsSwitch = $bgSwitch.find('.parent-option');

    // Thiết lập trạng thái mặc định
    $handleSwitch.css('transform', 'translateX(1px)');
    $bgSwitch.css('background', 'rgb(14, 159, 110)');
    $divAllSwitch.css('opacity', '0');
    $divParentsSwitch.css('opacity', '1');

    // Xử lý sự kiện click
    $btnSwitch.click(function () {
        const isChecked = $inputSwitch.prop('checked');
        if (isChecked) {
            $handleSwitch.css('transform', 'translateX(1px)');
            $bgSwitch.css('background', 'rgb(14, 159, 110)');
            $divAllSwitch.css('opacity', '0');
            $divParentsSwitch.css('opacity', '1');
        } else {
            $handleSwitch.css('transform', 'translateX({{ $with - 27 }}px)');
            $bgSwitch.css('background', 'rgb(47, 133, 90)');
            $divAllSwitch.css('opacity', '1');
            $divParentsSwitch.css('opacity', '0');
        }
        $inputSwitch.prop('checked', !isChecked);
    });
</script>
