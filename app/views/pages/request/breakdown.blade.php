<h2>Cost and Time Breakdown</h2><hr>
<?php
$num = count(@$vars['breakdowns']);
if ($num > 0)
{
    $colors = array('#F52', '#FA0', '#FD0', '#6C3', '#69F');

    for ($i = 0; $i < $num; $i++)
    {
        $costs[$i] = @$vars['breakdowns'][$i]['cost'];
        $times[$i] = @$vars['breakdowns'][$i]['time'];

        $time_percents[$i] = round(100 * $times[$i] / $vars['request']['time'], 1);
        $cost_percents[$i] = round(100 * $costs[$i] / $vars['request']['price'], 1);
    }
    
    if (array_sum($time_percents) != 100)
        $time_percents[0] += 100 - array_sum($time_percents);
    if (array_sum($cost_percents) != 100)
        $cost_percents[0] += 100 - array_sum($cost_percents);
    
    echo '<div class="pull-left space-right">Cost<br>Time</div><div class="percent-bar">';
    for ($i = 0; $i < $num; $i++)
    {
        if ($cost_percents[$i] != 0)
            echo "<span id='pbar-$i' style='background-color: {$colors[$i]}; width: {$cost_percents[$i]}%' class='percent-region'></span>";
    }
    echo "</div>";

    echo "<div class='percent-bar'>";
    for ($i = 0; $i < $num; $i++)
    {
        if ($time_percents[$i] != 0)
            echo "<span id='tbar-$i' style='background-color: {$colors[$i]}; width: {$time_percents[$i]}%' class='percent-region'></span>";
    }
    echo "</div><br>";

    for ($i = 0; $i < $num; $i++)
    {
        echo "<span id='breakdown-h$i' class='breakdown-head big' style='color:{$colors[$i]}'>{$vars['breakdowns'][$i]['name']}</span>";
        echo "<span id='breakdown-t$i' class='hint'><i class='pad-left fa fa-dollar space-right'></i> " . number_format($costs[$i], 2) . " <i class='fa fa-clock-o pad-left'></i> ";
        echo Helpers\FormatDateInterval($times[$i]);
        echo "</span><div class='breakdown-text'>{$vars['breakdowns'][$i]['description']}</div>";
    }
}
else
    echo '<div class="hint">There is no breakdown for this service</div>';
?>
<script type="text/javascript">
    /*$(document).ready(function()
    {
        var cost_percents = new Array(<?php echo '"' . implode('","', $cost_percents) . '"' ?>);
        var len = 300, delay = len / 2;
        $('.percent-region').each(function(i) { $(this).width(0).delay(i * delay).animate({ width: cost_percents[i] }, len); });
    });
    $('[id^=pbar-]').hover(
        function()
        {
            var id = $(this).attr('id');
            id = id.slice(5, id.length);
            $('#breakdown-h' + id).css('opacity', '0.75');
            $('#pbar-' + id).css('opacity', '0.75');
        },
        function()
        {
            var id = $(this).attr('id');
            id = id.slice(5, id.length);
            $('#breakdown-h' + id).css('opacity', '1');
            $('#pbar-' + id).css('opacity', '1');
    });
    $('[id^=breakdown-h],[id^=breakdown-t]').hover(
        function()
        {
            var id = $(this).attr('id');
            id = id.slice(11, id.length);
            $('#breakdown-h' + id).css('opacity', '0.75');
            $('#pbar-' + id).css('opacity', '0.75');
        },
        function()
        {
            var id = $(this).attr('id');
            id = id.slice(11, id.length);
            $('#breakdown-h' + id).css('opacity', '1');
            $('#pbar-' + id).css('opacity', '1');
        });*/
</script>