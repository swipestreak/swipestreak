<div class="streak-product-images">
<% if Variations %>
    <ul class="variations">

    <% loop Variations %>
        <% loop Options %>
            <li data-id="$ID">$Up.StreakImages.First()</li>
        <% end_loop %>
    <% end_loop %>

    </ul>

<% else %>
    <ul>
        <li data-id="$ID" class="current">$StreakImages.First()</li>
    </ul>
<% end_if %>
</div>
